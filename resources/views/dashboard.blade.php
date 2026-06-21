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
                    <span>Dashboard</span>
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
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang, {{ auth()->user()->name }}
                        👋</h1>
                    <p class="text-sm text-slate-500 mt-0.5">Ringkasan sistem manajemen verifikasi dan aktivitas absensi
                        hari ini.</p>
                </div>
                @if (auth()->user()->is_admin)
                    <div class="flex items-center gap-3">
                        <a href="{{ route('invites.index') }}"
                            class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs tracking-wider rounded-xl shadow-sm transition-all active:scale-[0.98]">
                            + Invite Karyawan
                        </a>
                        <a href="{{ route('labeler') }}"
                            class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs tracking-wider rounded-xl shadow-sm transition-all active:scale-[0.98]">
                            Buka Labeler Kerja →
                        </a>
                    </div>
                @endif
            </div>

            @if (auth()->user()->is_admin)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div
                        class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Absensi Hari Ini</p>
                            <h3 class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">{{ $todayAttendance }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Total pengajuan masuk</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center text-blue-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Absensi</p>
                            <h3 class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">{{ $totalAttendance }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Keseluruhan di sistem</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-indigo-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                    </div>

                    <div
                        class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Belum Dilabeli</p>
                            <h3 class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">{{ $unlabeledCount }}</h3>
                            <p class="text-xs text-slate-400 mt-1">Menunggu konfirmasi verifikasi</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-amber-50 border border-amber-100 rounded-xl flex items-center justify-center text-amber-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Status Kehadiran Hari Ini</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Ambil foto kamera atau unggah berkas untuk melakukan
                            absensi harian.</p>
                    </div>
                    @if ($alreadyAbsen)
                        <span
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sudah Absen Hari Ini
                        </span>
                    @else
                        <a href="{{ route('attendance.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs tracking-wider rounded-xl shadow-sm transition-all active:scale-[0.98]">
                            Mulai Absensi Masuk
                        </a>
                    @endif
                </div>
            @endif

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                    <h2 class="text-sm font-bold text-slate-800 tracking-tight">Aktivitas Riwayat Absensi Terbaru</h2>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menampilkan 5 Data
                        Terakhir</span>
                </div>

                <div class="divide-y divide-slate-100 overflow-x-auto">
                    @empty($recentAttendances->count())
                        <div class="text-slate-400 py-12 text-center flex flex-col items-center justify-center gap-2">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4V8m0 0v8m0-8H8" />
                            </svg>
                            <p class="text-xs font-medium">Belum ada riwayat data absensi terekam</p>
                        </div>
                    @else
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-200">
                                    <th class="py-3 px-6">Nama Pengguna</th>
                                    <th class="py-3 px-6">Tanggal Pengajuan</th>
                                    <th class="py-3 px-6">Waktu Masuk</th>
                                    <th class="py-3 px-6 text-right">Status Konfirmasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($recentAttendances as $att)
                                    <tr class="hover:bg-slate-50/50 transition duration-150">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 bg-slate-100 text-slate-700 rounded-full flex items-center justify-center font-bold text-xs border border-slate-200 shadow-inner">
                                                    {{ strtoupper(substr($att->user->name ?? 'K', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-800 leading-tight">
                                                        {{ $att->user->name }}</p>
                                                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">
                                                        {{ $att->user->email ?? 'user@email.com' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-600 font-semibold font-mono">
                                            {{ is_string($att->attendance_date) ? $att->attendance_date : $att->attendance_date->format('Y-m-d') }}
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-400 font-medium font-mono">
                                            {{ $att->created_at->format('H:i:s') }}
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            @if ($att->label)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider shadow-inner border {{ $att->label == 'good' ? 'bg-emerald-50 border-emerald-100 text-emerald-700' : ($att->label == 'spoof' ? 'bg-red-50 border-red-100 text-red-700' : 'bg-amber-50 border-amber-100 text-amber-700') }}">
                                                    {{ $att->label }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 border border-slate-200 text-slate-500">
                                                    Belum Label
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endempty
                </div>
            </div>
        </div>
    </div>
@endsection
