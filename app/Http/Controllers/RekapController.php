<?php

namespace App\Http\Controllers;

use App\Livewire\Penilaian;
use App\Models\Penilaiandb;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RekapController extends Controller
{
    public function index()
    {
        $tgl_penilaian = Penilaiandb::select('tgl_penilaian')->distinct()->pluck('tgl_penilaian');
        // dd($tgl_penilaian);
        return view('rekap.index', compact('tgl_penilaian'));
    }

    public function rekap(Request $request)
    {
        $request->validate([
            'tglPenilaian' => 'required|date', // Pastikan nama field sesuai
            'divisi' => 'required|array', // Pastikan divisi adalah array
        ]);

        // Mengambil penilaian berdasarkan tanggal dan divisi
        $penilaian = Penilaiandb::where('tgl_penilaian', $request->tglPenilaian)
            ->whereIn('divisi', $request->divisi) // Menggunakan whereIn untuk array
            ->get();

        // Membuat PDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('rekap.pdf', compact('penilaian', 'request'));

        // Mengunduh PDF
        return $pdf->download('rekap.pdf');
    }

    public function getDivisiByDate(Request $request)
    {
        $request->validate([
            'tgl_penilaian' => 'required|date',
        ]);

        $divisi = Penilaiandb::where('tgl_penilaian', $request->tgl_penilaian)
            ->distinct()
            ->pluck('divisi');

        return response()->json($divisi);
    }
}
