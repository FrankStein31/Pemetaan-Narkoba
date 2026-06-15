<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';
    protected $fillable = ['nama_desa',
        'kecamatan_id',
        'alt_name',
        'latitude',
        'longitude',
        'population',
        'type_polygon',
        'polygon'];
        protected $casts = [
            'latitude' => 'double',
            'longitude' => 'double',
            'population' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    // Relasi Many-to-One: Satu Desa hanya memiliki satu Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    // Relasi One-to-Many: Satu Desa memiliki banyak Warga
    public function wargas()
    {
        return $this->hasMany(Warga::class, 'desa_id', 'id');
    }
}
