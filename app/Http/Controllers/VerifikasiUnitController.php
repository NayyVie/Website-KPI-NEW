<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\SubArea;
use App\Models\MaturityLevel;
use App\Models\Criterion;
use App\Models\CriterionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiUnitController extends Controller
{
    /**
     * Menampilkan halaman verifikasi Admin.
     */
    public function index(Request $request)
    {
        // Mengambil seluruh unit aktif.
        $units = Unit::where('aktif', true)
            ->orderBy('nama_unit')
            ->get();

        // Mengambil unit berdasarkan parameter URL.
        $unit = Unit::where('aktif', true)
            ->find($request->integer('unit_id'))
            ?? $units->first();

        // Mengambil seluruh sub-area aktif.
        $subAreas = SubArea::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        // Mengambil sub-area berdasarkan parameter URL.
        $subArea = SubArea::where('aktif', true)
            ->find($request->integer('sub_area_id'))
            ?? $subAreas->first();

        // Mengambil seluruh level.
        $levels = MaturityLevel::orderBy('level')->get();

        // Menentukan level yang dipilih.
        $selectedLevel = (int) $request->input(
            'level',
            $levels->first()?->level ?? 1
        );

        // Memastikan level tersedia.
        if (!$levels->contains('level', $selectedLevel)) {
            $selectedLevel = (int) ($levels->first()?->level ?? 1);
        }

        $level = $levels->firstWhere('level', $selectedLevel);


 

// Menyiapkan data tab Level 1-5 dan Score ML Sub Area.
$levelTabs = collect();
$scoreMlSubArea = 0;

if ($unit && $subArea) {
    // Mengambil seluruh kriteria pada sub-area yang dipilih.
    $allCriteria = Criterion::with('maturityLevel')
        ->where('sub_area_id', $subArea->id)
        ->get();

    // Mengambil bukti yang sudah diunggah oleh unit.
    $allSubmissions = CriterionSubmission::where('unit_id', $unit->id)
        ->whereIn('criterion_id', $allCriteria->pluck('id'))
        ->whereNotNull('file_bukti')
        ->where('file_bukti', '!=', '')
        ->get()
        ->keyBy('criterion_id');

    // Digunakan khusus untuk menghitung Score ML Sub Area.
    $previousComplete = true;

    foreach ($levels as $levelTab) {
        $levelNumber = (int) $levelTab->level;

        // Mengambil kriteria pada level ini.
        $criteriaLevel = $allCriteria->filter(function ($item) use ($levelNumber) {
            return (int) $item->maturityLevel?->level === $levelNumber;
        });

        $total = $criteriaLevel->count();

        // Menghitung jumlah dokumen yang sudah diunggah.
        $uploaded = $criteriaLevel->filter(function ($item) use ($allSubmissions) {
            return $allSubmissions->has($item->id);
        })->count();

        // Level selesai jika seluruh dokumen sudah diunggah.
        $complete = $total > 0 && $uploaded === $total;

        // Nilai progres level.
        $value = $total > 0
            ? ($levelNumber - 1) + ($uploaded / $total)
            : 0;

        // Admin tetap dapat membuka seluruh level.
        $canAccess = true;

        $levelTabs->push([
            'level' => $levelNumber,
            'can_access' => $canAccess,
            'value' => $value,
            'complete' => $complete,
            'uploaded' => $uploaded,
            'total' => $total,
        ]);

        // Score ML mengikuti level terakhir yang dapat dicapai Unit.
        if ($previousComplete) {
            $scoreMlSubArea = $value;
        }

        // Level selanjutnya baru dihitung jika level ini lengkap.
        $previousComplete = $complete;
    }
}

        // Mengambil kriteria sesuai sub-area dan level.
        $kriteria = collect();
        $submissions = collect();

        if ($unit && $subArea) {
            $kriteria = Criterion::with('maturityLevel')
                ->where('sub_area_id', $subArea->id)
                ->whereHas('maturityLevel', function ($query) use ($selectedLevel) {
                    $query->where('level', $selectedLevel);
                })
                ->orderBy('urutan')
                ->get();

            // Mengambil bukti milik unit dan kriteria yang ditampilkan.
            $submissions = CriterionSubmission::where('unit_id', $unit->id)
                ->whereIn('criterion_id', $kriteria->pluck('id'))
                ->get()
                ->keyBy('criterion_id');
        }

        // Ringkasan berdasarkan status verifikasi.
        $totalKriteria = $kriteria->count();

        $totalSesuai = $kriteria->filter(function ($item) use ($submissions) {
            return $submissions->get($item->id)?->status_verifikasi === 'sesuai';
        })->count();

        $totalTidakSesuai = $kriteria->filter(function ($item) use ($submissions) {
            return $submissions->get($item->id)?->status_verifikasi === 'tidak_sesuai';
        })->count();

        $totalMenunggu = $kriteria->filter(function ($item) use ($submissions) {
            $submission = $submissions->get($item->id);

            return $submission
                && $submission->file_bukti
                && $submission->status_verifikasi === 'menunggu';
        })->count();

        $persentaseSesuai = $totalKriteria > 0
            ? round(($totalSesuai / $totalKriteria) * 100, 2)
            : 0;

        return view('Admin.verifkasiUnit', compact(
            'units',
            'unit',
            'subAreas',
            'subArea',
            'levels',
            'selectedLevel',
            'level',
            'levelTabs',
            'scoreMlSubArea',
            'kriteria',
            'submissions',
            'totalKriteria',
            'totalSesuai',
            'totalTidakSesuai',
            'totalMenunggu',
            'persentaseSesuai'
        ));
    }

    /**
     * Membuka halaman verifikasi untuk unit tertentu.
     */
    public function show(Unit $unit)
    {
        abort_unless($unit->aktif, 404);

        return redirect()->route('verifkasiUnit', [
            'unit_id' => $unit->id,
        ]);
    }

    /**
     * Menyimpan status verifikasi.
     */
    public function updateStatus(Request $request, Criterion $criterion)
    {
        $validated = $request->validate([
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'status' => ['required', 'in:sesuai,tidak_sesuai'],
        ]);

        $unit = Unit::where('aktif', true)
            ->findOrFail($validated['unit_id']);

        // Mengambil bukti dari tabel criterion_submissions.
        $submission = CriterionSubmission::where('unit_id', $unit->id)
            ->where('criterion_id', $criterion->id)
            ->whereNotNull('file_bukti')
            ->where('file_bukti', '!=', '')
            ->first();

        if (!$submission) {
            return response()->json([
                'message' => 'Kriteria belum memiliki bukti yang dapat diverifikasi.',
            ], 422);
        }

        $submission->update([
            'status_verifikasi' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Status verifikasi berhasil disimpan.',
            'status' => $submission->status_verifikasi,
        ]);
    }

    /**
     * Menyimpan catatan Admin.
     */
    public function updateCatatan(Request $request, Criterion $criterion)
    {
        $validated = $request->validate([
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'catatan' => ['nullable', 'string', 'max:5000'],
        ]);

        $unit = Unit::where('aktif', true)
            ->findOrFail($validated['unit_id']);

        // Mengambil bukti dari tabel criterion_submissions.
        $submission = CriterionSubmission::where('unit_id', $unit->id)
            ->where('criterion_id', $criterion->id)
            ->whereNotNull('file_bukti')
            ->where('file_bukti', '!=', '')
            ->first();

        if (!$submission) {
            return response()->json([
                'message' => 'Kriteria belum memiliki bukti. Catatan belum dapat disimpan.',
            ], 422);
        }

        $submission->update([
            'catatan_admin' => $validated['catatan'] ?? null,
        ]);

        return response()->json([
            'message' => 'Catatan berhasil disimpan.',
            'catatan' => $submission->catatan_admin,
        ]);
    }
}
