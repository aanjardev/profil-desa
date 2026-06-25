@extends('layouts.app')

@section('page_title', 'FAQ (Tanya Jawab)')
@section('page_subtitle', 'Kelola daftar pertanyaan yang sering diajukan beserta jawabannya.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-lg font-bold text-gray-900">Daftar Pertanyaan</h2>
    <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah FAQ
    </a>
</div>

@if($faqs->count() > 0)
    <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden" x-data="{ activeAccordion: null }">
        <div class="divide-y divide-gray-100" id="faq-list">
            @foreach($faqs as $faq)
                <div class="faq-item flex flex-col border-l-4 {{ $faq->is_active ? 'border-l-blue-500' : 'border-l-gray-300 bg-gray-50' }} transition-colors" data-id="{{ $faq->id }}">
                    
                    <!-- Accordion Header -->
                    <div class="flex items-center w-full hover:bg-gray-50 transition-colors">
                        
                        <!-- Drag Handle -->
                        <div class="drag-handle p-4 md:pl-6 cursor-move text-gray-400 hover:text-gray-600" title="Geser untuk mengatur urutan" @click.stop>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                            </svg>
                        </div>

                        <!-- Clickable Area for Accordion -->
                        <div @click="activeAccordion === {{ $faq->id }} ? activeAccordion = null : activeAccordion = {{ $faq->id }}"
                             class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between py-4 pr-4 md:pr-6 text-left cursor-pointer gap-4">
                            
                            <div class="flex-1 pr-4">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="px-2 py-0.5 text-[10px] font-bold tracking-wider rounded bg-gray-100 text-gray-600 uppercase">
                                        {{ $faq->category }}
                                    </span>
                                    @if(!$faq->is_active)
                                        <span class="px-2 py-0.5 text-[10px] font-bold tracking-wider rounded bg-red-100 text-red-600 uppercase">
                                            Nonaktif
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-sm md:text-base font-semibold text-gray-900 leading-snug">
                                    {{ $faq->question }}
                                </h3>
                            </div>

                            <!-- Action Buttons & Chevron -->
                            <div class="flex items-center justify-end gap-3 shrink-0">
                                <!-- Tombol Edit & Hapus -->
                                <div class="flex items-center gap-1 bg-white p-1 rounded-lg border border-gray-200 shadow-sm" @click.stop>
                                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="text-blue-500 hover:text-blue-700 p-1.5 rounded hover:bg-blue-50 transition-colors" title="Edit FAQ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <div class="w-px h-4 bg-gray-200"></div>
                                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="m-0 p-0 inline-flex items-center" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1.5 rounded hover:bg-red-50 transition-colors" title="Hapus FAQ">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Chevron -->
                                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-50 text-gray-400 transition-transform duration-300"
                                     :class="activeAccordion === {{ $faq->id }} ? 'rotate-180 bg-blue-50 text-blue-500' : ''">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Content -->
                    <div x-show="activeAccordion === {{ $faq->id }}" 
                         x-collapse 
                         class="px-4 md:px-6 pb-5 pt-1">
                        <div class="pl-4 border-l-2 border-gray-100 text-sm text-gray-600 prose prose-sm max-w-none prose-a:text-blue-600 hover:prose-a:text-blue-500 prose-p:leading-relaxed prose-headings:text-gray-800">
                            {{-- Convert Markdown to HTML --}}
                            {!! Str::markdown($faq->answer) !!}
                        </div>
                    </div>
                    
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $faqs->links() }}
    </div>

@else
    <div class="bg-white rounded-xl border border-gray-100 border-dashed p-12 text-center flex flex-col items-center justify-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-1">Belum ada FAQ</h3>
        <p class="text-sm text-gray-500 mb-4">Mulai berikan informasi bantuan dengan menambahkan pertanyaan pertama Anda.</p>
        <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-colors">
            Tambah FAQ
        </a>
    </div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqList = document.getElementById('faq-list');
        if (faqList) {
            new Sortable(faqList, {
                handle: '.drag-handle', // Drag handle selector within list items
                animation: 150,
                ghostClass: 'bg-blue-50', // Class added to the dragged item
                onEnd: function () {
                    // Gather all IDs in their new order
                    let order = [];
                    faqList.querySelectorAll('.faq-item').forEach(function(item) {
                        order.push(item.getAttribute('data-id'));
                    });

                    // Kirim ke server via AJAX
                    fetch('{{ route('admin.faqs.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Tampilkan notifikasi sukses kecil menggunakan Toast dari SweetAlert2
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui urutan.');
                    });
                }
            });
        }
    });
</script>
@endpush
