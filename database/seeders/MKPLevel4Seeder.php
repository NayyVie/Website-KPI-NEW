<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MKPLevel4Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area MKP milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'MKP'
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
                    'Terdapat Kualifikasi kompetensi penyedia dalam aplikasi VMS (Vendor Management System)',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Evaluasi hasil penilaian kinerja penyedia telah dilakukan melalui VMS (Vendor Management System)',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Monitoring tindak lanjut atas pembinaan yang dilakukan terhadap penyedia yang mempunyai reputasi/penilaian kurang baik dan penyedia yang telah diberikan surat peringatan',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Monitoring terhadap penyedia dengan status blacklist oleh PT PLN Nusantara Power Grup sudah dilakukan dan telah disosialisasikan kepada user',
                'deskripsi' => '*Pengukuran kepuasan penyedia dilakukan 2 kali dalam 1 tahun',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Evaluasi dan tindak lanjut hasil pengukuran kepuasan penyedia',
                'deskripsi' => '*Pengukuran kepuasan penyedia dilakukan 2 kali dalam 1 tahun
*Tindak lanjut hasil pengukuran kepuasan penyedia ≤75%',
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
            'Kriteria MKP Level 4 Banjarsari berhasil disimpan.'
        );
    }
}
