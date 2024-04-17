@extends('layouts.app')

@section('content')
<!-- Total Data Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-book fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Buku</p>
                    <h6 class="mb-0">{{ $totalBuku }}</h6>
                    <hr>
                    <a href="/buku" class="btn btn-primary">View Detail</a>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-user fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total User</p>
                    <h6 class="mb-0">{{ $totalUser }}</h6>
                    <hr>
                    <a href="/user" class="btn btn-primary">View Detail</a> 
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-handshake fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Peminjaman</p>
                    <h6 class="mb-0">{{ $totalPeminjaman }}</h6>
                    <hr>
                    <a href="/peminjaman" class="btn btn-primary">View Detail</a> 
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-star fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Ulasan</p>
                    <h6 class="mb-0">{{ $totalUlasan }}</h6>
                    <hr>
                    <a href="/ulasan" class="btn btn-primary">View Detail</a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Total Data End -->



            <!-- Recent Peminjaman Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-dark text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Peminjaman Terbaru</h6>
                        <a href="/peminjaman">Tampilkan Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Tanggal Peminjaman</th>
                                    <th scope="col">Tanggal Pengembalian</th>
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPeminjaman as $peminjaman)
                                <tr>
                                    <td>{{ $peminjaman->TanggalPeminjaman }}</td>
                                    <td>{{ $peminjaman->TanggalPengembalian }}</td>
                                    <td>{{ $peminjaman->buku->Judul }}</td>
                                    <td>{{ $peminjaman->user->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Peminjaman End -->

@endsection
