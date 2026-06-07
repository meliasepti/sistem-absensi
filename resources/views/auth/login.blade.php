@extends('layouts.app')

@section('content')
    <div class="min-h-screen  flex items-center justify-center p-6">
        <div class="max-w-md w-full">
            <div class="bg-white/95 backdrop-blur-2xl rounded-3xl shadow-2xl overflow-hidden border border-white/30">

                <!-- Header -->
                <div class="bg-gradient-to-r from-violet-700 to-indigo-700 px-10 py-12 text-center">
                    <div
                        class="mx-auto w-20 h-20 bg-white/20 backdrop-blur-xl rounded-3xl flex items-center justify-center text-5xl mb-5 shadow-inner border border-white/30">
                        🔐
                    </div>
                    <h1 class="text-3xl font-semibold text-white tracking-tight">Sistem Absensi</h1>
                    <p class="text-indigo-100 mt-2">Masuk ke Akun Anda</p>
                </div>

                <!-- Form -->
                <div class="p-8 md:p-10">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 outline-none transition-all"
                                    required autofocus>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                                <div class="relative">
                                    <input id="password" type="password" name="password"
                                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-2xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 outline-none transition-all pr-12"
                                        required>

                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                        <i class="ri-eye-line text-2xl"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white font-semibold py-4 rounded-2xl text-lg shadow-lg transition-all duration-300 active:scale-[0.98]">
                                MASUK
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class=" text-sm">
                    Sistem Absensi & Labeler © 2026
                </p>
                <p class="text-blue-600 text-sm mt-1">
                    Dibuat dengan ❤️ oleh <span class="font-medium">Septi Amellia</span>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.querySelector('.ri-eye-line, .ri-eye-off-line');

            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            } else {
                pwd.type = 'password';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            }
        }
    </script>
@endsection
