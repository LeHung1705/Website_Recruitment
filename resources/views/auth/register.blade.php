@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}" />
@endpush
@section('content')
<div class="content">
    <div class="register-container">
        <div class="login-title font-tinos">TÀI KHOẢN CỦA TÔI</div>
        <div class="login-subtitle font-tinos">
            Đăng nhập ngay để nhận các ưu đãi độc quyền
        </div>
        <div class="login-options">
            <a  style="text-decoration: none; color: black;" href="{{ route('login') }}" class="login-choice font-tinos">ĐĂNG NHẬP</a>
            <a class="register-choice font-tinos active">ĐĂNG KÝ</a>
        </div>
        <div class="register-form-container">
            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf
                <div class="form-group">
                    <input type="text" id="register-lname" name="name" value="{{ old('name') }}" placeholder="Họ và tên" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <input type="text" id="register-phone-number" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại" required>
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <input type="email" id="login-email" name="email" value="{{ old('email') }}" placeholder="Email *" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <input type="password" id="login-password" name="password" placeholder="Password" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <input type="password" id="login-password" name="password_confirmation" placeholder="Confirm Password" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <input style="background-color: black; color: white; font-weight: bold; font-size: px; padding: 0px; cursor: pointer;" type="submit" class="font-inter" value="ĐĂNG KÝ TÀI KHOẢN">
            </form>
            <div class="font-tinos">Hoặc</div>
            <div class="login-with-google font-inter item-size">
                <div class="logo-google">
                    <img src="{{ asset('assets/images/logo-google.png') }}" alt="Google Icon" width="18px">
                </div>
                <a href="#" class="btn-google font-inter btn-link">ĐĂNG NHẬP GOOGLE</a>
            </div>
            <div class="login-with-facebook font-inter item-size">
                <div class="logo-facebook">
                    <i class="fa-brands fa-facebook" style="color: #ffffff; width: 18px"></i>
                </div>
                <a href="#" class="btn-facebook font-inter btn-link">ĐĂNG NHẬP FACEBOOK</a>
            </div>
        </div>
    </div>
</div>
@endsection