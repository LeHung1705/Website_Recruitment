<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function account_dashboard()
    {
        return view("users.dashboard");
    }
}
