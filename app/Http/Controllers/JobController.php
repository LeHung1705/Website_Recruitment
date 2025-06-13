<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TinTuyenDung;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $jobs = TinTuyenDung::where('nguoi_dang_id', Auth::id())
            ->orderBy('ngay_dang', 'desc')
            ->get();
        return view('admin.jobs', compact('jobs'));
    }

    public function add_job_view()
    {
        return view('admin.add-job');
    }

    public function add_job(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'mo_ta' => 'required|string',
            'nganh_nghe' => 'required|string|max:255',
            'loai_cong_viec' => 'required|string|max:255',
            'dia_diem' => 'required|string|max:255',
            'luong' => 'required|numeric|min:0',
            'yeu_cau' => 'required|string',
        ]);

        // Create new job posting
        $job = new TinTuyenDung();
        $job->nguoi_dang_id = Auth::id();
        $job->tieu_de = $validatedData['tieu_de'];
        $job->mo_ta = $validatedData['mo_ta'];
        $job->nganh_nghe = $validatedData['nganh_nghe'];
        $job->loai_cong_viec = $validatedData['loai_cong_viec'];
        $job->dia_diem = $validatedData['dia_diem'];
        $job->luong = $validatedData['luong'];
        $job->yeu_cau = $validatedData['yeu_cau'];
        $job->save();

        return redirect()->route('admin.jobs')->with('success', 'Đã thêm tin tuyển dụng thành công!');
    }

    public function edit_job_view($id)
    {
        $job = TinTuyenDung::findOrFail($id);
        return view('admin.jobs.edit-job', compact('job'));
    }

    public function edit_job(Request $request, $id){
        $job = TinTuyenDung::findOrFail($id);
        $job->tieu_de = $request->tieu_de;
        $job->mo_ta = $request->mo_ta;
        $job->nganh_nghe = $request->nganh_nghe;
        $job->loai_cong_viec = $request->loai_cong_viec;
        $job->dia_diem = $request->dia_diem;
        $job->luong = $request->luong;
        $job->yeu_cau = $request->yeu_cau;
        $job->save();
        return redirect()->route('admin.jobs')->with('success', 'Đã cập nhật tin tuyển dụng thành công!');  
    }

    public function delete_job($id){
        $job = TinTuyenDung::findOrFail($id);
        $job->delete();
        return redirect()->route('admin.jobs')->with('success', 'Đã xóa tin tuyển dụng thành công!');
    }
}
