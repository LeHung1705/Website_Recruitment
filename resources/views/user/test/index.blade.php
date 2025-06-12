@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
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
                <h4>Bài kiểm tra của bạn</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.test.history') }}">
                            Lịch sử kiểm tra
                        </a>
                    </li>
                </ul>

                @if($pendingTests->isEmpty())
                <p>Bạn chưa có bài kiểm tra nào mới.</p>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Loại bài</th>
                                <th>Thời gian</th>
                                <th>Số câu hỏi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingTests as $notification)
                            @php
                                $test = $notification->baikiemtra;
                                $questions = json_decode($test->noi_dung, true);
                            @endphp
                            <tr>
                                <td>{{ ucfirst($test->loai_bai) }}</td>
                                <td>30 phút</td>
                                <td>{{ count($questions) }}</td>
                                <td>
                                    <a href="{{ route('user.test.show', $test->id) }}" 
                                       class="btn btn-primary"
                                       style="text-decoration: none;"
                                       onclick="return confirm('Bạn có chắc muốn bắt đầu làm bài? Thời gian sẽ bắt đầu tính ngay khi bạn vào làm bài.')">
                                        Bắt đầu làm bài
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pendingTests->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 