<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Menjaga agar kolom `id` tidak dapat diisi secara massal
    protected $guarded = ['id'];

    // Relasi: Seorang pasien memiliki nomor antrean (QueueNumber)
    public function queueNumber()
    {
        return $this->belongsTo(QueueNumber::class, 'queue_number_id');
    }

    // Scope pencarian berdasarkan keyword
    public function scopeSearching($query, $keyword)
    {
        if ($keyword) {
            $query->where(function($query) use ($keyword) {
                // Pencarian berdasarkan nama, alamat, usia, dan gender
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%')
                    ->orWhere('old', 'like', '%' . $keyword . '%')
                    ->orWhere('gender', 'like', '%' . $keyword . '%');
            });

            // Pencarian berdasarkan nomor antrean (queueNumber)
            $query->orWhereHas('queueNumber', function ($query) use ($keyword) {
                $query->where('number', 'like', '%' . $keyword . '%');
            });
        }
    }
}
