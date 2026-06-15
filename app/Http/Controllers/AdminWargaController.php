<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Patient;
use App\Models\Warga; // Pastikan model Warga sudah dibuat
use Illuminate\Support\Facades\DB; // ✅ Tambahkan baris ini

use Carbon\Carbon;


class AdminWargaController extends Controller
{
    // Menampilkan daftar warga
    public function index()
    {
        return view('admin.wargas.index', [
            'app' => Application::all(),
            'title' => 'Data Warga',
            'wargas' => Warga::with('kecamatan', 'desa')->latest()->paginate(8), // Eager loading kecamatan
            'kecamatans' => Kecamatan::all(), // Ambil semua kecamatan
            'desas' => Desa::all(), // Ambil semua desa
        ]);
    }
public function indexpositif(){
    return view('admin.wargas.positif', [
        'app'=> Application::all(),
        'title'=> 'Data Warga Positif',
        'wargas' => Warga::with('kecamatan', 'desa')
    ->where('status_narkoba', 'Positif Narkoba')
    ->latest()
    ->paginate(8),
        'kecamatans'=> Kecamatan::all(),
        'desas'=> Desa::all(),
        ] );
}
    // Menampilkan form tambah warga
    public function create()
    {
        // $kecamatans = Kecamatan::all(); // Ambil semua data kecamatan
        // return view('warga.create', compact('kecamatans'));
    }

    // Menyimpan data warga baru
    public function store(Request $request)
    {
        $request->validate(
            [
                'nik' => 'required|digits:16|unique:wargas',
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'jk' => 'required|in:Laki-Laki,Perempuan',
                'desa_id' => 'required|string',
                'kecamatan_id' => 'required|string',
            ],
            [
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits' => 'NIK harus terdiri dari 16 digit.',
                'nik.unique' => 'NIK sudah terdaftar.',
                'nama.required' => 'Nama wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
                'jk.required' => 'Jenis kelamin wajib dipilih.',
                'desa_id.required' => 'Desa wajib dipilih.',
                'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            ],
        );

        // Menambahkan nilai default untuk status_narkoba
        $data = $request->only(['nik', 'nama', 'alamat', 'jk', 'desa_id', 'kecamatan_id']);
        $data['status_narkoba'] = 'Belum Diketahui';

        Warga::create($data);

        return back()->with('tambahwargaBerhasil', 'Berhasil menambah warga!');
    }

    // Menampilkan detail warga tertentu
    public function show($id)
    {
        // $warga = Warga::findOrFail($id);
        // return view('admin.warga.show', compact('warga'));
    }

    // Menampilkan form edit warga
    public function edit($id)
    {
        // $warga = Warga::findOrFail($id);
        // return view('admin.warga.edit', compact('warga'));
    }

    // Memperbarui data warga
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'nama' => 'required|string|max:255',
        //     'alamat' => 'required|string',
        //     'no_telp' => 'required|numeric',
        // ]);

        // $warga = Warga::findOrFail($id);
        // $warga->update($request->all());

        // return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui!');
    }

    // Menghapus warga
    public function destroy($id)
    {
        // $warga = Warga::findOrFail($id);
        // $warga->delete();

        // return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil dihapus!');
    }
    public function deleteWarga(Request $request)
{
    $idWarga = decrypt($request->codeWarga);

    // Ambil data warga sebelum dihapus
    $warga = Warga::findOrFail($idWarga);
    $statusNarkoba = $warga->status_narkoba;
    $golongan = $warga->golongan;
    $desaId = $warga->desa_id;
    $kecamatanId = $warga->kecamatan_id;

    // Hapus data warga
    $warga->delete();

    // Kurangi population jika status narkoba positif
    if ($statusNarkoba === 'Positif Narkoba') {
        DB::table('desa')
            ->where('id', $desaId)
            ->where('kecamatan_id', $kecamatanId)
            ->decrement('population');
    }

    // Update golongan_positif di tabel desa
    if ($statusNarkoba === 'Positif Narkoba' && $golongan) {
        // Ambil semua golongan terbaru di desa itu
        $golonganDesa = Warga::where('desa_id', $desaId)
            ->where('status_narkoba', 'Positif Narkoba')
            ->whereNotNull('golongan')
            ->pluck('golongan')
            ->unique()
            ->toArray();

        // Update desa sesuai golongan yang tersisa
        if (empty($golonganDesa)) {
            // Kalau tidak ada lagi golongan positif
            DB::table('desa')
                ->where('id', $desaId)
                ->where('kecamatan_id', $kecamatanId)
                ->update([
                    'golongan_positif' => null
                ]);
        } else {
            // Kalau masih ada golongan, gabungkan jadi string
            $golonganString = implode(',', $golonganDesa);
            DB::table('desa')
                ->where('id', $desaId)
                ->where('kecamatan_id', $kecamatanId)
                ->update([
                    'golongan_positif' => $golonganString
                ]);
        }
    }

    return back()->with('deleteWarga', 'Warga berhasil dihapus!');
}



