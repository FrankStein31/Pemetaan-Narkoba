<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sosialisasi;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB; // ✅ Tambahkan baris ini
use App\Models\Application;
use Illuminate\Support\Facades\Storage;

class SosialisasiController extends Controller {
    // Tampilkan data di dashboard user

    public function indexuser(){
        $sosialisasi = Sosialisasi::where('status', 'aktif')->latest()->first();
return view('masyarakat.dashboard.index', compact('sosialisasi'));
    }


    public function index() {

        // $sosialisasi = Sosialisasi::latest()->get();
        // return view('admin.sosialisasi.create', compact('sosialisasi'));

        return view('admin.sosialisasi.index', [
            'app' => Application::all(),
            'sosialisasi' => Sosialisasi::with('kecamatan','desa')->paginate(10),
            'title' => 'Sosialisasi',
            'kecamatans'=> Kecamatan::all(),
        'desas'=> Desa::all(),
        ]);
    }
    public function store(Request $request) {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'desa_id' => 'required|string',
                'kecamatan_id' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        // Simpan dengan nama asli dan replace jika ada yang sama
        $gambar = $request->file('gambar');
        $namaFile = $gambar->getClientOriginalName(); // Ambil nama asli file
        $path = 'sosialisasi/' . $namaFile; // Path penyimpanan di storage

        // Simpan file ke storage/public/sosialisasi dengan nama asli
        $gambar->storeAs('sosialisasi', $namaFile, 'public');

        // Simpan ke database
        Sosialisasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'desa_id'=> $request->desa_id,
            'kecamatan_id' => $request->kecamatan_id,
            'gambar' => $path, // Simpan path untuk digunakan di tampilan
            'status' => 'aktif',

        ]);
        $jumlahAktif = Sosialisasi::where('status', 'aktif')
        ->where('desa_id', $request->desa_id)
        ->where('kecamatan_id', $request->kecamatan_id)
        ->count();

    // Update kolom sosialisasi di tabel desa
    DB::table('desa')
        ->where('id', $request->desa_id)
        ->where('kecamatan_id', $request->kecamatan_id)
        ->update(['sosialisasi' => $jumlahAktif]);


        return back()->with('tambahSosialisasiSukses', 'Sosialisasi berhasil diunggah!');
    }

    public function deleteSosialisasi(Request $request)
{
    $idSosialisasi = decrypt($request->codeSosialisasi);

    // Ambil data sosialisasi sebelum dihapus
    $sosialisasi = Sosialisasi::findOrFail($idSosialisasi);
    $status = $sosialisasi->status;
    $desaId = $sosialisasi->desa_id;
    $kecamatanId = $sosialisasi->kecamatan_id;

    // Hapus data sosialisasi
    $sosialisasi->delete();

    // Jika status aktif, kurangi kolom sosialisasi di desa
    if (strtolower($status) === 'aktif') {
        DB::table('desa')
            ->where('id', $desaId)
            ->where('kecamatan_id', $kecamatanId)
            ->where('sosialisasi', '>', 0) // Hindari nilai negatif
            ->decrement('sosialisasi');
    }

    return back()->with('deleteSosialisasi', 'Sosialisasi berhasil dihapus!');
}


    // Hapus data
    public function destroy($id) {
        $sosialisasi = Sosialisasi::findOrFail($id);
        Storage::disk('public')->delete($sosialisasi->gambar);
        $sosialisasi->delete();

        return back()->with('success', 'Brosur berhasil dihapus!');
    }

    public function toggleStatus($id) {
        $sosialisasi = Sosialisasi::findOrFail($id);

        // Simpan dulu desa_id dan kecamatan_id sebelum ubah status
        $desaId = $sosialisasi->desa_id;
        $kecamatanId = $sosialisasi->kecamatan_id;

        // Toggle status
        $sosialisasi->status = $sosialisasi->status === 'aktif' ? 'nonaktif' : 'aktif';
        $sosialisasi->save();

        // Hitung ulang jumlah sosialisasi aktif untuk desa & kecamatan ini
        $jumlahAktif = Sosialisasi::where('status', 'aktif')
            ->where('desa_id', $desaId)
            ->where('kecamatan_id', $kecamatanId)
            ->count();

        // Update kolom sosialisasi di tabel desa
        DB::table('desa')
            ->where('id', $desaId)
            ->where('kecamatan_id', $kecamatanId)
            ->update(['sosialisasi' => $jumlahAktif]);

        return back()->with('success', 'Status sosialisasi diperbarui!');
    }


