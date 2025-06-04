<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AuthUser;
use App\Http\Middleware\AuthAdmin;
use App\Http\Controllers\ApplicationController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[UserController::class,'index'])->name('user.index');

    //Route Ứng tuyển - cần đăng nhập
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply'])->name('apply.job');
});

//Route cua Admin
Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
    Route::get('/admin/jobs',[JobController::class,'index'])->name('admin.jobs');
    Route::get('/admin/add-job', [JobController::class, 'add_job_view'])->name('admin.add_job_view');
    Route::post('/admin/add-job', [JobController::class, 'add_job'])->name('admin.add_job');
});

//Route Job
Route::get('/jobs',[ApplicationController::class,'index'])->name('jobs.index');
Route::get('/jobs/search', [ApplicationController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{job}', [ApplicationController::class, 'show'])->name('jobs.show');


