<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        Unit::updateOrCreate(
            ['kode_unit' => 'UNIT001'],
            [
                'nama_unit' => 'Banjarsari',
                'lokasi' => 'Banjarsari',
                'aktif' => true,
            ]
        );

        Unit::updateOrCreate(
            ['kode_unit' => 'UNIT002'],
            [
                'nama_unit' => 'Asahan',
                'lokasi' => 'Asahan',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT003'],
            [
                'nama_unit' => 'Belitung',
                'lokasi' => 'Belitung',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT004'],
            [
                'nama_unit' => 'Bangka',
                'lokasi' => 'Bangka',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT005'],
            [
                'nama_unit' => 'Tembilahan',
                'lokasi' => 'Tembilahan',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT006'],
            [
                'nama_unit' => 'Ketapang',
                'lokasi' => 'Ketapang',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT007'],
            [
                'nama_unit' => 'Amurang',
                'lokasi' => 'Amurang',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT008'],
            [
                'nama_unit' => 'Tidore',
                'lokasi' => 'Tidore',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT009'],
            [
                'nama_unit' => 'Bolok',
                'lokasi' => 'Bolok',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT010'],
            [
                'nama_unit' => 'Ropa',
                'lokasi' => 'Ropa',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT011'],
            [
                'nama_unit' => 'Kendari',
                'lokasi' => 'Kendari',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT012'],
            [
                'nama_unit' => 'Anggrek',
                'lokasi' => 'Anggrek',
                'aktif' => true,
            ]
        );

         Unit::updateOrCreate(
            ['kode_unit' => 'UNIT013'],
            [
                'nama_unit' => 'Ampana',
                'lokasi' => 'Ampana',
                'aktif' => true,
            ]
        );
    }
}