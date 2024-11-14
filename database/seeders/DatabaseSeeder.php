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
        User::create([
            'name' => 'HRD',
            'role' => 'hrd',
            'username' => 'hrd',
            'password' => Hash::make('123'),
        ]);
        User::create([
            'name' => 'Pimpinan',
            'role' => 'pimpinan',
            'username' => 'pimpinan',
            'password' => Hash::make('123'),
        ]);

        $karyawan = [
            [
                'nama' => 'Hanny',
                'divisi' => 'IT'
            ],
            [
                'nama' => 'Farhan',
                'divisi' => 'IT'
            ],
            [
                'nama' => 'Desi',
                'divisi' => 'IT'
            ],
            [
                'nama' => 'Amelia',
                'divisi' => 'IT'
            ],
            [
                'nama' => 'Kevin',
                'divisi' => 'IT'
            ],
            [
                'nama' => 'Alda',
                'divisi' => 'Marketing'
            ],
            [
                'nama' => 'Devi',
                'divisi' => 'Marketing'
            ],
            [
                'nama' => 'Dian',
                'divisi' => 'Marketing'
            ],
            [
                'nama' => 'Anto',
                'divisi' => 'Marketing'
            ],
            [
                'nama' => 'Abi',
                'divisi' => 'Marketing'
            ],
            [
                'nama' => 'Imam',
                'divisi' => 'Operasional'
            ],
            [
                'nama' => 'Ridwan',
                'divisi' => 'Operasional'
            ],
            [
                'nama' => 'Dewi',
                'divisi' => 'Operasional'
            ],
            [
                'nama' => 'Amar',
                'divisi' => 'Operasional'
            ],
            [
                'nama' => 'Sari',
                'divisi' => 'Operasional'
            ],
            [
                'nama' => 'Zaki',
                'divisi' => 'Manajemen Resiko'
            ],
            [
                'nama' => 'Rizki',
                'divisi' => 'Manajemen Resiko'
            ],
            [
                'nama' => 'Ridho',
                'divisi' => 'Manajemen Resiko'
            ],
            [
                'nama' => 'Zize',
                'divisi' => 'Manajemen Resiko'
            ],
            [
                'nama' => 'Shella',
                'divisi' => 'Manajemen Resiko'
            ],
            [
                'nama' => 'Wisnu',
                'divisi' => 'Audit'
            ],
            [
                'nama' => 'Adit',
                'divisi' => 'Audit'
            ],
            [
                'nama' => 'Loli',
                'divisi' => 'Audit'
            ],
            [
                'nama' => 'Vadel',
                'divisi' => 'Audit'
            ],
            [
                'nama' => 'Mayang',
                'divisi' => 'Audit'
            ],
            [
                'nama' => 'Ibrahim',
                'divisi' => 'Pembiayaan'
            ],
            [
                'nama' => 'Dora',
                'divisi' => 'Pembiayaan'
            ],
            [
                'nama' => 'Ryan',
                'divisi' => 'Pembiayaan'
            ],
            [
                'nama' => 'Torik',
                'divisi' => 'Pembiayaan'
            ],
            [
                'nama' => 'Aliyah',
                'divisi' => 'Pembiayaan'
            ],
        ];

        foreach ($karyawan as $k) {
            Karyawan::create([
                'nama' => $k['nama'],
                'divisi' => $k['divisi'],
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
                'nama' => 'Tekanan Waktu',
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
            // Sub-kriteria untuk Kriteria C1
            [
                'kriteria_id' => 1, // Kriteria 'Tingkat Pendidikan'
                'kode' => 'C1.1',
                'rentang' => 'SMA/SMK',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.2',
                'rentang' => 'D3/S1',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.3',
                'rentang' => 'S1/S2',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2, // Kriteria 'Kompetensi'
                'kode' => 'C2.1',
                'rentang' => '<81',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.2',
                'rentang' => '81-90',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.3',
                'rentang' => '91-100',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-kriteria untuk Kriteria C3
            [
                'kriteria_id' => 3, // Kriteria 'Tekanan Waktu'
                'kode' => 'C3.1',
                'rentang' => '1-5',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.2',
                'rentang' => '6-12',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.3',
                'rentang' => '≥12',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-kriteria untuk Kriteria C4
            [
                'kriteria_id' => 4, // Kriteria 'Absensi'
                'kode' => 'C4.1',
                'rentang' => '75-80%',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.2',
                'rentang' => '81-85%',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.2',
                'rentang' => '≥85%',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-kriteria untuk Kriteria C5
            [
                'kriteria_id' => 5, // Kriteria 'Tanggung Jawab'
                'kode' => 'C5.1',
                'rentang' => 'Rendah',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 5,
                'kode' => 'C5.2',
                'rentang' => 'Sedang',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 5,
                'kode' => 'C5.3',
                'rentang' => 'Tinggi',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Menyimpan data ke tabel sub_kriteria
        foreach ($subKriteria as $sk) {
            SubKriteria::create([
                'kriteria_id' => $sk['kriteria_id'],
                'kode' => $sk['kode'],
                'rentang' => $sk['rentang'],
                'bobot' => $sk['bobot'],
            ]);
        }
    }
}
