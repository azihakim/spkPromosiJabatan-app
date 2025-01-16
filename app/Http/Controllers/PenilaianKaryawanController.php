<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaiandb;
use Illuminate\Http\Request;

class PenilaianKaryawanController extends Controller
{
    public $kriteriaPenilaian = [];

    public function create($id)
    {
        // Temukan karyawan berdasarkan ID
        $karyawan = Karyawan::find($id);

        // Dapatkan kriteria penilaian
        $kriteriaPenilaian = $this->getKriteriaPenilaian();

        // Decode penilaian karyawan yang ada (jika ada)
        $penilaian = json_decode($karyawan->penilaian, true);

        $penilainSebelumnya = Penilaiandb::where('karyawan_id', $id)->get();
        $kriteria = Kriteria::with('subKriterias')->get();

        return view('karyawan.penilaian.create', compact('karyawan', 'kriteriaPenilaian', 'penilaian', 'penilainSebelumnya', 'kriteria'));
    }

    public function getKriteriaPenilaian()
    {
        $kriteriaPenilaian = Kriteria::with('subKriterias')->get();

        $kriteriaPenilaianArray = $kriteriaPenilaian->toArray();
        // dd($kriteriaPenilaianArray);
        $this->kriteriaPenilaian = $kriteriaPenilaianArray;
        return $this->kriteriaPenilaian;
    }
    public function store($id, Request $request)
    {
        // dd($request->penilaianData);
        $karyawan = Karyawan::find($id);
        $karyawan->penilaian = json_encode($request->penilaianData);
        $karyawan->save();
        return redirect()->route('karyawan.index');
    }
}