// public function editSosialisasi(Request $request)
// {
//     $idSosialisasi = decrypt($request->code);

//     try {
//         $validatedData = $request->validate([
//             'judul' => 'required|string|max:255|unique:sosialisasi,judul,'.$idSosialisasi,
//             'deskripsi' => 'required|string|max:255',
//             'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);


//         $sosialisasi = Sosialisasi::findOrFail($idSosialisasi);

//         // Siapkan data update
//         $dataToUpdate = [
//             'judul' => $validatedData['judul'],
//             'deskripsi' => $validatedData['deskripsi'],
//         ];

//     // Hapus gambar lama
//     if ($request->hasFile('gambar')) {
//         // Hapus gambar lama jika ada
//         if ($sosialisasi->gambar && Storage::exists('public/' . $sosialisasi->gambar)) {
//             Storage::delete('public/' . $sosialisasi->gambar);
//         }

//         // Simpan gambar baru
//         $image = $request->file('gambar');
//         $imageName = time() . '_' . $image->getClientOriginalName();
//         $path = 'sosialisasi/' . $imageName; // Path penyimpanan

//         $image->storeAs('public/sosialisasi', $imageName); // Simpan ke storage/public/sosialisasi
//         $dataToUpdate['gambar'] = $path;
//     }

//         $sosialisasi->update($dataToUpdate);

//         return back()->with('editSosialisasiSuccess', 'Data sosialisasi berhasil diperbarui!');

//     } catch (ValidationException $e) {
//         return back()->withErrors($e->validator)
//                      ->withInput()
//                      ->with('editing_sosialisasi', true);
//     }
// }


public function editSosialisasi(Request $request)
{
    $idSosialisasi = decrypt($request->code);

    try {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255|unique:sosialisasi,judul,'.$idSosialisasi,
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desa' => 'required|string',       // Sesuaikan dengan nama di form
            'kecamatan' => 'required|string',
        ]);

        $sosialisasi = Sosialisasi::findOrFail($idSosialisasi);

        // Siapkan data update
        $dataToUpdate = [
            'judul' => $validatedData['judul'],
            'deskripsi' => $validatedData['deskripsi'],
            'desa_id' => $validatedData['desa'],         // Konversi ke nama kolom di database
            'kecamatan_id' => $validatedData['kecamatan'],
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            // Hapus gambar lama jika ada
            if ($sosialisasi->gambar && Storage::exists('public/' . $sosialisasi->gambar)) {
                Storage::delete('public/' . $sosialisasi->gambar);
            }

            // Simpan gambar baru
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = 'sosialisasi/' . $imageName; // Path penyimpanan

            $image->storeAs('public/sosialisasi', $imageName); // Simpan ke storage/public/sosialisasi
            $dataToUpdate['gambar'] = $path;
        }

        $sosialisasi->update($dataToUpdate);

        return back()->with('editSosialisasi', 'Data sosialisasi berhasil diperbarui!');

    } catch (ValidationException $e) {
        return back()->withErrors($e->validator)
                     ->withInput()
                     ->with('editing_sosialisasi', true);
    }
}

//     public function edit($id)
// {
//     $item = ModelAnda::findOrFail($id); // Pastikan mengambil data sesuai ID
//     return view('nama_view', compact('item'));
// }

}
