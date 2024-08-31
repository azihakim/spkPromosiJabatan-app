<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Penilaiandb;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menyaring data penilaian berdasarkan tanggal
        $penilaian = Penilaiandb::orderBy('created_at')->get();

        // Mengelompokkan data berdasarkan tanggal penilaian
        $groupedPenilaian = $penilaian->groupBy('created_at');

        // Mengambil satu entri pertama dari setiap grup
        $uniquePenilaian = $groupedPenilaian->map(function ($group) {
            return $group->first();
        });

        // Mengembalikan view dengan data yang telah disaring
        return view('penilaian.index', compact('uniquePenilaian'));
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
    public function show($created_at)
    {
        if (auth()->user()->role == 'Karyawan') {
            $penilaian = PenilaianDb::where('created_at', $created_at)
                ->get()
                ->take(3)
                ->sortBy(function ($penilaian) {
                    return data_get(json_decode($penilaian->data), 'ranking');
                });
        } else {
            $penilaian = PenilaianDb::where('created_at', $created_at)
                ->get()
                ->sortBy(function ($penilaian) {
                    return data_get(json_decode($penilaian->data), 'ranking');
                });
        }


        // Ubah data JSON menjadi objek dan tambahkan total_nilai ke model
        $penilaian->each(function ($item) {
            $data = json_decode($item->data);
            $item->total_nilai = $data->total_nilai;
        });

        // Urutkan data berdasarkan total_nilai dari nilai tertinggi ke terendah
        $penilaian = $penilaian->sortByDesc('total_nilai')->values(); // values() to reset keys
        // dd($penilaian);
        return view('penilaian.show', compact('penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($created_at)
    {
        $penilaian = PenilaianDb::where('created_at', $created_at)
            ->orderByDesc('data->total_nilai')
            ->get();

        foreach ($penilaian as $item) {
            $item->delete();
        }

        return redirect()->route('penilaian.index')->with('error', 'Penilaian berhasil dihapus');
    }
}
