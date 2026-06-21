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
                    <span>Daftar Karyawan</span>
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

        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <button onclick="window.location='{{ route('dashboard') }}'"
                        class="flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition mb-2 group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali ke Dashboard</span>
                    </button>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Undangan Karyawan</h1>
                    <p class="text-sm text-slate-500 mt-0.5">Manajemen token, otorisasi, dan pendaftaran akun karyawan baru.
                    </p>
                </div>

                <a href="{{ route('invites.create') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs tracking-wider rounded-xl shadow-sm transition-all active:scale-[0.98]">
                    + Tambah Karyawan Baru
                </a>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                    <h2 class="text-sm font-bold text-slate-800 tracking-tight">Data Undangan Aktif</h2>
                </div>

                <div class="overflow-x-auto">
                    @if ($invites->isEmpty())
                        <div class="text-slate-400 py-16 text-center flex flex-col items-center justify-center gap-2">
                            <div
                                class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-2xl shadow-inner">
                                📭</div>
                            <h3 class="text-sm font-bold text-slate-700 mt-2">Belum ada data undangan</h3>
                            <p class="text-xs text-slate-400 max-w-xs leading-relaxed">Silakan klik tombol tambah di atas
                                untuk membuat tautan verifikasi karyawan baru.</p>
                        </div>
                    @else
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-200">
                                    <th class="py-3 px-6">Nama Pengguna</th>
                                    <th class="py-3 px-6">Alamat Email</th>
                                    <th class="py-3 px-6">Tanggal Kirim</th>
                                    <th class="py-3 px-6 text-center">Aksi Manajemen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($invites as $invite)
                                    <tr class="hover:bg-slate-50/50 transition duration-150">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center font-bold text-xs border border-slate-200 shadow-inner">
                                                    {{ strtoupper(substr($invite->name ?? 'K', 0, 1)) }}
                                                </div>
                                                <p class="text-xs font-bold text-slate-800 leading-tight">
                                                    {{ $invite->name }}</p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-600 font-medium">
                                            {{ $invite->email }}
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-400 font-medium font-mono">
                                            {{ $invite->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center justify-center gap-4">
                                                <a href="{{ route('invites.edit', $invite) }}"
                                                    class="text-slate-400 hover:text-indigo-600 transition p-1 rounded-lg hover:bg-slate-50">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('invites.destroy', $invite) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data undangan karyawan ini?')"
                                                        class="text-slate-400 hover:text-red-600 transition p-1 rounded-lg hover:bg-slate-50 cursor-pointer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
