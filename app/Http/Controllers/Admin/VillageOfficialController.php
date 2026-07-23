<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageOfficial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageOfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officials = VillageOfficial::orderBy('level')
            ->orderBy('order_num')
            ->with('parent')
            ->get();
            
        $groupedOfficials = $officials->groupBy('level');

        return view('admin.village-officials.index', compact('groupedOfficials', 'officials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $potentialParents = VillageOfficial::orderBy('level')
            ->orderBy('order_num')
            ->get();

        return view('admin.village-officials.create', compact('potentialParents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => 'nullable|string|max:50',
            'position'  => 'required|string|max:150',
            'parent_id' => 'nullable|exists:village_officials,id',
            'status'    => 'required|in:aktif,tidak_aktif',
            'type'      => 'required|in:eksekutif,legislatif,kasun,staf',
            'order_num' => 'nullable|integer|min:0',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $level = 1;
        if ($request->parent_id) {
            $parent = VillageOfficial::find($request->parent_id);
            $level = $parent ? $parent->level + 1 : 1;
        }
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => 'nullable|string|max:50',
            'position'  => 'required|string|max:150',
            'parent_id' => 'nullable|exists:village_officials,id',
            'status'    => 'required|in:aktif,tidak_aktif',
            'type'      => 'required|in:eksekutif,legislatif,kasun,staf',
            'order_num' => 'nullable|integer|min:0',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cropped_image' => 'nullable|string',
        ]);

        $photoPath = null;
        if ($request->filled('cropped_image')) {
            $image_parts = explode(";base64,", $request->cropped_image);
            if(count($image_parts) == 2) {
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1] ?? 'jpeg';
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'village-officials/' . uniqid() . '.' . $image_type;
                Storage::disk('public')->put($fileName, $image_base64);
                $photoPath = $fileName;
            }
        } elseif ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('village-officials', 'public');
        }

        // Hitung level
        $level = 1;
        if (!empty($validated['parent_id'])) {
            $parent = VillageOfficial::find($validated['parent_id']);
            if ($parent) {
                $level = $parent->level + 1;
            }
        }
        
        $maxOrder = VillageOfficial::where('level', $level)->max('order_num') ?? 0;

        VillageOfficial::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'level'     => $level,
            'name'      => $request->name,
            'nip'       => $request->nip,
            'position'  => $request->position,
            'photo'     => $photoPath,
            'status'    => $request->status,
            'type'      => $request->type ?? 'eksekutif',
            'order_num' => $request->order_num ?? ($maxOrder + 1),
        ]);

        return redirect()->route('admin.village-officials.index')
            ->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VillageOfficial $villageOfficial)
    {
        $potentialParents = VillageOfficial::where('id', '!=', $villageOfficial->id)
            ->orderBy('level')
            ->orderBy('order_num')
            ->get();

        return view('admin.village-officials.edit', compact('villageOfficial', 'potentialParents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VillageOfficial $villageOfficial)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => 'nullable|string|max:50',
            'position'  => 'required|string|max:150',
            'parent_id' => 'nullable|exists:village_officials,id',
            'status'    => 'required|in:aktif,tidak_aktif',
            'type'      => 'required|in:eksekutif,legislatif,kasun,staf',
            'order_num' => 'nullable|integer|min:0',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cropped_image' => 'nullable|string',
        ]);

        $level = 1;
        if ($request->parent_id) {
            $parent = VillageOfficial::find($request->parent_id);
            $level = $parent ? $parent->level + 1 : 1;
        }

        $photoPath = $villageOfficial->photo;
        if ($request->filled('cropped_image')) {
            if ($villageOfficial->photo) {
                Storage::disk('public')->delete($villageOfficial->photo);
            }
            $image_parts = explode(";base64,", $request->cropped_image);
            if(count($image_parts) == 2) {
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1] ?? 'jpeg';
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'village-officials/' . uniqid() . '.' . $image_type;
                Storage::disk('public')->put($fileName, $image_base64);
                $photoPath = $fileName;
            }
        } elseif ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($villageOfficial->photo) {
                Storage::disk('public')->delete($villageOfficial->photo);
            }
            $photoPath = $request->file('photo')->store('village-officials', 'public');
        } elseif ($request->has('remove_photo') && $request->remove_photo == '1') {
            // Hapus foto jika diminta
            if ($villageOfficial->photo) {
                Storage::disk('public')->delete($villageOfficial->photo);
            }
            $photoPath = null;
        }

        $villageOfficial->update([
            'parent_id' => $request->parent_id,
            'level'     => $level,
            'name'      => $request->name,
            'nip'       => $request->nip,
            'position'  => $request->position,
            'photo'     => $photoPath,
            'status'    => $request->status,
            'type'      => $request->type ?? $villageOfficial->type,
            'order_num' => $request->order_num ?? $villageOfficial->order_num,
        ]);

        // Cascade level update to children
        $this->updateChildrenLevels($villageOfficial->id, $level);

        return redirect()->route('admin.village-officials.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VillageOfficial $villageOfficial)
    {
        // Biarkan DB (onDelete set null) yang bekerja agar children menjadi orphan tapi tetap di levelnya
        if ($villageOfficial->photo) {
            Storage::disk('public')->delete($villageOfficial->photo);
        }

        $villageOfficial->delete();

        return redirect()->route('admin.village-officials.index')
            ->with('success', 'Perangkat desa berhasil dihapus. Data bawahan sekarang tidak memiliki atasan.');
    }

    /**
     * Reorder via AJAX (SortableJS callback)
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:village_officials,id',
        ]);

        foreach ($request->ids as $order => $id) {
            VillageOfficial::where('id', $id)->update(['order_num' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Recursive function to update children levels
     */
    private function updateChildrenLevels($parentId, $parentLevel)
    {
        $children = VillageOfficial::where('parent_id', $parentId)->get();
        foreach ($children as $child) {
            $newLevel = $parentLevel + 1;
            $child->update(['level' => $newLevel]);
            $this->updateChildrenLevels($child->id, $newLevel);
        }
    }
}
