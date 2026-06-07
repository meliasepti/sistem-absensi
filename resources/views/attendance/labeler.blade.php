@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Image Area -->
            <div class="col-lg-7">
                @if ($attendance)
                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                {{ $attendance->user->name }}
                                <small class="text-muted">({{ $attendance->attendance_date }})</small>
                            </h5>
                        </div>
                        <div class="card-body text-center p-3">
                            <img src="{{ Storage::url($attendance->image_path) }}" class="img-fluid rounded"
                                style="max-height: 520px; object-fit: contain;">
                        </div>
                    </div>
                @else
                    <div class="alert alert-success text-center">
                        <h4>Semua foto sudah dilabeli! 🎉</h4>
                    </div>
                @endif
            </div>

            <!-- Label Panel -->
            <div class="col-lg-5">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Pilih Label</h4>

                        @if ($attendance)
                            <button onclick="submitLabel('good')" class="btn btn-success btn-lg w-100 mb-3 py-3 fs-5">
                                1. Good
                            </button>

                            <button onclick="submitLabel('spoof')" class="btn btn-danger btn-lg w-100 mb-3 py-3 fs-5">
                                2. Spoof
                            </button>

                            <button onclick="submitLabel('abnormal')" class="btn btn-warning btn-lg w-100 py-3 fs-5">
                                3. Abnormal
                            </button>

                            <a href="{{ route('labeler') }}" class="btn btn-secondary w-100 mt-4">
                                Next Image →
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitLabel(label) {
            fetch(`/attendance/{{ $attendance->id }}/label`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    label
                })
            }).then(() => {
                window.location.reload();
            });
        }
    </script>
@endsection
