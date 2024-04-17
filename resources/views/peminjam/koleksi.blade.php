@extends('layouts.papp')

@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Koleksi saya</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active text-white">Me</li>
        <li class="breadcrumb-item active text-white">Koleksi</li>
    </ol>
</div>
<!-- Single Page Header End -->

<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Koleksi Saya</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-xl-3">
                        <div class="input-group w-100 mx-auto d-flex">
                            <input type="search" id="searchInput" class="form-control p-3" placeholder="Search keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-6"></div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name m-2">
                                                <a href="{{ route('peminjam.perpus') }}">
                                                    <i class="fas fa-book me-2"></i>All
                                                </a>
                                            </div>
                                        </li>
                                        @foreach($categories as $category)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name m-2">
                                                <a href="{{ route('peminjam.koleksi', ['kategori' => $category->KategoriID]) }}"><i class="fas fa-book me-2"></i>{{ $category->NamaKategori }}</a>
                                                <span>({{ $category->bukus->count() }})</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center" id="koleksiContainer">
                            @foreach($koleksis as $koleksipribadi)
                                <div class="col-md-6 col-lg-6 col-xl-4" id="koleksiCard_{{ $koleksipribadi->KoleksiID }}">
                                    <div class="rounded position-relative fruite-item">
                                        <div class="fruite-img">
                                            <img src="{{ asset('storage/images/' . $koleksipribadi->buku->image) }}" class="img-fluid w-100 rounded-top" alt="">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                            @foreach($koleksipribadi->buku->kategoris as $kategori)
                                                {{ $kategori->NamaKategori }}
                                            @endforeach     
                                        </div>
                                        <div class="text-white px-3 py-1 position-absolute" style="top: 3px; left: 185px;">
                                            <button type="button" class="btn bg-secondary border border-secondary rounded-pill px-3 text-primary m-1" onclick="removeFromCollection('{{ $koleksipribadi->KoleksiID }}')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                        
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                            <h4>{{ $koleksipribadi->buku->Judul }}</h4>
                                            <p>{{ $koleksipribadi->buku->Penulis }}</p>
                                            <div class="d-flex justify-content-center flex-lg-wrap">
                                                <div class="btn-group" role="group">
                                                    @php
                                                        $isBookBorrowed = \App\Models\Peminjaman::where('UserID', Auth::user()->id)
                                                            ->where('BukuID', $koleksipribadi->buku->BukuID)
                                                            ->whereIn('StatusPeminjaman', ['konfirmasi', 'dipinjam'])
                                                            ->exists();
                                                    @endphp
                                                    @if($isBookBorrowed)
                                                    <button type="button" class="btn btn-sm border border-secondary rounded-pill px-3 text-primary m-1" disabled>
                                                        <i class="fa fa-check"></i> Dipinjam
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-sm border border-secondary rounded-pill px-3 text-primary m-1" onclick="showBorrowConfirmation('{{ $koleksipribadi->buku->BukuID }}', '{{ $koleksipribadi->buku->Judul }}', '{{ $koleksipribadi->buku->kategoris->implode('NamaKategori', ', ') }}')">
                                                        <i class="fa fa-plus"></i> Pinjam
                                                    </button>
                                                    @endif

                                                    <button type="button" class="btn btn-md border border-secondary rounded-pill px-3 text-primary m-1" onclick="showReviewFormKoleksi('{{ $koleksipribadi->buku->BukuID }}', '{{ $koleksipribadi->buku->Judul }}')">
                                                        <i class="far fa-comment"></i> Ulasan
                                                    </button>                                                                                                       
                                                                                                                                                       
                                                </div>                                                                                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12">
                            <div class="pagination d-flex justify-content-center mt-5">
                                <a href="#" class="rounded">&laquo;</a>
                                <a href="#" class="active rounded">1</a>
                                <a href="#" class="rounded">2</a>
                                <a href="#" class="rounded">3</a>
                                <a href="#" class="rounded">4</a>
                                <a href="#" class="rounded">5</a>
                                <a href="#" class="rounded">6</a>
                                <a href="#" class="rounded">&raquo;</a>
                            </div>
                        </div>      
                    </div>

                        <!-- Modal for Borrow Confirmation -->
                        <div class="modal fade" id="borrowConfirmationModal" tabindex="-1" aria-labelledby="borrowConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="borrowConfirmationModalLabel">Konfirmasi Pinjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Detail :</h6>
                                        <p>Buku Name: <span id="bukuName"></span></p>
                                        <p>Kategori: <span id="kategori"></span></p>
                                        <p>Tanggal Peminjaman: {{ now()->format('Y-m-d') }}</p>
                                        <form id="borrowForm" action="{{ route('borrow.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="tanggalPengembalian" class="form-label">Tanggal Pengembalian:</label>
                                                <input type="date" class="form-control" id="tanggalPengembalian" name="tanggalPengembalian" required min="{{ now()->format('Y-m-d') }}">
                                            </div>                                                    
                                            <input type="hidden" id="bukuID" name="bukuID">
                                            <input type="hidden" id="userID" name="userID" value="{{ Auth::user()->id }}">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" id="confirmBorrowBtn">Confirm Borrow</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Form Modal for Koleksi Saya Page -->
