<?php

namespace App\Http\Controllers;

use App\Livewire\Penilaian;
use App\Models\Penilaiandb;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return $pdf->loadView('rekap.pdf');
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

    public function getRekap(Request $request)
    {
        $tgl_dari = $request->tgl_dari; // Pastikan input tanggal penilaian yang dikirim adalah range
        $tgl_sampai = $request->tgl_sampai;
        // Mengambil total nilai per divisi berdasarkan tanggal yang dipilih
        $totalNilaiPerDivisi = $this->getTotalNilaiPerDivisi($tgl_dari, $tgl_sampai);

        // Generate PDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('rekap.pdf-rekap', [
            'tgl_dari' => $tgl_dari,
            'tgl_sampai' => $tgl_sampai,
            'totalNilaiPerDivisi' => $totalNilaiPerDivisi,
        ]);
        return $pdf->download('rekap_penilaian_karyawan.pdf');
    }
    function getTotalNilaiPerDivisi($tgl_dari, $tgl_sampai)
    {
        // Mengambil data dengan join ke tabel kriteria dan sub_kriteria
        $result = DB::table('penilaians')
            ->join('karyawans', 'penilaians.karyawan_id', '=', 'karyawans.id') // Relasi ke tabel karyawans
            ->select(
                'penilaians.divisi',
                'penilaians.karyawan_id',
                DB::raw('SUM(penilaians.nilai) as total_nilai'), // Total nilai per karyawan
                'penilaians.nilai_kriteria',
                'karyawans.nama as nama_karyawan'
            )
            ->whereBetween('penilaians.tgl_penilaian', [$tgl_dari, $tgl_sampai]) // Filter tanggal
            ->groupBy('penilaians.divisi', 'penilaians.karyawan_id', 'penilaians.nilai_kriteria', 'karyawans.nama')
            ->get()
            ->groupBy('karyawan_id')
            ->map(function ($group) {
                $first = $group->first();
                $first->total_nilai = $group->sum('total_nilai');
                return $first;
            })
            ->values();
        // Memproses data untuk menambahkan kriteria dan subkriteria
        foreach ($result as $data) {
            $nilai_kriteria = json_decode($data->nilai_kriteria, true); // Decode JSON nilai_kriteria
            $data->kriteria = []; // Inisialisasi kriteria

            if ($nilai_kriteria) {
                foreach ($nilai_kriteria as $kode => $bobot) {
                    $kriteria = DB::table('kriterias')->where('kode', $kode)->first();
                    $sub_kriteria = DB::table('sub_kriterias')
                        ->where('kriteria_id', $kriteria->id ?? null)
                        ->where('bobot', $bobot)
                        ->first();

                    $data->kriteria[] = [
                        'nama_kriteria' => $kriteria->nama ?? '-',
                        'kode_kriteria' => $kriteria->kode ?? '-',
                        'bobot_sub_kriteria' => $sub_kriteria->bobot ?? '-',
                        'rentang_subkriteria' => $sub_kriteria->rentang ?? '-',
                    ];
                }
            }
        }

        return $result;
    }

    // function getTotalNilaiPerDivisi($tgl_dari, $tgl_sampai)
    // {
    //     // Query untuk mengambil data dan menjumlahkan nilai berdasarkan divisi
    //     $result = Penilaiandb::with('karyawans')
    //         ->select('divisi', 'karyawan_id', DB::raw('SUM(nilai) as total_nilai'), 'nilai_kriteria')
    //         ->whereBetween('tgl_penilaian', [$tgl_dari, $tgl_sampai])
    //         ->groupBy('divisi', 'karyawan_id', 'nilai_kriteria')
    //         ->get();

    //     return $result;
    // }




}
