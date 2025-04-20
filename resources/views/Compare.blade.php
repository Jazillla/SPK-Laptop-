<!DOCTYPE html>
<html>
<head>
    <title>Bandingkan Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Bandingkan 2 Laptop</h1>

        <form method="POST" action="{{ route('compare.submit') }}">
            @csrf

            <h3>Pilih Laptop</h3>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label>Laptop 1</label>
                    <select name="laptop1" class="form-select">
                        @foreach($laptops as $laptop)
                        <option value="{{ $laptop->id }}">
                            {{ $laptop->merk }} {{ $laptop->model }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Laptop 2</label>
                    <select name="laptop2" class="form-select">
                        @foreach($laptops as $laptop)
                        <option value="{{ $laptop->id }}">
                            {{ $laptop->merk }} {{ $laptop->model }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h3>Berikan Bobot Kriteria (1-100)</h3>
            @foreach($kriterias as $kriteria)
            <div class="mb-3">
                <label class="form-label">{{ $kriteria->nama }}</label>
                <input type="number" name="bobot[{{ $kriteria->id }}]"
                       class="form-control" min="1" max="100" required>
            </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Bandingkan</button>
        </form>
    </div>
</body>
</html>