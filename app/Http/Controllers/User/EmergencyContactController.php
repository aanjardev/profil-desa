<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = EmergencyContact::where('is_active', true)
                                    ->orderBy('order_num')
                                    ->orderBy('name')
                                    ->get();

        return view('user.emergency_contacts', compact('contacts'));
    }
}