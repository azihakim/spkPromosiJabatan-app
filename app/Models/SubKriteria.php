<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    protected $table = 'sub_kriterias';
    protected $fillable = [
        'kriteria_id',
        'nama',
        'bobot',
        'penilaian'
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
