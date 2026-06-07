@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Daftar Absensi</h2>

        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <select name="label" class="form-select">
                            <option value="">Semua Label</option>
                            <option value="good" {{ request('label') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="spoof" {{ request('label') == 'spoof' ? 'selected' : '' }}>Spoof</option>
                            <option value="abnormal" {{ request('label') == 'abnormal' ? 'selected' : '' }}>Abnormal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5>Total User</h5>
                        <h3>{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5>Absen Hari Ini</h5>
                        <h3>{{ $todayCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Foto</th>
                    <th>Label</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $att)
                    <tr>
                        <td>{{ $att->attendance_date }}</td>
                        <td>{{ $att->user->name }}</td>
                        <td>
                            <img src="{{ Storage::url($att->image_path) }}" width="80" class="rounded">
                        </td>
                        <td>
                            @if ($att->label)
                                <span
                                    class="badge bg-{{ $att->label == 'good' ? 'success' : ($att->label == 'spoof' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($att->label) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('labeler') }}" class="btn btn-sm btn-primary">Label</a>
                            @if (auth()->user()->is_admin)
                                <form action="{{ route('attendance.destroy', $att) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $attendances->links() }}
    </div>
@endsection
