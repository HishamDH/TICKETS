<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Reservation::where('user_id', Auth::id())
            ->whereHas('branch')

            ->with(['branch' => function ($query) {
                $query->select('id', 'image', 'open_at', 'close_at', 'name', 'location','restaurant_id');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('visitor.dashboard.my_booking', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'chairs' => 'required|integer|min:1|max:5',
        ]);
        //dd($request->all());
        $branch = Branch::findOrFail($validated['branch_id']);
        $reservationDate = $validated['reservation_date'];

        $startTime = Carbon::parse("{$reservationDate} {$validated['start_time']}");
        $endTime = $startTime->copy()->addHours($validated['end_time']);

        $start_time = Carbon::parse("{$reservationDate} {$validated['start_time']}");
        $end_time = Carbon::parse("{$reservationDate} {$validated['end_time']}");

        $durationInMinutes = $start_time->diffInMinutes($end_time); // الفرق بالدقائق
        $durationInHours = $durationInMinutes / 60;

        $overlappingCount = Reservation::where('branch_id', $branch->id)
            ->whereDate('reservation_date', $reservationDate)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime->format('H:i:s'))
                    ->where('end_time', '>', $startTime->format('H:i:s'));
            })->count();

        if ($overlappingCount >= $branch->tables) {
            return response()->json(['message' => 'لا يوجد طاولات متاحة في هذا الوقت.'], 409);
        }
        //$duration= $startTime - $endTime;
        Reservation::create([
            'branch_id' => $branch->id,
            'reservation_date' => $reservationDate,
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'status' => 'pending',
            'price' => $branch->hour_price *  $durationInHours,
            'user_id' => auth()->id(),
            'chairs' => $validated['chairs'],
            'code' => 'Res-' . strtoupper(uniqid()),

        ]);
        //dd( $durationInHours,$start_time);

        return redirect()->route('visitor.my_bookings.index')->with('success', 'Booking successful');

        // return response()->json(['message' => 'تم الحجز بنجاح'], 201);
    }
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $branch = Branch::findOrFail($request->branch_id);
        $tables = $branch->tables;

        $startTime = Carbon::parse("{$request->date} {$request->start_time}");
        $endTime = $startTime->copy()->addMinutes(30);

        $overlaps = Reservation::where('branch_id', $branch->id)
            ->whereDate('reservation_date', $request->date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime->format('H:i:s'))
                    ->where('end_time', '>', $startTime->format('H:i:s'));
            })
            ->count();

        if ($overlaps < $tables) {
            return response()->json(['available' => true]);
        }

        // لو مش متاح، بنحسب اقرب وقت متاح
        $nextAvailable = $this->findNextAvailableSlot($branch, $request->date, $startTime);
        return response()->json([
            'available' => false,
            'next_available' => $nextAvailable->format('H:i')
        ]);
    }
    public function checkAvailabilityFull(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $branch = Branch::findOrFail($request->branch_id);
        $tables = $branch->tables;

        $startTime = Carbon::parse("{$request->date} {$request->start_time}");
        $endTime = Carbon::parse("{$request->date} {$request->end_time}");

        $overlaps = Reservation::where('branch_id', $branch->id)
            ->whereDate('reservation_date', $request->date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime->format('H:i:s'))
                    ->where('end_time', '>', $startTime->format('H:i:s'));
            })
            ->count();

        if ($overlaps < $tables) {
            return response()->json(['available' => true]);
        }

        // اقتراح اقرب فترة جديدة لاحقة (اختياري)
        $nextAvailable = $this->findNextAvailableSlot($branch, $request->date, $startTime, $endTime);
        return response()->json([
            'available' => false,
            'next_available' => $nextAvailable->format('H:i')
        ]);
    }

    private function findNextAvailableSlot($branch, $date, $startTime, $endTime)
    {
        for ($i = 1; $i <= 24; $i++) {
            $newStart = $startTime->copy()->addMinutes($i * 30);
            $newEnd = $endTime->copy()->addMinutes($i * 30);

            if ($newEnd->hour >= Carbon::parse($branch->close_at)->hour) {
                break;
            }

            $overlaps = Reservation::where('branch_id', $branch->id)
                ->whereDate('reservation_date', $date)
                ->where(function ($query) use ($newStart, $newEnd) {
                    $query->where('start_time', '<', $newEnd->format('H:i:s'))
                        ->where('end_time', '>', $newStart->format('H:i:s'));
                })->count();

            if ($overlaps < $branch->tables) {
                return $newStart;
            }
        }

        return $startTime->copy()->addMinutes(30); // fallback
    }

    // private function findNextAvailableSlot($branch, $date, $currentTime)
    // {
    //     for ($i = 1; $i <= 24; $i++) {
    //         $nextSlot = $currentTime->copy()->addMinutes($i * 30);
    //         if ($nextSlot->hour >= Carbon::parse($branch->close_at)->hour) {
    //             break; // لا يوجد مواعيد بعد إغلاق الفرع
    //         }

    //         $endSlot = $nextSlot->copy()->addMinutes(30);

    //         $overlaps = Reservation::where('branch_id', $branch->id)
    //             ->whereDate('reservation_date', $date)
    //             ->where(function ($query) use ($nextSlot, $endSlot) {
    //                 $query->where('start_time', '<', $endSlot->format('H:i:s'))
    //                       ->where('end_time', '>', $nextSlot->format('H:i:s'));
    //             })
    //             ->count();

    //         if ($overlaps < $branch->tables) {
    //             return $nextSlot;
    //         }
    //     }
    //     return $currentTime->copy()->addMinutes(30); // fallback
    // }

    //     public function getAvailableSlots(Request $request)
    //     {
    //         $validated = $request->validate([
    //             'branch_id' => 'required|exists:branches,id',
    //             'date' => 'required|date',
    //         ]);

    //         $branch = Branch::findOrFail($validated['branch_id']);
    //         $tablesCount = $branch->tables;

    //         $startHour = Carbon::parse($branch->open_at)->hour;
    //         $endHour = Carbon::parse($branch->close_at)->hour;

    //         $slots = [];

    //         for ($hour = $startHour; $hour < $endHour; $hour++) {
    //             for ($minute = 0; $minute < 60; $minute += 30) {
    //                 $slotStart = Carbon::parse("{$validated['date']} {$hour}:{$minute}:00");
    //                 $slotEnd = (clone $slotStart)->addMinutes(30);

    //                 $overlaps = Reservation::where('branch_id', $branch->id)
    //                     ->whereDate('reservation_date', $validated['date'])
    //                     ->where(function ($query) use ($slotStart, $slotEnd) {
    //                         $query->where('start_time', '<', $slotEnd->format('H:i:s'))
    //                             ->where('end_time', '>', $slotStart->format('H:i:s'));
    //                     })
    //                     ->count();

    //                 $slots[] = [
    //                     'time' => $slotStart->format('H:i'),
    //                     'reservations_count' => $overlaps,
    //                     'available_tables' => $tablesCount - $overlaps
    //                 ];
    //             }
    //         }

    //         return response()->json($slots);
    //     }


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function confirm(Request $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to update this ticket.');
        }

        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending reservations can be confirmed.');
        }
        // if ($reservation->start_time <= now()) {
        //     //$reservation->status = 'cancelled';
        //     $reservation->save();
        //     return redirect()->back()->with('error', 'You cannot confirm a reservation that has already started.');
        // }

        $reservation->status = 'confirmed';
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation confirmed successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this reservation.');
        }

        if ($reservation->status === 'confirmed') {
            return redirect()->back()->with('error', 'You cannot delete a confirmed reservation.');
        }

        $reservation->delete();
        return redirect()->back()->with('success', 'Reservation deleted successfully!');
    }
}
