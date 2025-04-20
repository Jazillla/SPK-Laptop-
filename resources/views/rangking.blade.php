@extends('layout')

@section('title', 'Hasil Ranking')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="bi bi-trophy"></i> Hasil Ranking Laptop</h2>
        <p class="text-muted">Berikut hasil perhitungan menggunakan metode SMART</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('laptops.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Laptop
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="50">Rank</th>
                        <th>Laptop</th>
                        <th>Spesifikasi</th>
                        <th width="150">Score</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laptops as $index => $laptop)
                    <tr>
                        <td>
                            <span class="badge bg-{{ $index < 3 ? 'primary' : 'secondary' }}">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $laptop->nama }}</strong>
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($laptop->specs as $kriteriaId => $option)
                                <li>
                                    <small>{{ $kriteriaNames[$kriteriaId] }}: {{ $option }}</small>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-success"
                                     role="progressbar"
                                     style="width: {{ $laptop->score }}%"
                                     aria-valuenow="{{ $laptop->score }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                    {{ number_format($laptop->score, 1) }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('laptops.show', $laptop->id) }}" class="btn btn-sm btn-outline-primary mb-4">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <form action="{{ route('laptops.destroy', $laptop->id) }}" method="POST"
                      class="d-inline" onsubmit="return confirm('Hapus laptop ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <i class="bi bi-pie-chart"></i> Distribusi Bobot Kriteria
            </div>
            <div class="card-body">
                <canvas id="weightChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-bar-chart"></i> Perbandingan Score
            </div>
            <div class="card-body">
                <canvas id="scoreChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Distribusi Bobot
    const weightCtx = document.getElementById('weightChart').getContext('2d');
    new Chart(weightCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_values($kriteriaNames)) !!},
            datasets: [{
                data: {!! json_encode(array_values($bobotValues)) !!},
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#8AC24A', '#607D8B'
                ]
            }]
        }
    });

    // Chart Perbandingan Score
    const scoreCtx = document.getElementById('scoreChart').getContext('2d');
    new Chart(scoreCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($laptops->pluck('nama')) !!},
            datasets: [{
                label: 'Score',
                data: {!! json_encode($laptops->pluck('score')) !!},
                backgroundColor: '#4BC0C0'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>
@endpush
@endsection