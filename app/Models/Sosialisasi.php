<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sosialisasi extends Model {
    use HasFactory;

    protected $table = 'sosialisasi';

    protected $fillable = [
        'judul',
        'deskripsi',
        'desa_id',
        'kecamatan_id',
        'gambar',
        'status',
    ];
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    // Relasi ke Desa (Setiap Warga memiliki satu Desa)
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id', 'id');
    }
}
