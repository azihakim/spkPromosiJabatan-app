<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Data;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // User::create([
        //     'name' => 'Admin',
        //     'role' => 'Admin',
        //     'username' => 'admin',
        //     'password' => Hash::make('123'),
        // ]);

        $karyawan = [
            [
                'nama' => 'Anwar Zemmi',
                'jabatan' => 'Kantor'
            ],
            [
                'nama' => 'Faisal Riza',
                'jabatan' => 'Lapangan'
            ],
            [
                'nama' => 'M. Lendra',
                'jabatan' => 'Kantor'
            ],
            [
                'nama' => 'Nicolas Alex',
                'jabatan' => 'Lapangan'
            ],
        ];

        foreach ($karyawan as $k) {
            Karyawan::create([
                'nama' => $k['nama'],
                'jabatan' => $k['jabatan'],
            ]);
        }

        $kriteria = [
            [
                'nama' => 'Tingkat Pendidikan',
                'kode' => 'C1',
            ],
            [
                'nama' => 'Kompetensi',
                'kode' => 'C2',
            ],
            [
                'nama' => 'Upaya Fisik dan Tekanan Waktu',
                'kode' => 'C3',
            ],
            [
                'nama' => 'Absensi',
                'kode' => 'C4',
            ],
            [
                'nama' => 'Tanggung Jawab',
                'kode' => 'C5',
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create([
                'nama' => $k['nama'],
                'kode' => $k['kode'],
            ]);
        }


        $subKriteria = [
            [
                'kriteria_id' => 1,
                'nama' => 'Kehadiran',
                'bobot' => 50,
                'penilaian' => json_encode([
                    ["rentang" => "Hadir > 90%", "skor" => 3],
                    ["rentang" => "Hadir 75% - 90%", "skor" => 2],
                    ["rentang" => "Hadir < 75%", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 1,
                'nama' => 'Keterlambatan',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "<2X", "skor" => 3],
                    ["rentang" => "2-4X", "skor" => 2],
                    ["rentang" => ">4X", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 1,
                'nama' => 'Izin',
                'bobot' => 20,
                'penilaian' => json_encode([
                    ["rentang" => "Tidak Pernah", "skor" => 3],
                    ["rentang" => "1-5x izin dengan keterangan", "skor" => 2],
                    ["rentang" => ">4x izin/tanpa keterangan", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Penyelesaian Tugas',
                'bobot' => 50,
                'penilaian' => json_encode([
                    ["rentang" => "Menyelesaikan semua tugas tepat waktu dan sesuai instruksi", "skor" => 3],
                    ["rentang" => "Menyelesaikan sebagian besar tugas tepat waktu", "skor" => 2],
                    ["rentang" => "Tidak menyelesaikan tugas atau sering terlambat", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Kualitas Kerja',
                'bobot' => 25,
                'penilaian' => json_encode([
                    ["rentang" => "Kualitas kerja baik, sangat sedikit atau tidak ada kesalahan", "skor" => 3],
                    ["rentang" => "Kualitas kerja cukup, beberapa kesalahan", "skor" => 2],
                    ["rentang" => "Kualitas kerja buruk, banyak kesalahan", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Inisiatif',
                'bobot' => 25,
                'penilaian' => json_encode([
                    ["rentang" => "Sering menunjukkan inisiatif", "skor" => 3],
                    ["rentang" => "Kadang-kadang menunjukkan inisiatif", "skor" => 2],
                    ["rentang" => "Tidak pernah menunjukkan inisiatif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Pengambilan Keputusan',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu mampu mengambil keputusan yang efektif", "skor" => 3],
                    ["rentang" => "Kadang-kadang mampu mengambil keputusan yang efektif", "skor" => 2],
                    ["rentang" => "Tidak mampu mengambil keputusan yang efektif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Komunikasi',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu mampu berkomunikasi dengan jelas dan efektif", "skor" => 3],
                    ["rentang" => "Kadang-kadang mampu berkomunikasi dengan jelas dan efektif", "skor" => 2],
                    ["rentang" => "Kurang mampu berkomunikasi dengan jelas dan efektif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Pemecahan Masalah',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu mampu memecahkan masalah dengan baik", "skor" => 3],
                    ["rentang" => "Kadang-kadang mampu memecahkan masalah dengan baik", "skor" => 2],
                    ["rentang" => "Tidak mampu memecahkan masalah dengan baik", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Efisiensi Waktu',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu efisien dan tidak terganggu", "skor" => 3],
                    ["rentang" => "Kadang-kadang efisien, tetapi sering mengalami gangguan", "skor" => 2],
                    ["rentang" => "Sering membuang waktu atau tidak efisien", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Ketepatan Waktu',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu tepat waktu dan memenuhi tenggat waktu", "skor" => 3],
                    ["rentang" => "Kadang-kadang tepat waktu, tetapi ada kasus telat", "skor" => 2],
                    ["rentang" => "Sering telat atau tidak menepati tenggat waktu", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Kreativitas',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu memberikan ide kreatif dan inovatif", "skor" => 3],
                    ["rentang" => "Kadang-kadang memberikan ide kreatif", "skor" => 2],
                    ["rentang" => "Tidak pernah memberikan ide kreatif atau inovatif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Kelengkapan Laporan',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Lengkap, semua informasi yang diperlukan ada", "skor" => 3],
                    ["rentang" => "Cukup lengkap, namun masih kurang beberapa informasi penting", "skor" => 2],
                    ["rentang" => "Tidak lengkap, banyak informasi yang hilang", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Pengumpulan Laporan Tepat Waktu',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu tepat waktu dalam pengumpulan laporan", "skor" => 3],
                    ["rentang" => "Kadang-kadang tepat waktu, namun sering terlambat", "skor" => 2],
                    ["rentang" => "Sering terlambat mengumpulkan laporan", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Kejelasan Laporan',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Sangat jelas, mudah dipahami", "skor" => 3],
                    ["rentang" => "Cukup jelas, tetapi masih memerlukan penjelasan lebih lanjut", "skor" => 2],
                    ["rentang" => "Tidak jelas, sulit dipahami", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 6,
                'nama' => 'Respon terhadap Kritik',
                'bobot' => 60,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu menerima kritik dengan baik", "skor" => 3],
                    ["rentang" => "Kadang-kadang menerima kritik dengan baik", "skor" => 2],
                    ["rentang" => "Tidak menerima kritik dengan baik", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 6,
                'nama' => 'Etika',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Etika sangat baik", "skor" => 3],
                    ["rentang" => "Etika cukup baik", "skor" => 2],
                    ["rentang" => "Etika kurang baik", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 7,
                'nama' => 'Tanggung Jawab',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu bertanggung jawab bersama", "skor" => 3],
                    ["rentang" => "Kadang-kadang bertanggung jawab bersama", "skor" => 2],
                    ["rentang" => "Kurang bertanggung jawab bersama", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 7,
                'nama' => 'Partisipasi Aktif',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu aktif dalam kegiatan kantor", "skor" => 3],
                    ["rentang" => "Kadang-kadang aktif dalam kegiatan kantor", "skor" => 2],
                    ["rentang" => "Tidak aktif dalam kegiatan kantor", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 7,
                'nama' => 'Kepedulian terhadap Rekan',
                'bobot' => 20,
                'penilaian' => json_encode([
                    ["rentang" => "Sangat peduli terhadap rekan kerja", "skor" => 3],
                    ["rentang" => "Cukup peduli terhadap rekan kerja", "skor" => 2],
                    ["rentang" => "Kurang peduli terhadap rekan kerja", "skor" => 1],
                ]),
            ]
        ];

        // Menyimpan data ke tabel sub_kriteria dan penilaian
        // foreach ($subKriteria as $sk) {
        //     $subKriteria = SubKriteria::create([
        //         'kriteria_id' => $sk['kriteria_id'],
        //         'nama' => $sk['nama'],
        //         'bobot' => $sk['bobot'],
        //         'penilaian' => $sk['penilaian'],
        //     ]);
        // }
    }
}
