@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 text-slate-600 hover:text-slate-800 transition">
                    <i class="ri-arrow-left-line text-xl"></i>
                    <span class="font-medium">Kembali</span>
                </a>
                <h1 class="text-3xl font-semibold">Daftar Karyawan</h1>

                <a href="{{ route('invites.create') }}"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-2xl hover:bg-indigo-700 transition flex items-center gap-2">
                    <i class="ri-user-add-line"></i>
                    Tambah Karyawan Baru
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow overflow-hidden">
                @if ($invites->isEmpty())
                    <div class="py-20 text-center">
                        <div class="text-6xl mb-4">📭</div>
                        <h3 class="text-xl font-medium text-slate-600">Belum ada data undangan</h3>
                        <p class="text-slate-500 mt-2">Silakan tambahkan karyawan baru</p>
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="border-b bg-slate-50">
                                <th class="px-8 py-5 text-left">Nama</th>
                                <th class="px-8 py-5 text-left">Email</th>
                                <th class="px-8 py-5 text-left">Tanggal Kirim</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invites as $invite)
                                <tr class="border-b hover:bg-slate-50">
                                    <td class="px-8 py-5 font-medium">{{ $invite->name }}</td>
                                    <td class="px-8 py-5">{{ $invite->email }}</td>
                                    <td class="px-8 py-5 text-slate-500">{{ $invite->created_at->format('d M Y H:i') }}</td>

                                    <td class="px-8 py-5 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('invites.edit', $invite) }}"
                                                class="text-indigo-600 hover:text-indigo-700">
                                                <i class="ri-edit-line text-xl"></i>
                                            </a>

                                            <form action="{{ route('invites.destroy', $invite) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Hapus karyawan ini?')"
                                                    class="text-red-600 hover:text-red-700">
                                                    <i class="ri-delete-bin-line text-xl"></i>
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
@endsection
