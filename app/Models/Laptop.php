<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;
     protected $fillable = [
        'nama',
        'merk',
        'specs',// menyimpan spesifikasi yang dipilih
        'bobot_used',
        'score'
    ];

    protected $casts = [
        'specs' => 'array', // otomatis konversi json ke array
        'bobot_used' => 'array'
    ];

    /**
     * Hitung score SMART untuk laptop ini
     */
        public function create()
    {
        // Pastikan bobot sudah diisi
        if (!session()->has('bobot_kriteria')) {
            return redirect()->route('bobot.create')
                   ->with('info', 'Silakan tentukan bobot kriteria terlebih dahulu');
        }

        $kriterias = Kriteria::all();
        $lastUsedWeights = session('bobot_kriteria');

        return view('create', [
            'kriterias' => $kriterias,
            'lastUsedWeights' => $lastUsedWeights
        ]);
    }
          private function hitungScore(Laptop $laptop, array $bobot)
        {
            // Validasi input
            if (!$laptop instanceof \App\Models\Laptop) {
                throw new \InvalidArgumentException('Parameter harus instance Laptop');
            }

            $kriterias = Kriteria::all();
            $totalBobot = array_sum($bobot);

            // Hitung score
            $totalScore = 0;
            foreach ($laptop->specs as $kriteriaId => $option) {
                $kriteria = $kriterias->find($kriteriaId);
                if (!$kriteria) continue;

                $nilai = $kriteria->getNilaiUntukOption($option);
                $max = max($kriteria->options);
                $min = min($kriteria->options);

                $utility = ($kriteria->jenis == 'benefit')
                    ? ($nilai - $min) / ($max - $min)
                    : ($max - $nilai) / ($max - $min);

                $totalScore += $utility * ($bobot[$kriteriaId] / $totalBobot);
            }

            $laptop->score = $totalScore * 100;
            $laptop->save();
        }
    /**
     * Relasi ke penilaian (jika menggunakan tabel terpisah)
     */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
    public function getSpecsAttribute($value)
{
    $specs = json_decode($value, true) ?? [];

    // Validasi kriteria yang ada
    $existingKriteria = Kriteria::pluck('id')->toArray();

    return array_filter($specs, function($kriteriaId) use ($existingKriteria) {
        return in_array($kriteriaId, $existingKriteria);
    }, ARRAY_FILTER_USE_KEY);
}
}
