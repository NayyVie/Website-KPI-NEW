<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class ISKLevel4Seeder extends Seeder
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

        // Cari Level 4
        $level = MaturityLevel::where(
            'level',
            4
        )->firstOrFail();

        $kriterias = [
            [
                'kode_kriteria' => '1',
                'nama_kriteria' =>
                    'Kontrak payung sesuai inventory policy sudah dibuat dan diimplementasikan sesuai rekomendasi ≥80%',
                'deskripsi' => '- Rekapan hasil Kontrak Payung',
                'urutan' => 1,
            ],
            [
                'kode_kriteria' => '2',
                'nama_kriteria' =>
                    'Melakukan koordinasi dan tindak lanjut atas monitoring jangka waktu berakhirnya kontrak payung untuk meningkatkan efektifitas kontrak payung (tindak lanjut ≤80%)',
                'deskripsi' => null,
                'urutan' => 2,
            ],
            [
                'kode_kriteria' => '3',
                'nama_kriteria' =>
                    'Kontrak payung yang telah dibuat diimplementasikan dengan melakukan delivery order',
                'deskripsi' => '- Efektifitas Implementasi Kontrak Payung ≥80% ',
                'urutan' => 3,
            ],
            [
                'kode_kriteria' => '4',
                'nama_kriteria' =>
                    'Monitoring, Evaluasi dan tindak lanjut terhadap Delivery Order terkait ketepatan waktu pengiriman barang dan terselesaikan ≤75%',
                'deskripsi' => null,
                'urutan' => 4,
            ],
            [
                'kode_kriteria' => '5',
                'nama_kriteria' =>
                    'Delivery Order terdokumentasi tepat waktu dalam SIT sesuai timeline prosed delivery order',
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
            'Kriteria ISK Level 4 Banjarsari berhasil disimpan.'
        );
    }
}
