<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaiandb extends Model
{
    use HasFactory;

    protected $table = 'penilaians';
    protected $fillable = [
        'karyawan_id',
        'tgl_penilaian',
        'data',
    ];
    protected $casts = [
        'data' => 'array',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
