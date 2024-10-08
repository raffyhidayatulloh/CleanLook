<x-layout title="Members - CleanLook">
    <div class="m-0 p-0">
        <h4>Members</h4>
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Add Member</button>
    </div>
    <div class="card px-3 py-1 table-responsive text-nowrap mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">NAME</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">GENDER</th>
                    <th scope="col">TELP</th>
                    <th scope="col" class="text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->address }}</td>
                        <td>{{ $data->gender }}</td>
                        <td>{{ $data->telp }}</td>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('add_member') }}" method="post" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="address" name="address" class="form-control" placeholder="Address" required>
                            <label for="address">Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="telp" id="telp" name="telp" class="form-control" placeholder="No. Telp" required>
                            <label for="telp">No. Telp</label>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="">Gender</label>
                            <select id="gender" name="gender" class="form-control form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('update_member') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="address" name="address" class="form-control" placeholder="Address" required>
                            <label for="address">Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="telp" id="telp" name="telp" class="form-control" placeholder="No. Telp" required>
                            <label for="telp">No. Telp</label>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="">Gender</label>
                            <select id="gender" name="gender" class="form-control form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
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
                console.log('User ID:', id);
                $.ajax({
                    url: 'get_member/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log('User Data:', response);
                        $('#modalEdit').modal('show');
                        $('#modalEdit #id').val(response.id);
                        $('#modalEdit #name').val(response.name);
                        $('#modalEdit #address').val(response.address);
                        $('#modalEdit #telp').val(response.telp);
                        $('#modalEdit #gender').val(response.gender);
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
                            url: '/delete_member/' + id,
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