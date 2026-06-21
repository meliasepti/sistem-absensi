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
                    <span>Absensi Kamera</span>
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

        <div class="flex-1 flex flex-col items-center justify-center px-4 py-6 md:px-6 md:py-8">
            <div class="w-full max-w-4xl">

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 md:p-10 mb-6">
                    <div class="mb-6 pb-4 border-b border-slate-100">
                        <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight">Presensi Kehadiran</h1>
                        <p class="text-xs md:text-sm text-slate-400 mt-1">Pastikan pencahayaan cukup dan wajah terlihat
                            jelas di dalam frame kamera.</p>
                    </div>

                    <div class="space-y-6">
                        <div id="cameraSection" class="space-y-4 md:space-y-6">
                            <div
                                class="relative bg-slate-950 rounded-xl md:rounded-2xl overflow-hidden aspect-[4/5] sm:aspect-square md:aspect-video border border-slate-800 flex items-center justify-center shadow-inner">
                                <video id="video" class="w-full h-full object-cover" autoplay playsinline></video>

                                <div
                                    class="absolute inset-4 md:inset-6 border-2 border-dashed border-white/20 rounded-xl pointer-events-none flex items-center justify-center">
                                    <div
                                        class="w-48 h-48 sm:w-64 sm:h-64 md:w-80 md:h-80 rounded-full border-2 border-dashed border-white/40 bg-black/10 backdrop-blur-[1px]">
                                    </div>
                                </div>
                            </div>

                            <button onclick="takePhoto()"
                                class="w-full py-3.5 md:py-4 px-6 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs md:text-sm tracking-wider rounded-xl shadow-md transition-all active:scale-[0.99] cursor-pointer flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>AMBIL FOTO SEKARANG</span>
                            </button>
                        </div>

                        <div id="previewSection" class="hidden space-y-4 md:space-y-6">
                            <div
                                class="bg-slate-950 rounded-xl md:rounded-2xl overflow-hidden aspect-[4/5] sm:aspect-square md:aspect-video border border-slate-800 flex items-center justify-center shadow-inner">
                                <img id="photoPreview" class="w-full h-full object-cover" alt="Preview">
                            </div>

                            <div class="flex gap-3 md:gap-4">
                                <button onclick="retakePhoto()"
                                    class="flex-1 py-3.5 md:py-4 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs md:text-sm tracking-wider rounded-xl transition shadow-sm cursor-pointer">
                                    Ambil Ulang
                                </button>
                                <button onclick="submitPhoto()"
                                    class="flex-1 py-3.5 md:py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs md:text-sm tracking-wider rounded-xl shadow-md transition-all active:scale-[0.99] cursor-pointer">
                                    Kirim Absensi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button onclick="window.location='{{ route('dashboard') }}'"
                        class="flex items-center gap-2 text-xs md:text-sm font-bold text-slate-400 hover:text-slate-600 transition group py-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali ke Dashboard</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        let video = document.getElementById('video');
        let canvas = document.createElement('canvas');
        let photoData = '';

        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "user",
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                }
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                alert("Gagal mengakses kamera: " + err.message);
            });

        function takePhoto() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            photoData = canvas.toDataURL('image/jpeg', 0.85);

            document.getElementById('photoPreview').src = photoData;
            document.getElementById('cameraSection').classList.add('hidden');
            document.getElementById('previewSection').classList.remove('hidden');
        }

        function retakePhoto() {
            document.getElementById('cameraSection').classList.remove('hidden');
            document.getElementById('previewSection').classList.add('hidden');
        }

        function submitPhoto() {
            if (!photoData) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('attendance.store') }}';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            const photoInput = document.createElement('input');
            photoInput.type = 'hidden';
            photoInput.name = 'photo';
            photoInput.value = photoData;
            form.appendChild(photoInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
