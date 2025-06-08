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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[UserController::class,'index'])->name('user.index');
    Route::get('/profile',[ProfileController::class,'index'])->name('user.profile');
    Route::post('/profile',[ProfileController::class,'storeOrUpdate'])->name('user.profile.store');
    Route::get('/applications', [ApplicationController::class, 'showApplicationsUser'])->name('user.applications');
    //Route Ứng tuyển - cần đăng nhập
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply'])->name('apply.job');

    // Routes cho user (USR) - Bài kiểm tra
    Route::prefix('user/test')->name('user.test.')->group(function () {
        Route::get('/', [TestController::class, 'candidateIndex'])->name('index');
        Route::get('/history', [TestController::class, 'candidateHistory'])->name('history');
        Route::get('/result/{id}', [TestController::class, 'candidateResult'])->name('result');
        Route::get('/{id}', [TestController::class, 'showTest'])->name('show');
        Route::post('/{id}/submit', [TestController::class, 'submitTest'])->name('submit');
    });
});

//Route cua Admin
Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
    Route::get('/admin/jobs',[JobController::class,'index'])->name('admin.jobs');
    Route::get('/admin/add-job', [JobController::class, 'add_job_view'])->name('admin.add_job_view');
    Route::post('/admin/add-job', [JobController::class, 'add_job'])->name('admin.add_job');

    // Thêm routes quản lý ứng viên
    Route::get('/admin/jobs/{job}/applications', [ApplicationController::class, 'showApplications'])->name('admin.applications');
    Route::patch('/admin/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('admin.applications.update-status');
    Route::get('/admin/profiles/{user}', [ApplicationController::class, 'viewProfile'])->name('admin.view.profile');

    // Routes cho admin (ADM) - Bài kiểm tra
    Route::prefix('admin/test')->name('admin.test.')->group(function () {
        Route::get('/', [TestController::class, 'index'])->name('index');
        Route::get('/create', [TestController::class, 'showCreateForm'])->name('create');
        Route::post('/store', [TestController::class, 'store'])->name('store');
        Route::get('/{id}/invite', [TestController::class, 'showInviteForm'])->name('invite');
        Route::post('/{id}/send-invite', [TestController::class, 'sendInvite'])->name('send.invite');
        Route::get('/{id}/results', [TestController::class, 'showResults'])->name('results');
        Route::delete('/{id}', [TestController::class, 'destroy'])->name('destroy');
    });
});

//Route Job
Route::get('/jobs',[ApplicationController::class,'index'])->name('jobs.index');
Route::get('/jobs/search', [ApplicationController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{job}', [ApplicationController::class, 'show'])->name('jobs.show');


