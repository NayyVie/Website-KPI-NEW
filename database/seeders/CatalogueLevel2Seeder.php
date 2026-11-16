<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class CatalogueLevel2Seeder extends Seeder
{
    public function run(): void
    {
        // Cari Catalogue milik unit Banjarsari
        $subArea = SubArea::where('nama_sub_area', 'Catalogue')
            ->whereHas('unit', function ($query) {
                $query->where('nama_unit', 'Banjarsari');
            })
            ->firstOrFail();

        // Cari Level 2
        $level = MaturityLevel::where('level', 2)
            ->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Data Katalog minimal terdiri dari Klasifikasi, dua deskripsi/Attribute dan additional information',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Standar penulisan spesifikasi belum lengkap. Standar Penulisan Spesifikasi  ≤ 90% dari total katalog',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Katalog menjadi acuan untuk pemenuhan  terhadap kebutuhan dengan membandingkan jumlah barang stock dengan barang non stock. Pemenuhan terhadap kebutuhan ≤ 90%',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Masih ada duplikasi dalam data katalog. Duplikasi ≤ 10% dari total katalog',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Pengelolaan Katalog sudah dilakukan untuk proses perbaikan data spesifikasi katalog ≤ 50% dari total katalog',
                'deskripsi' =>
                    '*Dapat berupa  pelaksanaan pengurangan duplikasi, melengkapi deskripsi katalog, perbaikan klasifikasi data katalog.',
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
            '5 kriteria Catalogue Level 2 Banjarsari berhasil disimpan.'
        );
    }
}
