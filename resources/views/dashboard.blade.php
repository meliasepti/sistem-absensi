@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-8 flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-semibold text-slate-800">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
                    <p class="text-slate-600 mt-2">Ringkasan sistem absensi hari ini</p>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-3 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 rounded-2xl text-slate-600 hover:text-red-600 transition-all font-medium">
                        <i class="ri-logout-box-r-line text-xl"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>

            @if (auth()->user()->is_admin)
                <!-- === DASHBOARD ADMIN === -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-white rounded-3xl p-8 shadow">
                        <i class="ri-calendar-line text-5xl text-blue-500 mb-4"></i>
                        <h3 class="text-5xl font-bold text-slate-800">{{ $todayAttendance ?? 0 }}</h3>
                        <p class="text-slate-500 mt-1">Absen Hari Ini</p>
                    </div>
                    <div class="bg-white rounded-3xl p-8 shadow">
                        <i class="ri-bar-chart-line text-5xl text-emerald-500 mb-4"></i>
                        <h3 class="text-5xl font-bold text-slate-800">{{ $totalAttendance ?? 0 }}</h3>
                        <p class="text-slate-500 mt-1">Total Absensi</p>
                    </div>
                    <div class="bg-white rounded-3xl p-8 shadow">
                        <i class="ri-price-tag-3-line text-5xl text-amber-500 mb-4"></i>
                        <h3 class="text-5xl font-bold text-slate-800">{{ $unlabeledCount ?? 0 }}</h3>
                        <p class="text-slate-500 mt-1">Belum Dilabeli</p>
                        @if (($unlabeledCount ?? 0) > 0)
                            <a href="{{ route('labeler') }}"
                                class="mt-4 inline-block text-sm bg-amber-100 text-amber-700 px-5 py-2.5 rounded-2xl hover:bg-amber-200">
                                Label Sekarang →
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <!-- === DASHBOARD USER === -->
                <div class="bg-white rounded-3xl shadow p-10 text-center mb-10">
                    @if ($alreadyAbsen ?? false)
                        <div class="text-6xl mb-6 text-emerald-500">✅</div>
                        <h2 class="text-2xl font-semibold text-emerald-600">Anda sudah absen hari ini</h2>
                        <p class="text-slate-500 mt-2">Terima kasih telah hadir</p>
                    @else
                        <div class="text-6xl mb-6">📸</div>
                        <h2 class="text-2xl font-semibold text-slate-800">Absen Sekarang</h2>
                        <p class="text-slate-500 mt-2">Ambil foto wajah Anda untuk absensi hari ini</p>
                        <a href="{{ route('attendance.create') }}"
                            class="mt-6 inline-block bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-10 py-4 rounded-2xl text-lg font-semibold hover:shadow-xl transition">
                            📸 Mulai Absensi
                        </a>
                    @endif
                </div>
            @endif

            @if (auth()->user()->is_admin)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    <a href="{{ route('invites.index') }}"
                        class="group bg-white hover:bg-indigo-50 border-2 border-indigo-100 rounded-3xl p-8 transition-all">
                        <i class="ri-user-add-line text-6xl mb-6 text-indigo-500"></i>
                        <h3 class="text-2xl font-semibold text-slate-800 group-hover:text-indigo-600">Undang Karyawan</h3>
                        <p class="text-slate-500 mt-3">Undang anggota baru</p>
                    </a>

                    <a href="{{ route('labeler') }}"
                        class="group bg-white hover:bg-violet-50 border-2 border-violet-100 rounded-3xl p-8 transition-all">
                        <i class="ri-price-tag-3-line text-6xl mb-6 text-violet-500"></i>
                        <h3 class="text-2xl font-semibold text-slate-800 group-hover:text-violet-600">Buka Labeler</h3>
                        <p class="text-slate-500 mt-3">Label foto yang belum ditandai</p>
                    </a>
                </div>
            @endif

            <!-- Recent Activity -->
            <div class="bg-white rounded-3xl shadow p-8">
                <h3 class="text-xl font-semibold mb-6">Aktivitas Terbaru</h3>
                <div class="space-y-5">
                    @forelse($recentAttendances as $att)
                        <div class="flex items-center gap-4 border-b pb-5 last:border-none">
                            <img src="{{ Storage::url($att->image_path) }}" class="w-14 h-14 object-cover rounded-2xl"
                                alt="">
                            <div class="flex-1">
                                <p class="font-medium">{{ $att->user->name }}</p>
                                <p class="text-sm text-slate-500">{{ $att->attendance_date->format('Y-m-d') }}
                                    {{ $att->created_at->format('H:i') }}</p>
                            </div>
                            <div>
                                @if ($att->label)
                                    <span
                                        class="px-5 py-2 rounded-full text-sm font-medium
                                {{ $att->label == 'good'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : ($att->label == 'spoof'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-amber-100 text-amber-700') }}">
                                        {{ ucfirst($att->label) }}
                                    </span>
                                @else
                                    <span
                                        class="px-5 py-2 bg-slate-100 text-slate-600 text-sm font-medium rounded-full">Belum
                                        Label</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 py-12 text-center">Belum ada data absensi</p>
                    @endempty
            </div>
        </div>

    </div>
</div>
@endsection
