<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Umkm::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%')
                  ->orWhere('owner_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $umkms = $query->paginate(15)->withQueryString();

        $categories = Umkm::select('category')->distinct()->whereNotNull('category')->orderBy('category')->pluck('category');

        return view('admin.umkms.index', compact('umkms', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.umkms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                        => 'required|string|max:255',
            'description'                 => 'required|string',
            'category'                    => 'nullable|string|max:100',
            'owner_name'                  => 'nullable|string|max:255',
            'opening_hours'               => 'nullable|string|max:255',
            'location'                    => 'required|string|max:255',
            'contact_person'              => 'nullable|string|max:255',
            'instagram_link'              => 'nullable|url|max:255',
            'youtube_link'                => 'nullable|url|max:255',
            'marketplace_link'            => 'nullable|url|max:255',
            'facilities'                  => 'nullable|string',
            'cropped_image'               => 'required|string',
            'supporting_images.*.file'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->has('cropped_image') && !empty($request->cropped_image)) {
            $base64_str = substr($request->cropped_image, strpos($request->cropped_image, ",")+1);
            $image_data = base64_decode($base64_str);
            $filename = 'umkms/' . Str::random(40) . '.jpg';
            Storage::disk('public')->put($filename, $image_data);
            $imagePath = $filename;
        }

        $supportingImages = [];
        if ($request->has('supporting_images')) {
            foreach ($request->supporting_images as $supportImg) {
                if (isset($supportImg['file'])) {
                    $path = $supportImg['file']->store('umkms/supporting', 'public');
                    $supportingImages[] = [
                        'path'    => $path,
                        'caption' => $supportImg['caption'] ?? null,
                    ];
                }
            }
        }

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Umkm::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        Umkm::create([
            'name'             => $request->name,
            'slug'             => $slug,
            'description'      => $request->description,
            'category'         => $request->category,
            'owner_name'       => $request->owner_name,
            'opening_hours'    => $request->opening_hours,
            'location'         => $request->location,
            'contact_person'   => $request->contact_person,
            'instagram_link'   => $request->instagram_link,
            'youtube_link'     => $request->youtube_link,
            'marketplace_link' => $request->marketplace_link,
            'facilities'       => $request->facilities,
            'main_image'       => $imagePath,
            'supporting_images' => empty($supportingImages) ? null : $supportingImages,
            'is_active'        => $request->has('is_active'),
        ]);

        return redirect()->route('admin.umkms.index')->with('success', 'Data UMKM berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Umkm $umkm)
    {
        return view('admin.umkms.show', compact('umkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Umkm $umkm)
    {
        return view('admin.umkms.edit', compact('umkm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $request->validate([
            'name'                        => 'required|string|max:255',
            'description'                 => 'required|string',
            'category'                    => 'nullable|string|max:100',
            'owner_name'                  => 'nullable|string|max:255',
            'opening_hours'               => 'nullable|string|max:255',
            'location'                    => 'required|string|max:255',
            'contact_person'              => 'nullable|string|max:255',
            'instagram_link'              => 'nullable|url|max:255',
            'youtube_link'                => 'nullable|url|max:255',
            'marketplace_link'            => 'nullable|url|max:255',
            'facilities'                  => 'nullable|string',
            'cropped_image'               => 'nullable|string',
            'supporting_images.*.file'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images'               => 'nullable|array',
        ]);

        $imagePath = $umkm->main_image;
        if ($request->has('cropped_image') && !empty($request->cropped_image)) {
            if ($umkm->main_image) {
                Storage::disk('public')->delete($umkm->main_image);
            }
            $base64_str = substr($request->cropped_image, strpos($request->cropped_image, ",")+1);
            $image_data = base64_decode($base64_str);
            $filename = 'umkms/' . Str::random(40) . '.jpg';
            Storage::disk('public')->put($filename, $image_data);
            $imagePath = $filename;
        }

        $supportingImages = $umkm->supporting_images ?? [];

        // Hapus gambar pendukung yang dipilih
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $index) {
                if (isset($supportingImages[$index])) {
                    Storage::disk('public')->delete($supportingImages[$index]['path']);
                    unset($supportingImages[$index]);
                }
            }
            $supportingImages = array_values($supportingImages);
        }

        // Tambah gambar pendukung baru
        if ($request->has('supporting_images')) {
            foreach ($request->supporting_images as $supportImg) {
                if (isset($supportImg['file'])) {
                    $path = $supportImg['file']->store('umkms/supporting', 'public');
                    $supportingImages[] = [
                        'path'    => $path,
                        'caption' => $supportImg['caption'] ?? null,
                    ];
                }
            }
        }

        $slug = $umkm->slug;
        if ($umkm->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Umkm::where('slug', $slug)->where('id', '!=', $umkm->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
        }

        $umkm->update([
            'name'             => $request->name,
            'slug'             => $slug,
            'description'      => $request->description,
            'category'         => $request->category,
            'owner_name'       => $request->owner_name,
            'opening_hours'    => $request->opening_hours,
            'location'         => $request->location,
            'contact_person'   => $request->contact_person,
            'instagram_link'   => $request->instagram_link,
            'youtube_link'     => $request->youtube_link,
            'marketplace_link' => $request->marketplace_link,
            'facilities'       => $request->facilities,
            'main_image'       => $imagePath,
            'supporting_images' => empty($supportingImages) ? null : $supportingImages,
            'is_active'        => $request->has('is_active'),
        ]);

        return redirect()->route('admin.umkms.index')->with('success', 'Data UMKM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Umkm $umkm)
    {
        if ($umkm->main_image) {
            Storage::disk('public')->delete($umkm->main_image);
        }

        if ($umkm->supporting_images) {
            foreach ($umkm->supporting_images as $img) {
                Storage::disk('public')->delete($img['path']);
            }
        }

        $umkm->delete();

        return redirect()->route('admin.umkms.index')->with('success', 'Data UMKM berhasil dihapus.');
    }
}
