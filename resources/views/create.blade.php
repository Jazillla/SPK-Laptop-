@extends('layout')
@section('title', 'Input Spesifikasi Laptop')
@section('content')
<div class="container">
  <!--   <h1 class="mb-4">Input Spesifikasi Laptop</h1>

    <div class="alert alert-info mb-4">
        <strong>Bobot Kriteria yang Digunakan:</strong>
        <ul class="mb-0">
            @foreach($kriterias as $kriteria)
                <li>{{ $kriteria->nama }}: {{ session('bobot_kriteria')[$kriteria->id] ?? 0 }}</li>
            @endforeach
        </ul> -->
        <div class="alert alert-primary mb-4">
    <h5><i class="bi bi-lightbulb"></i> Bobot Kriteria yang Digunakan</h5>
    <div class="row">
        @foreach($kriterias as $kriteria)
        <div class="col-md-3 mb-2">
            <div class="card card-criteria">
                <div class="card-body p-3">
                    <h6 class="card-title mb-1">{{ $kriteria->nama }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-{{ $kriteria->jenis == 'benefit' ? 'success' : 'warning' }}">
                            {{ $kriteria->jenis }}
                        </span>
                        <span class="fw-bold">{{ $lastUsedWeights[$kriteria->id] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-2">
        <a href="{{ route('bobot.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil"></i> Ubah Bobot
        </a>
    </div>
</div>
    </div>

    <!-- Tambahkan di bagian atas form -->
    <form method="POST" action="{{ route('laptops.store') }}">
        @csrf

        <div class="form-group mb-3">
            <label class="form-label">Nama Laptop</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="card mb-3">
            <div class="card-header">Spesifikasi Teknis</div>
            <div class="card-body">
                @foreach($kriterias as $kriteria)
                <div class="form-group mb-3">
                    <label class="form-label">{{ $kriteria->nama }}</label>
                    <select name="specs[{{ $kriteria->id }}]" class="form-control" required>
                        <option value="">Pilih {{ $kriteria->nama }}</option>
                        @foreach($kriteria->options as $option => $nilai)
                        <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan dan Lihat Ranking</button>
        <a href="{{ route('bobot.create') }}" class="btn btn-secondary">
            Kembali ke Edit Bobot
        </a>
    </form>


</div>
@endsection