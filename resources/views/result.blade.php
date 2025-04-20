<!DOCTYPE html>
<html>
<head>
    <title>Hasil Perbandingan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Hasil Perbandingan</h1>

        <div class="card mb-4">
            <div class="card-header">Bobot Kriteria</div>
            <div class="card-body">
                <ul>
                    @foreach($kriterias as $kriteria)
                    <li>
                        {{ $kriteria->nama }}: {{ $bobot[$kriteria->id] }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Ranking Laptop</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Laptop</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $result['laptop']->merk }} {{ $result['laptop']->model }}</td>
                            <td>{{ number_format($result['score'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ route('compare') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>