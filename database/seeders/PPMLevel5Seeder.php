<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class PPMLevel5Seeder extends Seeder
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

        // Cari Level 5
        $level = MaturityLevel::where(
            'level',
            5
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Monitoring dan pengendalian persediaan material sudah dilaksanakan secara rutin setiap 1 (satu) bulan, data terdokumen dan tersaji dengan baik, mudah diakses, lengkap dengan alokasi dan jadwal pemakaian, ada analisa dan evaluasi, dikomunikasikan ke bidang terkait, ada action plant  terhadap hasil analisa dan eveluasi',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Melakukan koordinasi dan tindak lanjut evaluasi kinerja hasil manajemen material dengan bidang terkait',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Tidak ada Deviasi pencapaian ITO bulanan terhadap target',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Menjadikan hasil evaluasi pencapaian target rencana persediaan dan implementasi Inventory Policy sebagai masukan dalam pelaksanaan pengelolaan persediaan pada periode berikutnya',
                'deskripsi' => '*Hasil evaluasi dapat dituliskan berupa Notulensi, Catatan Bidang, atau Lesson Learned',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Monitoring pemanfaatan Material Deadstock dengan prosentase penurunan nilai deadstock ≥30%',
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
            'Kriteria PPM Level 5 Banjarsari berhasil disimpan.'
        );
    }
}
