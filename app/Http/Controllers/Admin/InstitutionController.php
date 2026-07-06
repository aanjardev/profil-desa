<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\InstitutionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstitutionController extends Controller
{
    // Kategori jenis lembaga (umum, bukan nama lembaga)
    const TYPE_LABELS = [
        'kemasyarakatan' => 'Kemasyarakatan',
        'pemerintahan'   => 'Pemerintahan Desa',
        'ekonomi'        => 'Ekonomi & Usaha',
        'kepemudaan'     => 'Kepemudaan',
        'keagamaan'      => 'Keagamaan',
        'keamanan'       => 'Keamanan & Ketertiban',
        'lainnya'        => 'Lainnya',
    ];

    const TYPE_COLORS = [
        'kemasyarakatan' => 'bg-blue-100 text-blue-700',
        'pemerintahan'   => 'bg-purple-100 text-purple-700',
        'ekonomi'        => 'bg-emerald-100 text-emerald-700',
        'kepemudaan'     => 'bg-indigo-100 text-indigo-700',
        'keagamaan'      => 'bg-amber-100 text-amber-700',
        'keamanan'       => 'bg-orange-100 text-orange-700',
        'lainnya'        => 'bg-gray-100 text-gray-700',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Institution::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $query->orderBy('type')->orderBy('name');

        $institutions = $query->paginate(15)->withQueryString();
        $typeLabels   = self::TYPE_LABELS;
        $typeColors   = self::TYPE_COLORS;

        return view('admin.institutions.index', compact('institutions', 'typeLabels', 'typeColors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeLabels = self::TYPE_LABELS;

        return view('admin.institutions.create', compact('typeLabels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:150',
            'type'                => 'required|in:' . implode(',', array_keys(self::TYPE_LABELS)),
            'description'         => 'nullable|string',
            'contact_person'      => 'nullable|string|max:255',
            'logo'                => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'is_active'           => 'nullable|boolean',
            'gallery.*'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'members'             => 'nullable|array',
            'members.*.name'      => 'required_with:members|string|max:255',
            'members.*.position'  => 'required_with:members|string|max:100',
            'members.*.photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'members.*.order_num' => 'nullable|integer|min:0',
        ]);

        // Upload logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('institutions/logos', 'public');
        }

        // Upload galeri
        $images = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path     = $img->store('institutions/gallery', 'public');
                $images[] = ['path' => $path, 'caption' => null];
            }
        }

        $institution = Institution::create([
            'name'           => $request->name,
            'type'           => $request->type,
            'description'    => $request->description,
            'contact_person' => $request->contact_person,
            'logo'           => $logoPath,
            'images'         => empty($images) ? null : $images,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        // Simpan anggota
        if ($request->has('members')) {
            foreach ($request->members as $i => $memberData) {
                $photoPath = null;
                if (isset($memberData['photo']) && $memberData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $photoPath = $memberData['photo']->store('institutions/members', 'public');
                }

                $institution->members()->create([
                    'name'      => $memberData['name'],
                    'position'  => $memberData['position'],
                    'photo'     => $photoPath,
                    'order_num' => $memberData['order_num'] ?? ($i + 1),
                ]);
            }
        }

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Lembaga desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        $institution->load('members');
        $typeLabels = self::TYPE_LABELS;
        $typeColors = self::TYPE_COLORS;

        return view('admin.institutions.show', compact('institution', 'typeLabels', 'typeColors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        $institution->load('members');
        $typeLabels = self::TYPE_LABELS;

        return view('admin.institutions.edit', compact('institution', 'typeLabels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name'                         => 'required|string|max:150',
            'type'                         => 'required|in:' . implode(',', array_keys(self::TYPE_LABELS)),
            'description'                  => 'nullable|string',
            'contact_person'               => 'nullable|string|max:255',
            'logo'                         => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'is_active'                    => 'nullable|boolean',
            'gallery.*'                    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images'                => 'nullable|array',
            'members'                      => 'nullable|array',
            'members.*.id'                 => 'nullable|integer|exists:institution_members,id',
            'members.*.name'               => 'required_with:members|string|max:255',
            'members.*.position'           => 'required_with:members|string|max:100',
            'members.*.photo'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'members.*.order_num'          => 'nullable|integer|min:0',
            'members.*.remove_photo'       => 'nullable|boolean',
            'delete_member_ids'            => 'nullable|array',
            'delete_member_ids.*'          => 'integer|exists:institution_members,id',
        ]);

        // Update logo
        $logoPath = $institution->logo;
        if ($request->hasFile('logo')) {
            if ($institution->logo) {
                Storage::disk('public')->delete($institution->logo);
            }
            $logoPath = $request->file('logo')->store('institutions/logos', 'public');
        } elseif ($request->boolean('remove_logo')) {
            if ($institution->logo) {
                Storage::disk('public')->delete($institution->logo);
            }
            $logoPath = null;
        }

        // Kelola galeri - hapus yang dipilih
        $existingImages = $institution->images ?? [];
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $idx) {
                if (isset($existingImages[$idx])) {
                    Storage::disk('public')->delete($existingImages[$idx]['path']);
                    unset($existingImages[$idx]);
                }
            }
            $existingImages = array_values($existingImages);
        }

        // Upload galeri baru
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path             = $img->store('institutions/gallery', 'public');
                $existingImages[] = ['path' => $path, 'caption' => null];
            }
        }

        $institution->update([
            'name'           => $request->name,
            'type'           => $request->type,
            'description'    => $request->description,
            'contact_person' => $request->contact_person,
            'logo'           => $logoPath,
            'images'         => empty($existingImages) ? null : $existingImages,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        // Hapus anggota yang dipilih
        if ($request->has('delete_member_ids')) {
            foreach ($request->delete_member_ids as $memberId) {
                $member = InstitutionMember::find($memberId);
                if ($member && $member->institution_id === $institution->id) {
                    if ($member->photo) {
                        Storage::disk('public')->delete($member->photo);
                    }
                    $member->delete();
                }
            }
        }

        // Update / tambah anggota
        if ($request->has('members')) {
            foreach ($request->members as $i => $memberData) {
                $orderNum = $memberData['order_num'] ?? ($i + 1);

                if (!empty($memberData['id'])) {
                    $member = InstitutionMember::find($memberData['id']);
                    if ($member && $member->institution_id === $institution->id) {
                        $photoPath = $member->photo;

                        if (isset($memberData['photo']) && $memberData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                            if ($member->photo) Storage::disk('public')->delete($member->photo);
                            $photoPath = $memberData['photo']->store('institutions/members', 'public');
                        } elseif (!empty($memberData['remove_photo'])) {
                            if ($member->photo) Storage::disk('public')->delete($member->photo);
                            $photoPath = null;
                        }

                        $member->update([
                            'name'      => $memberData['name'],
                            'position'  => $memberData['position'],
                            'photo'     => $photoPath,
                            'order_num' => $orderNum,
                        ]);
                    }
                } else {
                    $photoPath = null;
                    if (isset($memberData['photo']) && $memberData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                        $photoPath = $memberData['photo']->store('institutions/members', 'public');
                    }

                    $institution->members()->create([
                        'name'      => $memberData['name'],
                        'position'  => $memberData['position'],
                        'photo'     => $photoPath,
                        'order_num' => $orderNum,
                    ]);
                }
            }
        }

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Data lembaga desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        if ($institution->logo) {
            Storage::disk('public')->delete($institution->logo);
        }

        if ($institution->images) {
            foreach ($institution->images as $img) {
                Storage::disk('public')->delete($img['path']);
            }
        }

        foreach ($institution->members as $member) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
        }

        $institution->delete();

        return redirect()->route('admin.institutions.index')
            ->with('success', 'Lembaga desa berhasil dihapus.');
    }
}
