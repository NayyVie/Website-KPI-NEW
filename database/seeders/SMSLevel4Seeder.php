<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class SMSLevel4Seeder extends Seeder
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

        // Cari Level 4
        $level = MaturityLevel::where(
            'level',
            4
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Implementasi setting ROP/EOQ dan ABC Analisis pada SIT, ≤ 90% dari rekomendasi Inventory Policy',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Akurasi setting ROP/EOQ dan ABC Analisis pada SIT, ≤ 90%',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Konsistensi setting ROP/EOQ dan ABC Analisis pada SIT, ≤ 90%',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Melakukan koordinasi lintas bidang terkait pemenuhan material setting ROP/EOQ',
                'deskripsi' => '*Pemenuhan pelayanan terhadap permintaan material (Service Level) >95%',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Menjadikan hasil evaluasi pencapaian implementasi Inventory Policy sebagai masukan dalam pelaksanaan pengelolaan persediaan pada periode berikutnya',
                'deskripsi' => '*Hasil evaluasi dapat dituliskan berupa Notulensi, Catatan Bidang, atau Lesson Learned',
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
            'Kriteria SMS Level 4 Banjarsari berhasil disimpan.'
        );
    }
}
