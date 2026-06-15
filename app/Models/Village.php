<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $table = 'villages';

    protected $fillable = [
        'name',
        'alt_name',
        'latitude',
        'longitude',
        'population',
        'type_polygon',
        'polygon',
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'population' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

