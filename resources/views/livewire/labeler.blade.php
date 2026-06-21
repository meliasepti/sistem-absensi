@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 flex flex-col font-sans select-none" x-data="{
        scale: 1,
        selected: @entangle('selectedLabel'),
        labelConfig: {
            good: { text: 'GOOD', bg: 'bg-emerald-500', shadow: 'shadow-emerald-200' },
            spoof: { text: 'SPOOF', bg: 'bg-red-500', shadow: 'shadow-red-200' },
            abnormal: { text: 'ABNORMAL', bg: 'bg-amber-400', shadow: 'shadow-amber-200' },
        },
        selectLabel(label) {
            this.selected = label;
        },
        saveAndNext() {
            if (this.selected) {
                $wire.saveAndNext();
            }
        },
        skipImage() {
            $wire.skipImage();
        },
        init() {
            window.addEventListener('keydown', (e) => {
                if (document.activeElement.tagName === 'INPUT') return;
                if (e.code === 'Space') {
                    e.preventDefault();
                    this.saveAndNext();
                }
                if (e.code === 'Digit1') this.selectLabel('good');
                if (e.code === 'Digit2') this.selectLabel('spoof');
                if (e.code === 'Digit3') this.selectLabel('abnormal');
                if (e.key === 's' || e.key === 'S') this.skipImage();
            });
        }
    }">

        <header
            class="bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between shadow-sm sticky top-0 z-50">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-amber-500 rounded flex items-center justify-center text-white font-black text-xs">
                        L</div>
                    <span class="font-bold text-slate-800 text-base tracking-tight">Labeler</span>
                </div>

                <div class="relative flex items-center">
                    <input type="date" wire:model.live="filterDate"
                        class="bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold py-1.5 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <span class="font-bold text-slate-800">{{ $totalLabeled }}</span>
                    <span>/</span>
                    <span class="text-slate-400">{{ $totalQueue }}</span>
                    <span
                        class="bg-emerald-50 text-emerald-600 px-1.5 py-0.5 rounded font-bold">{{ $progressPercentage }}%</span>
                    <div class="w-24 bg-slate-200 h-1.5 rounded-full overflow-hidden ml-1">
                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-300"
                            style="width: {{ $progressPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-800 leading-none">{{ auth()->user()->name ?? 'User Labeler' }}
                    </p>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5">
                        {{ auth()->user()->email ?? 'labeler@email.com' }}</p>
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

        <div class="flex-1 flex overflow-hidden">
            @if ($attendance)
                <main
                    class="flex-1 bg-slate-100 p-8 flex flex-col items-center justify-center relative overflow-hidden group">
                    <div
                        class="absolute top-4 left-6 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm flex items-center gap-2 border border-blue-100">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        <span>{{ $attendance->user->name ?? 'Karyawan' }} is here</span>
                    </div>

                    <div class="w-full max-w-xl h-[480px] bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden relative flex items-center justify-center p-2 transition-transform duration-200"
                        :style="`transform: scale(${scale})`" style="will-change: transform;">

                        <img src="{{ Storage::url($attendance->image_path) }}"
                            class="max-w-full max-h-full object-contain rounded-lg" alt="Foto Presensi">

                        <div x-show="selected" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute top-4 left-1/2 -translate-x-1/2 pointer-events-none">
                            <span :class="selected ? labelConfig[selected].bg + ' ' + labelConfig[selected].shadow : ''"
                                class="inline-block text-white font-black text-2xl tracking-widest px-6 py-2.5 rounded-2xl shadow-lg uppercase"
                                x-text="selected ? labelConfig[selected].text : ''">
                            </span>
                        </div>
                    </div>

                    <div
                        class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur shadow-md rounded-full px-4 py-1.5 flex items-center gap-4 border border-slate-200 text-slate-500 text-xs font-medium">
                        <span
                            class="text-[10px] text-slate-400 select-all truncate max-w-[200px] font-mono">{{ basename($attendance->image_path) }}</span>
                        <span class="text-slate-300">|</span>
                        <button @click="scale = Math.max(0.5, scale - 0.2)"
                            class="hover:text-slate-800 text-sm font-bold p-1">−</button>
                        <span class="font-bold text-slate-700 font-mono text-[11px]"
                            x-text="`${Math.round(scale * 100)}%`">100%</span>
                        <button @click="scale = Math.min(3, scale + 0.2)"
                            class="hover:text-slate-800 text-sm font-bold p-1">+</button>
                        <span class="text-slate-300">|</span>
                        <button @click="scale = 1" class="hover:text-slate-800 text-[11px] font-semibold">Reset</button>
                    </div>
                </main>

                <aside
                    class="w-96 bg-white border-l border-slate-200 flex flex-col justify-between p-6 shadow-2xl relative z-10">
                    <div>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition mb-8 group w-fit">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>

                        <p class="text-[10px] font-extrabold text-slate-400 tracking-wider mb-3">SELECT LABEL</p>

                        <div class="space-y-3">
                            <button type="button" @click="selectLabel('good')"
                                class="w-full text-left p-4 rounded-xl border transition-all duration-150 flex items-center justify-between outline-none
                                {{ $selectedLabel === 'good' ? 'border-emerald-500 bg-emerald-50/40 ring-1 ring-emerald-500' : 'border-slate-200 hover:border-slate-300 bg-white' }}">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-6 h-6 rounded-full flex items-center justify-center font-bold text-xs
                                    {{ $selectedLabel === 'good' ? 'bg-emerald-500 text-white shadow-sm' : 'bg-slate-100 text-slate-500' }}">
                                        1</div>
                                    <span
                                        class="font-bold text-sm {{ $selectedLabel === 'good' ? 'text-emerald-900' : 'text-slate-700' }}">Good</span>
                                </div>
                                <div
                                    class="w-4 h-4 rounded-full border flex items-center justify-center {{ $selectedLabel === 'good' ? 'border-emerald-500' : 'border-slate-300' }}">
                                    @if ($selectedLabel === 'good')
                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    @endif
                                </div>
                            </button>

                            <button type="button" @click="selectLabel('spoof')"
                                class="w-full text-left p-4 rounded-xl border transition-all duration-150 flex items-center justify-between outline-none
                                {{ $selectedLabel === 'spoof' ? 'border-red-500 bg-red-50/40 ring-1 ring-red-500' : 'border-slate-200 hover:border-slate-300 bg-white' }}">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-6 h-6 rounded-full flex items-center justify-center font-bold text-xs
                                    {{ $selectedLabel === 'spoof' ? 'bg-red-500 text-white shadow-sm' : 'bg-slate-100 text-slate-500' }}">
                                        2</div>
                                    <span
                                        class="font-bold text-sm {{ $selectedLabel === 'spoof' ? 'text-red-900' : 'text-slate-700' }}">Spoof</span>
                                </div>
                                <div
                                    class="w-4 h-4 rounded-full border flex items-center justify-center {{ $selectedLabel === 'spoof' ? 'border-red-500' : 'border-slate-300' }}">
                                    @if ($selectedLabel === 'spoof')
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    @endif
                                </div>
                            </button>

                            <button type="button" @click="selectLabel('abnormal')"
                                class="w-full text-left p-4 rounded-xl border transition-all duration-150 flex items-center justify-between outline-none
                                {{ $selectedLabel === 'abnormal' ? 'border-amber-500 bg-amber-50/40 ring-1 ring-amber-500' : 'border-slate-200 hover:border-slate-300 bg-white' }}">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-6 h-6 rounded-full flex items-center justify-center font-bold text-xs
                                    {{ $selectedLabel === 'abnormal' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-500' }}">
                                        3</div>
                                    <span
                                        class="font-bold text-sm {{ $selectedLabel === 'abnormal' ? 'text-amber-900' : 'text-slate-700' }}">Abnormal</span>
                                </div>
                                <div
                                    class="w-4 h-4 rounded-full border flex items-center justify-center {{ $selectedLabel === 'abnormal' ? 'border-amber-500' : 'border-slate-300' }}">
                                    @if ($selectedLabel === 'abnormal')
                                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                    @endif
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button type="button" @click="saveAndNext()" :disabled="!selected"
                            :class="selected ? 'bg-slate-800 text-white hover:bg-slate-900 cursor-pointer active:scale-[0.99]' :
                                'bg-slate-200 text-slate-400 cursor-not-allowed'"
                            class="w-full py-3.5 px-4 font-bold rounded-xl text-xs tracking-wider transition-all shadow-sm border border-transparent flex items-center justify-center gap-2">
                            <span>Next Image →</span>
                        </button>

                        <div class="flex items-center justify-between px-1 text-[10px] font-bold text-slate-400">
                            <span class="flex items-center gap-1">Press
                                <kbd
                                    class="bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded shadow-sm text-slate-500 font-mono text-[9px]">space</kbd>
                                to confirm
                            </span>
                            <button type="button" @click="skipImage()"
                                class="hover:text-slate-600 uppercase transition">Skip (S)</button>
                        </div>
                    </div>
                </aside>
            @else
                <main class="flex-1 bg-slate-100 p-8 flex flex-col items-center justify-center">
                    <div class="max-w-sm w-full bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center">
                        <div
                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 border border-slate-100 shadow-inner">
                            🎉</div>
                        <h2 class="text-xl font-bold text-slate-800">Antrean Selesai</h2>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">Semua foto absensi pada tanggal ini telah
                            selesai diperiksa dan dilabeli.</p>
                        <div class="mt-6 border-t border-slate-100 pt-5">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition w-full shadow-sm">
                                Dashboard
                            </a>
                        </div>
                    </div>
                </main>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@2.0.0/dist/tf.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@tensorflow-models/face-landmarks-detection@0.0.1/dist/face-landmarks-detection.min.js">
    </script>
@endpush
