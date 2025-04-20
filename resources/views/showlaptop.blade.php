@extends('layout')

@section('title', 'Detail Laptop')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="bi bi-laptop"></i> Detail Laptop</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('laptops.ranking') }}">Ranking</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-info-circle"></i> Informasi Utama
            </div>
            <div class="card-body">
                <h3>{{ $laptop->nama }}</h3>
                <p class="text-muted">Score: {{ number_format($laptop->score, 2) }}</p>

                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                           @foreach($laptop->specs as $kriteriaId => $option)
        @if(isset($kriteriaNames[$kriteriaId]) && isset($specValues[$kriteriaId]))
        <tr>
            <th width="30%">{{ $kriteriaNames[$kriteriaId] ?? 'Kriteria Tidak Ditemukan' }}</th>
            <td>{{ $option }}</td>
            <td class="text-end">{{ $specValues[$kriteriaId] ?? 'N/A' }}</td>
        </tr>
        @else
        <tr class="table-warning">
            <th width="30%">Kriteria #{{ $kriteriaId }} (tidak ditemukan)</th>
            <td>{{ $option }}</td>
            <td class="text-end">N/A</td>
        </tr>
        @endif
    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-graph-up"></i> Kontribusi Kriteria
            </div>
            <div class="card-body">
                <canvas id="contributionChart" height="250"></canvas>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <i class="bi bi-lightbulb"></i> Rekomendasi
            </div>
            <div class="card-body">
                @if($laptop->score >= 80)
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> <strong>Rekomendasi Tinggi</strong>
                    <p class="mb-0">Laptop ini memiliki score sangat baik untuk kriteria yang Anda prioritaskan.</p>
                </div>
                @elseif($laptop->score >= 60)
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> <strong>Rekomendasi Sedang</strong>
                    <p class="mb-0">Laptop ini cukup baik namun ada beberapa kriteria yang bisa ditingkatkan.</p>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> <strong>Rekomendasi Rendah</strong>
                    <p class="mb-0">Laptop ini kurang memenuhi prioritas kriteria yang Anda tentukan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('laptops.ranking') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Ranking
    </a>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Kontribusi Kriteria
    const ctx = document.getElementById('contributionChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_values($kriteriaNames)) !!},
            datasets: [{
                data: {!! json_encode($contributionValues) !!},
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#8AC24A', '#607D8B'
                ]
            }]
        }
    });
</script>
@endpush
@endsection