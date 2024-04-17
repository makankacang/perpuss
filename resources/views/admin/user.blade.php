@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-dark rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Users Table</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
                                <th scope="col">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $user->level }}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" onclick="confirmChangeLevel('{{ route('user.changeLevel', ['id' => $user->id, 'level' => 'admin']) }}')">Change to Admin</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="confirmChangeLevel('{{ route('user.changeLevel', ['id' => $user->id, 'level' => 'petugas']) }}')">Change to Petugas</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="confirmChangeLevel('{{ route('user.changeLevel', ['id' => $user->id, 'level' => 'user']) }}')">Change to User</a></li>
                                        </ul>
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

<!-- Modal for confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white text-dark">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="confirmationModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ganti level user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="confirmChangeLevelButton" class="btn btn-danger">Confirm</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmChangeLevel(url) {
        var confirmButton = document.getElementById('confirmChangeLevelButton');
        confirmButton.setAttribute('href', url);
        $('#confirmationModal').modal('show');
    }
</script>
@endsection
