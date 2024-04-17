@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-dark rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Buku Table</h6>
                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addBukuModal">Add Buku</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th> <!-- Add the numbered column header -->
                                <th scope="col">Judul</th>
                                <th scope="col">Penulis</th>
                                <th scope="col">Penerbit</th>
                                <th scope="col">Tahun Terbit</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Image</th> <!-- Add the image column header -->
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bukus as $buku)
                            <tr>
                                <td style="width: 5%">{{ $loop->iteration }}</td>
                                <form action="/bukuedit/{{ $buku->BukuID }}" method="POST" enctype="multipart/form-data"> <!-- Don't forget to add enctype="multipart/form-data" -->
                                    @csrf
                                    <td style="width: 20%">
                                        <span class="table-data">{{ $buku->Judul }}</span>
                                        <input type="text" name="Judul" class="form-control edit-input" value="{{ $buku->Judul }}" style="display: none;">
                                    </td>
                                    <td style="width: 20%">
                                        <span class="table-data">{{ $buku->Penulis }}</span>
                                        <input type="text" name="Penulis" class="form-control edit-input" value="{{ $buku->Penulis }}" style="display: none;">
                                    </td>
                                    <td style="width: 20%">
                                        <span class="table-data">{{ $buku->Penerbit }}</span>
                                        <input type="text" name="Penerbit" class="form-control edit-input" value="{{ $buku->Penerbit }}" style="display: none;">
                                    </td>
                                    <td style="width: 20%">
                                        <span class="table-data">{{ $buku->TahunTerbit }}</span>
                                        <input type="number" name="TahunTerbit" class="form-control edit-input" value="{{ $buku->TahunTerbit }}" style="display: none;">
                                    </td>
                                    <td style="width: 20%">
                                        <span class="table-data">{{ $buku->kategoris->first()->NamaKategori }}</span>
                                        <select name="KategoriID" class="form-select edit-input" style="display: none;">
                                            @foreach($categories as $category)
                                                @if($category->KategoriID == $buku->kategoris->first()->KategoriID)
                                                    <option value="{{ $category->KategoriID }}" selected>{{ $category->NamaKategori }}</option>
                                                @else
                                                    <option value="{{ $category->KategoriID }}">{{ $category->NamaKategori }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        
                                    </td>                                   
                                    <td style="width: 10%">
                                        <div style="position: relative;">
                                            <button type="button" class="btn text-white" onclick="showFullImage('{{ $buku->BukuID }}')" style="position: absolute; bottom: 50; right: 0;"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>
                                            <label for="imageInput{{ $buku->BukuID }}" class="btn btn-primary" style="pointer-events: none;">
                                                <img id="imagePreview{{ $buku->BukuID }}" src="{{ asset('storage/images/' . $buku->image) }}" alt="Book Image" style="max-width: 50px;">
                                            </label>
                                            <input id="imageInput{{ $buku->BukuID }}" type="file" name="image" class="form-control edit-input" data-original-src="{{ asset('storage/images/' . $buku->image) }}" style="display: none;">
                                        </div>
                                    </td>
                                                                      
                                    
                                    <td style="width: 15%">
                                        <button type="submit" class="btn text-success save-btn" style="display: none;">
                                        </form>
                                            <i class="bi bi-check"></i>
                                        </button>
                                        <button class="btn text-danger cancel-btn" style="display: none;">
                                            <i class="bi bi-x"></i>
                                        </button>
                                        <button class="btn text-white edit-btn">
                                            <i class="bi bi-pencil" onclick="editRow(this)"></i>
                                        </button>
                                        <button class="btn text-danger delete-btn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <div class="btn-group" style="display: none;">
                                            <p class="text-white mb-0">Are you sure?</p>
                                            <a href="/deletebuku/{{ $buku->BukuID }}" class="btn btn-danger confirm-delete-btn">Yes</a>
                                            <button class="btn btn-outline-danger cancel-delete-btn">Cancel</button>
                                        </div>                             
                                    </td>

                            </tr>
                                           
                            <!-- Image Modal -->
                            <div id="imageModal{{ $buku->BukuID }}" class="modal fade" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content bg-transparent border-0">
                                        <img id="fullImage{{ $buku->BukuID }}" src="{{ asset('storage/images/' . $buku->image) }}" alt="Full Book Image">
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


<!-- Add Buku Modal -->
<div class="modal fade" id="addBukuModal" tabindex="-1" aria-labelledby="addBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="addBukuModalLabel">Add Buku</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Buku Form -->
                <form action="/bukuinput" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="Judul" required>
                        </div>
                        <div class="col">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="Penulis" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="Penerbit" required>
                        </div>
                        <div class="col">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="TahunTerbit" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="kategori" class="form-label">Kategori</label>
                            <p id="kategori_name" class="form-control-static"></p>
                            <div class="input-group">
                                <input type="text" class="form-control bg-dark text-light" id="KategoriID" name="KategoriID" readonly>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kategoriModal">Select Category</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="image" class="form-label">Image</label>
                            <div class="input-group">
                                <input type="file" class="form-control bg-dark btn-primary text-light" id="imageAdd" name="image" onchange="previewImageAdd(event)">
                                <img id="imagePreviewAdd" src="#" alt="Image Preview" style="max-width: 100px; max-height: 100px; margin-left: 10px; display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 text-end">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Category Modal -->
<div class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriModalLabel">Select Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display category table here -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">KategoriID</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->KategoriID }}</td>
                            <td>{{ $category->NamaKategori }}</td>
                            <!-- Button to select category -->
                            <td><button type="button" class="btn btn-primary">Select</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
