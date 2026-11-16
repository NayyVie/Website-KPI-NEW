<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class PPMLevel1Seeder extends Seeder
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

        // Cari Level 1
        $level = MaturityLevel::where(
            'level',
            1
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Melakukan pengelolaan dan pengendalian persediaan material',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Melakukan penyusunan proyeksi Rencana Persediaan dan mengirimkan ke kantor pusat pada bulan Januari',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Laporan Manajemen Material Telah dibuat setiap bulan ditanda tangani atasan setara manajer dan dikirimkan melalui OA selambat-lambatnya Minggu pertama bulan berikutnya',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Melakukan review realisasi persediaan dengan rencana persediaan bulanan Deviasi pencapaian ITO bulanan ≤70%',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Realisasi nilai Inventory Akhir Tahun ≤80% terhadap target',
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
            'Kriteria PPM Level 1 Banjarsari berhasil disimpan.'
        );
    }
}
