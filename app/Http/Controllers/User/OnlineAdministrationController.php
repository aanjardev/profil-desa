<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
Use App\Models\ContactService;
use Illuminate\Http\Request;

class OnlineAdministrationController extends Controller
{
    public function index()
    {
        $serviceInfo = ContactService::where('is_active', true)->first();
        $menus = [
            ['id' => 'detail-pelayanan', 'title' => 'Informasi Pelayanan'],
        ];

        return view('user.online_administration', compact('serviceInfo', 'menus'));
    }
}
