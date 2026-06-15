<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan'; // Nama tabel di database

    protected $fillable = [
        'nama',
        'no_hp',
        'kategori',
        'lokasi',
        'waktu',
        'deskripsi',
        'bukti'
    ];
    
}
