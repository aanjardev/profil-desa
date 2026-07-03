{{-- Card partial untuk satu perangkat desa --}}
<div data-id="{{ $official->id }}"
     class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
    
    {{-- Drag handle bar --}}
    <div title="Tahan dan geser untuk mengatur urutan posisi perangkat di level yang sama" class="drag-handle select-none flex items-center justify-center h-7 bg-gray-50 border-b border-gray-100 text-gray-300 hover:text-gray-400 hover:bg-gray-100 transition-colors gap-1 cursor-grab active:cursor-grabbing">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <circle cx="9" cy="7" r="1.5"/><circle cx="15" cy="7" r="1.5"/>
            <circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/>
            <circle cx="9" cy="17" r="1.5"/><circle cx="15" cy="17" r="1.5"/>
        </svg>
        <span class="text-[10px] font-semibold uppercase tracking-widest">Drag</span>
    </div>

    {{-- Photo --}}
    <div class="relative w-full aspect-square bg-gray-100 overflow-hidden">
        @if($official->photo)
            <img src="{{ asset('storage/' . $official->photo) }}"
                 alt="{{ $official->name }}"
                 class="w-full h-full object-cover object-top">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        @endif

        {{-- Status badge --}}
        @if($official->status === 'aktif')
            <span class="absolute top-2 right-2 flex items-center gap-1 px-2 py-0.5 bg-emerald-500/90 backdrop-blur-sm text-white text-[10px] font-bold rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                Aktif
            </span>
        @else
            <span class="absolute top-2 right-2 flex items-center gap-1 px-2 py-0.5 bg-gray-500/80 backdrop-blur-sm text-white text-[10px] font-bold rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-white/70"></span>
                Nonaktif
            </span>
        @endif

        {{-- Parent badge --}}
        @if($official->parent)
            <div class="absolute bottom-2 left-2 right-2">
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-black/50 backdrop-blur-sm text-white text-[10px] font-medium rounded-md max-w-full truncate">
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    {{ $official->parent->position }}
                </span>
            </div>
        @elseif($official->level > 1)
            <div class="absolute bottom-2 left-2 right-2">
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-500/80 backdrop-blur-sm text-white text-[10px] font-medium rounded-md max-w-full truncate" title="Atasannya telah dihapus">
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Tanpa Atasan
                </span>
            </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-4 flex-1 flex flex-col">
        <h4 class="font-bold text-gray-900 text-sm leading-tight line-clamp-2">{{ $official->name }}</h4>
        <p class="text-xs font-semibold text-blue-600 mt-1 line-clamp-1">{{ $official->position }}</p>
        @if($official->nip)
            <p class="text-[11px] text-gray-400 mt-1 font-mono">NIP: {{ $official->nip }}</p>
        @endif

        {{-- Actions --}}
        <div class="flex items-center gap-2 mt-auto pt-3 border-t border-gray-50">
            <a href="{{ route('admin.village-officials.edit', $official->id) }}"
               class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
            <form action="{{ route('admin.village-officials.destroy', $official->id) }}" method="POST"
                  class="inline-flex" onsubmit="return confirm('Hapus perangkat {{ addslashes($official->name) }}? Data anak (level bawah) tidak ikut terhapus.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>
