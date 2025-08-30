<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Auth::user()->events()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.dashboard.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->where('type', 'events')->get();
        return view('seller.dashboard.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:now',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'total_tickets' => 'required|integer|min:1',
            'ticket_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        } else {
            return "erorr";
        }

        $imagePaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('restaurants/gallery', 'public');
                $imagePaths[] = $path;
            }
        }

        $event_sender = Event::create([
            'image' => $imagePath,
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'location' => $request->location,
            'total_tickets' => $request->total_tickets,
            'ticket_price' => $request->ticket_price,
            'status' => $request->status,
            'user_id' => Auth::user()->id,
            'gallery' => json_encode($imagePaths),
            'additional_data' => json_encode([
                'accepted' => 'no',
                'accepted_at' => null,
                'acceptes_by' => null,
            ]),

        ]);


        // if ($request->hasFile('image')){
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path(''),$imageName);

        //     $event_sender->image = $imageName;
        //     $event_sender->save();
        // }else{return "erorr";}
        // Logic to store the event in the database

        return redirect()->route('seller.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id != Auth::id())
            abort(403);
        $categories = Category::active()->where('type', 'events')->get();
        return view('seller.dashboard.events.edit', compact('event', "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if ($event->user_id != Auth::id())
            abort(403);
        $validated = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:now',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'total_tickets' => 'required|integer|min:1',
            'ticket_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        $imagePaths = [];

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('restaurants/gallery', 'public');
                $imagePaths[] = $path;
            }
            $validated['gallery'] = json_encode($imagePaths);
        } else {
            $imagePaths = $event->gallery;
            $validated['gallery'] = $imagePaths;
        }

        if ($request->hasFile('image')) {
            // File::delete(public_path($event->image));
            Storage::disk('public')->delete($event->image);
            $validated['image'] = $request->file('image')->store('events', 'public');
        } else {
            $validated['image'] = $event->image; // Keep the old image if no new one is uploaded
        }

        $event->update($validated);

        return redirect()->route('seller.events.index')->with("success", "تم التحديث بنجاح");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return redirect()->route('seller.events.index')->with("success", "event deleted successfully");
    }
    public function edit_gallery(Event $event)
    {
        if ($event->user_id != Auth::id()) {
            abort('403');
        }
        return view('seller.dashboard.events.edit_gallery', compact('event'));
    }
}
