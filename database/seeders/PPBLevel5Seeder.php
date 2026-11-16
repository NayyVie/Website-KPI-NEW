<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class PPBLevel5Seeder extends Seeder
{
    public function run(): void
    {
        // Cari sub-area PPB milik Banjarsari
        $subArea = SubArea::where(
            'kode_sub_area',
            'PPB'
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
                    'Terdapat Tindak lanjut terhadap evaluasi proses pengelolaan transaksi barang di gudang',
                'deskripsi' => '*Tindak lanjut dapat berupa kegiatan yang meningkatkan pelayanan gudang dalam pengelolaan transaksi, seperti perawatan peralatan, meningkatkan 5S gudang, koordinasi dengan bidang terkait, serta kegiatan lain yang dapat menunjang progress implementasi Tata Laksana Pergudangan.',
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Penyelesaian tindak lanjut terhadap Evaluasi monitoring dan scheduling rencana kedatangan dan transaksi pengeluaran barang sudah dilakukan 100%',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Tidak terdapat material selisih jumlah dalam SIT akibat dari kesalahan penanganan saat penerimaan/pengeluaran barang di Gudang',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Melakukan improvement berkelanjutan berdasarkan evaluasi proses pengelolaan transaksi material untuk meningkatkan pelayanan gudang',
                'deskripsi' => '*Dapat berupa program yang bertujuan mempercepat pelayanan, meningkatkan penanganan barang, meningkatkan tata kelola administrasi gudang, serta program pendukung lain untuk mencapai KPI Service Level 100%.',
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Pengelolaan Penerimaan dan Pengeluaran Barang menjadi acuan/benchmark',
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
            'Kriteria PPB Level 5 Banjarsari berhasil disimpan.'
        );
    }
}
