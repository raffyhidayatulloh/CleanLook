<x-layout title="Users - CleanLook">
    <div class="m-0 p-0">
        <h4>Users</h4>
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Add User</button>
    </div>
    <div class="card px-3 py-1 table-responsive text-nowrap mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">NAME</th>
                    <th scope="col">USERNAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ROLE</th>
                    <th scope="col" class="text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->username }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->role }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('add_user') }}" method="post" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="password" name="password" class="form-control" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <div>
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-select" required>
                                <option selected disabled>Choose :</option>
                                @foreach ($roles as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" action="{{ url('update_user') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-floating mb-3">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="change_password" name="change_password" class="form-control" placeholder="Change Password">
                            <label for="change_password">Change Password (Optional)</label>
                        </div>
                        <div>
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-select" required>
                                @foreach ($roles as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#modalAdd').on('hidden.bs.modal', function () {
                $('#addForm')[0].reset();
            });

            $('.btn-edit').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'get_user/' + id,
                    type: 'GET',
                    success: function(response) {
                        $('#modalEdit').modal('show');
                        $('#modalEdit #id').val(response.id);
                        $('#modalEdit #name').val(response.name);
                        $('#modalEdit #username').val(response.username);
                        $('#modalEdit #email').val(response.email);
                        $('#modalEdit #role').val(response.role);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });

            $('.btn-delete').click(function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: "Apakah Anda yakin ingin menghapus pengguna ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/delete_outlet/' + id,
                            type: 'get',
                            success: function(response) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: "Pengguna telah dihapus.",
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#6e72ff'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus pengguna.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

    @if(session('success'))
        <script type="text/javascript">
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#6e72ff'
            });
        </script>
    @endif
</x-layout>