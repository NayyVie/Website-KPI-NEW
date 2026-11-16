<?php

namespace App\Http\Controllers;

use App\Models\SubArea;
use App\Models\Criterion;
use App\Models\CriterionSubmission;
use App\Models\MaturityLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenilaianLevelController extends Controller
{
    /**
     * Menghitung progres seluruh level pada satu Sub Area.
     * Dokumen dihitung berdasarkan keberadaan file_bukti,
     * tanpa memperhatikan status verifikasi Admin.
     */
    private function hitungProgres(SubArea $subArea, int $unitId): array
    {
        $levels = MaturityLevel::orderBy('level')->get();

        $criteria = Criterion::where('sub_area_id', $subArea->id)
            ->orderBy('urutan')
            ->get()
            ->groupBy('maturity_level_id');

        $criterionIds = $criteria->flatten()->pluck('id');

        $uploadedIds = CriterionSubmission::where('unit_id', $unitId)
            ->whereIn('criterion_id', $criterionIds)
            ->whereNotNull('file_bukti')
            ->where('file_bukti', '!=', '')
            ->pluck('criterion_id')
            ->all();

        $tabs = [];
        $previousComplete = true;
        $scoreML = 0;

        foreach ($levels as $level) {
            $items = $criteria->get($level->id, collect());

            $total = $items->count();

            $uploaded = $items->filter(function ($criterion) use ($uploadedIds) {
                return in_array($criterion->id, $uploadedIds);
            })->count();

            $canAccess = $previousComplete;

            $ratio = $total > 0
                ? $uploaded / $total
                : 0;

            $value = $canAccess
                ? ($level->level - 1) + $ratio
                : 0;

            $complete = $total > 0 && $uploaded === $total;

            $tabs[] = [
                'id' => $level->id,
                'level' => (int) $level->level,
                'nama_level' => $level->nama_level,
                'total' => $total,
                'uploaded' => $uploaded,
                'value' => $value,
                'can_access' => $canAccess,
                'complete' => $complete,
                'criteria' => $items,
            ];

            if ($canAccess) {
                $scoreML = $value;
            }

            // Level berikutnya hanya terbuka jika level ini lengkap.
            $previousComplete = $complete;
        }

        return [
            'tabs' => $tabs,
            'score_ml' => $scoreML,
        ];
    }

    public function show(Request $request, $id)
    {
        $user = Auth::user();

        abort_unless(
            $user && $user->role === 'unit' && $user->unit_id,
            403,
            'Akun tidak memiliki akses ke halaman Unit.'
        );

        // Pastikan Sub Area memang milik Unit yang sedang login.
        $subArea = SubArea::where('id', $id)
            ->where('unit_id', $user->unit_id)
            ->firstOrFail();

        // Menghitung progres Sub Area yang sedang dibuka.
        $progress = $this->hitungProgres($subArea, $user->unit_id);

        $levelTabs = $progress['tabs'];

        // Menghitung progres seluruh Sub Area untuk sidebar.
        $subAreas = SubArea::where('unit_id', $user->unit_id)
            ->orderBy('urutan')
            ->get()
            ->map(function ($item) use ($user) {
                $itemProgress = $this->hitungProgres(
                    $item,
                    $user->unit_id
                );

                return [
                    'id' => $item->id,
                    'nama_sub_area' => $item->nama_sub_area,
                    'score' => $itemProgress['score_ml'],
                ];
            });

        // Menentukan level yang diminta melalui URL.
        $requestedLevel = $request->query('level');

        if ($requestedLevel !== null) {
            $selectedLevel = collect($levelTabs)->firstWhere(
                'level',
                (int) $requestedLevel
            );

            // Tolak akses jika level belum terbuka.
            if (!$selectedLevel || !$selectedLevel['can_access']) {
                $defaultLevel = collect($levelTabs)
                    ->first(function ($tab) {
                        return $tab['can_access'] && !$tab['complete'];
                    });

                if (!$defaultLevel) {
                    $defaultLevel = collect($levelTabs)
                        ->filter(fn ($tab) => $tab['can_access'])
                        ->last();
                }

                $defaultNumber = $defaultLevel['level'] ?? 1;

                return redirect()
                    ->route('penilaian', [
                        'id' => $subArea->id,
                        'level' => $defaultNumber,
                    ])
                    ->with('error', 'Level tersebut masih terkunci. Lengkapi seluruh dokumen pada level sebelumnya terlebih dahulu.');
            }
        } else {
            // Default: tampilkan level terbuka pertama yang belum lengkap.
            $selectedLevel = collect($levelTabs)->first(function ($tab) {
                return $tab['can_access'] && !$tab['complete'];
            });

            // Jika semua level sudah lengkap, tampilkan level terakhir.
            if (!$selectedLevel) {
                $selectedLevel = collect($levelTabs)
                    ->filter(fn ($tab) => $tab['can_access'])
                    ->last();
            }
        }

        abort_if(!$selectedLevel, 404, 'Data level tidak ditemukan.');

        $levelModel = MaturityLevel::findOrFail($selectedLevel['id']);

        // Mengambil kriteria dan dokumen pada level yang dipilih.
        
$sequenceComplete = true;

$kriteria = $selectedLevel['criteria']
    ->sortBy('urutan')
    ->values()
    ->map(function ($criterion) use ($user, &$sequenceComplete) {

        $submission = CriterionSubmission::where('unit_id', $user->unit_id)
            ->where('criterion_id', $criterion->id)
            ->first();

        $hasFile = $submission
            && !empty($submission->file_bukti);

        // Kriteria terbuka hanya jika seluruh kriteria sebelumnya
        // sudah memiliki dokumen.
        $isUnlocked = $sequenceComplete;

        // Setelah kriteria ini diperiksa, tentukan akses kriteria berikutnya.
        $sequenceComplete = $sequenceComplete && $hasFile;

        return (object) [
            'id' => $criterion->id,
            'no' => $criterion->urutan,
            'judul' => $criterion->nama_kriteria,

            'status' => $isUnlocked
                ? 'terbuka'
                : 'terkunci',

            'indeks_dokumen' => $hasFile ? 1 : 0,

            'catatan' => $hasFile
                ? ($submission->catatan_admin ?? '')
                : '',

            'file' => $hasFile
                ? basename($submission->file_bukti)
                : null,

            'file_path' => $hasFile
                ? $submission->file_bukti
                : null,

            'status_verifikasi' => $hasFile
                ? $submission->status_verifikasi
                : null,
        ];
    });


        $penilaian = (object) [
            'sub_area' => $subArea->nama_sub_area,
            'kode' => $subArea->kode_sub_area ?? '',
            'deskripsi' => $subArea->deskripsi ?? '',
            'score_ml' => $progress['score_ml'],
            'nilai_level' => $selectedLevel['value'],
            'jumlah_kriteria' => $selectedLevel['total'],
            'jumlah_terunggah' => $selectedLevel['uploaded'],
            'kriteria_level' => $kriteria,
        ];

        $namaUnit = $user->unit->nama_unit ?? 'Unit Pengguna';

        return view('Unit.penilaianLevel', compact(
            'namaUnit',
            'subAreas',
            'penilaian',
            'subArea',
            'levelTabs',
            'selectedLevel',
            'levelModel'
        ));
    }

    public function upload(Request $request, $id, $kriteria)
    {
        $user = Auth::user();

        abort_unless(
            $user && $user->role === 'unit' && $user->unit_id,
            403,
            'Akun tidak memiliki akses upload.'
        );

        // Pastikan Sub Area milik Unit yang sedang login.
        $subArea = SubArea::where('id', $id)
            ->where('unit_id', $user->unit_id)
            ->firstOrFail();

        // Pastikan kriteria berada di Sub Area tersebut.
        $criterion = Criterion::where('sub_area_id', $subArea->id)
            ->where('id', $kriteria)
            ->firstOrFail();

        $level = MaturityLevel::findOrFail(
            $criterion->maturity_level_id
        );

        // Periksa apakah level kriteria sudah boleh diakses.
        $progress = $this->hitungProgres($subArea, $user->unit_id);

        $levelProgress = collect($progress['tabs'])->firstWhere(
            'id',
            $level->id
        );

        if (!$levelProgress || !$levelProgress['can_access']) {
            return back()->with(
                'error',
                'Dokumen belum dapat diunggah karena level sebelumnya belum lengkap.'
            );
        }


// Ambil semua kriteria sebelum kriteria yang sedang diunggah.
$previousCriteria = Criterion::where('sub_area_id', $subArea->id)
    ->where('maturity_level_id', $level->id)
    ->where('urutan', '<', $criterion->urutan)
    ->orderBy('urutan')
    ->get();

// Periksa apakah seluruh kriteria sebelumnya sudah memiliki dokumen.
foreach ($previousCriteria as $previousCriterion) {

    $previousSubmission = CriterionSubmission::where(
        'unit_id',
        $user->unit_id
    )
        ->where('criterion_id', $previousCriterion->id)
        ->first();

    if (!$previousSubmission || !$previousSubmission->file_bukti) {
        return back()->with(
            'error',
            'Unggah dokumen kriteria sebelumnya terlebih dahulu.'
        );
    }
}


        $request->validate([
            'file_bukti' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
                'max:10240',
            ],
        ], [
            'file_bukti.required' => 'Pilih dokumen terlebih dahulu.',
            'file_bukti.mimes' => 'Format file tidak didukung.',
            'file_bukti.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $submission = CriterionSubmission::where('unit_id', $user->unit_id)
            ->where('criterion_id', $criterion->id)
            ->first();

        // Dokumen yang sudah disetujui Admin tidak dapat diganti.
        if ($submission && $submission->status_verifikasi === 'sesuai') {
            return back()->with(
                'error',
                'Dokumen yang sudah disetujui tidak dapat diganti.'
            );
        }

        $file = $request->file('file_bukti');

     // Ambil nama asli file yang dipilih Unit.
$originalName = basename($file->getClientOriginalName());

// Bersihkan karakter yang tidak aman, tetapi pertahankan nama dan ekstensi.
$originalName = preg_replace(
    '/[^A-Za-z0-9._ -]/u',
    '_',
    $originalName
);

$originalName = trim($originalName);

if ($originalName === '' || $originalName === '.' || $originalName === '..') {
    $originalName = 'dokumen.' . $file->getClientOriginalExtension();
}

$folder = 'bukti-kriteria/' . $user->unit_id;

// Pisahkan nama file dan ekstensi.
$name = pathinfo($originalName, PATHINFO_FILENAME);
$extension = pathinfo($originalName, PATHINFO_EXTENSION);

$fileName = $originalName;
$counter = 1;

// Hindari nama file yang sama menimpa file sebelumnya.
while (Storage::disk('public')->exists($folder . '/' . $fileName)) {
    $fileName = $name . ' (' . $counter . ')';

    if ($extension !== '') {
        $fileName .= '.' . $extension;
    }

    $counter++;
}

// Simpan dengan nama asli yang sudah diamankan.
$path = $file->storeAs(
    $folder,
    $fileName,
    'public'
);

        // Hapus dokumen sebelumnya jika ada.
        if ($submission && $submission->file_bukti) {
            Storage::disk('public')->delete($submission->file_bukti);
        }

       CriterionSubmission::updateOrCreate(
    [
        'unit_id' => $user->unit_id,
        'criterion_id' => $criterion->id,
    ],
    [
        'file_bukti' => $path,
        'status_verifikasi' => 'menunggu',
        'catatan_admin' => null,
    ]
);

        return redirect()
            ->route('penilaian', [
                'id' => $subArea->id,
                'level' => $level->level,
            ])
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function hapus($id, $kriteria)
{
    $user = Auth::user();

    abort_unless(
        $user && $user->role === 'unit' && $user->unit_id,
        403,
        'Akun tidak memiliki akses menghapus dokumen.'
    );

    // Pastikan Sub Area milik Unit yang sedang login.
    $subArea = SubArea::where('id', $id)
        ->where('unit_id', $user->unit_id)
        ->firstOrFail();

    // Pastikan kriteria berada pada Sub Area tersebut.
    $criterion = Criterion::where('sub_area_id', $subArea->id)
        ->where('id', $kriteria)
        ->firstOrFail();

    // Ambil dokumen milik Unit untuk kriteria tersebut.
    $submission = CriterionSubmission::where('unit_id', $user->unit_id)
        ->where('criterion_id', $criterion->id)
        ->firstOrFail();

    // Dokumen yang sudah disetujui tidak boleh dihapus.
    if ($submission->status_verifikasi === 'sesuai') {
        return back()->with(
            'error',
            'Dokumen yang sudah disetujui tidak dapat dihapus.'
        );
    }

    // Hapus file dari penyimpanan.
    if ($submission->file_bukti) {
        Storage::disk('public')->delete($submission->file_bukti);
    }

    // Kosongkan data dokumen.
    $submission->update([
        'file_bukti' => null,
        'status_verifikasi' => 'menunggu',
        'catatan_admin' => null,
    ]);

    return redirect()
        ->route('penilaian', [
            'id' => $subArea->id,
            'level' => $criterion->maturityLevel->level,
        ])
        ->with('success', 'Dokumen berhasil dihapus.');
}
}
