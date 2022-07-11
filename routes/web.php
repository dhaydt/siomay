<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard.auth.Login');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});

Route::get('/postAdministrator', function () {
    $user = new User();
    $user->name = 'administrator';
    $user->phone = '08123456789';
    $user->email = 'adminsitrator@adminsitrator.com';
    $user->role = 1;
    $user->password = bcrypt('adminadmin');
    $user->save();
});

Route::get('/postAdmin', function () {
    $user = new User();
    $user->name = 'admin';
    $user->phone = '08987654321';
    $user->email = 'admin@admin.com';
    $user->role = 2;
    $user->password = bcrypt('adminadmin');
    $user->save();
});

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthenticationController::class, 'login'])->name('login');
});

Route::prefix('dashboard')->middleware('admin')->group(function () {
    Route::get('index', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::get('config', [DashboardController::class, 'config'])->name('config');

    Route::prefix('user')->group(function () {
        Route::get('list/{status}', [UserController::class, 'index'])->name('user.list');
    });

    Route::get('cabang', [CabangController::class, 'index'])->name('cabang');
    Route::get('gudang/{status}', [GudangController::class, 'index'])->name('gudang');
    Route::get('produk', [ItemController::class, 'index'])->name('produk');
    Route::get('pengajuan/{status}', [GudangController::class, 'pengajuan_stock'])->name('pengajuan_stock');
    Route::get('pengajuan_stock', [GudangController::class, 'form_pengajuan_stock'])->name('form_stock');
    Route::post('post_pengajuan_stock', [GudangController::class, 'post_form_pengajuan_stock'])->name('post.pengajuan');
});
