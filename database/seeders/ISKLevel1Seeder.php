<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class ISKLevel1Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area ISK milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'ISK'
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
                    'Rekomendasi item barang/material kontrak payung sesuai inventory policy',
                'deskripsi' => '- Rekap Usulan Kontrak Payung',
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Kontrak payung sesuai inventory policy sudah dibuat dan diimplementasikan sesuai rekomendasi ≥25%',
                'deskripsi' => '- Rekap hasil Kontrak Payung',
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Monitoring Kontrak Payung secara manual melalui MS. Office',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Kontrak payung yang telah dibuat diimplementasikan dengan melakukan delivery order',
                'deskripsi' => '- Efektifitas Implementasi Kontrak Payung ≥25% (Perhitungan berdasarkan kombinasi Quantity dan Item)',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Monitoring Delivery Order Kontrak Payung secara manual melalui MS. Office',
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
            'Kriteria ISK Level 1 Banjarsari berhasil disimpan.'
        );
    }
}
