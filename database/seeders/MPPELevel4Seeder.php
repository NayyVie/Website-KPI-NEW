<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MPPELevel4Seeder extends Seeder
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

        // Cari Level 4
        $level = MaturityLevel::where(
            'level',
            4
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Evaluasi dan tindak lanjut monitoring proses pengadaan sudah dilakukan melalui Aplikasi Monitoring Pengadaan Online, terdapat ringkasan proses pengadaan dan sudah terdokumentasi dalam SIT ≤ 75%',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Pelaksanaan Proses Pengadaan, yang diwajibkan dalam pedoman CSMS PT PLN NP, telah menerapkan program CSMS dengan melakukan input data proses dalam aplikasi CSMS',
                'deskripsi' => '- Rekap data pengadaan yang diwajibkan memiliki CSMS',
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Usulan Pengadaan Terkontrak dan terdokumentasi dalam SIT sesuai dengan timeline pengadaan ≤ 100% dari total usulan pengadaan',
                'deskripsi' => '- Nilai Purchase Effectiveness (PO/PR) = 85% ≤ X≤ 100%',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Melakukan koordinasi dan komunikasi dengan bidang terkait untuk meningkatkan kinerja proses pengadaan barang/jasa',
                'deskripsi' => '*Pelaksanaan koordinasi dan komunikasi dilakukan 1 kali dalam 1 bulan',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Melakukan perhitungan Efisiensi BPP ( X ≤5%)',
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
            'Kriteria MPPE Level 4 Banjarsari berhasil disimpan.'
        );
    }
}
