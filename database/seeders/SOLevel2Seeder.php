<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class SOLevel2Seeder extends Seeder
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

        // Cari Level 2
        $level = MaturityLevel::where(
            'level',
            2
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Pemeriksaan dan pengecekan secara harian terhadap kesesuaian antara jumlah material secara fisik dan catatan/ sistem untuk material / barang yang ada transaksi pada hari itu sudah dilaksanakan',
                'deskripsi' => '*Checklist Implementasi No 8.1 terlaksana ≥80%',
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Melakukan penelusuran dan penyelesaian penyebab selisih atas pengecekan secara harian transaksi pada hari itu',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Pemeriksaan dan pengecekan secara tahunan terhadap kesesuaian antara jumlah material secara fisik dan catatan/ sistem untuk material / barang yang ada transaksi sudah dilaksanakan, baik secara jumlah dan kondisi material',
                'deskripsi' => '*Checklist Implementasi No 8.2 terlaksana ≥80%',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Penelusuran penyebab selisih atas pengecekan secara tahunan sudah dilaksanakan ≥80%',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Menyusun Berita Acara Stock Opname secara sistematis sesuai dengan hasil pengecekan jumlah dan kondisi fisik barang di gudang dan dilaporkan kepada manajemen unit dan kantor pusat',
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
            'Kriteria SO Level 2 Banjarsari berhasil disimpan.'
        );
    }
}
