@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-dark rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Kategori Buku Table</h6>
                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">Add Kategori</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Kategori</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoribukus as $kategori)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <form action="/katbukuedit/{{ $kategori->KategoriID }}" method="POST">
                                    @csrf
                                    <td style="width: 60%;"> <!-- Set a fixed width for the table cells -->
                                        <span class="table-data">{{ $kategori->NamaKategori }}</span>
                                        <input type="text" name="NamaKategori" class="form-control edit-input" value="{{ $kategori->NamaKategori }}" style="display: none;">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn text-success save-btn" style="display: none;">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                        <button class="btn text-danger cancel-btn" style="display: none;">
                                            <i class="bi bi-x"></i>
                                        </button>
                                        <button class="btn text-white edit-btn">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn text-danger delete-btn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <div class="btn-group" style="display: none;">
                                            <p class="text-white mb-0">Are you sure?</p>
                                            <a href="/katbukudelete/{{ $kategori->KategoriID }}" class="btn btn-danger confirm-delete-btn">Yes</a>
                                            <button class="btn btn-outline-danger cancel-delete-btn">Cancel</button>
                                        </div>                             
                                    </td>
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Kategori Modal -->
<div class="modal fade" id="addKategoriModal" tabindex="-1" aria-labelledby="addKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="addKategoriModalLabel">Add Kategori</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Kategori Form -->
                <form action="/katbukuinput" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="NamaKategori" required>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
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

            tableData.forEach((data, index) => {
                data.style.display = 'none';
                inputFields[index].style.display = 'inline-block';
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

            tableData.forEach((data, index) => {
                data.style.display = 'inline-block';
                inputFields[index].style.display = 'none';
            });

            saveButton.style.display = 'none';
            button.style.display = 'none';
            editButton.style.display = 'inline-block';
            deleteButton.style.display = 'inline-block';
            confirmDeleteButton.parentNode.style.display = 'none'; // Hide confirm delete button group
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
</script>

@endsection
