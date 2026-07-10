<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VillageIdentity;
use App\Models\VillageOfficial;
use App\Models\VillageStatistic;
use App\Models\RtRw;

class VillageDataController extends Controller
{
    public function profil()
    {
        $identities = VillageIdentity::whereIn('key', [
            'profil-singkat', 
            'sejarah', 
            'geografis', 
            'wilayah-dusun'
        ])->get()->keyBy('key');

        return view('user.village_data.profil', compact('identities'));
    }

    public function sotk()
    {
        // For organizational structure, fetch by levels and order_num
        // Level 1: Kepala, Level 2: Pejabat, Level 3: Staff
        $officials = VillageOfficial::aktif()->ordered()->get();
        
        $kepala = $officials->where('level', 1);
        $pejabat = $officials->where('level', 2);
        $staff = $officials->where('level', 3);

        return view('user.village_data.sotk', compact('kepala', 'pejabat', 'staff'));
    }

    public function visiMisi()
    {
        $visiMisi = VillageIdentity::getByKey('visi-misi');
        
        // Split content if necessary, assuming it contains VISI: and MISI: blocks
        return view('user.village_data.visi_misi', compact('visiMisi'));
    }

    public function monografi()
    {
        $demografi = VillageIdentity::getByKey('demografi');
        $statistics = VillageStatistic::all();
        $rtRws = RtRw::active()->orderBy('rw_number')->orderBy('rt_number')->get();

        return view('user.village_data.monografi', compact('demografi', 'statistics', 'rtRws'));
    }
}
