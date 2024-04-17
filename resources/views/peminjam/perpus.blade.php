@extends('layouts.papp')

@section('content')
        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Perpustakaan</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active text-white">Perpustakaan</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-1">
            <div class="container py-5">
                <h1 class="mb-4">Buku</h1>
                <div class="row g-1">
                    <div class="col-lg-12">
                        <div class="row g-1">
                            <div class="col-xl-3">
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" class="form-control p-3" id="searchInput" placeholder="keywords" aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="m-3">
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
                                                        <a href="{{ route('peminjam.perpus', ['kategori' => $category->KategoriID]) }}">
                                                            <i class="fas fa-book me-2"></i>{{ $category->NamaKategori }}
                                                        </a>
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
                                <div class="row g-4 justify-content-center">
                                    @foreach($bukus as $buku)
                                    @php
                                    $isBorrowed = \App\Models\Peminjaman::where('BukuID', $buku->BukuID)
                                                    ->where('UserID', Auth::user()->id)
                                                    ->whereIn('StatusPeminjaman', ['konfirmasi', 'dipinjam'])
                                                    ->exists();
                                    $isBorroweds = \App\Models\Peminjaman::where('BukuID', $buku->BukuID)
                                                    ->where('UserID', Auth::user()->id)
                                                    ->whereIn('StatusPeminjaman', ['dipinjam', 'dikembalikan'])
                                                    ->exists();
                                    $isInCollection = in_array($buku->BukuID, $userCollections);
                                    @endphp
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="{{ asset('storage/images/' . $buku->image) }}" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                                @foreach($buku->kategoris as $kategori)
                                                {{ $kategori->NamaKategori }}
                                                @endforeach
                                            </div>
                                            <div class="text-white px-3 py-1 position-absolute" style="top: 3px; left: 180px;">
                                                @if($isInCollection)
                                                <button id="addToCollectionBtn_{{ $buku->BukuID }}" type="button" class="btn bg-secondary border border-secondary rounded-pill px-3 text-primary m-1" onclick="removeFromCollection('{{ $buku->BukuID }}')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                @else
                                                <button id="addToCollectionBtn_{{ $buku->BukuID }}" type="button" class="btn bg-secondary border border-secondary rounded-pill px-3 text-primary m-1" onclick="addToCollection('{{ $buku->BukuID }}')">
                                                    <i class="fa fa-star"></i>
                                                </button>
                                                @endif
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $buku->Judul }}</h4>
                                                <p>{{ $buku->Penulis }}</p>
                                                <div class="d-flex justify-content-center flex-lg-wrap">
                                                    <div class="btn-group" role="group">
                                                        @if(!$isBorrowed)
                                                        <button type="button" class="btn btn-md border border-secondary rounded-pill px-3 text-primary m-1" onclick="showBorrowConfirmation('{{ $buku->BukuID }}', '{{ $buku->Judul }}', '{{ $buku->kategoris->implode('NamaKategori', ', ') }}')">
                                                            <i class="fa fa-plus"></i> Pinjam
                                                        </button>
                                                        @else
                                                        <button type="button" class="btn btn-md border border-secondary rounded-pill px-3 text-primary m-1" disabled>
                                                            <i class="fa fa-check"></i> Dipinjam
                                                        </button>
                                                        @endif
                                                        <button type="button" class="btn btn-md border border-secondary rounded-pill px-3 text-primary m-1" onclick="showReviewForm('{{ $buku->BukuID }}', '{{ $buku->Judul }}')">
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
                                    {{ $bukus->links() }}
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
                                                        <input type="date" class="form-control" id="tanggalPengembalian" name="tanggalPengembalian" required min="{{ now()->format('Y-m-d') }}" max="{{ now()->addWeeks(3)->format('Y-m-d') }}">
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

<!-- Review Form Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Buat Ulasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reviewForm" action="{{ route('submit_review') }}" method="POST">
                    @csrf
                    <input type="hidden" id="reviewId" name="ReviewID">
                    <input type="hidden" id="bukuId" name="BukuID">
                    <div class="mb-3">
                        <label for="review" class="form-label">Ulasan</label>
                        <textarea class="form-control" id="review" name="Ulasan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <div id="rating" class="rateYo"></div>
                        <input type="hidden" name="Rating" id="ratingInput" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <!-- Other Users' Reviews Section -->
                <div id="otherReviewsSection">
                    <h5>Ulasan Lainnya:</h5>
                    <div id="otherReviews"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Review Form Modal -->
