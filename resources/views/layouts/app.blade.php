<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WebsiteTuyenDung') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <header>
      <div class="header-left">
        <img src="{{ asset('assets/images/LOGO.png')}}" alt="logo" height="90%" />
        <span class="logo-name font-playfair-display" onclick="RedirectToHomePage()">TraiDepTuyenDung</span>
      </div>

      <nav class="main-nav">
        <ul class="nav-list">
          <li class="nav-item">
            <a href="{{ route('home.index') }}" class="nav-link font-playfair-display">Home</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('jobs.index') }}" class="nav-link font-playfair-display">Jobs</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link font-playfair-display">Companies</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link font-playfair-display">About us</a>
          </li>
        </ul>
      </nav>

      @guest
      <div class="header-right">
        <a href=" {{route('login')}} " class="btn-candidate header-right-item font-playfair-display">
          Đăng Nhập
        </a>
      </div>
      @else
      <div class="header-right">
        <a style="background-color:black; text-decoration: none;"href="{{ Auth::user()->utype=='ADM' ? route('admin.index') : route('user.index')}}" class="btn-candidate header-right-item font-playfair-display">
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
            <span style="padding: 10px; font-size:15px; white-space: nowrap;">{{ Auth::user()->name }}</span>
        </a>
      </div>
      @endguest
    </header>

      <!-- code here -->
      @yield('content')

    <!-- FOOTER -->
    <footer>
        <div class="footer-left">
            <h4>&copy; 2023 IntroWear. All rights reserved.</h4><br>
            <p>From: Trường Đại Học Công Nghệ Thông Tin - Đại Học Quốc Gia TP Hồ Chí Minh</p>
            <p>----------------</p>
        </div>
        <div class="footer-right">
            <i class="bi bi-telephone">  Contact: 0987654321</i>
            <br>
            <i class="bi bi-envelope">   Address: Khu phố 6, phường Linh Trung, Thủ Đức, TP Hồ Chí Minh</i>
        </div>
    </footer>
    <script src="{{ asset('assets/js/main.js')}}"></script>
    @stack('scripts')
</body>
</html>
