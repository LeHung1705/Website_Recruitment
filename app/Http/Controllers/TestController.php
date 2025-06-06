<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baikiemtra;
use App\Models\Ketquabaikiemtra;
use App\Models\Thongbao;
use App\Models\Donungtuyen;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    // Phương thức cho admin
    public function index()
    {
        $tests = Baikiemtra::where('nguoi_tao_id', Auth::id())
                          ->withCount(['ketquabaikiemtras as so_nguoi_lam'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        return view('admin.test.index', compact('tests'));
    }

    public function showCreateForm()
    {
        return view('admin.test.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'noi_dung' => 'required',
            'loai_bai' => 'required',
        ]);

        $test = Baikiemtra::create([
            'nguoi_tao_id' => Auth::id(),
            'noi_dung' => $request->noi_dung,
            'loai_bai' => $request->loai_bai,
        ]);

        return redirect()->route('admin.test.invite', $test->id)
                        ->with('success', 'Tạo bài kiểm tra thành công');
    }

    public function showInviteForm($id)
    {
        $test = Baikiemtra::findOrFail($id);
        
        // Lấy danh sách ứng viên từ đơn ứng tuyển
        $applicants = Donungtuyen::where('nha_tuyen_dung_id', Auth::id())
                                ->with('ungvien')
                                ->whereDoesntHave('ketquabaikiemtras', function($query) use ($id) {
                                    $query->where('bai_kiem_tra_id', $id);
                                })
                                ->get();

        return view('admin.test.invite', compact('test', 'applicants'));
    }

    public function sendInvite(Request $request, $id)
    {
        $test = Baikiemtra::findOrFail($id);
        
        if (!$request->has('applicants')) {
            return back()->with('error', 'Vui lòng chọn ít nhất một ứng viên');
        }

        foreach ($request->applicants as $applicantId) {
            Thongbao::create([
                'nguoi_nhan_id' => $applicantId,
                'noi_dung' => "Bạn được mời làm bài kiểm tra: {$test->loai_bai}",
                'trang_thai' => 'chua_doc',
                'thoi_gian_gui' => now(),
                'link' => route('user.test.show', $id)
            ]);
        }

        return redirect()->back()->with('success', 'Đã gửi lời mời thành công');
    }

    public function showResults($id)
    {
        if ($id === 'all') {
            $results = Ketquabaikiemtra::whereHas('baikiemtra', function($query) {
                                    $query->where('nguoi_tao_id', Auth::id());
                                })
                                ->with(['nguoidung', 'baikiemtra'])
                                ->orderBy('ngay_lam', 'desc')
                                ->paginate(10);
            return view('admin.test.all-results', compact('results'));
        }

        $test = Baikiemtra::findOrFail($id);
        $results = Ketquabaikiemtra::where('bai_kiem_tra_id', $id)
                                  ->with('nguoidung')
                                  ->orderBy('diem_so', 'desc')
                                  ->paginate(10);

        return view('admin.test.results', compact('test', 'results'));
    }

    public function destroy($id)
    {
        $test = Baikiemtra::where('nguoi_tao_id', Auth::id())
                          ->findOrFail($id);
        $test->delete();

        return redirect()->route('admin.test.index')
                        ->with('success', 'Đã xóa bài kiểm tra');
    }

    // Phương thức cho user
    public function candidateIndex()
    {
        $pendingTests = Thongbao::where('nguoi_nhan_id', Auth::id())
                               ->whereNotNull('link')
                               ->whereDoesntHave('ketqua', function($query) {
                                   $query->where('nguoi_lam_id', Auth::id());
                               })
                               ->with('baikiemtra')
                               ->paginate(10);

        return view('user.test.index', compact('pendingTests'));
    }

    public function showTest($id)
    {
        $test = Baikiemtra::findOrFail($id);
        
        // Kiểm tra xem ứng viên có được mời làm bài này không
        $invited = Thongbao::where('nguoi_nhan_id', Auth::id())
                          ->where('link', route('user.test.show', $id))
                          ->exists();

        if (!$invited) {
            abort(403, 'Bạn không được mời làm bài kiểm tra này');
        }

        // Kiểm tra xem đã làm bài chưa
        $completed = Ketquabaikiemtra::where('bai_kiem_tra_id', $id)
                                    ->where('nguoi_lam_id', Auth::id())
                                    ->exists();

        if ($completed) {
            return redirect()->route('user.test.result', $id);
        }

        return view('user.test.show', compact('test'));
    }

    public function submitTest(Request $request, $id)
    {
        $test = Baikiemtra::findOrFail($id);
        $score = 0;
        
        // Chấm điểm
        $questions = json_decode($test->noi_dung, true);
        foreach ($request->answers as $index => $answer) {
            if (isset($questions[$index]) && $questions[$index]['dap_an'] == $answer) {
                $score += (100 / count($questions)); // Chia đều điểm cho các câu
            }
        }

        // Lưu kết quả
        $result = Ketquabaikiemtra::create([
            'nguoi_lam_id' => Auth::id(),
            'bai_kiem_tra_id' => $id,
            'diem_so' => round($score, 2),
            'ngay_lam' => now(),
            'dap_an' => json_encode($request->answers)
        ]);

        // Gửi thông báo
        Thongbao::create([
            'nguoi_nhan_id' => Auth::id(),
            'noi_dung' => "Bạn đã hoàn thành bài kiểm tra với số điểm: {$result->diem_so}",
            'trang_thai' => 'chua_doc',
            'thoi_gian_gui' => now(),
        ]);

        return redirect()->route('user.test.result', $id)
                        ->with('success', 'Nộp bài thành công');
    }

    public function candidateHistory()
    {
        $completedTests = Ketquabaikiemtra::where('nguoi_lam_id', Auth::id())
                                         ->with('baikiemtra')
                                         ->orderBy('ngay_lam', 'desc')
                                         ->paginate(10);

        return view('user.test.history', compact('completedTests'));
    }

    public function candidateResult($id)
    {
        $result = Ketquabaikiemtra::where('bai_kiem_tra_id', $id)
                                 ->where('nguoi_lam_id', Auth::id())
                                 ->firstOrFail();

        return view('user.test.result', compact('result'));
    }
}