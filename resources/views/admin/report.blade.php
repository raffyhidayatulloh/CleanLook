<x-layout title="Reports - CleanLook">
    <div class="m-0 p-0 mb-3">
        <h4>Reports</h4>
    </div>
    <div class="container mb-3">
        <form id="reportForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="from_date" class="text-sm font-medium">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label for="to_date" class="text-sm font-medium">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" required />
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" id="filterBtn" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>

    <div id="reportdata" style="display: none;">
        <div class="table-responsive text-nowrap card p-3">
            <p>Laundry report data from <span id="sFromDate"></span> to <span id="sToDate"></span></p>
            <div class="mb-3">
                <button type="button" id="print" class="btn btn-primary">Print</button>
            </div>
            
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">INVOICE</th>
                        <th scope="col">MEMBER</th>
                        <th scope="col">DATE</th>
                        <th scope="col">EXTRA CHARGE</th>
                        <th scope="col">DISCOUNT</th>
                        <th scope="col">TAX</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">TOTAL AMOUNT</th>
                        <th scope="col">USER</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#filterBtn').click(function() {
                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
    
                if (fromDate && toDate) {
                    $.ajax({
                        url: "{{ url('get_report') }}",
                        method: 'GET',
                        data: {
                            from_date: fromDate,
                            to_date: toDate
                        },
                        success: function(response) {
                            $('#reportBody').empty();
                            $('#sFromDate').text(fromDate);
                            $('#sToDate').text(toDate); 

                            if (response.length > 0) {
                                response.forEach((transaction, index) => {
                                    $('#reportBody').append(`
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${transaction.invoice_code}</td>
                                            <td>${transaction.member_id}</td>
                                            <td>${transaction.date}</td>
                                            <td>${transaction.extra_charge}</td>
                                            <td>${transaction.discount}</td>
                                            <td>${transaction.tax}</td>
                                            <td>${transaction.status}</td>
                                            <td>${transaction.total_amount}</td>
                                            <td>${transaction.user_id}</td>
                                        </tr>
                                    `);
                                });
                                $('#reportdata').show();
                            } else {
                                $('#reportBody').append(`
                                    <tr>
                                        <td colspan="9" class="text-center">No Data Found</td>
                                    </tr>
                                `);
                                $('#reportdata').show();
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr);
                        }
                    });
                } else {
                    alert('Please select both dates.');
                }
            });

            document.getElementById('print').addEventListener('click', function () {
                this.style.display = 'none';
                const printContent = document.getElementById('reportdata').innerHTML;
                const originalContent = document.body.innerHTML;
                document.body.innerHTML = printContent;
                window.print();
                document.body.innerHTML = originalContent;
                this.style.display = 'block';
            });
        });
    </script>
</x-layout>