<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MPPELevel2Seeder extends Seeder
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

        // Cari Level 2
        $level = MaturityLevel::where(
            'level',
            2
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Monitoring pengadaan sudah dilakukan melalui Aplikasi Monitoring Pengadaan Online',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Media informasi terkait pengadaan barang/jasa sudah ada melalui Web dan Media Lainnya',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Usulan Pengadaan Terkontrak dan terdokumentasi dalam SIT sesuai dengan timeline pengadaan ≤ 65% dari total usulan pengadaan',
                'deskripsi' => '- Nilai Purchase Effectiveness (PO/PR) = 50% ≤ X≤ 65%',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Melakukan koordinasi dan komunikasi dengan bidang terkait untuk meningkatkan kinerja proses pengadaan barang/jasa',
                'deskripsi' => '*Pelaksanaan koordinasi dan komunikasi dilakukan 1 kali dalam 3 bulan',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Melakukan perhitungan Efisiensi BPP ( X ≤ 3%)',
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
            'Kriteria MPPE Level 2 Banjarsari berhasil disimpan.'
        );
    }
}
