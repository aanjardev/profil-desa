<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RtRw;
use Illuminate\Http\Request;

class PopulationController extends Controller
{
    public function index()
    {
        $rtRws = RtRw::active()
            ->orderBy('area_name', 'asc')
            ->orderBy('rw_number', 'asc')
            ->orderBy('rt_number', 'asc')
            ->get();

        // Group by Dusun (area_name), if null use 'Tanpa Dusun'
        $groupedData = $rtRws->groupBy(function($item) {
            return $item->area_name ?: 'Lain-lain / Tanpa Dusun';
        })->map(function ($dusunItems) {
            // Inside each dusun, group by RW
            return $dusunItems->groupBy('rw_number');
        });

        // Total Desa
        $totalDesaMale = $rtRws->sum('total_male');
        $totalDesaFemale = $rtRws->sum('total_female');
        $totalDesaPenduduk = $totalDesaMale + $totalDesaFemale;
        $totalDesaKk = $rtRws->sum('total_kk');
        
        $hasHeadName = $rtRws->whereNotNull('head_name')->filter(function($item) {
            return trim($item->head_name) !== '';
        })->count() > 0;

        return view('user.village_data.population', compact(
            'groupedData', 
            'totalDesaMale', 
            'totalDesaFemale', 
            'totalDesaPenduduk', 
            'totalDesaKk',
            'hasHeadName'
        ));
    }
}
