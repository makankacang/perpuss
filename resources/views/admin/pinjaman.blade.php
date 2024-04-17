@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">sadasdasdsada
            <div class="bg-dark rounded h-100 p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h3>Peminjaman Table</h3>

                </div>
                <div class="table-responsive">
                    <a href="{{ route('cetak.report') }}" type="submit" class="btn btn-primary">
                        <i class="fa fa-print"></i> Cetak Report
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dikembalikanModal">
                        Buku yang dipinjam
                    </button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Buku</th> <!-- Changed to display book name -->
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                <th scope="col">Status Peminjaman</th>
                                <th scope="col">Konfirmasi</th> <!-- Add the Action column header -->
                                <th scope="col">Batal</th> <!-- Add the Action column header -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $peminjaman)
                            @if($peminjaman->StatusPeminjaman === 'konfirmasi' || $peminjaman->StatusPeminjaman === 'dipinjam')
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peminjaman->user->name }}</td>
                                <td>{{ $peminjaman->buku->Judul }}</td> <!-- Displaying book name -->
                                <td>{{ $peminjaman->TanggalPeminjaman }}</td>
                                <td>{{ $peminjaman->TanggalPengembalian }}</td>
                                <td>{{ $peminjaman->StatusPeminjaman }}</td>
                                <td class="col-2">
                                    <div class="btn-group" role="group" aria-label="Action buttons">
                                        @if($peminjaman->StatusPeminjaman === 'konfirmasi' && $peminjaman->TanggalPengembalian)
                                            @php
                                                $tanggalPengembalian = \Carbon\Carbon::parse($peminjaman->TanggalPengembalian);
                                                $tigaHariSetelahPengembalian = $tanggalPengembalian->addDays(3);
                                            @endphp
                                            @if(\Carbon\Carbon::now()->gte($tigaHariSetelahPengembalian))
                                                <button class="btn btn-sm border border-warning rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#kembalikanModal{{ $peminjaman->PeminjamanID }}">
                                                    <i class="fa fa-handshake text-warning"></i> Jatuh Tempo Tanggal Pengembalian
                                                </button>
                                            @else
                                                <button class="btn btn-sm border border-success rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#konfirmasiModal{{ $peminjaman->PeminjamanID }}">
                                                    <i class="fa fa-check text-success"></i> Konfirmasi Peminjaman
                                                </button>
                                            @endif
                                        @elseif($peminjaman->StatusPeminjaman === 'dipinjam')
                                            @php
                                                $tanggalPengembalian = \Carbon\Carbon::parse($peminjaman->TanggalPengembalian);
                                                $sekarang = \Carbon\Carbon::now();
                                            @endphp
                                            @if($sekarang->greaterThanOrEqualTo($tanggalPengembalian))
                                                <button class="btn btn-sm border border-warning rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#kembalikanModal{{ $peminjaman->PeminjamanID }}">
                                                    <i class="fa fa-handshake text-warning"></i> Konfirmasi buku kembali
                                                </button>
                                            @elseif($sekarang->gt($tanggalPengembalian->addDays(3)))
                                                <button class="btn btn-sm border border-warning rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#kembalikanModal{{ $peminjaman->PeminjamanID }}">
                                                    <i class="fa fa-handshake text-warning"></i> Jatuh Tempo Tanggal Pengembalian
                                                </button>
                                            @elseif($sekarang->gt($tanggalPengembalian))
                                                <span class="badge bg-warning">Jatuh Tempo Tanggal Pengembalian</span>
                                            @else
                                                <span class="badge bg-danger">Buku belum masuk tanggal pengembalian</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                
                                
                                
                                
                                <td>                                        <!-- Button for Batalkan Peminjaman -->
                                    <button class="btn btn-sm border border-danger rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#batalkanModal{{ $peminjaman->PeminjamanID }}">
                                        <i class="fa fa-times text-danger"></i> Batal
                                    </button>
                                
                                                                <!-- Modal for Batalkan Peminjaman -->
                                                                <div class="modal fade" id="batalkanModal{{ $peminjaman->PeminjamanID }}" tabindex="-1" aria-labelledby="batalkanModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content bg-white">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title text-dark" id="batalkanModalLabel">Batalkan Peminjaman</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body text-dark">
                                                                                Apakah Anda yakin ingin membatalkan peminjaman ini?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                                                <!-- Form to submit DELETE request -->
                                                                                <form action="{{ route('peminjaman.cancel', ['id' => $peminjaman->PeminjamanID]) }}" method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-danger">Ya</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                </td>
                                
                                
                                <!-- Modal for Konfirmasi Peminjaman -->
                                <div class="modal fade" id="konfirmasiModal{{ $peminjaman->PeminjamanID }}" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-white">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="konfirmasiModalLabel">Konfirmasi Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-dark">
                                                Apakah Anda yakin ingin konfirmasi peminjaman ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                <form action="{{ route('konfirmasiPeminjaman', $peminjaman->PeminjamanID) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Ya</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal for Konfirmasi Buku Kembali -->
                                <div class="modal fade" id="kembalikanModal{{ $peminjaman->PeminjamanID }}" tabindex="-1" aria-labelledby="kembalikanModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-white">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark" id="kembalikanModalLabel">Konfirmasi Buku Kembali</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-dark">
                                                Apakah Anda yakin ingin konfirmasi buku kembali ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                <form action="{{ route('kembalikanBuku', $peminjaman->PeminjamanID) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Ya</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                                                                               
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="dikembalikanModal" tabindex="-1" aria-labelledby="dikembalikanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added 'modal-lg' class for a wider modal -->
        <div class="modal-content bg-white text-dark">
            <div class="modal-header">
                <h5 class="modal-title  text-dark" id="dikembalikanModalLabel">Peminjaman Table (Dikembalikan)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table  text-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Buku ID</th>
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                <th scope="col">Status Peminjaman</th>
                                <th scope="col">Generate Report</th> <!-- Add the column for generating report -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $peminjaman)
                            @if($peminjaman->StatusPeminjaman === 'dikembalikan')
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peminjaman->UserID }}</td>
                                <td>{{ $peminjaman->BukuID }}</td>
                                <td>{{ $peminjaman->TanggalPeminjaman }}</td>
                                <td>{{ $peminjaman->TanggalPengembalian }}</td>
                                <td>{{ $peminjaman->StatusPeminjaman }}</td>
                                <td>
                                    <form action="{{ route('generate.report', ['buku_id' => $peminjaman->BukuID]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection
