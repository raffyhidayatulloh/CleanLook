<x-layout title="Manage Orders - CleanLook">
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
                        <td><button type="button" class="btn btn-sm btn-primary btn-status" data-id="{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#modalStatus">{{ $data->status }}</button></td>
                        <td>{{ $data->user_id }}</td>
                        <td><button type="button" class="btn btn-sm btn-primary btn-detail" data-id="{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#modalDetail">Detail</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Status -->
    <div class="modal fade" id="modalStatus" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-outline-primary update-status" data-status="process">Process</button>
                    <button class="btn btn-outline-primary update-status" data-status="finished">Finished</button>
                    <button class="btn btn-outline-primary update-status" data-status="taken">Taken</button>
                </div>
            </div>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let transactionId = null;
        $('.btn-status').on('click', function() {
            transactionId = $(this).data('id');
        });

        $('.update-status').on('click', function() {
            let newStatus = $(this).data('status');

            $.ajax({
                url: '/update_status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: transactionId,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        $('button[data-id="' + transactionId + '"]').text(newStatus);
                        $('#modalStatus').modal('hide');
                    } else {
                        alert('Failed to update status.');
                    }
                },
                error: function() {
                    alert('An error occurred.');
                }
            });
        });

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
                $.ajax({
                    url: 'get_transaction_detail/' + id,
                    type: 'GET',
                    success: function(response) {
                        $('#modalDetail').modal('show');
                        $('#modalDetail #transaction_id').text(response.id);
                        $('#transaction-details').empty();
                        response.details.forEach(function(detail) {
                            $('#transaction-details').append(
                                `<tr>
                                    <td>${detail.package_name}</td>
                                    <td>${detail.quantity}</td>
                                    <td>${detail.description}</td>
                                </tr>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</x-layout>