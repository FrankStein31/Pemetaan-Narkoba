<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;


class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    return view('masyarakat.pengaduan.index', [
        'app' => Application::all(),
        'pengaduans' => Pengaduan::paginate(10),
        'title' => 'Laporan Pengaduan',

    ]);
}

public function indextambah()
{
    return view('masyarakat.pengaduan.tambah', [
        'app' => Application::all(),

        'title' => 'Laporan Pengaduan'

    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('masyarakat.pengaduan.create', [
            'app' => Application::all(),
            'title' => 'Pengaduan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'waktu' => 'required|date',
            'deskripsi' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240', // Maks 10MB
        ]);

        // Upload bukti jika ada
        $file = $request->file('bukti');
$fileName = $file->getClientOriginalName();
$path = 'bukti_pengaduan/';

$counter = 1;
while (Storage::disk('public')->exists($path . $fileName)) {
    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_$counter." . $file->getClientOriginalExtension();
    $counter++;
}

$buktiPath = $file->storeAs($path, $fileName, 'public');

        // Simpan data ke database
        Pengaduan::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'kategori' => $request->kategori,
            'lokasi' => $request->lokasi,
            'waktu' => $request->waktu,
            'deskripsi' => $request->deskripsi,
            'bukti' => $buktiPath,
        ]);
//         session()->flash('tambahPengaduan', 'Tes Flash Message');
// dd(session()->all());

return redirect()->back()->with('tambahPengaduan', 'Pengaduan berhasil dikirim!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
//     public function destroy($id)
// {
//     try {
//         $id = Crypt::decrypt($id); // Dekripsi ID
//         dd($id); // Lihat apakah ID benar atau tidak
//     } catch (\Exception $e) {
//         return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
//     }
// }

    public function deletePengaduan(Request $request)
    {
        $idPengaduan = decrypt($request->codePengaduan);
        Pengaduan::destroy($idPengaduan);
        return back()->with('deletePengaduan', 'Laporan berhasil dihapus!');
    }
}
