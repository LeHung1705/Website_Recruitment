<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhongVan;
use App\Models\KetQuaPhongVan;
use App\Models\ThongBao;
use App\Models\DonUngTuyen;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InterviewController extends Controller
{

    public function showFormInvite($id)
    {
        $donUngTuyen = DonUngTuyen::with('ungvien', 'tintuyendung')->findOrFail($id);
        return view('admin.interview.invite', compact('donUngTuyen'));
    }

    // Admin: Gửi lời mời phỏng vấn
    public function sendInvite(Request $request, $id)
    {
        $request->validate([
            'thoi_gian' => 'required|date',
            'hinh_thuc' => 'required|in:online,offline'
        ]);

        $donUngTuyen = DonUngTuyen::with('ungvien')->findOrFail($id);

        $phongVan = PhongVan::create([
            'nguoi_to_chuc_id' => Auth::id(),
            'don_ung_tuyen_id' => $id,
            'thoi_gian' => $request->thoi_gian,
            'hinh_thuc' => $request->hinh_thuc,
            'trang_thai' => 'cho_xac_nhan'
        ]);

        // Tạo thông báo cho ứng viên
        ThongBao::create([
            'nguoi_nhan_id' => $donUngTuyen->ungvien->id,
            'noi_dung' => "Lời mời phỏng vấn vào " . Carbon::parse($request->thoi_gian)->format('d/m/Y H:i') . " ({$request->hinh_thuc})",
            'trang_thai' => 'chua_doc',
            'thoi_gian_gui' => now(),
            'loai_thong_bao' => 'phong_van',
            'link' => route('user.interview.show', ['id' => $phongVan->id])
        ]);

        return redirect()->route('admin.applications', $donUngTuyen->tin_tuyen_dung_id)
                        ->with('success', 'Đã gửi lời mời phỏng vấn thành công');
    }

    // Admin: Hiển thị form nhập kết quả
    public function showResultForm($id)
    {
        $interview = PhongVan::with(['donungtuyen.user'])->findOrFail($id);
        return view('admin.interview.result', compact('interview'));
    }

    // Admin: Lưu kết quả phỏng vấn
    public function storeResult(Request $request, $id)
    {
        $request->validate([
            'diem_so' => 'required|integer|min:0|max:10',
            'nhan_xet' => 'required|string',
            'ket_qua' => 'required|in:dau,rot'
        ]);

        $phongVan = PhongVan::with('donungtuyen.user')->findOrFail($id);
        
        $ketQua = KetQuaPhongVan::create([
            'phong_van_id' => $id,
            'diem_so' => $request->diem_so,
            'nhan_xet' => $request->nhan_xet,
            'ket_qua' => $request->ket_qua
        ]);

        // Cập nhật trạng thái đơn ứng tuyển nếu rớt
        if ($request->ket_qua === 'rot') {
            $phongVan->donungtuyen->update(['trang_thai' => 'da_tu_choi']);
        }

        // Tạo thông báo kết quả cho ứng viên
        ThongBao::create([
            'nguoi_nhan_id' => $phongVan->donungtuyen->user_id,
            'noi_dung' => "Kết quả: {$request->ket_qua} (Điểm: {$request->diem_so}, Nhận xét: {$request->nhan_xet})",
            'trang_thai' => 'chua_doc',
            'thoi_gian_gui' => now(),
            'loai_thong_bao' => 'ket_qua_phong_van',
            'link' => route('user.interview.result', ['id' => $id])
        ]);

        return response()->json(['message' => 'Đã lưu kết quả phỏng vấn']);
    }

    // User: Lấy danh sách thông báo
    public function notifications()
    {
        $notifications = ThongBao::where('nguoi_nhan_id', Auth::id())
            ->whereIn('loai_thong_bao', ['phong_van', 'ket_qua_phong_van'])
            ->with(['phongvan' => function($query) {
                $query->with(['donungtuyen' => function($q) {
                    $q->with(['tintuyendung.nhatuyendung']);
                }]);
            }])
            ->orderBy('thoi_gian_gui', 'desc')
            ->paginate(10);

        // Load phongvan relationships manually for notifications that have valid IDs
        $notifications->each(function($notification) {
            if ($notification->loai_thong_bao === 'phong_van') {
                $id = $notification->getPhongVanIdFromLink();
                if ($id) {
                    $phongvan = PhongVan::with(['donungtuyen' => function($q) {
                        $q->with(['tintuyendung.nhatuyendung']);
                    }])->find($id);
                    $notification->setRelation('phongvan', $phongvan);
                }
            }
        });

        return view('user.interview.notifications', compact('notifications'));
    }

    // User: Xem chi tiết phỏng vấn
    public function show($id)
    {
        $interview = PhongVan::with(['nguoidung:id,ho_ten'])->findOrFail($id);

        // Kiểm tra quyền truy cập
        if ($interview->donungtuyen->user_id !== Auth::id()) {
            return redirect()->route('user.interview.notifications')
                ->with('error', 'Bạn không có quyền truy cập phỏng vấn này');
        }

        return view('user.interview.confirm', compact('interview'));
    }

    // User: Xác nhận phỏng vấn
    public function confirm($id)
    {
        $phongVan = PhongVan::with('donungtuyen')->findOrFail($id);

        // Kiểm tra quyền truy cập
        if ($phongVan->donungtuyen->ungvien->id !== Auth::id()) {
            return redirect()->route('user.interview.notifications')
                ->with('error', 'Bạn không có quyền truy cập phỏng vấn này');
        }

        // Cập nhật trạng thái phỏng vấn
        $phongVan->update(['trang_thai' => 'da_xac_nhan']);

        // Tạo thông báo cho admin
        ThongBao::create([
            'nguoi_nhan_id' => $phongVan->nguoi_to_chuc_id,
            'noi_dung' => "User xác nhận phỏng vấn ID: {$id}",
            'trang_thai' => 'chua_doc',
            'thoi_gian_gui' => now(),
            'loai_thong_bao' => 'phong_van',
            'link' => route('admin.interview.result.form', ['id' => $id])
        ]);

        return redirect()->route('user.interview.notifications')
            ->with('success', 'Đã xác nhận tham gia phỏng vấn thành công');
    }

    // User: Xem kết quả phỏng vấn
    public function showResult($id)
    {
        $ketQua = KetQuaPhongVan::with(['phongvan.donungtuyen'])
            ->whereHas('phongvan', function($query) {
                $query->whereHas('donungtuyen', function($q) {
                    $q->where('user_id', Auth::id());
                });
            })
            ->where('phong_van_id', $id)
            ->firstOrFail();

        return view('user.interview.result', compact('ketQua'));
    }

    // Admin: Danh sách phỏng vấn
    public function list()
    {
        $interviews = PhongVan::with(['donungtuyen.ungvien', 'donungtuyen.tintuyendung'])
            ->orderBy('thoi_gian', 'desc')
            ->paginate(10);
            
        return view('admin.interview.list', compact('interviews'));
    }

    // Admin: Danh sách kết quả phỏng vấn
    public function results()
    {
        $results = PhongVan::with(['donungtuyen.ungvien', 'donungtuyen.tintuyendung', 'ketquaphongvan'])
            ->whereHas('ketquaphongvan')
            ->orderBy('thoi_gian', 'desc')
            ->paginate(10);
            
        return view('admin.interview.all-results', compact('results'));
    }
}