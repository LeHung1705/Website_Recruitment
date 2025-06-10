@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
<style>
.status-badge {
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-cho_xu_ly {
    background-color: #fef3c7;
    color: #92400e;
}

.status-phu_hop {
    background-color: #dcfce7;
    color: #166534;
}

.status-khong_phu_hop {
    background-color: #fee2e2;
    color: #991b1b;
}

.table td {
    vertical-align: middle;
}
</style>
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
                <h4>Đơn ứng tuyển của bạn</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($applications->isEmpty())
                    <p>Bạn chưa có đơn ứng tuyển nào.</p>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Vị trí ứng tuyển</th>
                                    <th>Ngày ứng tuyển</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td>{{ $application->tintuyendung->tieu_de }}</td>
                                    <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $application->trang_thai }}">
                                            @switch($application->trang_thai)
                                                @case('phu_hop')
                                                    Phù hợp
                                                    @break
                                                @case('khong_phu_hop')
                                                    Không phù hợp
                                                    @break
                                                @default
                                                    Đang chờ xử lý
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('jobs.show', $application->tin_tuyen_dung_id) }}" 
                                           class="btn btn-primary btn-sm"
                                           style="text-decoration: none;">
                                            Xem tin tuyển dụng
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection