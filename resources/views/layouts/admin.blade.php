<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bảng Điều Khiển Quản Trị - PrimeLux Auto Admin')</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    @stack('styles')
</head>

<body style="background-color: #090d16;">

    <!-- TOP HEADER -->
    <nav class="navbar navbar-dark bg-dark border-bottom border-secondary py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <span class="brand-text">PRIMELUX <span class="badge bg-warning text-dark fs-6 ms-2">ADMIN PORTAL</span></span>
            </a>
            <div class="d-flex align-items-center gap-2 gap-md-3">
                <span class="text-secondary small d-none d-md-inline"><i class="fa-solid fa-user-circle text-primary me-1"></i> Xin chào, Quản trị viên</span>
                <a href="{{ url('/consultant') }}" target="_blank" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-headset me-1"></i> Bàn Tư Vấn Viên</a>
                <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-globe me-1"></i> Xem Website</a>
                <a href="{{ url('/login?role=admin') }}" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i> Đăng Xuất</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/Index.js') }}"></script>
    @stack('scripts')
</body>

</html>
