<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Penilaiandb;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua penilaian dan mengelompokkannya berdasarkan divisi
        $data = DB::table('penilaians')
            ->select('divisi', 'tgl_penilaian', 'status')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('penilaians')
                    ->groupBy('tgl_penilaian', 'divisi');
            })
            ->orderBy('divisi')
            ->orderBy('tgl_penilaian', 'desc')
            ->get();
        if (auth()->user()->role == 'Karyawan') {
            $data = $data->where('divisi', auth()->user()->karyawan->divisi);
            $data = $data->where('status', 1);
        }
        // $data = $data->get();
        // dd($data);
        return view('penilaian.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penilaian.penilaian');
    }


    /**
     * Display the specified resource.
     */
    public function show($divisi, $tgl_penilaian)
    {
        $penilaian = PenilaianDb::with('karyawans')
            ->where('divisi', $divisi)
            ->where('tgl_penilaian', $tgl_penilaian)
            ->get();

        // Decode nilai_kriteria
        foreach ($penilaian as $item) {
            $item->nilai_kriteria = json_decode($item->nilai_kriteria, true);
        }

        // Ambil data sub_kriteria dan buat mapping rentang berdasarkan bobot
        $subKriteria = SubKriteria::all()->groupBy('kriteria_id');
        $subKriteriaMapping = [];

        foreach ($subKriteria as $kriteriaId => $subItems) {
            foreach ($subItems as $sub) {
                $subKriteriaMapping[$sub->kriteria_id][$sub->bobot] = $sub->rentang;
            }
        }

        $kriteria = Kriteria::all(); // Ambil semua kriteria

        return view('penilaian.show', compact('penilaian', 'divisi', 'tgl_penilaian', 'kriteria', 'subKriteriaMapping'));
    }





    public function destroy($divisi, $tgl_penilaian)
    {
        Penilaiandb::where('divisi', $divisi)
            ->where('tgl_penilaian', $tgl_penilaian)
            ->delete();

        return redirect()->route('penilaian.index')->with('error', 'Penilaian berhasil dihapus');
    }

    public function validasi($divisi, $tgl_penilaian)
    {
        $penilaians = Penilaiandb::where('divisi', $divisi)
            ->where('tgl_penilaian', $tgl_penilaian)
            ->get();

        foreach ($penilaians as $penilaian) {
            $penilaian->status = 1;
            $penilaian->save();
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil divalidasi');
    }
}