<div class="modal fade" id="reviewModalKoleksi" tabindex="-1" aria-labelledby="reviewModalLabelKoleksi" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabelKoleksi">Buat Ulasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviewFormKoleksi" action="{{ route('submit_review') }}" method="POST">
                    @csrf
                    <input type="hidden" id="reviewIdKoleksi" name="ReviewID">
                    <input type="hidden" id="bukuIdKoleksi" name="BukuID">
                    <div class="mb-3">
                        <label for="reviewKoleksi" class="form-label">Ulasan</label>
                        <textarea class="form-control" id="reviewKoleksi" name="Ulasan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ratingKoleksi" class="form-label">Rating</label>
                        <div id="ratingKoleksi" class="rateYo"></div>
                        <input type="hidden" name="Rating" id="ratingInputKoleksi" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <!-- Other Users' Reviews Section for Koleksi Saya Page -->
                <div id="otherReviewsSectionKoleksi">
                    <h5>Ulasan Lainnya:</h5>
                    <div id="otherReviewsKoleksi"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Review Form Modal for Koleksi Saya Page -->
<div class="modal fade" id="editReviewModalKoleksi" tabindex="-1" aria-labelledby="editReviewModalLabelKoleksi" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewModalLabelKoleksi">Edit Ulasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReviewFormKoleksi" action="{{ route('update_review') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editReviewIdKoleksi" name="ReviewID">
                    <input type="hidden" id="editBukuIdKoleksi" name="BukuID">
                    <div class="mb-3">
                        <label for="editReviewKoleksi" class="form-label">Ulasan</label>
                        <textarea class="form-control" id="editReviewKoleksi" name="Ulasan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editRatingKoleksi" class="form-label">Rating</label>
                        <div id="editRatingKoleksi" class="rateYo"></div>
                        <input type="hidden" name="Rating" id="editRatingInputKoleksi" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                <!-- Other Users' Reviews Section for Koleksi Saya Page -->
                <div id="editOtherReviewsSectionKoleksi">
                    <h5>Ulasan Lainnya:</h5>
                    <div id="editOtherReviewsKoleksi"></div>
                </div>
            </div>
        </div>
    </div>
</div>


                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showBorrowConfirmation(bukuID, bukuName, kategori) {
    document.getElementById('bukuID').value = bukuID;
    document.getElementById('bukuName').textContent = bukuName;
    document.getElementById('kategori').textContent = kategori;
    $('#borrowConfirmationModal').modal('show');
}

