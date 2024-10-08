<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Outlet;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use DateTime;

class AdminController extends Controller
{
    public function outlet() {
        $datas = Outlet::all();
        return view('admin.outlet', compact('datas'));
    }

    public function get_outlet($id) {
        $outlet = Outlet::find($id);
        return response()->json($outlet);
    }

    public function add_outlet(Request $request) {
        $outlet = new Outlet;
        $outlet->name = $request->name;
        $outlet->address = $request->address;
        $outlet->telp = $request->telp;
        $outlet->save();
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function delete_outlet($id) {
        $data = Outlet::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function update_outlet(Request $request) {
        $data = Outlet::find($request->id);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->telp = $request->telp;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function package() {
        $outlets = Outlet::all();
        $datas = Package::with('outlet')->get();
        return view('admin.package', compact('outlets', 'datas'));
    }

    public function get_package($id) {
        $package = Package::find($id);
        return response()->json($package);
    }

    public function add_package(Request $request) {
        $package = new Package;
        $package->outlet_id = $request->outlet_id;
        $package->type = $request->type;
        $package->package_name = $request->package_name;
        $package->price = $request->price;
        $package->save();
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function delete_package($id) {
        $data = Package::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function update_package(Request $request) {
        $data = Package::find($request->id);
        $data->outlet_id = $request->outlet_id;
        $data->type = $request->type;
        $data->package_name = $request->package_name;
        $data->price = $request->price;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function member() {
        $datas = Member::all();
        return view('admin.member', compact('datas'));
    }

    public function get_member($id) {
        $member = Member::find($id);
        return response()->json($member);
    }

    public function add_member(Request $request) {
        $member = new Member;
        $member->name = $request->name;
        $member->address = $request->address;
        $member->gender = $request->gender;
        $member->telp = $request->telp;
        $member->save();
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function delete_member($id) {
        $data = Member::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function update_member(Request $request) {
        $data = Member::find($request->id);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->gender = $request->gender;
        $data->telp = $request->telp;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function user() {
        $datas = User::all();
        $roles = User::getStatuses();
        return view('admin.user', compact('datas', 'roles'));
    }

    public function get_user($id) {
        $user = User::find($id);
        return response()->json($user);
    }

    public function add_user(Request $request) {
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function delete_user($id) {
        $data = User::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function update_user(Request $request) {
        $data = User::find($request->id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->role = $request->role;
        $data->email = $request->email;
        $data->password = $request->change_password ?? $data->password;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function transaction() {
        $outlets = Outlet::all();
        $members = Member::all();
        $packages = Package::all();
        $statuses = Transaction::getStatuses();
        $datas = Transaction::all();
        return view('admin.transaction', compact('datas', 'outlets', 'members', 'packages', 'statuses'));
    }

    public function get_transaction_detail($id) {
        $transactionDetails = TransactionDetail::with('package')->find($id);
        if (!$transactionDetails) {
            return response()->json(['message' => 'Transaction detail not found'], 404);
        }
        return response()->json([
            'id' => $transactionDetails->id,
            'package_name' => $transactionDetails->package->package_name,
            'quantity' => $transactionDetails->quantity,
            'description' => $transactionDetails->description
        ]);
    }

    public function add_transaction(Request $request) {
        $invoiceCode = $this->generateInvoiceCode();

        $transaction = new Transaction;
        $transaction->outlet_id = $request->outlet_id;
        $transaction->member_id = $request->member_id;
        $transaction->invoice_code = $invoiceCode;
        $transaction->date = now();
        $transaction->deadline = $request->deadline;
        $transaction->payment_date = $request->payment_date;
        $transaction->extra_charge = $request->extra_charge;
        $transaction->discount = $request->discount;
        $transaction->tax = $request->tax;
        $transaction->status = 'new';
        $transaction->user_id = $request->user_id;
        $transaction->save();
    
        foreach ($request->package_id as $index => $packageId) {
            $transactionDetail = new TransactionDetail;
            $transactionDetail->transaction_id = $transaction->id;
            $transactionDetail->package_id = $packageId;
            $transactionDetail->quantity = $request->quantity[$index];
            $transactionDetail->description = $request->description[$index];
            $transactionDetail->save();
        }
        return redirect()->back();
    }


    function generateInvoiceCode() {
        $datePart = now()->format('Ymd');
        $invoiceCount = \App\Models\Transaction::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoiceCode = 'INV-' . $datePart . '-' . str_pad($invoiceCount, 4, '0', STR_PAD_LEFT);
        return $invoiceCode;
    }

    public function manage_order() {
        $datas = Transaction::all();
        return view('admin.manage_order', compact('datas'));
    }

    public function add_manage_order(Request $request) {
        $member = new Member;
        $member->name = $request->name;
        $member->address = $request->address;
        $member->gender = $request->gender;
        $member->telp = $request->telp;
        $member->save();
        return redirect()->back();
    }

    public function delete_manage_order($id) {
        $data = Member::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function update_manage_order(Request $request, $id) {
        $data = Member::find($id);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->gender = $request->gender;
        $data->telp = $request->telp;
        $data->save();
        return redirect('/member');
    }
}