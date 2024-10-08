<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('admin.sidebar')

    <div class="p-4 sm:ml-64">
        <div class="m-0 p-0">
            <h4>Manage Orders</h4>
        </div>
        <div class="card p-3 mt-3 table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Invoice Code</th>
                        <th scope="col">Member ID</th>
                        <th scope="col">Outlet ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Payment Date</th>
                        <th scope="col">Extra Charge</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Tax</th>
                        <th scope="col">Status</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->invoice_code }}</td>
                            <td>{{ $data->member_id }}</td>
                            <td>{{ $data->outlet_id }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->deadline }}</td>
                            <td>{{ $data->payment_date }}</td>
                            <td>{{ $data->extra_charge }}</td>
                            <td>{{ $data->discount }}</td>
                            <td>{{ $data->tax }}</td>
                            <td>{{ $data->status }}</td>
                            <td>{{ $data->user_id }}</td>
                            <td><button type="button" class="btn btn-sm btn-primary btn-detail" data-id="{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#modalDetail">Detail</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Order Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <p class="me-1">Transaction ID : </p><span id="transaction_id"></span>
                    </div>
                    <div class="card table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Package ID</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody id="transaction-details">
                                <tr>
                                    <td>
                                        <span id="package_name"></span>
                                    </td>
                                    <td>
                                        <span id="quantity"></span>
                                    </td>
                                    <td>
                                        <span id="description"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-delete').click(function() {
                var userId = $(this).data('id');
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
                            url: '/delete_user/' + userId,
                            type: 'get',
                            success: function(response) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Pengguna telah dihapus.',
                                    'success'
                                ).then(() => {
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

            $('.btn-detail').click(function() {
                var id = $(this).data('id');
                console.log('Tr ID:', id);
                $.ajax({
                    url: 'get_transaction_detail/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log('Tr Data:', response);
                        $('#modalDetail').modal('show');
                        $('#modalDetail #transaction_id').text(response.id);
                        $('#modalDetail #package_name').text(response.package_name);
                        $('#modalDetail #quantity').text(response.quantity);
                        $('#modalDetail #description').text(response.description);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>