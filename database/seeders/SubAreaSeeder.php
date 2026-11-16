<?php

namespace Database\Seeders;

use App\Models\SubArea;
use Illuminate\Database\Seeder;

class SubAreaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['CAT', 'Catalogue'],
            ['MPBJ', 'Mengelola Permintaan Penyediaan Barang dan Jasa dari Unit O&M'],
            ['SMS', 'Setting Minimum Stock (Implementasi Kebijakan Persediaan)'],
            ['PPM', 'Persediaan dan Perputaran Material'],
            ['MKP', 'Mengevaluasi dan Membina Kinerja Penyedia Barang dan Jasa'],
            ['MPPE', 'Monitoring, Pengendalian dan Purchase Effectiveness'],
            ['ISK', 'Implementasi Sistem Kontrak Payung'],
            ['PPB', 'Pengelolaan Penerimaan dan Pengeluaran Barang'],
            ['APB', 'Administrasi & Pengelolaan Barang'],
            ['SO', 'Stock Opname'],
        ];

        foreach ($data as $index => [$kode, $nama]) {
            SubArea::updateOrCreate(
                ['kode_sub_area' => $kode],
                [
                    'nama_sub_area' => $nama,
                    'urutan' => $index + 1,
                    'aktif' => true,
                ]
            );
        }
    }
}