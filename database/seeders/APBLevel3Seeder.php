<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class APBLevel3Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area APB milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'APB'
        )
        ->whereHas('unit', function ($query) {
            $query->where('nama_unit', 'Banjarsari');
        })
        ->firstOrFail();

        // Cari Level 3
        $level = MaturityLevel::where(
            'level',
            3
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Fungsi Pengelolaan dan penyimpanan barang sudah sesuai tata laksana pergudangan ≥80%',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Fungsi perawatan sudah berjalan sesuai rencana',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Dilakukan pengecekan kondisi material gudang',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Dilakukan pencatatan kondisi material gudang dan dilaporkan ke kantor pusat',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Melakukan monitoring terhadap material deadstock, obsolete, bekas pakai, dan material mendekati masa expired',
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
            'Kriteria APB Level 3 Banjarsari berhasil disimpan.'
        );
    }
}
