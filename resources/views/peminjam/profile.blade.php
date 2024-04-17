@extends('layouts.papp')

@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Pinjaman saya</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active text-white">Pinjaman saya</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('update-profile') }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="NamaLengkap">Nama Lengkap:</label>
                                <input type="text" class="form-control" id="NamaLengkap" name="NamaLengkap" value="{{ $user->NamaLengkap }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="Alamat">Alamat:</label>
                                <textarea class="form-control" id="Alamat" name="Alamat" rows="3">{{ $user->Alamat }}</textarea>
                            </div>
                            <!-- Tambahkan input untuk kolom-kolom lain yang ingin diubah -->
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->
@endsection
