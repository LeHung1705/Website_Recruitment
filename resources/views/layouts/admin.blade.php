<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WebsiteTuyenDung') }}</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="header-top">
            <div class="logo">
                <a href="{{ url('/') }}" style="text-decoration: none; color: black; font-size: 20px; font-weight: bold; font-family: 'Playfair Display', serif;">
                    <img style="width:20%;" src="{{ asset('assets/images/LOGO.png') }}" alt="Logo" class="logo-img">TraiDepTuyenDung
                </a>
            </div>
            @guest
                <div class="header-right">
                    <a href=" {{ route('login') }} " class="btn-candidate header-right-item font-playfair-display">
                        Đăng Nhập
                    </a>
                </div>
            @else
                <div class="header-right">
                    <a style="text-decoration: none;" href="{{ route('admin.index') }}"
                        class="btn-candidate header-right-item font-playfair-display">
                        <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        <span style="padding: 10px; font-size:15px; white-space: nowrap;">{{ Auth::user()->name }}</span>
                    </a>
                </div>
            @endguest
        </div>
    </header>

    <!-- NAVIGATION -->
    <main>
        <div class="sidebar">
            <a href="{{ route('admin.add_job_view') }}" class="nav-item {{ request()->routeIs('admin.add_job_view') ? 'active' : '' }}">
                <i class="bi bi-plus-square"></i> Thêm mới việc làm
            </a>
            <a href="{{ route('admin.jobs') }}" class="nav-item {{ request()->routeIs('admin.jobs') || request()->routeIs('admin.applications') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i> Quản lý tin tuyển dụng & ứng viên
            </a>
            
            <div class="nav-item-dropdown">
                <a href="#" class="nav-item {{ request()->routeIs('admin.interview.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i> Quản lý phỏng vấn
                    <i class="bi bi-chevron-right" style="float: right; margin: 3px;"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('admin.interview.list') }}" 
                        class="dropdown-item {{ request()->routeIs('admin.interview.list') ? 'active' : '' }}">
                        <i class="bi bi-list-ul"></i> Danh sách phỏng vấn
                    </a>
                    <a href="{{ route('admin.interview.results') }}" 
                        class="dropdown-item {{ request()->routeIs('admin.interview.results') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check"></i> Kết quả phỏng vấn
                    </a>
                </div>
            </div>

            <div class="nav-item-dropdown">
                <a href="#" class="nav-item {{ request()->routeIs('admin.test.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Quản lý bài kiểm tra
                    <i class="bi bi-chevron-right" style="float: right; margin: 3px;"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('admin.test.create') }}" 
                        class="dropdown-item {{ request()->routeIs('admin.test.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i> Thêm bài kiểm tra
                    </a>
                    <a href="{{ route('admin.test.index') }}" 
                        class="dropdown-item {{ request()->routeIs('admin.test.index') ? 'active' : '' }}">
                        <i class="bi bi-list"></i> Danh sách bài kiểm tra
                    </a>
                    <a href="{{ route('admin.test.results', ['id' => 'all']) }}" 
                        class="dropdown-item {{ request()->routeIs('admin.test.results') ? 'active' : '' }}">
                        <i class="bi bi-graph-up"></i> Kết quả kiểm tra
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="nav-logout">
                @csrf
                <button type="submit" class="sidebar-btn">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </button>
            </form>
        </div>

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="footer-left">
            <h4>&copy; 2023 IntroWear. All rights reserved.</h4><br>
            <p>From: Trường Đại Học Công Nghệ Thông Tin - Đại Học Quốc Gia TP Hồ Chí Minh</p>
            <p>----------------</p>
        </div>
        <div class="footer-right">
            <i class="bi bi-telephone"> Contact: 0987654321</i>
            <br>
            <i class="bi bi-envelope"> Address: Khu phố 6, phường Linh Trung, Thủ Đức, TP Hồ Chí Minh</i>
        </div>
    </footer>
    @stack('scripts')
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

