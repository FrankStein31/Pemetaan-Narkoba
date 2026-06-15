<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'wargas';

    protected $fillable = [
        'nik', 'nama', 'alamat', 'jk', 'status_narkoba', 'desa_id', 'kecamatan_id'
    ];
    protected $attributes = [
        'status_narkoba' => 'Negatif Narkoba',
    ];

    // Relasi ke Kecamatan (Setiap Warga memiliki satu Kecamatan)
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



