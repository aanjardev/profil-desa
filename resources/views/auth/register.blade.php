@php
    $webSetting = \App\Models\WebSetting::first();
    $villageName = $webSetting ? $webSetting->village_name : 'Profil Desa';
    $faviconUrl = $webSetting ? $webSetting->favicon_url : asset('favicon.ico');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Desa {{ $villageName }}</title>
    <link rel="icon" href="{{ $faviconUrl }}">
    @vite(['resources/css/app.css'])
    <!-- Alpine JS untuk interaktivitas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 font-sans text-slate-800">

    <div class="max-w-md w-full" x-data="registerForm()">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Akun</h1>
            <p class="text-slate-500 text-sm mt-2">Penyelesaian registrasi admin desa</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            
            <!-- Step Indicators -->
            <div class="flex items-center justify-between px-8 py-5 border-b border-slate-100 bg-slate-50/50">
                <div class="flex flex-col text-left">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1" x-text="'Langkah ' + step + ' dari 2'"></span>
                    <span class="text-sm font-semibold text-slate-700" x-text="step === 1 ? 'Verifikasi Email' : 'Detail Akun'"></span>
                </div>
                
                <div class="flex gap-2">
                    <div class="h-2 w-8 rounded-full transition-colors duration-300" :class="step >= 1 ? 'bg-blue-600' : 'bg-slate-200'"></div>
                    <div class="h-2 w-8 rounded-full transition-colors duration-300" :class="step >= 2 ? 'bg-blue-600' : 'bg-slate-200'"></div>
                </div>
            </div>

            <div class="p-8">
                <!-- Error Alert (Global) -->
                <div x-show="errorMessage" x-transition.opacity style="display: none;" class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex gap-3 text-red-700">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="font-medium text-sm" x-text="errorMessage"></span>
                </div>

                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex flex-col gap-1 text-red-700">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span class="font-medium text-sm">{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('register') }}" method="POST" id="mainRegisterForm">
                    @csrf
                    
                    <!-- STEP 1: Email Check -->
                    <div x-show="step === 1" x-transition.in.opacity.duration.400ms>
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email Terdaftar</label>
                            <input type="email" name="email" x-model="email" @keydown.enter.prevent="checkEmail" 
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-sm transition-all" 
                                placeholder="Masukkan email yang diundang" required autofocus>
                        </div>
                        
                        <button type="button" @click="checkEmail" :disabled="isLoading" 
                            class="w-full flex justify-center items-center gap-2 bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-70 shadow-sm shadow-blue-600/20">
                            <span x-show="!isLoading">Lanjutkan</span>
                            <span x-show="isLoading" style="display: none;">Memeriksa...</span>
                            <svg x-show="!isLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk disini</a></p>
                        </div>
                    </div>

                    <!-- STEP 2: Password & Name -->
                    <div x-show="step === 2" style="display: none;" x-transition.in.opacity.duration.400ms>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" x-model="name"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-sm transition-all" 
                                placeholder="Nama sesuai identitas" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-4" x-data="{ showPw: false }">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                            <div class="relative">
                                <input :type="showPw ? 'text' : 'password'" name="password" minlength="8"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-sm pr-12 transition-all" 
                                    placeholder="Minimal 8 karakter" required>
                                <button type="button" @click="showPw = !showPw" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPw" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-8" x-data="{ showPw: false }">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <input :type="showPw ? 'text' : 'password'" name="password_confirmation" minlength="8"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-sm pr-12 transition-all" 
                                    placeholder="Ketik ulang password" required>
                                <button type="button" @click="showPw = !showPw" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPw" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="step = 1; errorMessage = ''" 
                                class="px-5 py-3 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                                Kembali
                            </button>
                            <button type="submit" 
                                class="flex-1 flex justify-center items-center bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 transition-colors shadow-sm shadow-blue-600/20">
                                Daftar Sekarang
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        
    </div>

    <script>
        function registerForm() {
            return {
                step: 1,
                email: '{{ old('email') }}',
                name: '{{ old('name') }}',
                errorMessage: '',
                isLoading: false,

                async checkEmail() {
                    if (!this.email) {
                        this.errorMessage = 'Harap isi alamat email Anda terlebih dahulu.';
                        return;
                    }
                    
                    this.isLoading = true;
                    this.errorMessage = '';
                    
                    try {
                        const response = await fetch('{{ route('register.check-email') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify({ email: this.email })
                        });
                        
                        const data = await response.json();
                        
                        if (response.ok && data.success) {
                            // Pindah ke step 2
                            this.step = 2;
                            // Fokus ke input nama dengan sedikit delay
                            setTimeout(() => {
                                document.querySelector('input[name="name"]').focus();
                            }, 100);
                        } else {
                            this.errorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                        }
                    } catch (error) {
                        this.errorMessage = 'Gagal menghubungi server. Periksa koneksi internet Anda.';
                    } finally {
                        this.isLoading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>
