@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('assets/css/log-in.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tinos&display=swap" rel="stylesheet" />
    <title>INTROWEAR - Đăng nhập</title>
  </head>

  <body>
    
    <!-- LOGIN CONTENT -->
    <div class="content">
      <div class="login-container">
        <div class="login-title font-tinos">TÀI KHOẢN CỦA TÔI</div>
        <div class="login-subtitle font-tinos">Đăng nhập ngay để nhận các ưu đãi độc quyền</div>

        <div class="login-options">
          <button style="text-decoration: none; color: black;" id="login-page" class="login-choice font-tinos">ĐĂNG NHẬP</button>
          <button id="register-page" class="register-choice font-tinos" onclick="window.location='{{ route('register') }}'">ĐĂNG KÝ</button>
        </div>

        <div class="login-form-container">
          <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <div class="form-group">
              <input type="email" name="email" id="login-email" placeholder="Email *" value="{{ old('email') }}" required autofocus />
              @error('email')
                <div class="text-danger" style="font-size: 14px;">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <input type="password" name="password" id="login-password" placeholder="Password" required />
              @error('password')
                <div class="text-danger" style="font-size: 14px;">{{ $message }}</div>
              @enderror
            </div>

            <div class="forget-password">
              @if (Route::has('password.request'))
                <a class="font-tinos" href="{{ route('password.request') }}">Quên mật khẩu?</a>
              @endif
            </div>

            <input type="submit" class="font-inter" value="ĐĂNG NHẬP" />
          </form>

          <div class="font-tinos">Hoặc</div>
        
        <a href="#" class="login-with-google font-inter item-size">
          <div class="logo-google">
              <img src="{{ asset('assets/images/logo-google.png') }}" alt="logo-google" width="10px" />
          </div>
          <span class="btn-google font-inter btn-link">ĐĂNG NHẬP GOOGLE</span>
        </a>
        
          <button class="login-with-facebook font-inter item-size">
            <div class="logo-facebook">
              <i class="fa-brands fa-facebook" style="color: #ffffff; width: 20px"></i>
            </div>
            <span class="btn-facebook font-inter btn-link">ĐĂNG NHẬP FACEBOOK</span>
          </button>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
  

    <script src="{{ asset('assets/js/log-in.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
  </body>
</html>
@endsection