document.querySelectorAll('.edit-btn').forEach((button) => {
    button.addEventListener('click', () => {
        const row = button.closest('tr');
        const tableData = row.querySelectorAll('.table-data');
        const inputFields = row.querySelectorAll('.edit-input');
        const saveButton = row.querySelector('.save-btn');
        const cancelButton = row.querySelector('.cancel-btn');
        const deleteButton = row.querySelector('.delete-btn');
        const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
        const cancelDeleteButton = row.querySelector('.cancel-delete-btn');

        inputFields.forEach((input) => {
            input.style.display = 'inline-block'; // Display the input fields for editing
        });

        tableData.forEach((data) => {
            data.style.display = 'none'; // Hide the table data elements
        });

        saveButton.style.display = 'inline-block';
        cancelButton.style.display = 'inline-block';
        button.style.display = 'none';
        deleteButton.style.display = 'none';
        confirmDeleteButton.parentNode.style.display = 'none'; // Hide confirm delete button group
    });
});


document.querySelectorAll('.cancel-btn').forEach((button) => {
    button.addEventListener('click', () => {
        const row = button.closest('tr');
        const tableData = row.querySelectorAll('.table-data');
        const inputFields = row.querySelectorAll('.edit-input');
        const editButton = row.querySelector('.edit-btn');
        const saveButton = row.querySelector('.save-btn');
        const deleteButton = row.querySelector('.delete-btn');
        const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
        const cancelDeleteButton = row.querySelector('.cancel-delete-btn');
        const imageInput = row.querySelector('input[type="file"]');
        const imagePreview = row.querySelector('img[id^="imagePreview"]');

        tableData.forEach((data, index) => {
            data.style.display = 'inline-block';
            inputFields[index].style.display = 'none';
        });

        saveButton.style.display = 'none';
        button.style.display = 'none';
        editButton.style.display = 'inline-block';
        deleteButton.style.display = 'inline-block';
        confirmDeleteButton.parentNode.style.display = 'none'; // Hide confirm delete button group
        
        // Check if imageInput and imagePreview are not null before accessing dataset
        if (imageInput && imagePreview) {
            // Reset image preview to original source
            imagePreview.src = imageInput.dataset.originalSrc || ''; // Use empty string if dataset.originalSrc is not defined
            imageInput.style.display = 'none'; // Hide input file
            imageInput.value = ''; // Clear selected file
        }
    });
});

    document.addEventListener('DOMContentLoaded', function () {
        // Add change event listener to the select dropdown
        document.querySelector('#KategoriID').addEventListener('change', function () {
            // Get the selected category ID
            var selectedCategoryID = this.value;

            // Update the hidden input field with the selected category ID
            document.querySelector('input[name="KategoriID"]').value = selectedCategoryID;

            // Optionally, display the selected category name for better user experience
            var selectedCategoryName = this.options[this.selectedIndex].text;
            document.querySelector('#kategori_name').innerText = selectedCategoryName;
        });
    });

    document.querySelectorAll('.delete-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
            const deleteButton = row.querySelector('.delete-btn');
            const editButton = row.querySelector('.edit-btn'); // Get the edit button

            deleteButton.style.display = 'none'; // Hide delete button
            editButton.style.display = 'none'; // Hide edit button
            confirmDeleteButton.parentNode.style.display = 'inline-block'; // Show confirm delete button group
        });
    });

    document.querySelectorAll('.cancel-delete-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const deleteButton = row.querySelector('.delete-btn');
            const confirmDeleteButton = row.querySelector('.confirm-delete-btn');
            const editButton = row.querySelector('.edit-btn'); // Get the edit button

            confirmDeleteButton.parentNode.style.display = 'none'; // Hide confirm delete button group
            deleteButton.style.display = 'inline-block'; // Show delete button
            editButton.style.display = 'inline-block'; // Show edit button
        });
    });

    function previewImageAdd(event) {
        var image = document.getElementById('imagePreviewAdd');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.style.display = 'block'; // Display the preview image
    }

    document.querySelectorAll('input[type="file"]').forEach((input) => {
    input.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();
        const imagePreview = input.previousElementSibling.querySelector('img');

        reader.onload = function(e) {
            imagePreview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    });
});

    function showFullImage(bukuID) {
        // Open the modal corresponding to the bukuID
        $('#imageModal' + bukuID).modal('show');
    }

        // JavaScript code to handle category selection
        document.addEventListener('DOMContentLoaded', function () {
        // Add click event listener to each 'Select' button in the category modal
        document.querySelectorAll('.modal#kategoriModal button.btn-primary').forEach(function (button) {
            button.addEventListener('click', function () {
                // Get the selected category ID and name
                var categoryID = this.closest('tr').querySelector('td:first-child').innerText;
                var categoryName = this.closest('tr').querySelector('td:nth-child(2)').innerText;

                // Set the selected category ID and name in the addBukuModal
                document.querySelector('#addBukuModal input#KategoriID').value = categoryID;
                document.querySelector('#addBukuModal p#kategori_name').innerText = categoryName;

                // Close the category modal
                $('#kategoriModal').modal('hide');
            });
        });
    });
</script>




@endsection
