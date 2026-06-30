<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Agenda::where('start_date', '>=', now()->format('Y-m-d'));

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->sort === 'oldest') {
            $query->orderBy('start_date', 'desc'); // Terlama (paling akhir)
        } else {
            $query->orderBy('start_date', 'asc'); // Tercepat (paling dekat dengan hari ini)
        }

        $agendas = $query->paginate(15)->withQueryString();
        
        return view('admin.agendas.index', compact('agendas'));
    }

    public function archives(Request $request)
    {
        $query = Agenda::where('start_date', '<', now()->format('Y-m-d'));

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->sort === 'oldest') {
            $query->orderBy('start_date', 'asc');
        } else {
            $query->orderBy('start_date', 'desc');
        }

        $agendas = $query->paginate(15)->withQueryString();
        
        return view('admin.agendas.archives', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.agendas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|url',
            'audience' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['is_active'] = $request->has('is_active');
        $data['audience'] = $request->audience ?? 'Umum';

        Agenda::create($data);

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda)
    {
        return view('admin.agendas.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i', // removed after:start_time to avoid complex validation logic
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|url',
            'audience' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        $data = $request->all();
        if ($request->title !== $agenda->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }
        $data['is_active'] = $request->has('is_active');
        $data['audience'] = $request->audience ?? 'Umum';

        $agenda->update($data);

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
