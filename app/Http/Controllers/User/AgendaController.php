<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query()->where('is_active', true)->orderBy('start_date', 'asc');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Archive Filter (Month/Year based on start_date)
        if ($month = $request->input('month')) {
            $query->whereMonth('start_date', $month);
        }
        if ($year = $request->input('year')) {
            $query->whereYear('start_date', $year);
        }

        $agendas = $query->paginate(8)->withQueryString();

        // Sidebar Data
        $categories = Agenda::where('is_active', true)
            ->whereNotNull('category')->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')->get();

        $upcomingAgendas = Agenda::where('is_active', true)
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')->take(4)->get();
        
        $archives = Agenda::where('is_active', true)
            ->selectRaw('YEAR(start_date) year, MONTH(start_date) month, count(*) count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($archive) {
                $archive->month_name = Carbon::create()->month((int)$archive->month)->translatedFormat('F');
                return $archive;
            });

        return view('user.agenda.index', compact('agendas', 'categories', 'upcomingAgendas', 'archives'));
    }
}
