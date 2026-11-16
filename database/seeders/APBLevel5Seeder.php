<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class APBLevel5Seeder extends Seeder
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

        // Cari Level 5
        $level = MaturityLevel::where(
            'level',
            5
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Fungsi Pengelolaan dan penyimpanan barang sudah sesuai tata laksana pergudangan 100%',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Dilakukan pencatatan kondisi material gudang dalam SIT 100% ',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Melakukan tindak lanjut terhadap evaluasi monitoring material deadstock, obsolete, bekas pakai, dan material mendekati masa expired',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Tidak terdapat material rusak atau selisih jumlah dalam SIT akibat kesalahan penyimpanan',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Ada inovasi terhadap fasilitas gudang',
                'deskripsi' => '*Dapat berupa program yang bertujuan mempercepat pelayanan, meningkatkan perawatan terhadap barang yang disimpan, dan kelengkapan pencatatan material gudang.',
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
            'Kriteria APB Level 5 Banjarsari berhasil disimpan.'
        );
    }
}
