<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    public function create()
    {
          $kriterias = Kriteria::all();

    // Ambil bobot terakhir yang digunakan dari database
    $lastUsedWeights = [];
    foreach ($kriterias as $kriteria) {
        $lastUsedWeights[$kriteria->id] = $kriteria->bobot_user;
    }

    return view('createbobot', [
        'kriterias' => $kriterias,
        'lastUsedWeights' => $lastUsedWeights
    ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bobot' => 'required|array',
            'bobot.*' => 'required|numeric|min:1|max:100'
        ]);

        // Simpan bobot ke session
        session(['bobot_kriteria' => $request->bobot]);

        // Update bobot di database (optional)
        foreach ($request->bobot as $id => $bobot) {
            Kriteria::where('id', $id)->update(['bobot_user' => $bobot]);
        }

        return redirect()->route('laptops.create');
    }
    public function history()
{
    $kriterias = Kriteria::all();
    $laptops = Laptop::whereNotNull('bobot_used')->latest()->take(5)->get();

    return view('historybobot', compact('kriterias', 'laptops'));
}
}