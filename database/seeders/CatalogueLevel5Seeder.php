<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class CatalogueLevel5Seeder extends Seeder
{
    public function run(): void
    {
        // Cari Catalogue milik unit Banjarsari
        $subArea = SubArea::where('nama_sub_area', 'Catalogue')
            ->whereHas('unit', function ($query) {
                $query->where('nama_unit', 'Banjarsari');
            })
            ->firstOrFail();

        // Cari Level 5
        $level = MaturityLevel::where('level', 5)
            ->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Tidak ada duplikasi dalam database katalog',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Penyusunan Pedoman Standarisasi penulisan katalog minimal 20 jenis klasifikasi material',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Pengelolaan Katalog sudah 100% dan dilakukan evaluasi hasil pengelolaan katalog terhadap rencana perbaikan pada priode berjalan',
                'deskripsi' => '*Data yang dapat menjadi acuan antara lain terkait dengan kelengkapan detail spesifikasi, duplikasi katalog, dan ratio PO Stock untuk material pembangkit.',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Improvement dalam penyempurnaan katalog (baru/lama) yang didukung dengan referensi best practice',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Database dan Standar penulisan spesifikasi katalog menjadi benchmarking/acuan terhadap penulisan katalog',
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
            '5 kriteria Catalogue Level 5 Banjarsari berhasil disimpan.'
        );
    }
}