    public function editWarga(Request $request)
{
    $idWarga = decrypt($request->code);

    try {
        $validatedData = $request->validate([
            'nik' => 'required|digits:16|unique:wargas,nik,'.$idWarga,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jk' => 'required|in:Laki-Laki,Perempuan',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'status_narkoba' => 'required|string',
            'golongan' => 'nullable|required_if:status_narkoba,Positif Narkoba|string',
            'jenis_golongan' => 'nullable|required_if:status_narkoba,Positif Narkoba|string',
        ]);

        // Ambil data lama warga
        $wargaLama = Warga::findOrFail($idWarga);
        $statusLama = $wargaLama->status_narkoba;
        $desaIdLama = $wargaLama->desa_id;
        $kecamatanIdLama = $wargaLama->kecamatan_id;

        // Data baru
        $statusBaru = $validatedData['status_narkoba'];
        $desaIdBaru = $validatedData['desa'];
        $kecamatanIdBaru = $validatedData['kecamatan'];

        // Update data warga
        $dataToUpdate = [
            'nik' => $validatedData['nik'],
            'nama' => $validatedData['nama'],
            'alamat' => $validatedData['alamat'],
            'jk' => $validatedData['jk'],
            'desa_id' => $desaIdBaru,
            'kecamatan_id' => $kecamatanIdBaru,
            'status_narkoba' => $statusBaru,
        ];

        if ($statusBaru === 'Positif Narkoba') {
            $dataToUpdate['golongan'] = $validatedData['golongan'];
            $dataToUpdate['jenis_golongan'] = $validatedData['jenis_golongan'];
        } else {
            $dataToUpdate['golongan'] = null;
            $dataToUpdate['jenis_golongan'] = null;
        }

        // Lakukan update data warga
        Warga::where('id', $idWarga)->update($dataToUpdate);

        // Cek perubahan status dan update population
        if ($statusLama === 'Positif Narkoba' && $statusBaru !== 'Positif Narkoba') {
            // Kurangi population
            DB::table('desa')
                ->where('id', $desaIdLama)
                ->where('kecamatan_id', $kecamatanIdLama)
                ->decrement('population');
        } elseif ($statusLama !== 'Positif Narkoba' && $statusBaru === 'Positif Narkoba') {
            // Tambah population
            DB::table('desa')
                ->where('id', $desaIdBaru)
                ->where('kecamatan_id', $kecamatanIdBaru)
                ->increment('population');
        }
        // >>> Tambahkan Update jumlah_positif_narkoba <<<
        // >>> Tambahkan Update jumlah_positif_narkoba <<<
// >>> Update golongan_narkoba per desa <<<
DB::statement("
    UPDATE desa d
    LEFT JOIN (
        SELECT w.desa_id, GROUP_CONCAT(DISTINCT w.golongan ORDER BY w.golongan ASC SEPARATOR ', ') AS golongan_positif
        FROM wargas w
        WHERE w.status_narkoba = 'Positif Narkoba'
          AND w.golongan IN ('Golongan I', 'Golongan II', 'Golongan III')
        GROUP BY w.desa_id
    ) w ON w.desa_id = d.id
    SET d.golongan_positif = w.golongan_positif
");


        return back()->with('editWargaSuccess', 'Data warga berhasil diupdate!');

    } catch (ValidationException $e) {
        return back()->withErrors($e->validator)
                     ->withInput()
                     ->with('editing_warga', true);
    }
}

    public function getDesaByKecamatan($kecamatan_id)
{
    $desas = Desa::where('kecamatan_id', $kecamatan_id)->get();
    return response()->json($desas);
}

    public function search()
    {
        if (request('q') === null) {
            return redirect('/admin/warga');
            exit;
        }
        return view('admin.wargas.search', [
            'app' => Application::all(),
            'title' => 'Data Warga',
            'wargas' => Warga::with('kecamatan', 'desa')->where('nama', 'like', '%' . request('q') . '%')->latest()->paginate(8),
            'kecamatans' => Kecamatan::all(), // Ambil semua kecamatan
            'desas' => Desa::all(), // Ambil semua desa
        ]);
    }

    public function searchpos()
    {
        if (request('q') === null) {
            return redirect('/warga-positif');
            exit;
        }

            return view('admin.wargas.searchpos', [
                'app' => Application::all(),
                'title' => 'Data Warga Positif',
                'wargas' => Warga::with('kecamatan', 'desa')
                    ->when(request('q'), function ($query) {
                        $query->where('nama', 'like', '%' . request('q') . '%');
                    })
                    ->where('status_narkoba', 'Positif Narkoba')
                    ->latest()
                    ->paginate(8),
                'kecamatans' => Kecamatan::all(),
                'desas' => Desa::all(),
            ]);
    }


public function getDataPasienPositif()
{


    $data = DB::table('wargas')
        ->select(
            DB::raw('DATE_FORMAT(updated_at, "%M %Y") as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->where('status_narkoba', 'Positif Narkoba')
        ->groupBy('bulan')
        ->orderBy(DB::raw('MIN(updated_at)'))
        ->get();

    return response()->json($data);
}




}
