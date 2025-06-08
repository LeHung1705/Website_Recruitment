@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
<style>
    .profile-info {
        margin-bottom: 2rem;
    }
    .profile-info h5 {
        color: #2457A6;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }
    .info-group {
        margin-bottom: 1rem;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 4px;
    }
    .info-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .info-content {
        color: #212529;
        white-space: pre-line;
    }
    .cv-download {
        display: inline-block;
        margin-top: 0.5rem;
        text-decoration: none;
    }
    .cv-download:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
    <div class="test-card">
        <div class="test-card-header">
            <div id="test-header">
                <h4>Hồ sơ ứng viên: {{ $user->name }}</h4>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </div>
        <div class="test-card-body">
            <div class="profile-info">
                <h5>Thông tin cá nhân</h5>
                <div class="info-group">
                    <div class="info-label">Họ và tên</div>
                    <div class="info-content">{{ $user->name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-content">{{ $user->email }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Số điện thoại</div>
                    <div class="info-content">{{ $user->phone ?? 'Chưa cập nhật' }}</div>
                </div>
            </div>

            @if($user->hosocanhan)
            <div class="profile-info">
                <h5>Học vấn</h5>
                <div class="info-group">
                    <div class="info-content">{{ $user->hosocanhan->hoc_van ?? 'Chưa cập nhật' }}</div>
                </div>
            </div>

            <div class="profile-info">
                <h5>Kinh nghiệm làm việc</h5>
                <div class="info-group">
                    <div class="info-content">{{ $user->hosocanhan->kinh_nghiem ?? 'Chưa cập nhật' }}</div>
                </div>
            </div>

            <div class="profile-info">
                <h5>Kỹ năng</h5>
                <div class="info-group">
                    <div class="info-content">{{ $user->hosocanhan->ky_nang ?? 'Chưa cập nhật' }}</div>
                </div>
            </div>

            @if($user->hosocanhan->cv_path)
            <div class="profile-info">
                <h5>CV</h5>
                <div class="info-group">
                    <a href="{{ Storage::url($user->hosocanhan->cv_path) }}" 
                       target="_blank"
                       class="btn btn-primary cv-download">
                        <i class="fas fa-download"></i> Tải xuống CV
                    </a>
                </div>
            </div>
            @endif

            @else
            <div class="alert alert-info">
                Ứng viên chưa cập nhật hồ sơ chi tiết.
            </div>
            @endif
        </div>
    </div>
@endsection