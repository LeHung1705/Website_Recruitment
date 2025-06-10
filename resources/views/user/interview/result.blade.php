@extends('layouts.app')

@push('styles')

<link rel="stylesheet" href="{{ asset('assets/css/interview.css') }}">
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
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Kết quả phỏng vấn</h4>
                <a href="{{ route('user.interview.notifications') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <div class="detail-card">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h3 class="mb-2">{{ $ketQua->phongvan->donungtuyen->tintuyendung->tieu_de ?? 'Không có tiêu đề' }}</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-building"></i> 
                                {{ $ketQua->phongvan->donungtuyen->tintuyendung->nhatuyendung->name ?? 'Không có thông tin công ty' }}
                            </p>
                        </div>
                        <span class="interview-status status-da_hoan_thanh">
                            Đã hoàn thành
                        </span>
                    </div>

                    <div class="info-section">
                        <h5><i class="fas fa-star"></i> Kết quả phỏng vấn</h5>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-check-circle"></i> Kết quả:</span>
                            <span class="info-content">
                                @if($ketQua->ket_qua == 'dau')
                                    <span class="badge bg-success">Đạt</span>
                                @else
                                    <span class="badge bg-danger">Không đạt</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-chart-bar"></i> Điểm số:</span>
                            <span class="info-content">{{ $ketQua->diem_so }}/10</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-comment"></i> Nhận xét:</span>
                            <span class="info-content">{{ $ketQua->nhan_xet }}</span>
                        </div>
                    </div>

                    <div class="info-section">
                        <h5><i class="fas fa-info-circle"></i> Thông tin phỏng vấn</h5>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-clock"></i> Thời gian:</span>
                            <span class="info-content">{{ \Carbon\Carbon::parse($ketQua->phongvan->thoi_gian)->format('H:i - d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-video"></i> Hình thức:</span>
                            <span class="info-content">{{ ucfirst($ketQua->phongvan->hinh_thuc) }}</span>
                        </div>
                    </div>

                    @if($ketQua->ket_qua == 'dau')
                    <div class="alert alert-success mt-4">
                        <i class="fas fa-info-circle"></i> 
                        Chúc mừng bạn đã vượt qua vòng phỏng vấn! Chúng tôi sẽ liên hệ với bạn để thông báo các bước tiếp theo.
                    </div>
                    @else
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle"></i> 
                        Cảm ơn bạn đã tham gia phỏng vấn. Đừng nản lòng, hãy tiếp tục cải thiện và ứng tuyển các vị trí khác phù hợp!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
