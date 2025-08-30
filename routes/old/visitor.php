<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\seller\BranchController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\visitor\BranchController as VisitorBranchController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\visitor\EventController;
use App\Http\Controllers\visitor\LoginController;
use App\Http\Controllers\visitor\ProfileController;
use App\Http\Controllers\visitor\VisitorController;
use App\Http\Controllers\visitor\RestaurentController;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
// Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
// Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
// Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');
Route::middleware(['auth', 'role:visitor'])->group(function () {
    Route::get('', function (HttpRequest $request) {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'category' => 'nullable|exists:categories,id',
            'minPrice' => 'nullable|numeric|max:99999|min:0',
            'maxPrice' => 'nullable|numeric|max:10000|min:1',
        ]);
        $events = Event::where('status', 'active');
        if (isset($validated['search']) && $validated['search'] != '') {
            $events = $events->where('name', 'like', '%' . $validated['search'] . '%')->orWhere('description', 'like', '%' . $validated['search'] . '%')->orwhere('location', 'like', '%' . $validated['search'] . '%');
        }
        if (isset($validated['date']) && $validated['date'] != '') {
            $events = $events->whereDate('date', $validated['date']);
        } else {
            $events = $events->where('date', '>', now());
        }
        if (isset($validated['category']) && $validated['category'] != '') {
            $events = $events->where('category_id', $validated['category']);
        }
        if (isset($validated['minPrice']) && $validated['minPrice'] != '') {
            $events = $events->where('ticket_price', '>=', $validated['minPrice']);
        }
        if (isset($validated['maxPrice']) && $validated['maxPrice'] != '') {
            $events = $events->where('ticket_price', '<=', $validated['maxPrice']);
        }
        $events = $events->orderBy('date', 'asc')->paginate(12);
        // ->paginate(12);
        // where('date','>',now())->
        $categories = Category::where('type', 'events')->where('status', 'active')->get();
        return view('visitor.dashboard.index', compact('events', 'categories'));
    })->name('dashboard');
    // Route::get('my_bookings', function () {
    //     $bookings = [];
    //     return view('visitor.dashboard.my_booking', compact('bookings'));
    // })->name('my_bookings');
    // Route::get('tickets', function () {
    //     $tickets = [];
    //     // return view('visitor.dashboard.tickets', compact('tickets'));
    // })->name('my_tickets');


    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('restaurent/{restaurant}', [VisitorBranchController::class, 'show'])->name('bran.show');
    Route::get('restaurent/{restaurant}/preview/{branch}', [VisitorBranchController::class, 'index'])->name('branch_preview');
    // Route::post('/visitor/get-schedule', [VisitorBranchController::class, 'getSchedule'])->name('get_schedule');
    // Route::post('/check-availability', [ReservationController::class, 'checkAvailability']);
    Route::post('/check-availability-full', [ReservationController::class, 'checkAvailabilityFull'])->name('check_availability_full');
    Route::post('/check-availability', [ReservationController::class, 'checkAvailability'])->name('check_availability');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

    Route::resource('/my_bookings', ReservationController::class)->middleware("auth")->names('my_bookings');
    Route::post('my_bookings/pay/{id}', [ReservationController::class, 'confirm'])->name('my_bookings.pay');


    Route::get('explore_restaurents', function () {
        $restaurents = [];
        return view('visitor.dashboard.explore_restaurents', compact('restaurents'));
    })->name('my_restaurents');
    Route::resource('dashboard/details', VisitorController::class)->middleware("auth")->names('details');
    Route::resource('restaurent', RestaurentController::class)->middleware("auth")->names('restaurent');

    Route::post('event{event}-tickets', [TicketController::class, 'store'])
        ->name('tickets.store');
    Route::resource('tickets', TicketController::class)
        ->except(['store'])
        ->names('tickets')->parameters([
            'event' => 'event',
            'tickets' => 'ticket'
        ]);
    Route::get('profile', [ProfileController::class, 'index']);

    Route::resource('support', SupportController::class)->middleware("auth")->names('support');
    Route::resource('support/chat', ChatController::class)->middleware("auth")->names('support_chat');
    Route::post('support/chat/{id}', [ChatController::class,'store'])->middleware("auth")->name('support_chat.send');

});


