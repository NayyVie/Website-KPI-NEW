<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class CatalogueLevel1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari sub-area Catalogue milik Banjarsari
        $subArea = SubArea::where('nama_sub_area', 'Catalogue')
            ->whereHas('unit', function ($query) {
                $query->where('nama_unit', 'Banjarsari');
            })
            ->firstOrFail();

        // 2. Cari Level 1
        $level = MaturityLevel::where('level', 1)
            ->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Data katalog terdokumentasi dalam SIT',
                'deskripsi' =>
                    '*Katalog dibuat tanpa pengecekan database dahulu, deskripsi tidak lengkap, penulisan deskripsi tidak menggunakan huruf kapital, penulisan klasifikasi tidak mengikuti basis Auslang dan NATO.',
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Data Katalog minimal terdiri dari Klasifikasi dan dua deskripsi/Attribute',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Standar penulisan spesifikasi belum lengkap. Standar Penulisan Spesifikasi  ≤ 80% dari total katalog',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Katalog menjadi acuan untuk pemenuhan  terhadap kebutuhan material ≤ 80% dari total pengadaan material pembangkit.',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Masih ada duplikasi dalam data katalog. Duplikasi ≤ 20% dari total katalog',
                'deskripsi' => null,
                'urutan' => 5,
            ],
        ];

        // 4. Simpan atau perbarui kriteria
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
            '5 kriteria Catalogue Level 1 Banjarsari berhasil disimpan.'
        );
    }
}