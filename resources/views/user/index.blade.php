@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <div class="sidebar">
        <div class="nav-menu">
            <div class="nav-menu-header">
                <h3>Tài khoản của tôi</h3>
            </div>
            <ul class="nav-menu-items">
                <li class="nav-menu-item">
                    <a href="{{ route('user.index') }}" class="nav-menu-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                        <i class="fas fa-user nav-menu-icon"></i>
                        Thông tin cá nhân
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('user.profile') }}" class="nav-menu-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                        <i class="fas fa-edit nav-menu-icon"></i>
                        Cập nhật hồ sơ
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('user.applications') }}" class="nav-menu-link {{ request()->routeIs('user.applications') ? 'active' : '' }}">
                        <i class="fas fa-briefcase nav-menu-icon"></i>
                        Đơn ứng tuyển
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('user.test.index') }}" class="nav-menu-link {{ request()->routeIs('user.test.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt nav-menu-icon"></i>
                        Bài kiểm tra
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('user.interview.notifications') }}" class="nav-menu-link {{ request()->routeIs('user.interview.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt nav-menu-icon"></i>
                        Lịch phỏng vấn
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a href="{{ route('logout') }}" 
                       class="nav-menu-link"
                       onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt nav-menu-icon"></i>
                        Đăng xuất
                    </a>
                </li>
            </ul>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <div class="main-content">
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-header">
                    <h4>Thông tin cá nhân</h4>
                </div>
                <div class="profile-body">
                    <div class="form-group">
                        <label class="form-label">Họ và tên</label>
                        <div class="form-control-static">{{ Auth::user()->name }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="form-control-static">{{ Auth::user()->email }}</div>
                    </div>

                    @if($profile)
                    <div class="form-group">
                        <label class="form-label">Học vấn</label>
                        <div class="form-control-static">{{ $profile->hoc_van }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kinh nghiệm làm việc</label>
                        <div class="form-control-static">{{ $profile->kinh_nghiem }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kỹ năng</label>
                        <div class="form-control-static">{{ $profile->ky_nang }}</div>
                    </div>

                    @if($profile->cv_path)
                    <div class="form-group">
                        <label class="form-label">CV</label>
                        <div class="cv-preview">
                            <a href="{{ Storage::url($profile->cv_path) }}" target="_blank">
                                <i class="fas fa-file-pdf nav-menu-icon"></i>
                                Xem CV
                            </a>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="alert alert-info">
                        Bạn chưa cập nhật hồ sơ. 
                        <a href="{{ route('user.profile') }}" class="alert-link">Cập nhật ngay</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection