<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MPPELevel1Seeder extends Seeder
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

        // Cari Level 1
        $level = MaturityLevel::where(
            'level',
            1
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Monitoring proses pengadaan sudah dilakukan secara manual dan computerized',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Media informasi terkait pengadaan barang/jasa sudah ada melalui Web atau Media Lainnya',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Sudah dibuat Checklist dokumen proses pengadaan barang/jasa',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Pembuatan PO/SPK/Kontrak Perjanjian dalam SIT sesuai dengan Kontrak Pengadaan Barang/Jasa',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Pembuatan dokumen pengadaan dilakukan secara computerized (Masih menggunakan MS. Office)',
                'deskripsi' => '*Berita Acara proses pengadaan',
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
            'Kriteria MPPE Level 1 Banjarsari berhasil disimpan.'
        );
    }
}
