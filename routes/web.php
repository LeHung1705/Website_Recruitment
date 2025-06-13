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
use App\Http\Controllers\InterviewController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[UserController::class,'index'])->name('user.index');
    Route::get('/profile',[ProfileController::class,'index'])->name('user.profile');
    Route::post('/profile',[ProfileController::class,'storeOrUpdate'])->name('user.profile.store');
    Route::get('/applications', [ApplicationController::class, 'showApplicationsUser'])->name('user.applications');
    //Route Ứng tuyển - cần đăng nhập
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply'])->name('apply.job');

    // Routes cho user (USR) - Phỏng vấn
    Route::prefix('user/interviews')->name('user.interview.')->group(function () {
        Route::get('/', [InterviewController::class, 'notifications'])->name('notifications');
        Route::get('/{id}', [InterviewController::class, 'show'])->name('show');
        Route::post('/{id}/confirm', [InterviewController::class, 'confirm'])->name('confirm');
        Route::get('/{id}/result', [InterviewController::class, 'showResult'])->name('result');
    });

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

    // Routes cho admin (ADM) - Quản lý tin tuyển dụng
    Route::get('/admin/jobs',[JobController::class,'index'])->name('admin.jobs');
    Route::get('/admin/add-job', [JobController::class, 'add_job_view'])->name('admin.add_job_view');
    Route::post('/admin/add-job', [JobController::class, 'add_job'])->name('admin.add_job');
    Route::get('/admin/jobs/{job}/edit', [JobController::class, 'edit_job_view'])->name('admin.edit_job_view');
    Route::put('/admin/jobs/{job}/edit', [JobController::class, 'edit_job'])->name('admin.edit_job');
    Route::delete('/admin/jobs/{job}', [JobController::class, 'delete_job'])->name('admin.delete_job');

    // Routes cho admin (ADM) - Phỏng vấn
    Route::prefix('admin/interviews')->name('admin.interview.')->group(function () {
        Route::get('/', [InterviewController::class, 'list'])->name('list');
        Route::get('/results', [InterviewController::class, 'results'])->name('results');
        Route::post('/invite/{id}', [InterviewController::class, 'sendInvite'])->name('invite');
        Route::get('/{id}/result', [InterviewController::class, 'showResultForm'])->name('result.form');
        Route::post('/{id}/result', [InterviewController::class, 'storeResult'])->name('result.store');
    });

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

    // Interview routes
    Route::get('/interviews/invite/{id}', [InterviewController::class, 'showFormInvite'])->name('interview.invite');
    Route::post('/interviews/invite/{id}', [InterviewController::class, 'sendInvite'])->name('interview.sendInvite');
    Route::get('/interviews/{id}/result', [InterviewController::class, 'showResultForm'])->name('interview.result.form');
    Route::post('/interviews/{id}/result', [InterviewController::class, 'storeResult'])->name('interview.result.store');
});

//Route Job
Route::get('/jobs',[ApplicationController::class,'index'])->name('jobs.index');
Route::get('/jobs/search', [ApplicationController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{job}', [ApplicationController::class, 'show'])->name('jobs.show');

