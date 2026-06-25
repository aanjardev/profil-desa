@extends('layouts.app')

@section('page_title', 'Edit FAQ')
@section('page_subtitle', 'Perbarui detail pertanyaan atau jawaban FAQ.')

@section('content')

<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-bold text-red-800 mb-1">Terdapat kesalahan:</h4>
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Baris 1: Kategori & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="category" id="category" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm text-gray-700" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $faq->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end pb-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-bold text-gray-700">Tampilkan FAQ (Aktif)</span>
                        </label>
                    </div>
                </div>

                <!-- Soal -->
                <div>
                    <label for="question" class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan (Soal) <span class="text-red-500">*</span></label>
                    <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" placeholder="Contoh: Apa syarat membuat KTP baru?" 
                           required maxlength="500"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm font-semibold">
                </div>

                <!-- Jawaban -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label for="answer" class="block text-sm font-bold text-gray-700">Jawaban <span class="text-red-500">*</span></label>
                        <span class="text-[11px] font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">Mendukung format Markdown</span>
                    </div>
                    
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Textarea Area -->
                        <div class="flex-1">
                            <textarea name="answer" id="answer" rows="10" placeholder="Tuliskan jawaban lengkap di sini..."
                                      required maxlength="3000"
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm resize-y leading-relaxed font-mono">{{ old('answer', $faq->answer) }}</textarea>
                        </div>
                        
                        <!-- Markdown Guide Panel -->
                        <div class="w-full lg:w-64 shrink-0">
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                <h5 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-3">Panduan Markdown</h5>
                                <ul class="space-y-3 text-xs text-gray-600">
                                    <li>
                                        <span class="font-mono bg-white px-1 py-0.5 border border-gray-200 rounded">**Tebal**</span><br>
                                        Menjadi: <span class="font-bold text-gray-900">Tebal</span>
                                    </li>
                                    <li>
                                        <span class="font-mono bg-white px-1 py-0.5 border border-gray-200 rounded">_Miring_</span><br>
                                        Menjadi: <span class="italic text-gray-900">Miring</span>
                                    </li>
                                    <li>
                                        <span class="font-mono bg-white px-1 py-0.5 border border-gray-200 rounded">- Item List</span><br>
                                        Menjadi: Titik-titik (Bullet list)
                                    </li>
                                    <li>
                                        <span class="font-mono bg-white px-1 py-0.5 border border-gray-200 rounded">[Teks](Link URL)</span><br>
                                        Menjadi: Tautan yang dapat diklik
                                    </li>
                                </ul>
                                <a href="https://www.markdownguide.org/cheat-sheet/" target="_blank" class="mt-4 inline-block text-[11px] text-blue-500 hover:text-blue-700 font-medium">Lihat Panduan Lengkap &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
