<?php

namespace Database\Seeders;

use App\Models\MaturityLevel;
use Illuminate\Database\Seeder;

class MaturityLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            1 => 'Fire Fighting (Melakukan tindakan setelah ada kejadian)',
            2 => 'Stabilizing (Bertindak sebatas merespons kejadian)',
            3 => 'Preventing (Ada usaha untuk melakukan pencegahan)',
            4 => 'Optimizing (Adanya usaha optimasi sumberdaya & improvement)',
            5 => 'Excellence (Mencapai keunggulan optimasi sumberdaya & continuous improvement)',
        ];

        foreach ($levels as $level => $nama) {
            MaturityLevel::updateOrCreate(
                ['level' => $level],
                ['nama_level' => $nama]
            );
        }
    }
}