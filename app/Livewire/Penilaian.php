<?php

namespace App\Livewire;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaiandb;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Penilaian extends Component
{
    public $step = 3;

    public $karyawans;
    public $id_karyawan = [];
    public $nama_karyawan = [];
    public $jabatan_karyawan = [];
    public $kriteria = [];
    public $subkriteria = [];
    public $nilai = [];
    // public $comparisons = [];
    public $comparisons =
    [
        "C1C2" => "9",
        "C1C3" => "3",
        "C1C4" => "5",
        "C1C5" => "3",
        "C2C1" => "0.1111111111111111",
        "C2C3" => "3",
        "C2C4" => "5",
        "C2C5" => "9",
        "C3C1" => "0.3333333333333333",
        "C3C2" => "0.3333333333333333",
        "C3C4" => "5",
        "C3C5" => "3",
        "C4C1" => "0.2",
        "C4C2" => "0.2",
        "C4C3" => "0.2",
        "C4C5" => "5",
        "C5C1" => "0.3333333333333333",
        "C5C2" => "0.1111111111111111",
        "C5C3" => "0.3333333333333333",
        "C5C4" => "0.2",
        "C1C1" => "1",
        "C2C2" => "1",
        "C3C3" => "1",
        "C4C4" => "1",
        "C5C5" => "1"
    ];
    public $divisis = [];
    public $nilaiKaryawan = false;
    public $selectedDivisi = "Pilih Divisi";
    public $divisiTerpilih = [];
    public $listKaryawan = [];
    public $kriteriaPenilaian = [];
    public $penilaianData = [];
    public $totalPebandingan = [];
    public $normalizedComparisons = [];
    public $filteredPenilaianData = [];

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
        $this->loadDivisi();
        $this->formInput();
        $this->getKriteriaPenilaian();
    }

    public function loadDivisi()
    {
        $this->divisis = Karyawan::select('jabatan')->groupBy('jabatan')->get();
    }

    public function getKriteriaPenilaian()
    {
        $kriteriaPenilaian = Kriteria::with('subKriterias')->get();

        $kriteriaPenilaianArray = $kriteriaPenilaian->toArray();
        // dd($kriteriaPenilaianArray);
        $this->kriteriaPenilaian = $kriteriaPenilaianArray;
        return $this->kriteriaPenilaian;
    }


    public function pilihDivisi()
    {
        $this->penilaianData = []; // Kosongkan penilaianData
        $this->listKaryawan = []; // Kosongkan listKaryawan sebelumnya

        // Muat divisi yang baru dipilih
        $this->loadDivisi();
        $this->nilaiKaryawan = true;

        if ($this->selectedDivisi) {
            // Tambahkan divisi yang dipilih ke array jika belum ada
            if (!in_array($this->selectedDivisi, $this->divisiTerpilih)) {
                $this->divisiTerpilih[] = $this->selectedDivisi;
            }
        }

        // Ambil daftar karyawan berdasarkan divisi yang dipilih
        $this->listKaryawan = Karyawan::where('jabatan', $this->selectedDivisi)->get();
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

    public function submitPenilaian()
    {
        // Ambil data penilaian untuk hanya karyawan yang ada di listKaryawan
        $filteredPenilaianData = [];

        foreach ($this->listKaryawan as $karyawan) {
            // Pastikan karyawan yang ada di listKaryawan diambil
            if (isset($this->penilaianData[$karyawan->nama])) {
                $filteredPenilaianData[$karyawan->id] = $this->penilaianData[$karyawan->nama];
            }
        };
    }

    public function hasilPerbandingan()
    {
        $comparisons = $this->comparisons;

        // Inisialisasi array untuk menyimpan total setiap kriteria
        $totals = [];

        // Ambil semua kriteria yang ada dari key (bisa di-generate dinamis jika diperlukan)
        $kriteria = ['C1', 'C2', 'C3', 'C4', 'C5'];

        // Inisialisasi total untuk setiap kriteria
        foreach ($kriteria as $kri) {
            $totals[$kri] = 0.0; // Gunakan float untuk total
        }

        // Loop melalui semua key di array comparisons
        foreach ($comparisons as $key => $value) {
            // Ambil kriteria kolom (karakter kedua dari key)
            $kolom = substr($key, 2, 2);

            // Jika ada value yang bukan null, tambahkan ke total kolom terkait
            if (!is_null($value)) {
                $totals[$kolom] += (float)$value; // Ubah ke float
            }
        }
        // dd($totals);
        $this->totalPebandingan = $totals;
        return $totals;
    }

    public function normalizeComparisons()
    {
        $this->hasilPerbandingan();
        $comparisons = $this->comparisons;
        $totals = $this->totalPebandingan;
        $normalized = [];

        // Loop melalui semua key di array comparisons
        foreach ($comparisons as $key => $value) {
            // Ambil kriteria kolom (karakter kedua dari key)
            $kolom = substr($key, 2, 2);

            // Normalisasi jika total kolom bukan nol
            if (isset($totals[$kolom]) && $totals[$kolom] != 0) {
                $normalized[$key] = (float)$value / $totals[$kolom];
            } else {
                $normalized[$key] = null; // Atau 0 jika ingin
            }
        }
        // dd($normalized);
        return $normalized;
    }

    public function calculatePriorityVector()
    {
        $normalizedComparisons = $this->normalizeComparisons();
        $priorityVector = [];
        $numCriteria = 0;

        // Hitung jumlah baris untuk setiap kriteria
        foreach ($normalizedComparisons as $key => $value) {
            // Ambil kriteria baris (karakter pertama dari key)
            $baris = substr($key, 0, 2);

            // Pastikan ada nilai
            if ($value !== null) {
                if (!isset($priorityVector[$baris])) {
                    $priorityVector[$baris] = [
                        'sum' => 0,
                        'count' => 0,
                    ];
                }
                // Tambahkan nilai ke total sum dan increment count
                $priorityVector[$baris]['sum'] += $value;
                $priorityVector[$baris]['count']++;
            }
        }

        // Hitung rata-rata untuk setiap kriteria
        foreach ($priorityVector as $kriteria => $data) {
            if ($data['count'] > 0) {
                $priorityVector[$kriteria] = $data['sum'] / $data['count'];
            } else {
                $priorityVector[$kriteria] = 0; // Atau null jika diinginkan
            }
        }
        // dd($priorityVector);
        return $priorityVector;
    }

    public function calculateRatio()
    {
        $priorityVector = $this->calculatePriorityVector();
        $totalCriteria = $this->totalPebandingan;
        $ratio = [];

        foreach ($priorityVector as $kriteria => $priorityValue) {
            // Ambil total untuk kriteria yang sesuai
            $totalValue = isset($totalCriteria[$kriteria]) ? $totalCriteria[$kriteria] : 0;

            // Hitung ratio
            if ($totalValue > 0) {
                $ratio[$kriteria] = $priorityValue * $totalValue;
            } else {
                $ratio[$kriteria] = 0; // Atau null jika diinginkan
            }
        }
        dd($ratio);
        return $ratio;
    }



    public function hasilAkhir()
    {
        dd($this->comparisons);
        $count = count($this->kriteria);
        for ($i = 0; $i < $count; $i++) {
            $total = 0;
            for ($j = 0; $j < $count; $j++) {
                if ($i != $j) {
                    $key = $this->kriteria[$i] . $this->kriteria[$j];
                    $total += $this->comparisons[$key];
                }
            }
            $this->nilai[$this->kriteria[$i]] = $total;
        }
    }


    public function render()
    {
        return view('livewire.penilaian');
    }
}
