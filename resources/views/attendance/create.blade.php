@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-2xl mx-auto px-6">

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-10 text-center">
                    <div
                        class="mx-auto w-20 h-20 bg-white/20 backdrop-blur rounded-3xl flex items-center justify-center text-5xl mb-4">
                        📸
                    </div>
                    <h1 class="text-3xl font-semibold text-white">Absen Hari Ini</h1>
                    <p class="text-indigo-100 mt-2">Ambil foto wajah Anda</p>
                </div>

                <div class="p-8">
                    <!-- Live Camera -->
                    <div id="cameraSection">
                        <video id="video" class="w-full rounded-2xl shadow-inner bg-black aspect-video" autoplay
                            playsinline></video>

                        <button onclick="takePhoto()"
                            class="w-full mt-6 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-semibold py-5 rounded-2xl text-lg shadow-lg hover:shadow-xl transition-all active:scale-95">
                            📸 AMBIL FOTO
                        </button>
                    </div>

                    <!-- Preview Section -->
                    <div id="previewSection" class="hidden">
                        <p class="text-center text-sm text-slate-500 mb-3">Preview Foto</p>
                        <img id="photoPreview" class="w-full rounded-2xl shadow-inner" alt="Preview">

                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <button onclick="retakePhoto()"
                                class="py-5 border border-slate-300 text-slate-700 font-semibold rounded-2xl hover:bg-slate-50 transition">
                                📷 Ambil Ulang
                            </button>
                            <button onclick="submitPhoto()"
                                class="py-5 bg-emerald-600 text-white font-semibold rounded-2xl hover:bg-emerald-700 transition">
                                ✅ KIRIM ABSENSI
                            </button>
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-slate-700">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let video = document.getElementById('video');
        let canvas = document.createElement('canvas');
        let photoData = '';

        // Start Camera
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "user"
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
