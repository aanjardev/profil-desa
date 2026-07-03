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
        // Level 1: Kepala Desa (root) - Harus level 1 dan parent_id null
        $level1 = VillageOfficial::whereNull('parent_id')
            ->where('level', 1)
            ->orderBy('order_num')
            ->get();

        // Level 2: Sekdes, Kasie, dll.
        $level2 = VillageOfficial::where('level', 2)
            ->orderBy('order_num')
            ->with('parent')
            ->get();

        // Level 3: Staff dan seterusnya (agar tidak hilang jika level > 3)
        $level3 = VillageOfficial::where('level', '>=', 3)
            ->orderBy('level')
            ->orderBy('order_num')
            ->with('parent')
            ->get();

        return view('admin.village-officials.index', compact('level1', 'level2', 'level3'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Calon parent: level 1 dan 2 saja
        $potentialParents = VillageOfficial::whereIn('level', [1, 2])
            ->orderBy('level')
            ->orderBy('order_num')
            ->get();

        $hasLevel1 = VillageOfficial::whereNull('parent_id')->where('level', 1)->exists();

        return view('admin.village-officials.create', compact('potentialParents', 'hasLevel1'));
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
            'order_num' => 'nullable|integer|min:0',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $level = 1;
        if ($request->parent_id) {
            $parent = VillageOfficial::find($request->parent_id);
            $level = $parent ? $parent->level + 1 : 1;
        } else {
            // Mencegah lebih dari 1 Kepala Desa (Level 1)
            if (VillageOfficial::whereNull('parent_id')->where('level', 1)->exists()) {
                return back()->withInput()->withErrors(['parent_id' => 'Level 1 (Kepala Desa) sudah ada. Silakan pilih atasan untuk perangkat ini.']);
            }
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('village-officials', 'public');
        }

        // Auto-set order_num: last in its level
        $maxOrder = VillageOfficial::where('level', $level)->max('order_num') ?? 0;

        VillageOfficial::create([
            'parent_id' => $request->parent_id,
            'level'     => $level,
            'name'      => $request->name,
            'nip'       => $request->nip,
            'position'  => $request->position,
            'photo'     => $photoPath,
            'status'    => $request->status,
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
        $potentialParents = VillageOfficial::whereIn('level', [1, 2])
            ->where('id', '!=', $villageOfficial->id)
            ->orderBy('level')
            ->orderBy('order_num')
            ->get();
            
        $hasLevel1 = VillageOfficial::whereNull('parent_id')->where('level', 1)->where('id', '!=', $villageOfficial->id)->exists();

        return view('admin.village-officials.edit', compact('villageOfficial', 'potentialParents', 'hasLevel1'));
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
            'order_num' => 'nullable|integer|min:0',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $level = 1;
        if ($request->parent_id) {
            $parent = VillageOfficial::find($request->parent_id);
            $level = $parent ? $parent->level + 1 : 1;
        } else {
            // Mencegah lebih dari 1 Kepala Desa (Level 1) kecuali dirinya sendiri
            if (VillageOfficial::whereNull('parent_id')->where('level', 1)->where('id', '!=', $villageOfficial->id)->exists()) {
                return back()->withInput()->withErrors(['parent_id' => 'Level 1 (Kepala Desa) sudah ada. Silakan pilih atasan untuk perangkat ini.']);
            }
        }

        $photoPath = $villageOfficial->photo;
        if ($request->hasFile('photo')) {
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
