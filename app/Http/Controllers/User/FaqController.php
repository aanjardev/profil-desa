<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Parsedown;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_active', true)
                    ->orderBy('category')
                    ->get();

        $parsedown = new Parsedown();

        foreach ($faqs as $faq) {
            $faq->parsed_answer = $parsedown->text($faq->answer);
        }
    
        $groupedFaqs = $faqs->groupBy('category');

        return view('user.faq', compact('groupedFaqs'));
    }
}
