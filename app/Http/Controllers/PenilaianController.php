<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Penilaiandb;
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
        $data = Penilaiandb::select('p.divisi', 'p.tgl_penilaian', 'p.status')
            ->from('penilaians as p')
            ->whereIn('p.id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('penilaians')
                    ->groupBy('divisi');
            })
            ->orderBy('p.divisi');
        if (auth()->user()->role == 'Karyawan') {
            $data = $data->where('divisi', auth()->user()->karyawan->jabatan);
            $data = $data->where('status', 1);
        }
        $data = $data->get();
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($divisi, $tgl_penilaian)
    {
        $penilaian = PenilaianDb::with('karyawans')->where('divisi', $divisi)
            ->where('tgl_penilaian', $tgl_penilaian)
            ->get();
        // dd($penilaian);
        return view('penilaian.show', compact('penilaian', 'divisi', 'tgl_penilaian'));
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
