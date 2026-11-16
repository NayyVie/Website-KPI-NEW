<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class SOLevel5Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area SO milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'SO'
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
                    'Tidak terdapat  selisih jumlah antara pengecekan fisik dan data',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Tidak terdapat penambahan jumlah barang tidak layak pakai (rusak, obsolete, atau expired) berdasarkan hasil stock opname',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Melakukan improvement berdasarkan evaluasi hasil stock opname untuk meningkatkan kegiatan pengelolaan pergudangan',
                'deskripsi' => '*Dapat berupa program yang bertujuan mempercepat pelayanan, meningkatkan perawatan terhadap barang yang disimpan, dan kelengkapan pencatatan material gudang',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Melaporkan dan menindak lanjuti kondisi barang/material tipe P (Rusak dapat diperbaiki), D (Deskripsi tidak tepat), T (Baik tidak dapat digunakan)',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Membuat usulan penghapusan atau pembursaan barang/material sesuai kriteria hasil stock opname kepada manajeman',
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
            'Kriteria SO Level 5 Banjarsari berhasil disimpan.'
        );
    }
}
