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
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Peminjaman ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Tanggal Peminjaman</th>
                        <th scope="col">Tanggal Pengembalian</th>
                        <th scope="col">Status Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->PeminjamanID }}</td>
                        <td>{{ $peminjaman->user->name }}</td>
                        <td>{{ $peminjaman->buku->Judul }}</td>
                        <td>{{ $peminjaman->TanggalPeminjaman }}</td>
                        <td>{{ $peminjaman->TanggalPengembalian }}</td>
                        <td>
                            @if($peminjaman->StatusPeminjaman === 'konfirmasi')
                                <span class="badge bg-warning"> <i class="fa fa-clock text-white"></i> Menunggu Konfirmasi</span>
                                <button class="btn btn-md rounded-pill bg-light border m-1" onclick="showCancelConfirmationModal('{{ $peminjaman->PeminjamanID }}')">
                                    <i class="fa fa-times text-danger"></i> Batal meminjam
                                </button>                                                                                               
                            @elseif($peminjaman->StatusPeminjaman === 'dipinjam')
                                <span class="badge bg-success"> <i class="fa fa-handshake text-white"></i> Sedang Dipinjam</span>
                            @elseif($peminjaman->StatusPeminjaman === 'dikembalikan')
                                <span class="badge bg-info"> <i class="fa fa-check-circle text-white"></i> Dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apa anda yakin ingin membatalkan pinjaman ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmCancelBtn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- Cart Page End -->



<script>
function showCancelConfirmationModal(peminjamanID) {
    $('#cancelConfirmationModal').modal('show');
    $('#confirmCancelBtn').data('peminjamanID', peminjamanID);
}

$('#confirmCancelBtn').click(function() {
    var peminjamanID = $(this).data('peminjamanID');
    $.ajax({
        type: 'POST',
        url: '{{ route("cancel.borrow") }}',
        data: {
            "_token": "{{ csrf_token() }}",
            "peminjamanID": peminjamanID
        },
        success: function(response) {
            // Reload the page or update the UI accordingly
            window.location.reload();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});


</script>
@endsection
