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
                <h4>Bài kiểm tra</h4>
            </div>
            <div class="card-body">
                <div class="timer" id="timer" style="margin-top: 80px;">Thời gian: 30:00</div>

                <form action="{{ route('user.test.submit', $test->id) }}" method="POST" id="testForm">
                    @csrf
                    @if(empty($donUngTuyenId))
                        <div class="alert alert-danger">
                            Không tìm thấy thông tin đơn ứng tuyển. Vui lòng liên hệ admin.
                        </div>
                    @endif
                    <input type="hidden" name="don_ung_tuyen_id" value="{{ $donUngTuyenId }}">
                    @php
                        $questions = json_decode($test->noi_dung, true);
                    @endphp

                    @foreach($questions as $index => $question)
                    <div class="question-block">
                        <h5>Câu {{ $index + 1 }}</h5>
                        <p>{{ $question['cau_hoi'] }}</p>
                        
                        <ul class="options-list">
                            @foreach($question['lua_chon'] as $optionIndex => $option)
                            <li class="option-item">
                                <label>
                                    <input type="radio" 
                                           name="answers[{{ $index }}]" 
                                           value="{{ $optionIndex }}"
                                           required>
                                    {{ $option }}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary" id="submitBtn">Nộp bài</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let timeLeft = 1800; // 30 minutes in seconds
const timerElement = document.getElementById('timer');
const form = document.getElementById('testForm');
const submitBtn = document.getElementById('submitBtn');

const timer = setInterval(() => {
    timeLeft--;
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `Thời gian: ${minutes}:${seconds.toString().padStart(2, '0')}`;

    if (timeLeft <= 0) {
        clearInterval(timer);
        form.submit();
    }
}, 1000);

// Prevent form resubmission
form.addEventListener('submit', () => {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang nộp bài...';
});

// Warn before leaving page
window.addEventListener('beforeunload', (e) => {
    e.preventDefault();
    e.returnValue = '';
});
</script>
@endpush
@endsection 