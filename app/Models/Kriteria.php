<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
  protected $fillable = [
        'nama',
        'jenis', // benefit atau cost

        'options' // menyimpan opsi dan nilai kuantitatif
    ];

    protected $casts = [
        'options' => 'array' // otomatis konversi json ke array
    ];

    /**
     * Hitung bobot normalisasi
     */
    public function getBobotNormalizedAttribute()
    {
        $totalBobot = Kriteria::sum('bobot_user');
        return $this->bobot_user / $totalBobot;
    }

    /**
     * Dapatkan nilai kuantitatif dari opsi yang dipilih
     */
    public function getNilaiUntukOption($option)
    {
        return $this->options[$option] ?? 0;
    }
    // Tambahkan method untuk mendapatkan bobot terakhir
    public static function getLastUsedWeights()
    {
        return self::pluck('bobot_user', 'id')->toArray();
    }
}
