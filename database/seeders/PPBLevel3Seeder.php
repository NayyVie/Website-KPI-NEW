<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class PPBLevel3Seeder extends Seeder
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

        // Cari Level 3
        $level = MaturityLevel::where(
            'level',
            3
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Evaluasi terhadap Monitoring dan scheduling rencana kedatangan barang di gudang sudah dilaksanakan secara periodik',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Dilakukan penjadwalan penerimaan/pengeluaran barang secara fisik berdasarkan monitoring PO dan Picking Slip dalam SIT, sehingga penanganan barang dapat dilakukan sesuai prosedur tata laksana gudang',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Penerimaan dilakukan pencatatan secara sistem SIT, sudah dilengkapi dokumen pendukung penerimaan barang di gudang (Berita Acara Penerimaan Barang) dan dicatatkan pada kartu gantung',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Setiap pengeluaran barang dilakukan pencatatan secara sistem SIT dan sudah dilengkapi dengan picking slip atau MR (Material manual requisition) dan dicatatkan pada kartu gantung',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Pengembalian barang secara fisik sudah dilakukan, dicatatkan secara sistem SIT, sudah dilengkapi dengan dokumen pengembalian barang dan dicatatkan pada kartu gantung dan diberikan label status material sesuai dengan prosedur tata laksana pergudangan',
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
            'Kriteria PPB Level 3 Banjarsari berhasil disimpan.'
        );
    }
}
