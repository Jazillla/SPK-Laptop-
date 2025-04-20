<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\Laptop;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
            $kriterias = [
        [
            'nama' => 'CPU',
            'jenis' => 'benefit',
            'options' => [
                'Intel i3' => 60,
                'Intel i5' => 75,
                'Intel i7' => 85,
                'AMD Ryzen 5' => 70,
                'AMD Ryzen 7' => 80
            ]
        ],
        [
            'nama' => 'RAM',
            'jenis' => 'benefit',
            'options' => [
                '4GB' => 50,
                '8GB' => 70,
                '16GB' => 90
            ]
        ],
        [
            'nama' => 'Harga',
            'jenis' => 'cost',
            'options' => [
                '< Rp10jt' => 90,
                'Rp10-15jt' => 70,
                '> Rp15jt' => 50
            ]
        ],
         [
            'nama' => 'Daya Tahan Baterai',
            'jenis' => 'benefit',
            'options' => [
                'Rendah (<5 jam)' => 40,
                'Sedang (5-8 jam)' => 65,
                'Tinggi (8-12 jam)' => 80,
                'Sangat Tinggi (>12 jam)' => 95
            ]
        ]
    ];

    foreach ($kriterias as $k) {
        Kriteria::create($k);
    }
}
}