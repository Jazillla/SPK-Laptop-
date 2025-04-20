@extends('layout')
@section('title', 'Penentuan Bobot')

@section('content')
<div class="container">
    <h1 class="mb-4">Tentukan Bobot Kriteria</h1>

    @if(array_filter($lastUsedWeights))
    <div class="alert alert-info mb-4">
        <h5><i class="bi bi-info-circle"></i> Bobot Sebelumnya</h5>
        <ul class="mb-0">
            @foreach($kriterias as $kriteria)
                @if($lastUsedWeights[$kriteria->id] > 0)
                <li>
                    <strong>{{ $kriteria->nama }}:</strong>
                    {{ $lastUsedWeights[$kriteria->id] }}
                </li>
                @endif
            @endforeach
        </ul>
        <p class="mb-0 mt-2 text-muted">
            Anda dapat memodifikasi bobot sebelumnya atau menggunakan yang baru.
        </p>
    </div>
    @endif

    <form method="POST" action="{{ route('bobot.store') }}">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-sliders"></i> Setel Bobot Kriteria (1-100)
            </div>
            <div class="card-body">
                @foreach($kriterias as $kriteria)
                <div class="form-group mb-3">
                    <label class="form-label">
                        {{ $kriteria->nama }} ({{ $kriteria->jenis }})
                        @if($lastUsedWeights[$kriteria->id] > 0)
                        <small class="text-muted">
                            Sebelumnya: {{ $lastUsedWeights[$kriteria->id] }}
                        </small>
                        @endif
                    </label>
                    <input type="number"
                           name="bobot[{{ $kriteria->id }}]"
                           class="form-control"
                           min="1"
                           max="100"
                           value="{{ old('bobot.'.$kriteria->id, $lastUsedWeights[$kriteria->id]) }}"
                           required>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Bobot
            </button>
            <a href="{{ route('laptops.create') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection