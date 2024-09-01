<?php

namespace App\Livewire;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaiandb;
use App\Models\SubKriteria;
use Livewire\Component;

class Penilaian extends Component
{
    public $karyawans;
    public $id_karyawan = [];
    public $nama_karyawan = [];
    public $jabatan_karyawan = [];
    public $kriteria = [];
    public $subkriteria = [];
    public $nilai = [];
    public $comparisons = [];
    public function mount()
    {
        $this->karyawans = Karyawan::all();

        foreach ($this->karyawans as $karyawan) {
            $this->id_karyawan[$karyawan->id] = $karyawan->id;
            $this->nama_karyawan[$karyawan->id] = $karyawan->nama;
            $this->jabatan_karyawan[$karyawan->id] = $karyawan->jabatan;
        }

        $this->kriteria = Kriteria::select(
            'kriterias.kode',
        )->pluck('kode')->toArray();
        // $this->kriteria = $this->kriteria->pluck('kode')->toArray();
        $this->formInput();
    }

    public function formInput()
    {
        $count = count($this->kriteria);
        for ($i = 0; $i < $count; $i++) {
            for ($j = 0; $j < $count; $j++) {
                if ($i != $j) {
                    $key = $this->kriteria[$i] . $this->kriteria[$j];
                    $this->comparisons[$key] = null;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.penilaian');
    }
}
