<x-layout title="Transactions - CleanLook">
    <div class="m-0 p-0">
        <h4>Transaction</h4>
    </div>
    <form action="{{ url('add_transaction') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="outlet_id">Outlet ID</label>
                    <select id="outlet_id" name="outlet_id" class="form-select">
                        <option selected disabled>Choose :</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="member_id">Member ID</label>
                    <select id="member_id" name="member_id" class="form-select">
                        <option selected disabled>Choose :</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="deadline" class="text-sm font-medium">Deadline</label>
                    <input type="datetime-local" name="deadline" id="deadline" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label for="payment_date" class="text-sm font-medium">Payment Date</label>
                    <input type="datetime-local" name="payment_date" id="payment_date" class="form-control" required />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="payment_status">Payment Status</label>
                    <select id="payment_status" name="payment_status" class="form-select">
                        <option selected disabled>Choose :</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>
            </div>
    
            <div class="row mb-3">
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="number" id="extra_charge" name="extra_charge" class="form-control" placeholder="Extra Charge">
                        <label for="extra_charge">Extra Charge</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="number" id="discount" name="discount" class="form-control" placeholder="Discount">
                        <label for="discount">Discount</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-floating">
                        <input type="number" id="tax" name="tax" class="form-control" placeholder="Tax">
                        <label for="tax">Tax</label>
                    </div>
                </div>
            </div>
    
            <div class="mb-2">
                <button type="button" id="add-detail" class="btn btn-success">Add Detail</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
    
            <h5>Transaction Details</h5>
            <div class="table-responsive text-nowrap card p-3">
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
                                <select id="package_id" name="package_id[]" class="form-select">
                                    <option selected disabled>Choose :</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" id="quantity" name="quantity[]" class="form-control" placeholder="Quantity">
                            </td>
                            <td>
                                <input type="text" id="description" name="description[]" class="form-control" placeholder="Description">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        document.getElementById('add-detail').addEventListener('click', function() {
            const detailsContainer = document.getElementById('transaction-details');
            const newDetail = `
                <tr>
                    <td>
                        <select id="package_id" name="package_id[]" class="form-select">
                            <option selected disabled>Choose :</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" id="quantity" name="quantity[]" class="form-control" placeholder="Quantity">
                    </td>
                    <td>
                        <input type="text" id="description" name="description[]" class="form-control" placeholder="Description">
                    </td>
                </tr>
            `;
            detailsContainer.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
</x-layout>