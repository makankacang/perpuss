<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpustakaan Digital') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
 <!-- Favicon -->
        <link href="../darkpan/img/favicon.ico" rel="icon">

     <!-- Google Web Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
 
     <!-- Icon Font Stylesheet -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

     <!-- Libraries Stylesheet -->
    <link href="../darkpan/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../darkpan/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../darkpan/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    
    <link href="{{ asset('../resources/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @auth <!-- Only show when user is logged in -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-dark navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-book me-2"></i>Perpustakaan</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="/" class="nav-item nav-link {{ Request::is('homeadmin') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="/buku" class="nav-item nav-link {{ Request::is('buku') ? 'active' : '' }}"><i class="fa fa-book me-2"></i>Buku</a>
                    <a href="/kategori" class="nav-item nav-link {{ Request::is('kategori') ? 'active' : '' }}"><i class="fa fa-table me-2"></i>Kategori Buku</a>
                    <a href="/koleksis" class="nav-item nav-link {{ Request::is('koleksis') ? 'active' : '' }}"><i class="fa fa-address-book me-2"></i>Koleksi</a>
                    <a href="/peminjaman" class="nav-item nav-link {{ Request::is('peminjaman') ? 'active' : '' }}"><i class="fa fa-handshake me-2"></i>Peminjaman</a>
                    <a href="/ulasan" class="nav-item nav-link {{ Request::is('ulasan') ? 'active' : '' }}"><i class="fa fa-star me-2"></i>Ulasan Buku</a>
                    <a href="/user" class="nav-item nav-link {{ Request::is('user') ? 'active' : '' }}"><i class="fa fa-user me-2"></i>User</a>
                </div>
            </nav>            
        </div>
        @endauth

        
        <div class="main">
            <div class="content">
            <nav class="navbar navbar-expand bg-dark navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-user me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-dark border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{ route('profiles') }}" class="dropdown-item">My Profile</a>
                            <button href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal">Log Out</button>
                        </div>
                    </div>
                </div>
            </nav>

                            <!-- Logout Confirmation Modal -->
                            <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-white">
                                        <div class="modal-body">
                                            Are you sure you want to logout?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Logout Confirmation Modal -->

            @yield('content')
            </div>
        </div>
    </div>

       <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>             
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
       <script src="../darkpan/lib/chart/chart.min.js"></script>
       <script src="../darkpan/lib/easing/easing.min.js"></script>
       <script src="../darkpan/lib/waypoints/waypoints.min.js"></script>
       <script src="../darkpan/lib/owlcarousel/owl.carousel.min.js"></script>
       <script src="../darkpan/lib/tempusdominus/js/moment.min.js"></script>
       <script src="../darkpan/lib/tempusdominus/js/moment-timezone.min.js"></script>
       <script src="../darkpan/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>   
       
       <!-- Template Javascript -->
       <script src="../darkpan/js/main.js"></script>
    </div>
</body>
</html>
