<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class PPBLevel4Seeder extends Seeder
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

        // Cari Level 4
        $level = MaturityLevel::where(
            'level',
            4
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Sudah dilakukan tindak lanjut terhadap Evaluasi monitoring dan scheduling rencana kedatangan dan transaksi pengeluaran barang, Penyelesaian tindak lanjut ≤75%',
                'deskripsi' => '*Dapat berdasarkan realisasi jadwal penerimaan/pengeluaran barang, jumlah barang dalam SIT, kondisi barang setelah penanganan pemindahan akibat transaksi, kondisi peralatan penangangan barang dan pergudangan, serta faktor pergudangan lain untuk menunjang pelayanan gudang',
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Penerimaan dilakukan pencatatan secara sistem SIT, sudah dilengkapi dokumen pendukung penerimaan barang di gudang (Berita Acara Penerimaan Barang), dicatatkan pada kartu gantung, dan ditempatkan sesuai dengan bin location',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Setiap pengeluaran barang dilakukan pencatatan secara sistem SIT dan sudah dilengkapi dengan picking slip atau MR (Material manual requisition), dicatatkan pada kartu gantung dan ditempatkan pada area ekspor',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Pengembalian barang secara fisik sudah dilakukan, dicatatkan secara sistem SIT, sudah dilengkapi dengan dokumen pengembalian barang, dicatatkan pada kartu gantung, diberikan label status material sesuai dengan prosedur tata laksana pergudangan dan dilakukan pemisahan penyimpanan sesuai dengan label status',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Dilakukan evaluasi proses pengelolaan transaksi barang di gudang',
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
            'Kriteria PPB Level 4 Banjarsari berhasil disimpan.'
        );
    }
}
