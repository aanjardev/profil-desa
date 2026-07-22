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
        $officials = VillageOfficial::aktif()->orderBy('level')->orderBy('order_num')->get();
        return view('user.village_data.sotk', compact('officials'));
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
