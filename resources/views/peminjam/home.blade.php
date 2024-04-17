@extends('layouts.papp')

@section('content')
        <!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">100% Online</h4>
                        <h1 class="mb-5 display-3 text-primary">Perpustakaan Online</h1>
                        <div class="position-relative mx-auto">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded position-relative">
                                    <img src="../img/60207_amazonia-doc-image.jpg" class="img-fluid w-100 bg-secondary rounded" style="height: 300px; object-fit: cover;" alt="First slide">
                                    <a href="#" class="btn btn-primary px-4 py-2 text-white rounded position-absolute top-50 start-50 translate-middle">Fantasy</a>
                                </div>
                                <div class="carousel-item rounded position-relative">
                                    <img src="../img/61117f8f2a24d0001862714c.jpg" class="img-fluid w-100 rounded" style="height: 300px; object-fit: cover;" alt="Second slide">
                                    <a href="#" class="btn btn-primary px-4 py-2 text-white rounded position-absolute top-50 start-50 translate-middle">Action</a>
                                </div>
                                <div class="carousel-item rounded position-relative">
                                    <img src="../img/family-drama-fiction-reads-ftr.jpg" class="img-fluid w-100 rounded" style="height: 300px; object-fit: cover;" alt="Third slide">
                                    <a href="#" class="btn btn-primary px-4 py-2 text-white rounded position-absolute top-50 start-50 translate-middle">Drama</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    
                                          
                    
                </div>
            </div>
        </div>
        <!-- Hero End -->

        <!-- Online Library Features Section -->
        <div class="container-fluid featurs py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fa fa-book fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Wide Selection</h5>
                                <p class="mb-0">Explore a vast collection of books from various genres.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-users fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Community Engagement</h5>
                                <p class="mb-0">Connect with fellow readers, join book clubs, and participate in discussions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-search fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Advanced Search</h5>
                                <p class="mb-0">Effortlessly find your favorite books using our advanced search feature.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fa fa-list fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Lots of Categories</h5>
                                <p class="mb-0">Explore a wide range of categories to find your favorite books.</p>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <!-- Online Library Features Section End -->

<!-- Banner Section Start-->
<div class="container-fluid banner bg-secondary my-5">
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="py-4">
                    <h1 class="display-3 text-white">Perpustakaan Digital Terbaik</h1>
                    <p class="fw-normal display-3 text-dark mb-4">di SMK Merdeka</p>
                    <p class="mb-4 text-dark">Selamat datang di perpustakaan digital terbaik di SMK Merdeka, tempat untuk menemukan berbagai informasi dan pengetahuan. Mari jelajahi koleksi kami!</p>
                    <a href="/perpustakaan" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">Jelajahi</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="../img/perpus.png" class="img-fluid w-100 rounded" alt="">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 140px; height: 140px; top: 0; left: 0;">
                        <h1 style="font-size: 100px;">1</h1>
                        <div class="d-flex flex-column">
                            <span class="h2 mb-0">#</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Section End -->

@endsection