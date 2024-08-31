<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SubKriteria::all();
        // dd($data);
        return view('subkriteria.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kriterias = Kriteria::all(); // Ambil semua data kriteria

        return view('subkriteria.create', compact('kriterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $subKriteria = new SubKriteria;

        $subKriteria->nama = $request->nama;
        $subKriteria->bobot = $request->bobot;
        $subKriteria->kriteria_id = $request->kriteria_id;

        // Menggabungkan rentang dan skor menjadi format penilaian yang sesuai
        $penilaian = [];
        for ($i = 0; $i < count($request->rentang); $i++) {
            $penilaian[] = [
                'rentang' => $request->rentang[$i],
                'skor' => $request->skor[$i],
            ];
        }

        $subKriteria->penilaian = json_encode($penilaian); // Simpan sebagai JSON
        // dd($subKriteria);
        // Simpan perubahan
        $subKriteria->save();

        return redirect('/subkriteria')->with('success', 'Data sub kriteria berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubKriteria $subKriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $kriterias = Kriteria::all(); // Ambil semua data kriteria

        return view('subkriteria.edit', compact('subKriteria', 'kriterias'));
    }

    public function update(Request $request, $id)
    {
        $subKriteria = SubKriteria::find($id);

        $subKriteria->nama = $request->nama;
        $subKriteria->bobot = $request->bobot;
        $subKriteria->kriteria_id = $request->kriteria_id;

        // Menggabungkan rentang dan skor menjadi format penilaian yang sesuai
        $penilaian = [];
        for ($i = 0; $i < count($request->rentang); $i++) {
            $penilaian[] = [
                'rentang' => $request->rentang[$i],
                'skor' => $request->skor[$i],
            ];
        }

        $subKriteria->penilaian = json_encode($penilaian); // Simpan sebagai JSON
        // dd($subKriteria);
        // Simpan perubahan
        $subKriteria->save();

        return redirect('/subkriteria')->with('success', 'Data sub kriteria berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = SubKriteria::findOrFail($id);
        $data->delete();

        return redirect('/subkriteria')->with('success', 'Data sub kriteria berhasil dihapus.');
    }
}
