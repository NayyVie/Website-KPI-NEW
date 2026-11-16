<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class PPBLevel1Seeder extends Seeder
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

        // Cari Level 1
        $level = MaturityLevel::where(
            'level',
            1
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Monitoring dan scheduling rencana kedatangan barang di gudang sudah dilaksanakan belum secara periodik',
                'deskripsi' => null,
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Pemilahan /pemisahan secara fisik terhadap material/barang sedang dalam proses transaksi sudah dilakukan',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Penerimaan, pengeluaran dan pengembalian barang dilakukan pencatatan secara sistem SIT',
                'deskripsi' => null,
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Waktu proses penerimaan barang dari penyedia sampai dengan berita acara pemeriksaan tepat waktu (Maksimal 14 Hari Kalender)',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Fungsi Ruang Penerimaan Barang (Import Area) dan Ruang Pengeluaran Barang (Export Area) Sudah Tersedia',
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
            'Kriteria PPB Level 1 Banjarsari berhasil disimpan.'
        );
    }
}
