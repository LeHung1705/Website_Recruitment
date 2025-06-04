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
        $hoSo = Hosocanhan::where('user_id', Auth::id())->first();
        
        if (!$hoSo) {
            return redirect()->route('user.index')
                           ->with('error', 'Vui lòng cập nhật hồ sơ cá nhân trước khi ứng tuyển');
        }

        $exists = Donungtuyen::where('user_id', Auth::id())
                            ->where('tin_tuyen_dung_id', $job_id)
                            ->exists();

        if ($exists) {
            return back()->with('error', 'Bạn đã ứng tuyển công việc này rồi');
        }

        Donungtuyen::create([
            'user_id' => Auth::id(),
            'tin_tuyen_dung_id' => $job_id,
            'trang_thai' => 'cho_duyet'
        ]);

        return back()->with('success', 'Ứng tuyển thành công! Nhà tuyển dụng sẽ sớm liên hệ với bạn.');
    }
}
