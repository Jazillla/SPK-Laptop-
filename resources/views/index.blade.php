<!DOCTYPE html>
<html>
<head>
    <title>Daftar Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Daftar Laptop</h1>
            <a href="{{ route('laptops.create') }}" class="btn btn-primary">Tambah Laptop</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Laptop</th>
                    <th>Score</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laptops as $index => $laptop)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $laptop->nama }}</td>
                    <td>{{ number_format($laptop->score, 2) }}</td>
                    <td>
                        <a href="{{ route('laptops.ranking') }}" class="btn btn-sm btn-info">Lihat Ranking</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>