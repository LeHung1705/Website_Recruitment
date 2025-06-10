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
                <h4>Chi tiết phỏng vấn</h4>
                <a href="{{ route('user.interview.notifications') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <div class="detail-card">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="mb-2">{{ $interview->donungtuyen->tintuyendung->tieu_de }}</h4>
                            <p class="text-muted mb-0">
                                <i class="fas fa-building"></i> 
                                {{ $interview->donungtuyen->tintuyendung->nhatuyendung->name }}
                            </p>
                        </div>
                        <span class="interview-status status-{{ $interview->trang_thai }}">
                            @switch($interview->trang_thai)
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
                    </div>

                    <div class="info-section">
                        <h5><i class="fas fa-info-circle"></i> Thông tin phỏng vấn</h5>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-clock"></i> Thời gian:</span>
                            <span class="info-content">{{ \Carbon\Carbon::parse($interview->thoi_gian)->format('H:i - d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-video"></i> Hình thức:</span>
                            <span class="info-content">{{ ucfirst($interview->hinh_thuc) }}</span>
                        </div>
                        @if($interview->hinh_thuc == 'offline')
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-map-marker-alt"></i> Địa điểm:</span>
                                <span class="info-content">{{ $interview->donungtuyen->tintuyendung->dia_diem }}</span>
                            </div>
                        @else
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-link"></i> Link phỏng vấn:</span>
                                <span class="info-content">
                                    <a href="#" class="text-primary">Link sẽ được gửi trước buổi phỏng vấn</a>
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="info-section">
                        <h5><i class="fas fa-user-tie"></i> Người phỏng vấn</h5>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-user"></i> Họ tên:</span>
                            <span class="info-content">{{ $interview->nguoidung->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-envelope"></i> Email:</span>
                            <span class="info-content">{{ $interview->nguoidung->email }}</span>
                        </div>
                    </div>

                    <div class="info-section">
                        <h5><i class="fas fa-briefcase"></i> Thông tin công việc</h5>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-building"></i> Công ty:</span>
                            <span class="info-content">{{ $interview->donungtuyen->tintuyendung->nhatuyendung->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-map-marker-alt"></i> Địa chỉ:</span>
                            <span class="info-content">{{ $interview->donungtuyen->tintuyendung->dia_diem }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-money-bill-wave"></i> Mức lương:</span>
                            <span class="info-content">{{ $interview->donungtuyen->tintuyendung->luong }}</span>
                        </div>
                    </div>

                    @if($interview->hinh_thuc == 'offline')
                        <div class="info-section">
                            <h5><i class="fas fa-map"></i> Bản đồ</h5>
                            <div class="map-container">
                                <div id="map" style="height: 300px;"></div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <h5><i class="fas fa-clipboard-list"></i> Lưu ý</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Vui lòng có mặt trước 15 phút</li>
                            <li><i class="fas fa-check text-success me-2"></i> Mang theo CV và các giấy tờ liên quan</li>
                            <li><i class="fas fa-check text-success me-2"></i> Ăn mặc lịch sự, chuyên nghiệp</li>
                            @if($interview->hinh_thuc == 'online')
                                <li><i class="fas fa-check text-success me-2"></i> Chuẩn bị máy tính và đường truyền internet ổn định</li>
                                <li><i class="fas fa-check text-success me-2"></i> Đảm bảo môi trường yên tĩnh khi phỏng vấn</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if($interview->hinh_thuc == 'offline')
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
<script>
function initMap() {
    // Thêm code khởi tạo Google Maps ở đây nếu cần
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: { lat: -34.397, lng: 150.644 }, // Cập nhật tọa độ thực tế của địa điểm
    });
}
</script>
@endpush
@endif
