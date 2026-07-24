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
            ->orderBy('rw_number', 'asc')
            ->orderBy('rt_number', 'asc')
            ->get();

        // Group by RW
        $groupedData = $rtRws->groupBy('rw_number');

        // Total Desa
        $totalDesaMale = $rtRws->sum('total_male');
        $totalDesaFemale = $rtRws->sum('total_female');
        $totalDesaPenduduk = $totalDesaMale + $totalDesaFemale;
        $totalDesaKk = $rtRws->sum('total_kk');

        return view('user.village_data.population', compact(
            'groupedData', 
            'totalDesaMale', 
            'totalDesaFemale', 
            'totalDesaPenduduk', 
            'totalDesaKk'
        ));
    }
}
