@extends('layouts.app')

@section('page_title', 'Profil Desa')
@section('page_subtitle', 'Kelola informasi sejarah, visi misi, kondisi geografis, dan demografi desa.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($identities as $identity)
    <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
        <div>
            <!-- Header Card -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 
                        @if($identity->key === 'sejarah') bg-amber-50 text-amber-600
                        @elseif($identity->key === 'visi-misi') bg-indigo-50 text-indigo-600
                        @elseif($identity->key === 'geografis') bg-emerald-50 text-emerald-600
                        @else bg-sky-50 text-sky-600
                        @endif">
                        
                        @if($identity->key === 'sejarah')
                            <!-- Icon Sejarah (Book Open) -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        @elseif($identity->key === 'visi-misi')
                            <!-- Icon Visi & Misi (Target) -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        @elseif($identity->key === 'geografis')
                            <!-- Icon Geografis (Map / Globe) -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        @else
                            <!-- Icon Demografi (Users) -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">{{ $identity->title }}</h4>
                        <span class="text-xs text-gray-400">Key: <code class="font-mono text-gray-500 bg-gray-50 px-1 rounded">{{ $identity->key }}</code></span>
                    </div>
                </div>
            </div>

            <!-- Content Snippet -->
            <p class="text-sm text-gray-600 mb-6 leading-relaxed whitespace-pre-line">
                {{ Str::limit($identity->content ?: 'Belum ada konten.', 180, '...') }}
            </p>
        </div>

        <!-- Footer Card -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
            <span class="text-xs text-gray-400">
                Pembaruan: {{ $identity->updated_at ? $identity->updated_at->translatedFormat('d M Y H:i') : 'Belum diisi' }}
            </span>
            <a href="{{ route('admin.village-identities.edit', $identity->id) }}" 
               class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors">
                <span>Edit Konten</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
