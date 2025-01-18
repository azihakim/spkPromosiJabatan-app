<?php

namespace App\Models;

use App\Livewire\Penilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;


    public function penilaianDb()
    {
        return $this->hasMany(Penilaiandb::class, 'karyawan_id', 'id');
    }
}
