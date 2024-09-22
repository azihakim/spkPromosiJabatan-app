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
    public $comparisons = [];
    // public $comparisons =
    // [
    //     "C1C2" => "9",
    //     "C1C3" => "3",
    //     "C1C4" => "5",
    //     "C1C5" => "3",
    //     "C2C1" => "0.1111111111111111",
    //     "C2C3" => "3",
    //     "C2C4" => "5",
    //     "C2C5" => "9",
    //     "C3C1" => "0.3333333333333333",
    //     "C3C2" => "0.3333333333333333",
    //     "C3C4" => "5",
    //     "C3C5" => "3",
    //     "C4C1" => "0.2",
    //     "C4C2" => "0.2",
    //     "C4C3" => "0.2",
    //     "C4C5" => "5",
    //     "C5C1" => "0.3333333333333333",
    //     "C5C2" => "0.1111111111111111",
    //     "C5C3" => "0.3333333333333333",
    //     "C5C4" => "0.2",
    //     "C1C1" => "1",
    //     "C2C2" => "1",
    //     "C3C3" => "1",
    //     "C4C4" => "1",
    //     "C5C5" => "1"
    // ];
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
        // dd($ratio);
        return $ratio;
    }


    public function getComparisonValues()
    {
        $comparisons = $this->comparisons;
        $results = [];
        foreach ($comparisons as $key => $value) {
            $value = (float) $value;

            // Cari nilai tengah (nilai yang diinput)
            $nilaiTengah = $this->findMiddleValue($value);

            // Cari nilai bawah (invers dari nilai yang diinput)
            $nilaiBawah = $this->findLowerValue($value);

            // Cari nilai atas (biasanya adalah kebalikan atau nilai lebih besar)
            $nilaiAtas = $this->findUpperValue($value);

            // Simpan hasil ke array
            $results[$key] = [
                'nilai_bawah' => $nilaiBawah,
                'nilai_tengah' => $nilaiTengah,
                'nilai_atas' => $nilaiAtas
            ];
        }
        return $results;
    }

    // Fungsi untuk mencari nilai bawah sesuai aturan yang diberikan
    private function findLowerValue($value)
    {
        if ($value == 1) return 1;
        if ($value == 2) return 0.5;
        if ($value == 0.5) return 0.666;
        if ($value == 3) return 1;
        if ($value == 0.333333333333333) return 0.5;
        if ($value == 4) return 1.5;
        if ($value == 0.25) return 0.4;
        if ($value == 5) return 2;
        if ($value == 0.2) return 0.333;
        if ($value == 6) return 2.5;
        if ($value == 0.1666666666666667) return 0.285;
        if ($value == 7) return 3;
        if ($value == 0.1428571428571429) return 0.25;
        if ($value == 8) return 3.5;
        if ($value == 0.125) return 0.222;
        if ($value == 9) return 4;
        if ($value == 0.111111111111111) return 0.222;

        return 1; // Default jika tidak ada match
    }

    // Fungsi untuk mencari nilai tengah sesuai aturan yang diberikan
    private function findMiddleValue($value)
    {
        if ($value == 1) return 1;
        if ($value == 2) return 1;
        if ($value == 0.5) return 1;
        if ($value == 3) return 1.5;
        if ($value == 0.333333333333333) return 0.666;
        if ($value == 4) return 2;
        if ($value == 0.25) return 0.5;
        if ($value == 5) return 2.5;
        if ($value == 0.2) return 0.4;
        if ($value == 6) return 3;
        if ($value == 0.1666666666666667) return 0.333;
        if ($value == 7) return 3.5;
        if ($value == 0.1428571428571429) return 0.285;
        if ($value == 8) return 4;
        if ($value == 0.125) return 0.25;
        if ($value == 9) return 4.5;
        if ($value == 0.111111111111111) return 0.222;

        return 1; // Default jika tidak ada match
    }

    // Fungsi untuk mencari nilai atas sesuai aturan yang diberikan
    private function findUpperValue($value)
    {
        if ($value == 1) return 1;
        if ($value == 2) return 1.5;
        if ($value == 0.5) return 2;
        if ($value == 3) return 2;
        if ($value == 0.333333333333333) return 1;
        if ($value == 4) return 2.5;
        if ($value == 0.25) return 0.666;
        if ($value == 5) return 3;
        if ($value == 0.2) return 0.5;
        if ($value == 6) return 3.5;
        if ($value == 0.1666666666666667) return 0.4;
        if ($value == 7) return 4;
        if ($value == 0.1428571428571429) return 0.333;
        if ($value == 8) return 4.5;
        if ($value == 0.125) return 0.285;
        if ($value == 9) return 4.5;
        if ($value == 0.111111111111111) return 0.25;

        return 1; // Default jika tidak ada match
    }

    function calculateAllCriteriaValues()
    {
        $array = $this->getComparisonValues();
        // Kriteria yang akan dihitung
        $criteria = ['C1', 'C2', 'C3', 'C4', 'C5'];

        // Inisialisasi hasil untuk setiap kriteria
        $totals = [];
        foreach ($criteria as $criterion) {
            $totals[$criterion] = [
                'nilai_bawah' => 0,
                'nilai_tengah' => 0,
                'nilai_atas' => 0
            ];
        }

        // Inisialisasi total nilai keseluruhan
        $totalKeseluruhan = [
            'nilai_bawah' => 0,
            'nilai_tengah' => 0,
            'nilai_atas' => 0
        ];

        // Loop melalui array dan tambahkan nilai untuk setiap kriteria
        foreach ($array as $key => $values) {
            foreach ($criteria as $criterion) {
                if (strpos($key, $criterion) === 0) {
                    $totals[$criterion]['nilai_bawah'] += $values['nilai_bawah'];
                    $totals[$criterion]['nilai_tengah'] += $values['nilai_tengah'];
                    $totals[$criterion]['nilai_atas'] += $values['nilai_atas'];

                    // Tambahkan ke total keseluruhan
                    $totalKeseluruhan['nilai_bawah'] += $values['nilai_bawah'];
                    $totalKeseluruhan['nilai_tengah'] += $values['nilai_tengah'];
                    $totalKeseluruhan['nilai_atas'] += $values['nilai_atas'];
                }
            }
        }

        // Menghitung invers
        $inverseValues = [
            'inverse_bawah' => 1 / ($totalKeseluruhan['nilai_atas']),
            'inverse_tengah' => 1 / ($totalKeseluruhan['nilai_tengah']),
            'inverse_atas' => 1 / ($totalKeseluruhan['nilai_bawah'])
        ];

        // dd([
        //     'totals_per_criteria' => $totals,
        //     'total_overall' => $totalKeseluruhan,
        //     'inverses' => $inverseValues
        // ]);

        return [
            'totals_per_criteria' => $totals,
            'total_overall' => $totalKeseluruhan,
            'inverses' => $inverseValues
        ];
    }

    function calculateSynthesis()
    {
        $synthesisResults = [];

        $data = $this->calculateAllCriteriaValues();
        $inverses = $data['inverses'];

        // Loop melalui setiap kriteria
        foreach ($data['totals_per_criteria'] as $criterion => $values) {
            $synthesisResults[$criterion] = [
                'synthesis_bawah' => $values['nilai_bawah'] * $inverses['inverse_bawah'],
                'synthesis_tengah' => $values['nilai_tengah'] * $inverses['inverse_tengah'],
                'synthesis_atas' => $values['nilai_atas'] * $inverses['inverse_atas'],
            ];
        }
        // dd($synthesisResults);
        return $synthesisResults;
    }


    function calculateFuzzyAHPMatrix()
    {
        $synthesis = $this->calculateSynthesis();
        $matrix = [];

        foreach ($synthesis as $keyI => $valuesI) {
            foreach ($synthesis as $keyJ => $valuesJ) {
                if ($keyI === $keyJ) {
                    // Diagonal elements: comparison with itself is always 1
                    $matrix[$keyI][$keyJ] = 1.00;
                } else {
                    // Calculate the fuzzy vector comparison based on middle, lower, and upper values
                    $matrix[$keyI][$keyJ] = $this->calculateSingleVectorValue(
                        $valuesI['synthesis_bawah'],   // lower bound of the current criterion
                        $valuesI['synthesis_tengah'], // middle value of the current criterion
                        $valuesJ['synthesis_bawah'],   // lower bound of the other criterion
                        $valuesJ['synthesis_tengah'],  // middle value of the other criterion
                        $valuesJ['synthesis_atas']     // upper bound of the other criterion
                    );
                }
            }
        }
        dd($matrix);
        return $matrix;
    }

    function calculateSingleVectorValue($currentLower, $currentMiddle, $comparisonLower, $comparisonMiddle, $comparisonUpper)
    {
        // If the middle value of the current criterion is greater than or equal to the upper value of the comparison criterion
        if ($comparisonMiddle >= $currentMiddle) {
            return 1.00;
        }
        // If the middle value of the current criterion is less than or equal to the lower value of the comparison criterion
        elseif ($currentLower >= $comparisonUpper) {
            return 0.00;
        }
        // Otherwise, perform a fuzzy ratio calculation for values between the bounds
        else {
            $a = $currentLower - $comparisonUpper;
            $b = $comparisonMiddle - $comparisonUpper;
            $c = $currentMiddle - $currentLower;
            $bc = $b - $c;
            $result = $a / $bc;
            return $result;
            // return ($currentLower - $comparisonUpper) / (($comparisonMiddle - $comparisonUpper) - ($currentMiddle - $currentLower));
        }
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
