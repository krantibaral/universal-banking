<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CryptoRateController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'admin', 'middleware' => ['auth',]], function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('transfers', TransferController::class);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/change-password', [UserController::class, 'changePasswordForm'])->name('users.changePasswordForm');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::get('crypto-rates', [CryptoRateController::class, 'index'])->name('crypto-rates.index');
    Route::post('crypto-rates/update', [CryptoRateController::class, 'update'])->name('crypto-rates.update');
    Route::post('/buy-crypto', [HomeController::class, 'buyCrypto'])->name('buy.crypto');
    Route::get('/edit', [UserController::class, 'editProfile'])->name('users.editProfile');
    Route::put('/update', [UserController::class, 'updateProfile'])->name('users.updateProfile');

});
