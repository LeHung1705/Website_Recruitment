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
                    <a href="#" class="nav-menu-link {{ request()->routeIs('user.applications') ? 'active' : '' }}">
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
                    <a href="#" class="nav-menu-link {{ request()->routeIs('user.interviews') ? 'active' : '' }}">
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
                    <h4>Hồ Sơ Cá Nhân</h4>
                </div>
                <div class="profile-body">
                    @if(session('success'))
                        <div class="success-alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{route('user.profile.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="hoc_van">Học Vấn</label>
                            <textarea class="form-control @error('hoc_van') error @enderror" 
                                id="hoc_van" 
                                name="hoc_van" 
                                rows="3"
                                required>{{ old('hoc_van', $profile->hoc_van ?? '') }}</textarea>
                            @error('hoc_van')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="kinh_nghiem">Kinh Nghiệm Làm Việc</label>
                            <textarea class="form-control @error('kinh_nghiem') error @enderror" 
                                id="kinh_nghiem" 
                                name="kinh_nghiem" 
                                rows="3"
                                required>{{ old('kinh_nghiem', $profile->kinh_nghiem ?? '') }}</textarea>
                            @error('kinh_nghiem')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ky_nang">Kỹ Năng</label>
                            <textarea class="form-control @error('ky_nang') error @enderror" 
                                id="ky_nang" 
                                name="ky_nang" 
                                rows="3"
                                required>{{ old('ky_nang', $profile->ky_nang ?? '') }}</textarea>
                            @error('ky_nang')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="cv_path">CV (PDF, DOC, DOCX - Max 2MB)</label>
                            <input type="file" 
                                class="form-control @error('cv_path') error @enderror" 
                                id="cv_path" 
                                name="cv_path"
                                accept=".pdf,.doc,.docx">
                            @error('cv_path')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            @if($profile && $profile->cv_path)
                                <div class="cv-preview">
                                    CV hiện tại: 
                                    <a href="{{ Storage::url($profile->cv_path) }}" target="_blank">Xem CV</a>
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="submit-button">
                            {{ $profile ? 'Cập Nhật Hồ Sơ' : 'Tạo Hồ Sơ' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection