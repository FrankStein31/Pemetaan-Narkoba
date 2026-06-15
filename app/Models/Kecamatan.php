<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $fillable = ['nama_kecamatan'];

    // Relasi One-to-Many: Satu Kecamatan memiliki banyak Desa
    public function desas()
    {
        return $this->hasMany(Desa::class, 'kecamatan_id', 'id');
    }

    // Relasi One-to-Many: Satu Kecamatan memiliki banyak Warga
    public function wargas()
    {
        return $this->hasMany(Warga::class, 'kecamatan_id', 'id');
    }
}
