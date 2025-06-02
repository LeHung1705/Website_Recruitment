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
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.jobs', compact('jobs'));
    }
}
