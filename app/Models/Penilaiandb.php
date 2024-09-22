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
        'divisi',
        'peringkat',
        'nilai',
    ];
    protected $casts = [
        'data' => 'array',
    ];

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
