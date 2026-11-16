<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MPPELevel5Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area MPPE milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'MPPE'
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
                    'Evaluasi dan tindak lanjut monitoring proses pengadaan sudah dilakukan melalui Aplikasi Monitoring Pengadaan Online, terdapat ringkasan proses pengadaan dan sudah terdokumentasi dalam SIT ≤ 100%',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Usulan Pengadaan Terkontrak dan terdokumentasi dalam SIT sesuai dengan timeline pengadaan 100% dari total usulan pengadaan dan terdapat continuous improvement',
                'deskripsi' => '*Nilai Purchase Effectiveness (PO/PR) = 100%',
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Melakukan perhitungan Efisiensi BPP ( X ≤ 6%)',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Hasil evaluasi proses pengadaan barang/jasa menjadi masukan improvement dalam proses pengadaan barang/jasa sejenis berikutnya',
                'deskripsi' => '*Dapat berupa Lesson Learned dari kendala proses pengadaan beserta improvement yang dilakukan',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Monitoring terhadap proses pengadaan dapat dijadikan benchmarking/acuan',
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
            'Kriteria MPPE Level 5 Banjarsari berhasil disimpan.'
        );
    }
}
