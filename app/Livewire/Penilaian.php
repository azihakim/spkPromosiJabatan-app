<?php

namespace App\Livewire;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaiandb;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Penilaian extends Component
{
    public $step = 1;

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

    public $data_penilaian = [];

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

        // Loop untuk mendapatkan penilaian karyawan dan konversi bobot ke integer
        foreach ($this->listKaryawan as $karyawan) {
            if ($karyawan->penilaian) {
                // Decode penilaian dan ambil nilai berdasarkan ID karyawan
                $decodedPenilaian = json_decode($karyawan->penilaian, true);

                // Ambil nilai penilaian berdasarkan ID karyawan
                $penilaianKaryawan = $decodedPenilaian[$karyawan->id] ?? null;

                // Konversi nilai bobot ke integer jika ada
                if ($penilaianKaryawan) {
                    $this->penilaianData[$karyawan->id] = array_map('intval', $penilaianKaryawan);
                }
            }
        }
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

    public function submitPenilaianKaryawan()
    {
        // $this->pilihDivisi();
        // Ambil data penilaian untuk hanya karyawan yang ada di listKaryawan
        $filteredPenilaianData = [];

        foreach ($this->listKaryawan as $karyawan) {
            // Pastikan karyawan yang ada di listKaryawan diambil
            if (isset($this->penilaianData[$karyawan->id])) {
                $filteredPenilaianData[$karyawan->id] = $this->penilaianData[$karyawan->id];
            }
        };
        return $filteredPenilaianData;
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
            return ($currentLower - $comparisonUpper) / (($comparisonMiddle - $comparisonUpper) - ($currentMiddle - $currentLower));
        }
    }

    function findColumnMinima()
    {
        $matrix = $this->calculateFuzzyAHPMatrix();
        // Initialize an array to hold the minimum values for each column
        $minValues = [];

        // Get the list of criteria (keys from the matrix)
        $criteria = array_keys($matrix);

        // Initialize a variable to hold the sum of all minimum values
        $totalSum = 0;

        // Loop through each criterion (column)
        foreach ($criteria as $criterion) {
            // Initialize the min value for the current column to a very high value
            $minValue = INF;

            // Loop through each row in the matrix
            foreach ($matrix as $row) {
                // Compare the value in the current column and update the minimum if necessary
                if ($row[$criterion] < $minValue) {
                    $minValue = $row[$criterion];
                }
            }

            // Store the minimum value for the current criterion (column)
            $minValues[$criterion] = $minValue;

            // Add the minimum value to the total sum
            $totalSum += $minValue;
        }

        // Add a "total" key which is the sum of all the column minima
        $minValues['total'] = $totalSum;

        // dd($minValues); // Uncomment this line to debug
        return $minValues;
    }

    function normalisasiBobot()
    {
        $kriteria = $this->findColumnMinima(); // Mengambil array bobot kriteria
        $total = 0;

        // Hitung total bobot tanpa menghitung 'total' yang sudah ada
        foreach ($kriteria as $key => $value) {
            if ($key !== 'total') {
                $total += $value;
            }
        }

        $normalisasi = [];

        foreach ($kriteria as $key => $value) {
            // Menghindari pembagian dengan nol
            if ($key !== 'total' && $total > 0) {
                // Normalisasi dengan 2 angka di belakang koma
                $normalisasi[$key] = number_format($value / $total, 2, '.', '');
            } else {
                $normalisasi[$key] = '0.00'; // Jika totalnya nol, set ke 0.00
            }
        }

        // Hitung total dari nilai normalisasi
        $normalisasi['total'] = array_sum(array_map('floatval', $normalisasi)); // Konversi kembali ke float untuk penjumlahan
        $normalisasi['total'] = number_format($normalisasi['total'], 2, '.', '');

        // dd($normalisasi);
        return $normalisasi;
    }

    public $errors = [];

    public function checkDataPenilaian()
    {
        $this->errors = []; // Clear previous errors

        // Loop through each employee
        foreach ($this->listKaryawan as $karyawan) {
            $karyawanId = $karyawan->id;

            // Loop through each criterion
            foreach ($this->kriteriaPenilaian as $kriteria) {
                $kodeKriteria = $kriteria['kode'];
                $selectedValue = $this->penilaianData[$karyawanId][$kodeKriteria] ?? null;

                // If the value is empty, add an error
                if (empty($selectedValue)) {
                    $this->errors["penilaianData.{$karyawanId}.{$kodeKriteria}"] = "Harap isi penilaian untuk kriteria {$kriteria['nama']}";
                }
            }
        }
        $this->loadDivisi();
        // Return true if no errors, otherwise false
        return empty($this->errors);
    }

    public function step2()
    {

        // Validate penilaianData before proceeding
        if (!$this->checkDataPenilaian()) {
            // If there are validation errors, stop here
            return redirect()->back()->with('error', 'Ada kesalahan validasi. Silakan lengkapi semua input yang diperlukan.');
        }

        $penilaian = $this->submitPenilaianKaryawan();
        $bobot = $this->normalisasiBobot();
        $this->step = 2;

        return [
            'penilaian' => $penilaian,
            'bobot' => $bobot,
        ];
    }


    public function validateComparisons()
    {
        $this->errors = []; // Reset errors

        foreach ($this->kriteria as $i => $criterion) {
            foreach ($this->kriteria as $j => $otherCriterion) {
                $key = $this->kriteria[$i] . $this->kriteria[$j];

                // Validate if each comparison input is set and not empty
                if (!isset($this->comparisons[$key]) || $this->comparisons[$key] === '') {
                    $this->errors["comparisons.$key"] = "Harap isi nilai perbandingan untuk {$criterion} dan {$otherCriterion}.";
                }
            }
        }

        // If errors exist, prevent proceeding to the next step
        if (!empty($this->errors)) {
            return false;
        }

        return true;
    }

    function hasilAkhir()
    {
        $this->validateComparisons();
        if (!$this->validateComparisons()) {
            return; // Stop if there are validation errors
        }
        $result = $this->step2();
        $penilaian = $result['penilaian'];
        $bobot = $result['bobot'];

        $nilaiTotal = [];
        $rataRata = [];

        // Hitung nilai total untuk setiap karyawan
        foreach ($penilaian as $karyawanId => $kriteria) {
            $total = 0;
            $jumlahKriteria = count($kriteria);

            foreach ($kriteria as $kriteriaId => $nilai) {
                // Menghitung total nilai berdasarkan penilaian dan bobot
                $total += $nilai * $bobot[$kriteriaId];
            }

            // Simpan nilai total dalam array
            $nilaiTotal[$karyawanId] = $total;

            // Hitung rata-rata nilai
            $rataRata[$karyawanId] = $total / $jumlahKriteria;
        }

        // Mengurutkan karyawan berdasarkan nilai total (descending)
        arsort($nilaiTotal);

        // Membuat array peringkat berdasarkan urutan
        $peringkat = [];
        $rank = 1;

        $tanggal = Carbon::now()->format('Y-m-d');
        $divisi = $this->selectedDivisi;

        // foreach ($nilaiTotal as $karyawanId => $nilai) {
        //     $peringkat[$karyawanId] = [
        //         'karyawan_id' => $karyawanId,
        //         'tgl_penilaian' => $tanggal,
        //         'divisi' => $divisi,
        //         'peringkat' => $rank++,
        //         'nilai_total' => $nilai,
        //         'rata_rata' => number_format($rataRata[$karyawanId], 2, '.', ''),
        //     ];
        // }

        foreach ($nilaiTotal as $karyawanId => $nilai) {
            Penilaiandb::create([
                'karyawan_id' => $karyawanId,
                'tgl_penilaian' => $tanggal,
                'divisi' => $divisi,
                'peringkat' => $rank++,
                'nilai' => number_format($rataRata[$karyawanId], 2, '.', '')
            ]);
        }


        return redirect()->route('penilaian.index');
    }


    public function render()
    {
        return view('livewire.penilaian');
    }
}
