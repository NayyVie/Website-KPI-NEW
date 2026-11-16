<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MPBJLevel2Seeder extends Seeder
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

        // Cari Level 2
        $level = MaturityLevel::where(
            'level',
            2
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Setiap Usulan permintaan pengadaan barang/jasa sudah dibuatkan Usulan Pengadaan Melalui SIT  ≤ 70%',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Masih ada Usulan Permintaan Pengadaan yang dikembalikan kepada user ≤ 10% karena Dokumen Pendukung (TOR, RAB) kurang lengkap',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Masih ada Usulan Pengadaan kepada inventory/perencana pengadaan yang dikembalikan ≤ 10% karena Dokumen Pendukung Usulan pengadaan kurang lengkap',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Monitoring dan evaluasi Usulan pengadaan sudah dilaksanakan dan terdokumentasi',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Usulan Pengadaan masuk ke fungsi pelaksana pengadaan sesuai dengan timeline pengadaan ≤ 65% dari total usulan pengadaan',
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
            'Kriteria MPBJ Level 2 Banjarsari berhasil disimpan.'
        );
    }
}
