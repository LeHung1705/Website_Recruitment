<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donungtuyen;
use App\Models\Tintuyendung;
use App\Models\User;
use App\Models\Hosocanhan;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(){
        $jobs = Tintuyendung::where('trang_thai','da_phe_duyet')
            ->orderBy('ngay_dang', 'desc')
            ->paginate(16);
        return view('jobs',compact('jobs'));
    }

    public function show($id){
        $job = Tintuyendung::findOrFail($id);
        return view('job-detail',compact('job'));
    }

    public function search(Request $request)
    {
        $query = Tintuyendung::where('trang_thai', 'da_phe_duyet');

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('tieu_de', 'like', '%'.$keyword.'%')
                  ->orWhere('mo_ta', 'like', '%'.$keyword.'%')
                  ->orWhere('yeu_cau', 'like', '%'.$keyword.'%');
            });
        }

        if ($request->has('thanh_pho') && $request->thanh_pho != '') {
            $query->where('thanh_pho', $request->thanh_pho);
        }

        $jobs = $query->orderBy('ngay_dang', 'desc')
                     ->paginate(15)
                     ->withQueryString();

        return view('jobs', compact('jobs'));
    }

    public function apply(Request $request, $job_id)
    {
        $hoSo = Hosocanhan::where('nguoi_dung_id', Auth::id())->first(); // Lấy hồ sơ cá nhân của người dùng đang đăng nhập
        
        if (!$hoSo) {
            return redirect()->route('user.index')
                           ->with('error', 'Vui lòng cập nhật hồ sơ cá nhân trước khi ứng tuyển');
        }

        $exists = Donungtuyen::where('ung_vien_id', Auth::id())
                            ->where('tin_tuyen_dung_id', $job_id)
                            ->exists();

        if ($exists) {
            return back()->with('error', 'Bạn đã ứng tuyển công việc này rồi');
        }

        // Lấy thông tin tin tuyển dụng để biết ai là người đăng tin
        $job = Tintuyendung::findOrFail($job_id);

        Donungtuyen::create([
            'ung_vien_id' => Auth::id(),
            'tin_tuyen_dung_id' => $job_id,
            'nha_tuyen_dung_id' => $job->nguoi_dang_id, // Thêm ID của nhà tuyển dụng
            'trang_thai' => 'cho_xu_ly'
        ]);

        return back()->with('success', 'Ứng tuyển thành công! Nhà tuyển dụng sẽ sớm liên hệ với bạn.');
    }

    public function showApplications($jobId){
        $applications = Donungtuyen::where('tin_tuyen_dung_id', $jobId)
            ->with(['ungvien', 'ungvien.hosocanhan']) // Lấy thông tin ứng viên và hồ sơ cá nhân
            ->get();
        return view('admin.applications', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = Donungtuyen::findOrFail($id);
        $application->update(['trang_thai' => $request->status]);
        return back()->with('success', 'Đã cập nhật trạng thái đơn ứng tuyển');
    }

    public function viewProfile($userId)
    {
        $user = User::with('hosocanhan')->findOrFail($userId);
        return view('admin.profile', compact('user'));
    }
}
