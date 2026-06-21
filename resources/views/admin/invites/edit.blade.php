@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 flex flex-col font-sans select-none">
        <header
            class="bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between shadow-sm sticky top-0 z-50">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-amber-500 rounded flex items-center justify-center text-white font-black text-xs">
                        L</div>
                    <span class="font-bold text-slate-800 text-base tracking-tight">Labeler</span>
                </div>
                <div
                    class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-md">
                    <span>Edit Karyawan</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-800 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-slate-400 hover:text-slate-600 transition p-1 rounded-lg hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <div class="flex-1 flex flex-col items-center justify-center px-4 py-12">
            <div class="w-full max-w-lg">

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 mb-4">
                    <div class="mb-6 pb-4 border-b border-slate-100">
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Edit Data Karyawan</h1>
                        <p class="text-xs text-slate-400 mt-1">Perbarui data profil atau informasi alamat email karyawan
                            yang terdaftar.</p>
                    </div>

                    <form method="POST" action="{{ route('invites.update', $invite) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">Nama
                                    Lengkap</label>
                                <input type="text" name="name" value="{{ $invite->name }}"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-semibold py-2.5 px-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">Alamat
                                    Email</label>
                                <input type="email" name="email" value="{{ $invite->email }}"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-semibold py-2.5 px-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                                    placeholder="contoh@perusahaan.com" required>
                            </div>

                            <div class="pt-4 flex gap-3">
                                <a href="{{ route('invites.index') }}"
                                    class="flex-1 py-3 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs tracking-wider rounded-xl transition shadow-sm">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="flex-1 py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs tracking-wider rounded-xl shadow-sm transition-all active:scale-[0.99] cursor-pointer">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="flex justify-center">
                    <button onclick="window.location='{{ route('invites.index') }}'"
                        class="flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-slate-600 transition group py-2">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali ke Daftar Karyawan</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
