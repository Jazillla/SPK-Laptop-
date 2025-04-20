<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index()
    {
        // DUMMY
         $kriterias = Kriteria::all();
    return view('bobot-form', compact('kriterias'));
    }

    public function create()
    {
        // Pastikan bobot sudah diisi
        if (!session()->has('bobot_kriteria')) {
            return redirect()->route('bobot.create')
                   ->with('error', 'Silahkan tentukan bobot kriteria terlebih dahulu');
        }

        $kriterias = Kriteria::all();
          $lastUsedWeights = session('bobot_kriteria');

    return view('create', [
        'kriterias' => $kriterias,
        'lastUsedWeights' => $lastUsedWeights
    ]);
    }

   public function store(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'specs' => 'required|array'
    ]);

    // Debug: Cek session bobot
    if (!session()->has('bobot_kriteria')) {
        logger()->error('Session bobot_kriteria tidak ditemukan');
        return redirect()->route('createbobot')
               ->with('error', 'Silakan tentukan bobot kriteria terlebih dahulu');
    }

    // Ambil bobot dari session
    $bobot = session('bobot_kriteria');

    try {
        // Buat instance Laptop baru
        $laptop = new Laptop();
        $laptop->nama = $request->nama;
        $laptop->specs = $request->specs;
        $laptop->bobot_used = $bobot;
        $laptop->save();

        // Debug: Pastikan ini benar-benar instance Laptop
        logger()->debug('Laptop sebelum hitungScore', [
            'class' => get_class($laptop),
            'id' => $laptop->id,
            'attributes' => $laptop->getAttributes()
        ]);

        // Hitung score
        $this->hitungScore($laptop, $bobot);

        return redirect()->route('laptops.ranking')
               ->with('success', 'Laptop berhasil ditambahkan');

    } catch (\Exception $e) {
        logger()->error('Error menyimpan laptop', ['error' => $e->getMessage()]);
        return back()->with('error', 'Gagal menyimpan data laptop');
    }
}

    private function hitungScore(Laptop $laptop, array $bobot)
    {
        $kriterias = Kriteria::all();
        $totalBobot = array_sum($bobot);

        $totalScore = 0;

        foreach ($laptop->specs as $kriteriaId => $option) {
            $kriteria = $kriterias->find($kriteriaId);
            $nilai = $kriteria->getNilaiUntukOption($option);

            $max = max($kriteria->options);
            $min = min($kriteria->options);

            if ($kriteria->jenis == 'benefit') {
                $utility = ($nilai - $min) / ($max - $min);
            } else {
                $utility = ($max - $nilai) / ($max - $min);
            }

            $totalScore += $utility * ($bobot[$kriteriaId] / $totalBobot);
        }

        $laptop->update(['score' => $totalScore * 100]);
    }

    public function ranking()
{
    $laptops = Laptop::orderBy('score', 'DESC')->get();
    $kriterias = Kriteria::all();

    $kriteriaNames = [];
    $bobotValues = [];

    foreach ($kriterias as $kriteria) {
        $kriteriaNames[$kriteria->id] = $kriteria->nama;
        $bobotValues[$kriteria->id] = $kriteria->bobot_user;
    }

    return view('rangking', compact('laptops', 'kriteriaNames', 'bobotValues'));
}

    public function show(Laptop $laptop)
{
   $kriterias = Kriteria::all()->keyBy('id'); // Gunakan keyBy untuk akses lebih mudah

    $kriteriaNames = [];
    $specValues = [];
    $contributionValues = [];

    $totalBobot = array_sum($laptop->bobot_used);

    foreach ($laptop->specs as $kriteriaId => $option) {
        // Pastikan kriteria ada
        if (!isset($kriterias[$kriteriaId])) {
            continue; // Lewati jika kriteria tidak ditemukan
        }

        $kriteria = $kriterias[$kriteriaId];
        $kriteriaNames[$kriteriaId] = $kriteria->nama;

        // Dapatkan nilai kuantitatif
        $specValues[$kriteriaId] = $kriteria->getNilaiUntukOption($option);

        // Hitung kontribusi
        $max = max($kriteria->options);
        $min = min($kriteria->options);
        $nilai = $specValues[$kriteriaId];

        $utility = ($kriteria->jenis == 'benefit')
            ? ($nilai - $min) / ($max - $min)
            : ($max - $nilai) / ($max - $min);

        $contributionValues[$kriteriaId] = round(
    ($utility * ($laptop->bobot_used[$kriteriaId] / $totalBobot)) * 100,
    2
);

        return view('showlaptop', [
            'laptop' => $laptop,
            'kriteriaNames' => $kriteriaNames,
            'specValues' => $specValues,
            'contributionValues' => $contributionValues
        ]);

        }
        }
public function destroy(Laptop $laptop)
{
    try {
        $laptop->delete();
        return redirect()->route('laptops.ranking')
               ->with('success', 'Laptop berhasil dihapus');
    } catch (\Exception $e) {
        return redirect()->route('laptops.ranking')
               ->with('error', 'Gagal menghapus laptop: ' . $e->getMessage());
    }
}
}