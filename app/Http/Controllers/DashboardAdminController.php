<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\SubArea;
use App\Models\Criterion;
use App\Models\MaturityLevel;
use App\Models\CriterionSubmission;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // 1. Mengambil seluruh unit aktif.
        $unitList = Unit::where('aktif', true)
            ->orderBy('nama_unit')
            ->get();

        // 2. Mengambil seluruh sub area aktif.
        $subAreas = SubArea::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        // 3. Mengambil seluruh level maturity.
        $levels = MaturityLevel::orderBy('level')
            ->get();

        // 4. Mengambil kriteria berdasarkan sub area.
        $criteriaBySubArea = Criterion::with('maturityLevel')
            ->whereIn('sub_area_id', $subAreas->pluck('id'))
            ->orderBy('urutan')
            ->get()
            ->groupBy('sub_area_id');

        // 5. Mengambil dokumen yang sudah diunggah oleh seluruh unit.
        // Status verifikasi tidak digunakan sebagai indeks.
        $submissionByUnit = CriterionSubmission::whereIn(
                'unit_id',
                $unitList->pluck('id')
            )
            ->whereNotNull('file_bukti')
            ->where('file_bukti', '!=', '')
            ->get()
            ->groupBy('unit_id')
            ->map(function ($submissions) {
                return $submissions->keyBy('criterion_id');
            });

        // 6. Pengelompokan area mengikuti pembagian
        // yang saat ini digunakan pada Blade dashboard.
        $areaMapping = [
            'Catalogue' => 'Inventory',
            'Mengelola Permintaan Penyediaan Barang dan Jasa' => 'Inventory',
            'Setting Minimum Stock' => 'Inventory',
            'Persediaan dan Perputaran Material' => 'Inventory',

            'Mengevaluasi dan Membina Kinerja Penyedia' => 'Procurement',
            'Monitoring, Pengendalian dan Purchase Effectiveness' => 'Procurement',
            'Implementasi Sistem Kontrak Payung' => 'Procurement',

            'Pengelolaan Penerimaan dan Pengeluaran Barang' => 'Gudang',
            'Administrasi & Pengelolaan Barang' => 'Gudang',
            'Stock Opname' => 'Gudang',
        ];

        // 7. Menghitung score setiap sub area untuk setiap unit.
        $scorePerSubArea = $subAreas->map(function ($subArea) use (
            $unitList,
            $levels,
            $criteriaBySubArea,
            $submissionByUnit,
            $areaMapping
        ) {
            $criteria = $criteriaBySubArea->get(
                $subArea->id,
                collect()
            );

            $scores = [];

            foreach ($unitList as $unit) {
                $unitSubmissions = $submissionByUnit->get(
                    $unit->id,
                    collect()
                );

                $scores[$unit->id] = $this->calculateSubAreaScore(
                    $criteria,
                    $levels,
                    $unitSubmissions
                );
            }

            // Mencari Area berdasarkan potongan nama Sub Area.
$area = null;

foreach ($areaMapping as $keyword => $areaName) {
    if (stripos($subArea->nama_sub_area, $keyword) !== false) {
        $area = $areaName;
        break;
    }
}

return [
    'id' => $subArea->id,
    'name' => $subArea->nama_sub_area,
    'area' => $area,
    'scores' => $scores,
];
        });

        // 8. Menghitung rata-rata ML seluruh sub area untuk setiap unit.
        $colors = ['blue', 'green', 'orange', 'purple'];

        $rekapUnits = $unitList->values()->map(function ($unit, $index) use (
            $scorePerSubArea,
            $colors
        ) {
            $scores = $scorePerSubArea
                ->map(function ($subArea) use ($unit) {
                    return $subArea['scores'][$unit->id] ?? null;
                })
                ->filter(function ($score) {
                    return $score !== null;
                });

            return [
                'id' => $unit->id,
                'name' => $unit->nama_unit,

                'ml' => $scores->isNotEmpty()
                    ? round($scores->avg(), 2)
                    : null,

                // Belum tersedia sumber data KPI dan Konkin.
                'kpi' => null,
                'konkin' => null,
                'difference' => null,

                'color' => $colors[$index % count($colors)],
            ];
        });

        return view('Admin.dashboardAdmin', compact(
            'unitList',
            'rekapUnits',
            'scorePerSubArea'
        ));
    }

    /**
     * Menghitung score ML untuk satu sub area pada satu unit.
     *
     * Indeks:
     * Dokumen sudah diunggah = 1
     * Dokumen belum diunggah = 0
     *
     * Level berikutnya hanya dihitung jika seluruh
     * kriteria level sebelumnya sudah diunggah.
     */
    private function calculateSubAreaScore(
        $criteria,
        $levels,
        $unitSubmissions
    ): ?float {
        $score = null;

        foreach ($levels as $level) {
            $levelNumber = (int) $level->level;

            $levelCriteria = $criteria->filter(function ($criterion) use (
                $levelNumber
            ) {
                return $criterion->maturityLevel
                    && (int) $criterion->maturityLevel->level === $levelNumber;
            });

            // Level tanpa kriteria tidak boleh dianggap selesai.
            if ($levelCriteria->isEmpty()) {
                break;
            }

            $totalCriteria = $levelCriteria->count();

            $uploadedCriteria = $levelCriteria->filter(function ($criterion) use (
                $unitSubmissions
            ) {
                return $unitSubmissions->has($criterion->id);
            })->count();

            // Score level = nomor level - 1 + rata-rata indeks.
            $score = round(
                ($levelNumber - 1) + ($uploadedCriteria / $totalCriteria),
                2
            );

            // Jika masih ada dokumen yang belum diunggah,
            // proses level berikutnya dihentikan.
            if ($uploadedCriteria < $totalCriteria) {
                break;
            }
        }

        return $score;
    }
}
