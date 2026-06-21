@extends('layouts.app')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="min-h-screen bg-slate-50 flex flex-col font-sans select-none" x-data="{
        showErrorModal: {{ $errors->isNotEmpty() ? 'true' : 'false' }},
        showPassword: false
    }">

        <div class="flex-1 flex flex-col items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-4">
                    <div
                        class="p-8 bg-slate-900 border-b border-slate-800 flex flex-col items-center justify-center text-center">
                        <div
                            class="w-12 h-12 bg-slate-800 border border-slate-700 rounded-xl flex items-center justify-center text-2xl shadow-inner mb-4">
                            🔐
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-tight">Sistem Absensi</h1>
                        <p class="text-xs text-slate-400 mt-1">Masuk ke akun Sistem</p>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">
                                        Alamat Email
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-semibold py-2.5 px-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-400 focus:bg-white transition"
                                        placeholder="name@company.com" required autofocus>
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">
                                        Password
                                    </label>
                                    <div class="relative">
                                        {{-- FIX toggle: gunakan x-ref agar Alpine langsung manipulasi DOM --}}
                                        <input x-ref="passwordInput" type="password" name="password"
                                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-semibold py-2.5 px-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-400 focus:bg-white transition pr-10"
                                            placeholder="••••••••" required>

                                        <button type="button"
                                            @click="
                                            showPassword = !showPassword;
                                            $refs.passwordInput.type = showPassword ? 'text' : 'password'
                                        "
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1 z-10">

                                            {{-- Ikon mata terbuka: tampil saat password tersembunyi --}}
                                            <svg x-cloak x-show="!showPassword" class="w-4 h-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>

                                            {{-- Ikon mata tercoret: tampil saat password terlihat --}}
                                            <svg x-cloak x-show="showPassword" class="w-4 h-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.695 3.515A10.028 10.028 0 0112 3c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.4M9.9 9.9a3 3 0 114.2 4.2m-4.2-4.2l4.2 4.2" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit"
                                        class="w-full py-3 px-4 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs tracking-wider rounded-xl shadow-sm transition-all active:scale-[0.99] cursor-pointer">
                                        MASUK KE SISTEM
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-6 text-xs font-medium text-slate-400 space-y-0.5">
                    <p>Sistem Absensi & Labeler © 2026</p>
                    <p>Dibuat oleh <span class="text-slate-500 font-bold">Septi Amellia</span></p>
                </div>

            </div>
        </div>

        {{-- Modal error --}}
        <div x-cloak x-show="showErrorModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition>
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xl max-w-sm w-full text-center"
                @click.away="showErrorModal = false">
                <div
                    class="w-12 h-12 bg-red-50 border border-red-100 rounded-full flex items-center justify-center text-red-500 mx-auto mb-4 text-xl">
                    ⚠️
                </div>
                <h3 class="text-base font-bold text-slate-800 tracking-tight">Gagal Masuk</h3>
                <div
                    class="text-xs text-slate-500 mt-2 space-y-1.5 bg-slate-50 p-3 rounded-xl border border-slate-100 text-left">
                    @forelse ($errors->all() as $error)
                        <p class="flex items-start gap-1.5">
                            <span class="text-red-500 mt-0.5">•</span>
                            <span>{{ $error }}</span>
                        </p>
                    @empty
                        <p class="text-center text-slate-400">Email atau password salah.</p>
                    @endforelse
                </div>
                <div class="mt-5">
                    <button @click="showErrorModal = false"
                        class="w-full py-2.5 px-4 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs tracking-wider rounded-lg shadow-sm transition-all active:scale-[0.99]">
                        COBA LAGI
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
