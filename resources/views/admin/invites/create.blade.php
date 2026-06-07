@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-lg mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-xl p-10">
                <h1 class="text-3xl font-semibold text-center mb-8">Tambahkan Karyawan Baru</h1>

                <form method="POST" action="{{ route('invites.store') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name"
                                class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:border-indigo-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input type="email" name="email"
                                class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:border-indigo-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Password Awal</label>
                            <input type="password" name="password"
                                class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:border-indigo-500"
                                placeholder="Password untuk karyawan baru" required>
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-5 rounded-2xl text-lg font-semibold hover:bg-indigo-700">
                            Tambah Karyawan
                        </button>
                    </div>
                    <div class="text-center mt-6">
                        <a href="{{ route('invites.index') }}" class="text-sm text-slate-600 hover:text-slate-800">
                            Kembali ke Daftar Karyawan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
