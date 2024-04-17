<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Perpustakaan Digital</title>

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Include RateYo library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

        <!-- Libraries Stylesheet -->
        <link href="../fruitables/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="../fruitables/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="../fruitables/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="../fruitables/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">

<style>
    /* Add this CSS in your existing CSS file or style tag */
    .rating {
        unicode-bidi: bidi-override;
        direction: rtl;
        text-align: center;
    }

    .rating input {
        display: none;
    }

    .rating label {
        display: inline-block;
        padding: 5px;
        font-size: 20px;
        color: #FFD700;
        cursor: pointer;
    }

    .rating label:hover,
    .rating label:hover ~ label,
    .rating input:checked ~ label {
        color: #FFED85;
    }
</style>

</head>
<body>
    <div id="app">
        @auth <!-- Only show when user is logged in -->
        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Jl. Pahlawan No. 54</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">smkmerdeka@gmail.com</a></small>
                    </div>
                    <div class="top-link pe-1">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.html" class="navbar-brand"><h1 class="text-primary display-6">Perpus</h1></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="/home" class="nav-item nav-link {{ request()->routeIs('homep') ? 'active' : '' }}">Home</a>
                            <a href="/perpustakaan" class="nav-item nav-link {{ request()->routeIs('peminjam.perpus') ? 'active' : '' }}">Perpustakaan</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Me</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="{{ route('peminjam.pinjaman') }}" class="dropdown-item {{ request()->routeIs('peminjam.pinjaman') ? 'active' : '' }}">Pinjaman</a>
                                    <a href="{{ route('peminjam.koleksi') }}" class="dropdown-item {{ request()->routeIs('peminjam.koleksi') ? 'active' : '' }}">Koleksi Saya</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <div class="dropdown">
                                <button class="btn-search btn border border-secondary rounded-pill bg-white me-4 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user text-primary"></i> {{ auth()->user()->name }} <!-- Display the authenticated user's name -->
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="btn dropdown-item" href="/profile">Profile</a></li> <!-- Add a link to the user's profile page -->
                                    <li><a class="btn dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal">Log Out</a></li> <!-- Add a link to log out -->
                                </ul>
                            </div>
                        </div>                        
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->


        @endauth
                            <!-- Logout Confirmation Modal -->
                            <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
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
        
        <div class="main">
            <div class="content">

            @yield('content')
            <!-- Footer Start -->
            <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
                <div class="container py-5">
                    <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <a href="#">
                                    <h1 class="text-primary mb-0">Perpustakaan Digital</h1>
                                </a>
                            </div>
                            <div class="col-lg-6">
                                <div class="position-relative mx-auto">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex justify-content-end pt-3">
                                    <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                    <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-5">
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-item">
                                <h4 class="text-light mb-3">Why People Like us!</h4>
                                <p class="mb-4">typesetting, remaining essentially unchanged. It was 
                                    popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-item">
                                <h4 class="text-light mb-3">Contact</h4>
                                <p>Alamat: Jln. Merdeka</p>
                                <p>Email: Example@gmail.com</p>
                                <p>No Telepon: +6283 4567 8910</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->

            <!-- Copyright Start -->
            <div class="container-fluid copyright bg-dark py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            <span class="text-light"><a href="/home"><i class="fas fa-copyright text-light me-2"></i>Perpus</a>, All right reserved.</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Copyright End -->



            <!-- Back to Top -->
            <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   
            </div>
        </div>
    </div>


    </div>

    <!-- Include RateYo library -->
                <!-- JavaScript Libraries -->
                <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="../fruitables/lib/chart/chart.min.js"></script>
                <script src="../fruitables/lib/easing/easing.min.js"></script>
                <script src="../fruitables/lib/waypoints/waypoints.min.js"></script>
                <script src="../fruitables/lib/owlcarousel/owl.carousel.min.js"></script>
                <script src="../fruitables/lib/tempusdominus/js/moment.min.js"></script>
                <script src="../fruitables/lib/tempusdominus/js/moment-timezone.min.js"></script>
                <script src="../fruitables/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/star-rating-svg/dist.min.js"></script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/star-rating-svg/dist.min.css"/>
                
                <!-- Template Javascript -->
                <script src="../fruitables/js/main.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

</body>
</html>
