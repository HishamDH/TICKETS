<?php

use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\admin\SellerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Withdraw_checking;
use App\Http\Controllers\AccesMerchantProfile;

Route::get('/', function () {
    return redirect()->route('dashboard.overview');
})->middleware('auth:admin');
Route::prefix('dashboard')->as('dashboard.')->middleware(['auth:admin'])->group(function () {

    Route::get('', function () {
        return view('admin.dashboard.index');
    })->name('overview');
    Route::get('reports', function () {
        return view('admin.dashboard.reports');
    })->name('reports');

    Route::get('setup', function () {
        return view('admin.dashboard.generale-settings');
    })->name('setup');

    Route::prefix('merchants')->as('merchants.')->group(function () {
        Route::get('/', [MerchantController::class, 'index'])->name('index');
    });
    Route::resource('withdraws', Withdraw_checking::class)
        ->names('withdraws');

    Route::get("merchant",[AccesMerchantProfile::class,"index"])->name('merchant.access');
    Route::get('/handled', [Withdraw_checking::class, 'index2'])->name('withdraw.handled');
    Route::resource('support', \App\Http\Controllers\Admin_Support::class)
        ->names('support');
    Route::get('public_res', function () {
            return view('admin.dashboard.public_res');
        })->name('public_reservations');
    Route::get('employees', function () {
            return view('admin.dashboard.employee_managment');
        })->name('employees');
});

Route::get('/login', function () {
    return view('admin.auth.login');
})->middleware('guest:admin')->name('login');
Route::post('login', [AuthController::class, 'login'])->middleware('guest:admin')->name('singin');
Route::post('logout', [AuthController::class, 'adminLogout'])->middleware('auth:admin')->name('logout');
