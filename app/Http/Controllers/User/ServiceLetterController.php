<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ServiceLetter;
use Parsedown;

class ServiceLetterController extends Controller
{
    public function index()
    {
        $letters = ServiceLetter::where('is_active', true)
                                ->orderBy('id', 'asc')
                                ->get();

        $parsedown = new Parsedown();
        foreach ($letters as $letter) {
            $letter->parsed_requirements = $parsedown->text($letter->requirements ?? '');
        }

        return view('user.service_letter', compact('letters'));
    }
}
