@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-lg mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-xl p-10">
                <h1 class="text-3xl font-semibold text-center mb-8">Edit Karyawan</h1>

                <form method="POST" action="{{ route('invites.update', $invite) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $invite->name }}"
                                class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:border-indigo-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ $invite->email }}"
                                class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:border-indigo-500"
                                required>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('invites.index') }}"
                                class="flex-1 text-center py-4 border border-slate-300 rounded-2xl font-medium hover:bg-slate-50">
                                Batal
                            </a>
                            <button type="submit"
                                class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-semibold hover:bg-indigo-700">
                                Simpan Perubahan
                            </button>
                        </div>
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
