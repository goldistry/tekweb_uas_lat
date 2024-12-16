<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeliveryLogController;
use App\Http\Controllers\DeliveryTransactionController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'login'])->name('user.login');
Route::post('/signUp', [AuthController::class, 'signUp'])->name('user.signUp');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');


Route::get('/welcome', [MainController::class, 'welcome'])->name('user.welcome');
Route::middleware('protectLogin')->group(function () {
Route::get('/admin/login', [MainController::class, 'loginAdmin'])->name('admin.login');
Route::post('/admin/login/submit', [AuthController::class, 'loginAdmin'])->name('admin.login.submit');
});
Route::middleware('isLogin')->group(function () {
  Route::get('/dashboard', [MainController::class, 'dashboardAdmin'])->name('admin.dashboard');
  Route::get('/entryLogs', [MainController::class, 'entryLog'])->name('admin.entryLog');
  Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
  Route::get('/admin/userAdmin', [MainController::class, 'userAdmin'])->name('admin.userAdmin');
  Route::get('/admin/userAdmin/edit/{id}', [MainController::class, 'editUserAdmin'])->name('admin.userAdmin.edit');

  Route::post('/delivery_transactions', [DeliveryTransactionController::class, 'store'])->name('delivery_transactions.store');
  Route::get('/delivery_transactions', [DeliveryTransactionController::class, 'index'])->name('delivery_transactions.index');
  Route::get('/delivery_transactions', [DeliveryTransactionController::class, 'index'])->name('delivery_transactions.index');
  Route::delete('/delivery_transactions/{id}', [DeliveryTransactionController::class, 'destroy'])->name('delivery_transactions.destroy');
  Route::get('/delivery_logs/{nomor_resi}', [MainController::class, 'entryLog'])->name('delivery_logs.form');
  Route::post('/delivery_logs/submit', [DeliveryLogController::class, 'save'])->name('delivery_logs.save');
  Route::delete('/delivery_logs/{id}', [DeliveryLogController::class, 'destroy'])->name('delivery_logs.destroy');
  Route::get('/search-delivery_logs/{nomor_resi}', [DeliveryLogController::class, 'getByNomorResi'])->name('delivery_logs.search');


  Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
  Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');
  Route::patch('/admins/{id}', [AdminController::class, 'updatePartial'])->name('admins.update');


});
