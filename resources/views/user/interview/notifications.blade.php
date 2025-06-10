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
            <div class="card-header">
                <h4>Lịch phỏng vấn của bạn</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 4px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px;">
                        {{ session('error') }}
                    </div>
                @endif

                @if($notifications->isEmpty())
                    <p>Bạn chưa có lịch phỏng vấn nào.</p>
                @else
                    @foreach($notifications as $notification)
                    <div class="interview-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                @if($notification->phongvan && $notification->phongvan->donungtuyen && $notification->phongvan->donungtuyen->tintuyendung)
                                    <h4 class="mb-1">{{ $notification->phongvan->donungtuyen->tintuyendung->tieu_de }}</h4>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-building"></i> 
                                        @if($notification->phongvan->donungtuyen->tintuyendung->nhatuyendung)
                                            {{ $notification->phongvan->donungtuyen->tintuyendung->nhatuyendung->name }}
                                        @else
                                            Công ty không xác định
                                        @endif
                                    </p>
                                @else
                                    <h5 class="mb-1">Thông báo phỏng vấn</h5>
                                    <p class="text-muted mb-0">{{ $notification->noi_dung }}</p>
                                @endif
                            </div>
                            @if($notification->phongvan)
                                <span class="interview-status status-{{ $notification->phongvan->trang_thai }}">
                                    @switch($notification->phongvan->trang_thai)
                                        @case('cho_xac_nhan')
                                            Chờ xác nhận
                                            @break
                                        @case('da_xac_nhan')
                                            Đã xác nhận
                                            @break
                                        @case('da_hoan_thanh')
                                            Đã hoàn thành
                                            @break
                                    @endswitch
                                </span>
                            @endif
                        </div>
                        
                        @if($notification->phongvan)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <i class="fas fa-clock"></i> 
                                        Thời gian: {{ \Carbon\Carbon::parse($notification->phongvan->thoi_gian)->format('H:i - d/m/Y') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-video"></i> 
                                        Hình thức: {{ ucfirst($notification->phongvan->hinh_thuc) }}
                                    </p>
                                    @if($notification->phongvan->hinh_thuc == 'offline')
                                        <p class="mb-1">
                                            <i class="fas fa-map-marker-alt"></i> 
                                            Địa điểm: Tầng 82, Toà nhà Landmark 81, đường Lê Văn Lương, phường Tân Định, quận 1, TP.HCM
                                        </p>
                                    @else
                                        <p class="mb-1">
                                            <i class="fas fa-video"></i> 
                                            Truy cập: https://meet.jit.si/TraiDepBanHangTuyenDung
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    @switch($notification->phongvan->trang_thai)
                                        @case('cho_xac_nhan')
                                            <form action="{{ route('user.interview.confirm', $notification->phongvan->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn xác nhận tham gia phỏng vấn này?')">
                                                    <i class="fas fa-check"></i> Xác nhận tham gia
                                                </button>
                                            </form>
                                            @break
                                        @case('da_xac_nhan')
                                            <a href="#{{--{{ route('user.interview.show', $notification->phongvan->id) }}--}}" 
                                               class="btn btn-info">
                                                <i class="fas fa-info-circle"></i> Xem chi tiết
                                            </a>
                                            @break
                                        @case('da_hoan_thanh')
                                            <a href="{{ route('user.interview.result', $notification->phongvan->id) }}" 
                                               class="btn btn-secondary">
                                                <i class="fas fa-star"></i> Xem kết quả
                                            </a>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                {{ $notification->noi_dung }}
                            </div>
                        @endif
                    </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

