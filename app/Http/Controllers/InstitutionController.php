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

        // Hanya kategori yang benar-benar punya lembaga aktif yang akan ditampilkan
        $institutions = Institution::query()->active()->with('members')
            ->orderBy('type')->orderBy('name')->get()->groupBy('type');

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

        // Lembaga lain di kategori yang sama, buat pengisi sidebar & bantu eksplorasi
        $relatedInstitutions = Institution::query()
            ->active()
            ->ofType($institution->type)
            ->where('id', '!=', $institution->id)
            ->orderBy('name')
            ->limit(5)
            ->get();

        return view('user.institution-show', compact('institution', 'typeLabels', 'typeColors', 'relatedInstitutions'));
    }
}