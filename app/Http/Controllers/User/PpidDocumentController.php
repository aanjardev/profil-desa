<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PpidDocument;
use Illuminate\Http\Request;

class PpidDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = PpidDocument::where('is_active', true)->orderBy('year', 'desc')->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('register_no', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }
        
        if ($year = $request->input('year')) {
            $query->where('year', $year);
        }

        $documents = $query->paginate(10)->withQueryString();
        
        // Filter options
        $categories = PpidDocument::where('is_active', true)
            ->whereNotNull('category')->where('category', '!=', '')
            ->select('category')->distinct()->pluck('category');
            
        $years = PpidDocument::where('is_active', true)
            ->whereNotNull('year')
            ->select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('user.ppid.index', compact('documents', 'categories', 'years'));
    }
}