$(document).ready(function() {
    $('#borrowForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function(response) {
                var scrollPosition = window.scrollY || window.pageYOffset;
                location.reload();
                window.scrollTo(0, scrollPosition);

                // Reset the form
                form.trigger('reset');
                // Close the modal
                $('#borrowConfirmationModal').modal('hide');
                // Update the button state
                $('#confirmBorrowBtn').attr('disabled', true).html('Dipinjam').addClass('disabled');

                // Show success toast after reload
                setTimeout(function() {
                    showToast('Buku berhasil dipinjam');
                }, 500); // Adjust delay as needed
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});



function removeFromCollection(koleksiID) {
    $.ajax({
        type: 'POST',
        url: '{{ route('remove-from-collections') }}',
        data: {
            koleksiID: koleksiID,
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            console.log(response); // Log the response to check if it's successful
            if (response.success) {
                // Fade out and then remove the koleksipribadi item from the UI
                $('#koleksiCard_' + koleksiID).fadeOut(500, function() {
                    $(this).remove();
                });
                // Show success toast or update UI
                showToast('Buku dihapus dari koleksi');
            } else {
                // Handle case when removal was not successful
                console.error('Error removing item from collection:', response.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
}


    // Function to show a custom toast notification
    function showToast(message) {
        const toastContainer = document.querySelector('.container-fluid'); // Select the container element where you want to append the toast
        const toast = document.createElement('div');
        toast.classList.add('toast');
        toast.classList.add('show');
        toast.classList.add('position-fixed');
        toast.classList.add('top-1');
        toast.classList.add('end-0');
        toast.classList.add('m-4');
        toast.style.opacity = '0'; // Start with opacity 0
        toast.style.transform = 'scale(0.8)'; // Start with a smaller scale
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        const toastBody = document.createElement('div');
        toastBody.classList.add('toast-body');
        toastBody.innerText = message;

        toast.appendChild(toastBody);
        toastContainer.appendChild(toast);

        // Animate the toast
        setTimeout(() => {
            toast.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out'; // Add transition for opacity and transform
            toast.style.opacity = '1'; // Fade in
            toast.style.transform = 'scale(1)'; // Scale up
            setTimeout(() => {
                toast.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out'; // Add transition for opacity and transform
                toast.style.opacity = '0'; // Fade out
                toast.style.transform = 'scale(0.8)'; // Scale down
                setTimeout(() => {
                    toast.remove();
                }, 300); // Remove the toast after animation completes
            }, 3000); // Display the toast for 3 seconds
        }, 100); // Delay the animation to ensure it starts properly
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const koleksiContainer = document.getElementById('koleksiContainer');

        searchInput.addEventListener('input', function () {
            const searchText = searchInput.value.toLowerCase().trim();

            // Loop through each koleksipribadi item and check if it matches the search text
            Array.from(koleksiContainer.children).forEach(function (koleksiItem) {
                const title = koleksiItem.querySelector('h4').textContent.toLowerCase();
                const author = koleksiItem.querySelector('p').textContent.toLowerCase();
                const isVisible = title.includes(searchText) || author.includes(searchText);
                koleksiItem.style.display = isVisible ? 'block' : 'none';
            });
        });
    });


    function showReviewFormKoleksi(bukuId, judul) {
    // Function to fetch and display other reviews
    function fetchOtherReviewsKoleksi(targetElement) {
        $.ajax({
            url: '{{ route("other_reviews") }}',
            type: 'GET',
            data: {
                bukuId: bukuId
            },
            success: function(otherReviews) {
                $(targetElement).html(otherReviews);
            }
        });
    }

    // Check if the user has already reviewed the book
    $.ajax({
        url: '{{ route("check_review") }}',
        type: 'GET',
        data: {
            bukuId: bukuId
        },
        success: function(response) {
            if (response.review) {
                // If the user has already reviewed, show edit review modal
                $('#editBukuIdKoleksi').val(bukuId);
                $('#editReviewIdKoleksi').val(response.review.id);
                $('#editReviewKoleksi').val(response.review.Ulasan);
                $('#editRatingKoleksi').rateYo({
                    starWidth: '30px',
                    normalFill: '#A0A0A0',
                    ratedFill: '#FFD700',
                    spacing: '5px',
                    rating: response.review.Rating,
                    onChange: function(rating, rateYoInstance) {
                        $('#editRatingInputKoleksi').val(rating);
                    }
                });
                // Fetch and display other reviews before showing the edit review modal
                fetchOtherReviewsKoleksi('#editOtherReviewsKoleksi');
                // Show the edit review modal
                $('#editReviewModalKoleksi').modal('show');
            } else {
                // If the user hasn't reviewed, check the borrowing status
                $.ajax({
                    url: '{{ route("check_borrow_status") }}',
                    type: 'GET',
                    data: {
                        bukuId: bukuId
                    },
                    success: function(response) {
                        if (response.status === 'dipinjam' || response.status === 'dikembalikan') {
                            // If the book is borrowed or returned, show the review form
                            $('#bukuIdKoleksi').val(bukuId);
                            $('#reviewModalLabelKoleksi').text('Buat Ulasan untuk ' + judul);
                            $('#reviewFormKoleksi').show();
                            $('#ratingKoleksi').rateYo({
                                starWidth: '30px',
                                normalFill: '#A0A0A0',
                                ratedFill: '#FFD700',
                                spacing: '5px',
                                onChange: function(rating, rateYoInstance) {
                                    $('#ratingInputKoleksi').val(rating);
                                }
                            });
                            // Fetch and display other reviews before showing the review modal
                            fetchOtherReviewsKoleksi('#otherReviewsKoleksi');
                            // Show the review modal
                            $('#reviewModalKoleksi').modal('show');
                        } else {
                            // If the book is not borrowed or returned, show a message
                            $('#reviewModalLabelKoleksi').text('Harap pinjam buku dulu sebelum mengulas');
                            $('#reviewFormKoleksi').hide();
                            $('#reviewModalKoleksi').modal('show');
                            // Fetch and display other reviews
                            fetchOtherReviewsKoleksi('#otherReviewsKoleksi');
                        }
                    }
                });
            }
        }
    });
}


</script>


@endsection