<div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewModalLabel">Edit Ulasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReviewForm" action="{{ route('update_review') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editReviewId" name="ReviewID">
                    <input type="hidden" id="editBukuId" name="BukuID">
                    <div class="mb-3">
                        <label for="editReview" class="form-label">Ulasan</label>
                        <textarea class="form-control" id="editReview" name="Ulasan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editRating" class="form-label">Rating</label>
                        <div id="editRating" class="rateYo"></div>
                        <input type="hidden" name="Rating" id="editRatingInput" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                <!-- Other Users' Reviews Section -->
                <div id="editOtherReviewsSection">
                    <h5>Ulasan Lainnya:</h5>
                    <div id="editOtherReviews"></div>
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
        <!-- Fruits Shop End-->

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
                // Show success toast
                showToast('Buku berhasil dipinjam');
                // Reset the form
                form.trigger('reset');
                // Close the modal
                $('#borrowConfirmationModal').modal('hide');
                // Update the button state
                $('#confirmBorrowBtn').attr('disabled', true).html('Dipinjam').addClass('disabled');

                // Reload the page without changing the scroll position
                var scrollPosition = window.scrollY || window.pageYOffset;
                location.reload();
                window.scrollTo(0, scrollPosition);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});


        
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

            function addToCollection(bukuID) {
    $.ajax({
        type: 'POST',
        url: '{{ route('add-to-collection') }}',
        data: {
            bukuID: bukuID,
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            // Update button icon to 'fa-check'
            $('#addToCollectionBtn_' + bukuID + ' .fa').removeClass('fa-star').addClass('fa-check');
            // Change the onclick function to call removeFromCollection
            $('#addToCollectionBtn_' + bukuID).attr('onclick', 'removeFromCollection(\'' + bukuID + '\')');
            // Show success toast or update UI
            showToast('Buku berhasil ditambahkan ke koleksi');
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
}

function removeFromCollection(bukuID) {
    $.ajax({
        type: 'POST',
        url: '{{ route('remove-from-collection') }}',
        data: {
            bukuID: bukuID,
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            // Update button icon to 'fa-star'
            $('#addToCollectionBtn_' + bukuID + ' .fa').removeClass('fa-check').addClass('fa-star');
            // Change the onclick function to call addToCollection
            $('#addToCollectionBtn_' + bukuID).attr('onclick', 'addToCollection(\'' + bukuID + '\')');
            // Show success toast or update UI
            showToast('Buku berhasil dihapus dari koleksi');
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

    if (searchInput) { // Check if search input element exists
        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();
            const books = document.querySelectorAll('.col-md-6');

            books.forEach(function (book) {
                const titleElement = book.querySelector('h4');
                if (titleElement) {
                    const title = titleElement.textContent.toLowerCase();
                    if (title.includes(searchTerm)) {
                        book.style.display = 'block';
                    } else {
                        book.style.display = 'none';
                    }
                }
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('sort');

    if (selectElement) {
        selectElement.addEventListener('change', function () {
            const selectedOption = selectElement.value;
            const booksContainer = document.querySelector('.row.g-4');

            // Get all book cards
            const books = Array.from(booksContainer.children);

            // Sort the book cards based on the selected option
            switch (selectedOption) {
                case 'title-asc':
                    books.sort((a, b) => {
                        const titleA = a.querySelector('h4').textContent.toLowerCase();
                        const titleB = b.querySelector('h4').textContent.toLowerCase();
                        return titleA.localeCompare(titleB);
                    });
                    break;
                case 'title-desc':
                    books.sort((a, b) => {
                        const titleA = a.querySelector('h4').textContent.toLowerCase();
                        const titleB = b.querySelector('h4').textContent.toLowerCase();
                        return titleB.localeCompare(titleA);
                    });
                    break;
                default:
                    // No sorting needed for other options
                    break;
            }

            // Remove existing book cards from the container
            while (booksContainer.firstChild) {
                booksContainer.removeChild(booksContainer.firstChild);
            }

            // Add sorted book cards back to the container
            books.forEach(function (book) {
                booksContainer.appendChild(book);
            });
        });
    }
});

function showReviewForm(bukuId, judul) {
    // Function to fetch and display other reviews
    function fetchOtherReviews(targetElement) {
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
                $('#editBukuId').val(bukuId);
                $('#editReviewId').val(response.review.id);
                $('#editReview').val(response.review.Ulasan);
                $('#editRating').rateYo({
                    starWidth: '30px',
                    normalFill: '#A0A0A0',
                    ratedFill: '#FFD700',
                    spacing: '5px',
                    rating: response.review.Rating,
                    onChange: function(rating, rateYoInstance) {
                        $('#editRatingInput').val(rating);
                    }
                });
                // Fetch and display other reviews before showing the edit review modal
                fetchOtherReviews('#editOtherReviews');
                // Show the edit review modal
                $('#editReviewModal').modal('show');
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
                            $('#bukuId').val(bukuId);
                            $('#reviewModalLabel').text('Buat Ulasan untuk ' + judul);
                            $('#reviewForm').show();
                            $('#rating').rateYo({
                                starWidth: '30px',
                                normalFill: '#A0A0A0',
                                ratedFill: '#FFD700',
                                spacing: '5px',
                                onChange: function(rating, rateYoInstance) {
                                    $('#ratingInput').val(rating);
                                }
                            });
                            // Fetch and display other reviews before showing the review modal
                            fetchOtherReviews('#otherReviews');
                            // Show the review modal
                            $('#reviewModal').modal('show');
                        } else {
                            // If the book is not borrowed or returned, show a message
                            $('#reviewModalLabel').text('Harap pinjam buku dulu sebelum mengulas');
                            $('#reviewForm').hide();
                            $('#reviewModal').modal('show');
                            // Fetch and display other reviews
                            fetchOtherReviews('#otherReviews');
                        }
                    }
                });
            }
        }
    });
}


        </script>
        

@endsection