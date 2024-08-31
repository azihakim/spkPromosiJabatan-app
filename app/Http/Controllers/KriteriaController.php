<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kriteria::all();
        return view('kriteria.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi data yang diterima dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required', // Bobot harus numerik dan maksimum 100
        ]);

        // Simpan data kriteria
        Kriteria::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);

        // Redirect atau tampilkan pesan sukses jika berhasil disimpan
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Kriteria::find($id);
        return view('kriteria.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Kriteria::find($id);
        $data->nama = $request->nama;
        $data->kode = $request->kode;
        $data->save();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
}
