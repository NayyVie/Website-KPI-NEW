<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class PPMLevel4Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area PPM milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'PPM'
        )
        ->whereHas('unit', function ($query) {
            $query->where('nama_unit', 'Banjarsari');
        })
        ->firstOrFail();

        // Cari Level 4
        $level = MaturityLevel::where(
            'level',
            4
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Monitoring dan pengendalian persediaan material sudah dilaksanakan secara rutin setiap 1 (satu) bulan, data terdokumen dan tersaji dengan baik, mudah diakses, lengkap dengan alokasi dan jadwal pemakaian',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Melakukan Evaluasi kinerja hasil manajemen material pada laporan manajemen material',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Melakukan review realisasi persediaan dengan rencana persediaan bulanan Deviasi pencapaian ITO bulanan ≤10%',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Realisasi nilai Inventory Akhir Tahun >100% terhadap target',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Monitoring pemanfaatan Material Deadstock dengan prosentase penurunan nilai deadstock ≥10%',
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
            'Kriteria PPM Level 4 Banjarsari berhasil disimpan.'
        );
    }
}
