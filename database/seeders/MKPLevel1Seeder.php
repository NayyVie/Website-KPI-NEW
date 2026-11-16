<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MKPLevel1Seeder extends Seeder
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

        // Cari Level 1
        $level = MaturityLevel::where(
            'level',
            1
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Pengelolaan database penyedia telah dilakukan melalui salah satu SIT atau aplikasi VMS (Vendor Management System)',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Penilaian Kinerja Penyedia secara manual atau melalui aplikasi VMS (Vendor Management System)',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Monitoring hasil penilaian kinerja penyedia barang/jasa',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Survey Kepuasan Penyedia dilakukan secara manual atau melalui aplikasi VMS (Vendor Management System)',
                'deskripsi' => '*Pengukuran kepuasan penyedia dilakukan 1 kali dalam 1 tahun',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Pelaksanaan Supplier Gathering terpusat setiap tahun',
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
            'Kriteria MKP Level 1 Banjarsari berhasil disimpan.'
        );
    }
}
