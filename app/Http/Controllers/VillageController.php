<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\Desa;
use App\Models\Kecamatan;

class VillageController extends Controller
{
    public function index()
    {
        return view('desamap', [
            'title' => 'Peta Desa',
            'desas' => Desa::all(),
            'kecamatans' => Kecamatan::orderBy('nama_kecamatan')->get(),
            'gmapsKey' => env('GOOGLE_MAPS_API_KEY', ''),
        ]);
    }

    public function coba()
    {
        return view('admin.maps.desamap', [
            'app' => Application::all(),
            'title' => 'Peta Desa',
            'desas' => Desa::all(),
            'kecamatans' => Kecamatan::orderBy('nama_kecamatan')->get(),
            'gmapsKey' => env('GOOGLE_MAPS_API_KEY', ''),
        ]);
    }

    public function sosialisasi()
    {
        return view('admin.maps.sosialisasimap', [
            'app' => Application::all(),
            'title' => 'Peta Desa',
            'desas' => Desa::all(),
            'kecamatans' => Kecamatan::orderBy('nama_kecamatan')->get(),
            'gmapsKey' => env('GOOGLE_MAPS_API_KEY', ''),
        ]);
    }

    public function jenis()
    {
        return view('admin.maps.golonganmap', [
            'app' => Application::all(),
            'title' => 'Peta Desa',
            'desas' => Desa::all(),
            'kecamatans' => Kecamatan::orderBy('nama_kecamatan')->get(),
            'gmapsKey' => env('GOOGLE_MAPS_API_KEY', ''),
        ]);
    }
}
