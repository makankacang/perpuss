@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-dark rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Ulasan Buku Table</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Ulasan</th>
                                <th scope="col">Rating</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ulasanBuku as $ulasan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ulasan->user->name }}</td>
                                <td>{{ $ulasan->buku->Judul }}</td>
                                <td>{{ $ulasan->Ulasan }}</td>
                                <td>{{ $ulasan->Rating }}</td>
                                <td>
                                    <button class="btn border-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $ulasan->id }}"> <i class="fa fa-times text-danger"></i> Hapus Ulasan</button>
                                </td>
                            </tr>
                            <!-- Modal for confirming delete -->
                            <div class="modal fade" id="confirmDeleteModal{{ $ulasan->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-white text-dark">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Yakin ingin hapus ulasan ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="/ulasanBuku/delete/{{ $ulasan->UlasanID }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
