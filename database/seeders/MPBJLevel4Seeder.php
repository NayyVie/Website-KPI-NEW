<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MPBJLevel4Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area MPBJ milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'MPBJ'
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
                    'Setiap Usulan permintaan pengadaan barang/jasa sudah dibuatkan Usulan Pengadaan Melalui SIT  ≤ 90%',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Tidak ada Usulan Permintaan Pengadaan yang dikembalikan kepada user Dokumen Pendukung sudah lengkap',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Tidak ada Usulan Pengadaan yang dikembalikan kepada inventory/perencana pengadaan',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Analisa proses perencanaan usulan pengadaan sudah dilaksanakan dan terdokumentasi',
                'deskripsi' => '*Rekap Analisa proses perencanaan usulan pengadaan',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Usulan Pengadaan masuk ke fungsi pelaksana pengadaan sesuai dengan timeline pengadaan ≤ 90% dari total usulan pengadaan',
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
            'Kriteria MPBJ Level 4 Banjarsari berhasil disimpan.'
        );
    }
}
