<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hosocanhan;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $profile = Hosocanhan::where('nguoi_dung_id', Auth::id())->first(); //lấy hồ sơ cá nhân của người dùng đang đăng nhập
        return view('profile', compact('profile')); //truyền biến vào view
    }

    public function storeOrUpdate(Request $request){
        $request->validate([
            'hoc_van' => 'required',
            'kinh_nghiem' => 'required',
            'ky_nang' => 'required',
            'cv_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $profile = Hosocanhan::updateOrCreate( //tạo hoặc cập nhật hồ sơ cá nhân, updateOrCreate là hàm tạo hoặc cập nhật dữ liệu
            ['nguoi_dung_id' => Auth::id()],
            [
                'hoc_van' => $request->hoc_van,
                'kinh_nghiem' => $request->kinh_nghiem,
                'ky_nang' => $request->ky_nang,
            ]
        );

        if($request->hasFile('cv_path')){
            $file = $request->file('cv_path');
            
            // Tạo tên file unique để tránh trùng lặp
            $fileName = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            
            // Di chuyển file vào thư mục public/uploads
            $file->move(public_path('uploads'), $fileName);
            
            // Lưu đường dẫn tương đối vào database
            $profile->cv_path = 'uploads/' . $fileName;
            $profile->save();
        }

        return redirect()->route('user.profile')->with('success', 'Hồ sơ cá nhân đã được cập nhật thành công');
    }
}