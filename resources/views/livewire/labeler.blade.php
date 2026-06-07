@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-800">Labeler Absensi</h1>
                    <p class="text-slate-600">Beri label pada foto absensi</p>
                </div>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-slate-600 hover:text-slate-800">
                    <i class="ri-arrow-left-line"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>

            @if ($attendance)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Foto Section -->
                    <div class="lg:col-span-7">
                        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                            <div class="px-6 py-4 bg-slate-800 text-white flex items-center justify-between">
                                <div>
                                    <p class="font-medium">{{ $attendance->user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $attendance->attendance_date }}</p>
                                </div>
                                <span class="px-4 py-1 bg-yellow-400 text-yellow-900 text-xs font-medium rounded-full">BELUM
                                    DILABELI</span>
                            </div>
                            <div class="p-8 bg-slate-900 flex items-center justify-center min-h-[520px]">
                                <img src="{{ Storage::url($attendance->image_path) }}"
                                    class="max-h-[520px] rounded-2xl shadow-2xl object-contain border border-slate-700"
                                    alt="Foto Absensi">
                            </div>
                        </div>
                    </div>

                    <!-- Label Selection -->
                    <div class="lg:col-span-5">
                        <div class="bg-white rounded-3xl shadow-2xl p-8 h-full flex flex-col">
                            <h3 class="text-2xl font-semibold text-center mb-10">Pilih Label</h3>

                            <div class="space-y-4 flex-1">
                                <button wire:click="label('good')"
                                    class="w-full flex items-center gap-5 p-6 bg-emerald-50 hover:bg-emerald-100 border-2 border-emerald-200 rounded-2xl transition-all group">
                                    <div
                                        class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 transition">
                                        ✅</div>
                                    <div class="text-left">
                                        <p class="font-bold text-xl text-emerald-700">Good</p>
                                        <p class="text-emerald-600">Foto jelas dan normal</p>
                                    </div>
                                </button>

                                <button wire:click="label('spoof')"
                                    class="w-full flex items-center gap-5 p-6 bg-red-50 hover:bg-red-100 border-2 border-red-200 rounded-2xl transition-all group">
                                    <div
                                        class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 transition">
                                        🚫</div>
                                    <div class="text-left">
                                        <p class="font-bold text-xl text-red-700">Spoof</p>
                                        <p class="text-red-600">Foto palsu / manipulasi</p>
                                    </div>
                                </button>

                                <button wire:click="label('abnormal')"
                                    class="w-full flex items-center gap-5 p-6 bg-amber-50 hover:bg-amber-100 border-2 border-amber-200 rounded-2xl transition-all group">
                                    <div
                                        class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 transition">
                                        ⚠️</div>
                                    <div class="text-left">
                                        <p class="font-bold text-xl text-amber-700">Abnormal</p>
                                        <p class="text-amber-600">Foto buram / tidak jelas</p>
                                    </div>
                                </button>
                            </div>

                            <button wire:click="loadNextImage"
                                class="mt-8 w-full py-4 border border-slate-300 hover:bg-slate-50 rounded-2xl font-medium transition">
                                Next Image →
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-2xl p-20 text-center">
                    <div class="text-8xl mb-6">🎉</div>
                    <h2 class="text-3xl font-semibold text-slate-700">Semua Foto Sudah Dilabeli!</h2>
                    <p class="text-slate-500 mt-4 text-lg">Terima kasih telah membantu proses labeling absensi</p>
                    <a href="{{ route('dashboard') }}"
                        class="mt-10 inline-block bg-indigo-600 text-white px-8 py-4 rounded-2xl font-semibold">
                        Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
