<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class APBLevel2Seeder extends Seeder
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

        // Cari Level 2
        $level = MaturityLevel::where(
            'level',
            2
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Mempersiapkan fasilitas dan peralatan gudang untuk melakukan fungsi penyimpanan sesuai dengan prosedur tata laksana pergudangan',
                'deskripsi' => '- Checklist Implementasi No 1 telah  terlaksana ≥70%',
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Pengamanan, Keselamatan dan Kenyamanan gudang sesuai dengan prosedur tata laksana pergudangan',
                'deskripsi' => '- Checklist Implementasi No 2 telah terlaksana ≥70%',
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Perawatan dan Penanganan Barang/Material sesuai dengan prosedur tata laksana pergudangan',
                'deskripsi' => '- Checklist Implementasi No 5 telah  terlaksana ≥70%',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Pelaksanaan proses pengelolaan penyimpanan material',
                'deskripsi' => '- Checklist Implementasi No 4 telah terlaksana ≥70%',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Penanganan Barang/Material Bekas Pakai sesuai dengan prosedur tata laksana pergudangan',
                'deskripsi' => '- Checklist Implementasi No 7 telah terlaksana ≥70%',
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
            'Kriteria APB Level 2 Banjarsari berhasil disimpan.'
        );
    }
}
