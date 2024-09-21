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
        'kode',
        'nama',
    ];


    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    // // Tambahkan accessor ke appends
    // protected $appends = ['nama_kriteria', 'kode_kriteria'];

    // // Accessor untuk nama kriteria
    // public function getNamaKriteriaAttribute()
    // {
    //     return $this->kriteria ? $this->kriteria->nama : null;
    // }
    // // Accessor untuk kode kriteria
    // public function getKodeKriteriaAttribute()
    // {
    //     return $this->kriteria ? $this->kriteria->kode : null;
    // }
}
