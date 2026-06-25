<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil data FAQ dengan pagination
        // Diurutkan berdasarkan kategori, lalu urutan angka (order_num)
        $faqs = Faq::orderBy('category')
                    ->orderBy('order_num', 'asc')
                    ->latest()
                    ->paginate(15);

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kategori default yang bisa dipilih
        $categories = ['Umum', 'Layanan', 'Administrasi', 'Lainnya'];
        return view('admin.faqs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:3000', // max 3000 chars for markdown
            'category' => 'required|string|max:100',
        ], [
            'question.required' => 'Pertanyaan wajib diisi.',
            'answer.required' => 'Jawaban wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
        ]);

        $maxOrder = Faq::where('category', $request->category)->max('order_num');

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'order_num' => $maxOrder !== null ? $maxOrder + 1 : 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'Pertanyaan FAQ berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        // Opsional: Untuk melihat detail jika diperlukan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $categories = ['Umum', 'Layanan', 'Administrasi', 'Lainnya'];
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:3000',
            'category' => 'required|string|max:100',
        ], [
            'question.required' => 'Pertanyaan wajib diisi.',
            'answer.required' => 'Jawaban wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'Pertanyaan FAQ berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }

    /**
     * Reorder FAQs via AJAX.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:faqs,id',
        ]);

        // Ambil ID dari request
        $ids = $request->order;

        // Cari FAQ yang diurutkan ulang, dan ambil order_num aslinya
        $faqs = Faq::whereIn('id', $ids)->get();
        
        // Ekstrak semua order_num saat ini dan urutkan dari terkecil ke terbesar
        $orderNums = $faqs->pluck('order_num')->sort()->values()->toArray();

        // Assign order_num yang sudah diurutkan ke ID sesuai urutan baru dari frontend
        foreach ($ids as $index => $id) {
            if (isset($orderNums[$index])) {
                Faq::where('id', $id)->update(['order_num' => $orderNums[$index]]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
    }
}
