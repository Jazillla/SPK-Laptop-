@extends('layout')

@section('title', 'Riwayat Bobot Kriteria')

@section('content')
<div class="container">
    <h1 class="mb-4"><i class="bi bi-clock-history"></i> Riwayat Bobot Kriteria</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-sliders"></i> Bobot Terakhir Digunakan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th>Jenis</th>
                            <th>Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriterias as $kriteria)
                        <tr>
                            <td>{{ $kriteria->nama }}</td>
                            <td>
                                <span class="badge bg-{{ $kriteria->jenis == 'benefit' ? 'success' : 'warning' }}">
                                    {{ $kriteria->jenis }}
                                </span>
                            </td>
                            <td>{{ $kriteria->bobot_user }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <i class="bi bi-laptop"></i> 5 Input Terakhir
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Laptop</th>
                            <th>Total Bobot</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laptops as $laptop)
                        <tr>
                            <td>{{ $laptop->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $laptop->nama }}</td>
                            <td>{{ array_sum($laptop->bobot_used) }}</td>
                            <td>
                                <a href="{{ route('laptops.show', $laptop->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('bobot.create') }}" class="btn btn-primary">
            <i class="bi bi-sliders"></i> Setel Bobot Baru
        </a>
        <a href="{{ route('laptops.ranking') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Ranking
        </a>
    </div>
</div>
@endsection