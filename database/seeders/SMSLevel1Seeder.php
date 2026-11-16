<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class SMSLevel1Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area SMS milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'SMS'
        )
        ->whereHas('unit', function ($query) {
            $query->where('nama_unit', 'Banjarsari');
        })
        ->firstOrFail();

        // Cari Level 1
        $level = MaturityLevel::where(
            'level',
            1
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Pelaksanaan Workshop Inventory Policy Setiap Awal Semester',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Menyusun Laporan Hasil Workshop Inventory Policy dan rekomendasi kontrak payung yang telah ditanda tangain atasan setara manajer dan dikirim melalui OA ke Kantor Pusat bulan pertama pada awal semester',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Implementasi setting ROP/EOQ dan ABC Analisis pada SIT, ≤ 60% dari rekomendasi Inventory Policy',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Akurasi setting ROP/EOQ dan ABC Analisis pada SIT ≤ 60%',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Konsistensi setting ROP/EOQ dan ABC Analisis pada SIT ≤ 60%',
                'deskripsi' => null,
                'urutan' => 5,
            ],
        ];

        foreach ($kriterias as $kriteria) {
            Criterion::updateOrCreate(
                [
                    'sub_area_id' => $subArea->id,
                    'maturity_level_id' => $level->id,
                    'kode_kriteria' => $kriteria['kode_kriteria'],
                ],
                [
                    'nama_kriteria' => $kriteria['nama_kriteria'],
                    'deskripsi' => $kriteria['deskripsi'],
                    'urutan' => $kriteria['urutan'],
                ]
            );
        }

        $this->command->info(
            'Kriteria SMS Level 1 Banjarsari berhasil disimpan.'
        );
    }
}
