<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Category;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branchs = Branch::where('restaurant_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.dashboard.branches.index', compact('branchs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$categories = Category::active()->where('type', 'events')->get();
        return view('seller.dashboard.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'tables' => 'required|integer',
            'hour_price' => 'required|numeric',
            'open_at' => 'nullable|date_format:H:i',
            'close_at' => 'required_with:open_at|date_format:H:i|after:open_at',
            'status' => 'required|in:active,inactive',
            'gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'

        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        } else {
            //$imagePath = Branch::all()->image;
            return "erorr";
        }

        $imagePaths = [];

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('restaurants/gallery', 'public');
                $imagePaths[] = $path;
            }
        }

        $branch_sender = Branch::create([
            'image' => $imagePath,
            'name' => $validate['name'],
            'location' => $validate['location'],
            'tables' => $validate['tables'],
            'hour_price' => $validate['hour_price'],
            'open_at' => $validate['open_at'],
            'close_at' => $validate['close_at'],
            'status' => $validate['status'],
            'restaurant_id' => Auth::id(),
            'gallery' => json_encode($imagePaths)
        ]);
        return redirect()->route('seller.branch.index')->with('success', 'branch was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(branch $branch)
    {
        $restaurant = Branch::findOrFail($branch);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(branch $branch)
    {
        //$categories = Category::active()->where('id', 'user')->get();
        return view("seller.dashboard.branches.edit", compact('branch'));
    }

    public function edit_gallery(Branch $branch)
    {
        //$categories = Category::active()->where('id', 'user')->get();

        // dd($branch->gallery);
        return view("seller.dashboard.branches.edit_gallery", compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, branch $branch)
    {
        $validate = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'tables' => 'nullable|integer',
            'hour_price' => 'nullable|numeric',
            'open_at' => 'nullable|date_format:H:i:s',
            'close_at' => 'required_with:open_at|date_format:H:i:s|after:open_at',
            'status' => 'in:active,inactive',

            // أضف هنا فحص الصور الجديدة والمعدلة
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'updated_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($branch->image);
            $validate['image'] = $request->file('image')->store('branches', 'public');
        } else {
            $validate['image'] = $branch->image;
        }
        // جلب الصور التي بقيت كما هي
        $gallery = $request->input('keep_images', []);

        // تحديث الصور التي تم تعديلها
        if ($request->hasFile('updated_images')) {
            foreach ($request->file('updated_images') as $index => $updatedImage) {
                if ($updatedImage) {
                    // حذف الصورة القديمة إن وجدت
                    if (isset($gallery[$index])) {
                        Storage::disk('public')->delete($gallery[$index]);
                    }

                    // رفع الصورة الجديدة بنفس مكان القديمة
                    $gallery[$index] = $updatedImage->store('branches/gallery', 'public');
                }
            }
        }

        // إضافة الصور الجديدة المضافة
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $newImage) {
                $gallery[] = $newImage->store('branches/gallery', 'public');
            }
        }

        // ترتيب الصور بعد التعديلات (لضمان ترتيب الفهرسة بشكل نظيف)
        $gallery = array_values($gallery);

        // تخزين البيانات الجديدة
        $branch->update([
            'image' => $validate['image'],
            'name' => $validate['name'],
            'location' => $validate['location'],
            'tables' => $validate['tables'],
            'hour_price' => $validate['hour_price'],
            'open_at' => $validate['open_at'],
            'close_at' => $validate['close_at'],
            'status' => $validate['status'],
            'gallery' => json_encode($gallery),
        ]);



        return redirect()->route('seller.branch.index')->with('success', 'Branch updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        if ($branch->image && Storage::disk('public')->exists($branch->image)) {
            Storage::disk('public')->delete($branch->image);
        }
        $branch->delete();

        return redirect()->route('seller.branch.index')->with('success', 'Branch deleted successfully.');
    }
}
