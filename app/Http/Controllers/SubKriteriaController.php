<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Ambil kriteria berdasarkan ID yang dipilih
        $kriteria = Kriteria::findOrFail($request->kriteria_id);

        // Cari sub-kriteria terakhir untuk menentukan urutan kode sub-kriteria berikutnya
        $lastSubKriteria = SubKriteria::where('kriteria_id', $kriteria->id)
            ->orderBy('kode', 'desc')
            ->first();

        // Tentukan nomor urut berikutnya
        if ($lastSubKriteria) {
            // Ambil bagian angka setelah titik pada kode terakhir (misalnya, C1.3 -> ambil 3)
            $lastNumber = intval(explode('.', $lastSubKriteria->kode)[1]);
        } else {
            // Jika belum ada sub-kriteria, mulai dari 0
            $lastNumber = 0;
        }

        // Loop untuk menyimpan data sub-kriteria berdasarkan rentang dan skor
        foreach ($request->rentang as $key => $rentang) {
            $subKriteria = new SubKriteria();
            $subKriteria->kriteria_id = $request->kriteria_id;

            // Increment nomor urut untuk setiap sub-kriteria
            $newNumber = $lastNumber + 1 + $key;
            $kodeSubKriteria = "{$kriteria->kode}.{$newNumber}"; // Kode dengan format C1.1, C1.2, dst.

            $subKriteria->kode = $kodeSubKriteria; // Set kode sub-kriteria
            $subKriteria->rentang = $rentang; // Rentang dari input
            $subKriteria->bobot = $request->skor[$key]; // Skor dari input
            $subKriteria->save(); // Simpan ke database
        }


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

    public function getNextSubKriteria($kode_kriteria)
    {
        // Cari sub-kriteria terakhir yang memiliki kode yang diawali dengan kode kriteria yang dipilih
        $lastSubKriteria = SubKriteria::where('kode', 'like', "$kode_kriteria.%")
            ->orderBy('kode', 'desc')
            ->first();

        // Jika ada sub-kriteria, ambil nomor terakhir dan tambahkan 1
        if ($lastSubKriteria) {
            $lastNumber = intval(explode('.', $lastSubKriteria->kode_sub_kriteria)[1]); // Ambil nomor setelah titik
            $newNumber = $lastNumber + 1;
        } else {
            // Jika belum ada sub-kriteria, mulai dari 1
            $newNumber = 1;
        }

        // Format kode sub-kriteria baru dengan format [kode_kriteria].[nomor_sub_kriteria]
        $newKodeSubKriteria = $kode_kriteria . '.' . $newNumber;

        return response()->json([
            'kode_sub_kriteria' => $newKodeSubKriteria
        ]);
    }
}
