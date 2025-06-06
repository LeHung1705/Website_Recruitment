<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hosocanhan;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $profile = Hosocanhan::where('nguoi_dung_id', Auth::id())->first();
        return view("user.index", compact('profile'));
    }
}
