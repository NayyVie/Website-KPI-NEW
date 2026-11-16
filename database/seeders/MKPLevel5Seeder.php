<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MKPLevel5Seeder extends Seeder
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

        // Cari Level 5
        $level = MaturityLevel::where(
            'level',
            5
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Penerapan Kualifikasi kompetensi penyedia dalam aplikasi VMS (Vendor Management System) terhadap usulan proses pengadaan',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Raport Hasil penilaian kinerja telah disampaikan kepada penyedia dan terdokumentasi dalam VMS (Vendor Management System)',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Evaluasi dan tindak lanjut hasil pengukuran kepuasan penyedia',
                'deskripsi' => '*Pengukuran kepuasan penyedia dilakukan 2 kali dalam 1 tahun
*Tindak lanjut hasil pengukuran kepuasan penyedia ≤100%',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Monitoring terhadap penyedia dengan status blacklist oleh PT PLN Nusantara Power Grup sudah dilakukan melalui VMS (Vendor Management System) dan telah disosialisasikan kepada user',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Proses pengelolaan penyedia menjadi acuan/becnhmark',
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
            'Kriteria MKP Level 5 Banjarsari berhasil disimpan.'
        );
    }
}
