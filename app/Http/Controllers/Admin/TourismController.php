<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tourism;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourismController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tourism::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tourisms = $query->paginate(15)->withQueryString();

        return view('admin.tourisms.index', compact('tourisms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tourisms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'opening_hours' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|url|max:255',
            'facilities' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'cropped_image' => 'required|string',
            'supporting_images.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required_with:tickets|string|max:255',
            'tickets.*.price' => 'nullable|string|max:255',
            'spots' => 'nullable|array',
            'spots.*.name' => 'required_with:spots|string|max:255',
            'spots.*.price' => 'nullable|string|max:255',
            'spots.*.description' => 'nullable|string|max:500',
            'spots.*.order_link' => 'nullable|url|max:255',
            'digital_map_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'order_link' => 'nullable|url|max:255',
        ]);

        $imagePath = null;
        if ($request->has('cropped_image') && !empty($request->cropped_image)) {
            $base64_str = substr($request->cropped_image, strpos($request->cropped_image, ",")+1);
            $image_data = base64_decode($base64_str);
            $filename = 'tourisms/' . Str::random(40) . '.jpg';
            Storage::disk('public')->put($filename, $image_data);
            $imagePath = $filename;
        }

        $supportingImages = [];
        if ($request->has('supporting_images')) {
            foreach ($request->supporting_images as $supportImg) {
                if (isset($supportImg['file'])) {
                    $path = $supportImg['file']->store('tourisms/supporting', 'public');
                    $supportingImages[] = [
                        'path' => $path,
                        'caption' => $supportImg['caption'] ?? null,
                    ];
                }
            }
        }

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Tourism::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        Tourism::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'tickets' => $request->tickets,
            'spots' => $request->spots,
            'opening_hours' => $request->opening_hours,
            'location' => $request->location,
            'maps_link' => $request->maps_link,
            'digital_map_link' => $request->digital_map_link,
            'instagram_link' => $request->instagram_link,
            'youtube_link' => $request->youtube_link,
            'order_link' => $request->order_link,
            'facilities' => $request->facilities,
            'contact_person' => $request->contact_person,
            'main_image' => $imagePath,
            'supporting_images' => empty($supportingImages) ? null : $supportingImages,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.tourisms.index')->with('success', 'Wisata berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tourism $tourism)
    {
        return view('admin.tourisms.show', compact('tourism'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tourism $tourism)
    {
        return view('admin.tourisms.edit', compact('tourism'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tourism $tourism)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'opening_hours' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|url|max:255',
            'facilities' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'cropped_image' => 'nullable|string',
            'supporting_images.*.file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images' => 'nullable|array',
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required_with:tickets|string|max:255',
            'tickets.*.price' => 'nullable|string|max:255',
            'spots' => 'nullable|array',
            'spots.*.name' => 'required_with:spots|string|max:255',
            'spots.*.price' => 'nullable|string|max:255',
            'spots.*.description' => 'nullable|string|max:500',
            'spots.*.order_link' => 'nullable|url|max:255',
            'digital_map_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'order_link' => 'nullable|url|max:255',
        ]);

        $imagePath = $tourism->main_image;
        if ($request->has('cropped_image') && !empty($request->cropped_image)) {
            if ($tourism->main_image) {
                Storage::disk('public')->delete($tourism->main_image);
            }
            $base64_str = substr($request->cropped_image, strpos($request->cropped_image, ",")+1);
            $image_data = base64_decode($base64_str);
            $filename = 'tourisms/' . Str::random(40) . '.jpg';
            Storage::disk('public')->put($filename, $image_data);
            $imagePath = $filename;
        }

        $supportingImages = $tourism->supporting_images ?? [];

        // Hapus gambar pendukung yang dipilih
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $index) {
                if (isset($supportingImages[$index])) {
                    Storage::disk('public')->delete($supportingImages[$index]['path']);
                    unset($supportingImages[$index]);
                }
            }
            $supportingImages = array_values($supportingImages); // reindex
        }

        // Tambah gambar pendukung baru
        if ($request->has('supporting_images')) {
            foreach ($request->supporting_images as $supportImg) {
                if (isset($supportImg['file'])) {
                    $path = $supportImg['file']->store('tourisms/supporting', 'public');
                    $supportingImages[] = [
                        'path' => $path,
                        'caption' => $supportImg['caption'] ?? null,
                    ];
                }
            }
        }

        $slug = $tourism->slug;
        if ($tourism->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Tourism::where('slug', $slug)->where('id', '!=', $tourism->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
        }

        $tourism->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'tickets' => $request->tickets,
            'spots' => $request->spots,
            'opening_hours' => $request->opening_hours,
            'location' => $request->location,
            'maps_link' => $request->maps_link,
            'digital_map_link' => $request->digital_map_link,
            'instagram_link' => $request->instagram_link,
            'youtube_link' => $request->youtube_link,
            'order_link' => $request->order_link,
            'facilities' => $request->facilities,
            'contact_person' => $request->contact_person,
            'main_image' => $imagePath,
            'supporting_images' => empty($supportingImages) ? null : $supportingImages,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.tourisms.index')->with('success', 'Wisata berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tourism $tourism)
    {
        if ($tourism->main_image) {
            Storage::disk('public')->delete($tourism->main_image);
        }

        if ($tourism->supporting_images) {
            foreach ($tourism->supporting_images as $img) {
                Storage::disk('public')->delete($img['path']);
            }
        }

        $tourism->delete();

        return redirect()->route('admin.tourisms.index')->with('success', 'Wisata berhasil dihapus.');
    }
}
