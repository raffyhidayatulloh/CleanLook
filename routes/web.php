<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'home']);

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);

route::get('outlet', [AdminController::class, 'outlet'])->middleware(['auth', 'admin']);
route::get('delete_outlet/{id}', [AdminController::class, 'delete_outlet'])->middleware(['auth', 'admin']);
route::post('add_outlet', [AdminController::class, 'add_outlet'])->middleware(['auth', 'admin']);
route::post('update_outlet', [AdminController::class, 'update_outlet'])->middleware(['auth', 'admin']);

Route::get('package', [AdminController::class, 'package'])->middleware(['auth', 'admin']);
route::get('delete_package/{id}', [AdminController::class, 'delete_package'])->middleware(['auth', 'admin']);
Route::post('add_package', [AdminController::class, 'add_package'])->middleware(['auth', 'admin']);
Route::post('update_package', [AdminController::class, 'update_package'])->middleware(['auth', 'admin']);

Route::get('member', [AdminController::class, 'member'])->middleware(['auth', 'admin']);
Route::get('delete_member/{id}', [AdminController::class, 'delete_member'])->middleware(['auth', 'admin']);
Route::post('add_member', [AdminController::class, 'add_member'])->middleware(['auth', 'admin']);
Route::post('update_member', [AdminController::class, 'update_member'])->middleware(['auth', 'admin']);

Route::get('transaction', [AdminController::class, 'transaction'])->middleware(['auth', 'admin']);
Route::get('delete_transaction/{id}', [AdminController::class, 'delete_transaction'])->middleware(['auth', 'admin']);
Route::post('add_transaction', [AdminController::class, 'add_transaction'])->middleware(['auth', 'admin']);
Route::post('update_transaction', [AdminController::class, 'update_transaction'])->middleware(['auth', 'admin']);

Route::get('user', [AdminController::class, 'user'])->middleware(['auth', 'admin']);
Route::get('delete_user/{id}', [AdminController::class, 'delete_user'])->middleware(['auth', 'admin']);
Route::post('add_user', [AdminController::class, 'add_user'])->middleware(['auth', 'admin']);
Route::post('update_user', [AdminController::class, 'update_user'])->middleware(['auth', 'admin']);

Route::get('manage_order', [AdminController::class, 'manage_order'])->middleware(['auth', 'admin']);
Route::get('delete_manage_order/{id}', [AdminController::class, 'delete_manage_order'])->middleware(['auth', 'admin']);
Route::post('add_manage_order', [AdminController::class, 'add_manage_order'])->middleware(['auth', 'admin']);
Route::post('update_manage_order', [AdminController::class, 'update_manage_order'])->middleware(['auth', 'admin']);

// Route::get('/get_user/{id}', 'AdminController@getUser');
Route::get('get_user/{id}', [AdminController::class, 'get_user'])->middleware(['auth', 'admin']);
Route::get('get_outlet/{id}', [AdminController::class, 'get_outlet'])->middleware(['auth', 'admin']);
Route::get('get_package/{id}', [AdminController::class, 'get_package'])->middleware(['auth', 'admin']);
Route::get('get_member/{id}', [AdminController::class, 'get_member'])->middleware(['auth', 'admin']);
Route::get('get_transaction_detail/{id}', [AdminController::class, 'get_transaction_detail'])->middleware(['auth', 'admin']);