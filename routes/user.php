<?php

use App\Http\Controllers\AuthController;
//use App\Http\Controllers\Customer\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Tickets;
use App\Http\Controllers\SupportController;
use App\Models\PaidReservation;
use Carbon\Carbon;
use App\Http\Controllers\CustomerExperince;

Route::prefix('dashboard')->as('dashboard.')->middleware(['auth:customer','verified_user'])->group(function () {

    Route::get('/', function () {

        $now = Carbon::now();
        $all = PaidReservation::where('user_id', auth()->id())->get();
    
        $nearestReservation = null;
        $nearestDateTime = null;
        $futureCount = 0;
    
        foreach ($all as $reservation) {
            if (!$reservation->additional_data) {
                continue;
            }
    
            $data = json_decode($reservation->additional_data, true);
    
            if (empty($data['selected_date']) || empty($data['selected_time'])) {
                continue;
            }
    
            $dateTime = Carbon::parse($data['selected_date'].' '.$data['selected_time']);
    
            if ($dateTime->greaterThanOrEqualTo($now)) {
                $futureCount++;
    
                if ($nearestDateTime === null || $dateTime->lessThan($nearestDateTime)) {
                    $nearestDateTime = $dateTime;
                    $nearestReservation = $reservation;
                    $nearestReservation->selected_datetime = $dateTime;
                }
            }
        }
    //dd($nearestReservation,$futureCount);
        return view('customer.dashboard.index', [
            'nearestReservation' => $nearestReservation,
            'futureCount' => $futureCount,
            'user' => auth()->user(),

        ]);
    })->name('overview');

    Route::get('tickets/print', [Tickets::class, 'tickets_print'])->name('tickets.print');
    Route::get('tickets/{id}/cancel', [Tickets::class, 'tickets_cancel'])->name('tickets.cancel');
    Route::get('tickets/payHistory', [Tickets::class, 'payHistory'])->name('tickets.payHistory');
    Route::get('profile',function (){return view('customer.dashboard.profile');})->name('profile');
    //Route::get('support', function () {return view('customer.dashboard.support');})->name('support');
    Route::get('settings', function () {
        return view('customer.dashboard.user_settings');
    })->name('settings');
    Route::get('rewards', function () {
        return view('customer.dashboard.reward');
    })->name('rewards');
    // Route::get('expirence', function () {
    //     return view('customer.dashboard.expirence');
    // })->name('expirences');
    Route::resource('expirence', CustomerExperince::class)->names("expirences");

    Route::resource('tickets', Tickets::class)->names('tickets');
    Route::resource('support', SupportController::class)->names('support');

    Route::get('/chatC', function () {
        return view('customer.dashboard.chat');
    })->name('chatC');


});




Route::get('/login', function () {
    return view('customer.auth.login');
})->middleware('guest:customer')->name('login');
Route::get('/register', function () {
    return view('customer.auth.register');
})->middleware('guest:customer')->name('register');
Route::post('register', [AuthController::class, 'store'])->middleware('guest:customer')->name('signup');
Route::post('login', [AuthController::class, 'login'])->middleware('guest:customer')->name('singin');

Route::post('logout', [AuthController::class, 'userLogout'])->middleware('auth:customer')->name('logout');
