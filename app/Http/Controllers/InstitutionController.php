<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\InstitutionController as AdminInstitutionController;
use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Halaman daftar lembaga desa (publik).
     */
    public function index(Request $request)
    {
        $typeLabels = AdminInstitutionController::TYPE_LABELS;
        $typeColors = AdminInstitutionController::TYPE_COLORS;

        $all = Institution::query()->active()->with('members')
            ->orderBy('type')->orderBy('name')->get()->groupBy('type');

        // Pastikan semua kategori tetap muncul di nav walau belum ada datanya
        $institutions = collect(array_keys($typeLabels))
            ->mapWithKeys(fn ($type) => [$type => $all->get($type, collect())]);

        return view('user.team', compact('institutions', 'typeLabels', 'typeColors'));
    }

    /**
     * Halaman detail satu lembaga desa (publik).
     */
    public function show(Institution $institution)
    {
        // Lembaga yang tidak aktif tidak boleh diakses publik
        if (!$institution->is_active) {
            abort(404);
        }

        $institution->load('members');
        $typeLabels = AdminInstitutionController::TYPE_LABELS;
        $typeColors = AdminInstitutionController::TYPE_COLORS;

        return view('user.instutions-show', compact('institution', 'typeLabels', 'typeColors'));
    }
}