<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Criterion;
use App\Models\CriterionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CriterionSubmissionController extends Controller
{
    /**
     * Mendapatkan unit milik pengguna yang sedang login.
     */
    private function getUserUnit(): Unit
    {
        $user = Auth::user();

        abort_unless($user, 403, 'Silakan login terlebih dahulu.');

        abort_unless(
            $user->role === 'unit' && $user->unit_id,
            403,
            'Akun ini tidak memiliki akses ke data Unit.'
        );

        $unit = Unit::find($user->unit_id);

        abort_unless(
            $unit,
            403,
            'Unit pengguna tidak ditemukan.'
        );

        return $unit;
    }

    /**
     * Menampilkan daftar kriteria milik unit yang sedang login.
     */
   
public function index()
{
    $unit = $this->getUserUnit();

    $criteria = \App\Models\Criterion::with([
        'subArea',
        'maturityLevel'
    ])
        ->whereHas('subArea', function ($query) use ($unit) {
            $query->where('unit_id', $unit->id);
        })
        ->orderBy('sub_area_id')
        ->orderBy('maturity_level_id')
        ->orderBy('urutan')
        ->get();

    $submissions = \App\Models\CriterionSubmission::where(
        'unit_id',
        $unit->id
    )
        ->get()
        ->keyBy('criterion_id');

    return view('Unit.submissions.index', compact(
        'unit',
        'criteria',
        'submissions'
    ));
}


    /**
     * Menyimpan dokumen bukti kriteria.
     */
    public function store(Request $request, $criterionId)
    {
        $unit = $this->getUserUnit();

        // Pastikan kriteria termasuk unit yang sedang login.
        $criterion = Criterion::where('id', $criterionId)
            ->whereHas('subArea', function ($query) use ($unit) {
                $query->where('unit_id', $unit->id);
            })
            ->firstOrFail();

        $request->validate([
            'file_bukti' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
                'max:10240',
            ],
        ], [
            'file_bukti.required' => 'Silakan pilih dokumen bukti.',
            'file_bukti.mimes' => 'Format file harus PDF, Word, Excel, JPG, atau PNG.',
            'file_bukti.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $submission = CriterionSubmission::where('unit_id', $unit->id)
            ->where('criterion_id', $criterion->id)
            ->first();

        // Dokumen yang sudah dinyatakan sesuai tidak dapat diganti.
        if ($submission && $submission->status_verifikasi === 'sesuai') {
            return back()->with(
                'error',
                'Dokumen yang sudah dinyatakan sesuai tidak dapat diunggah ulang.'
            );
        }

        $path = $request->file('file_bukti')
            ->store('bukti-kriteria/' . $unit->id, 'public');

        // Hapus dokumen lama setelah file baru berhasil disimpan.
        if ($submission && $submission->file_bukti) {
            Storage::disk('public')->delete($submission->file_bukti);
        }

        CriterionSubmission::updateOrCreate(
            [
                'unit_id' => $unit->id,
                'criterion_id' => $criterion->id,
            ],
            [
                'file_bukti' => $path,
                'status_verifikasi' => 'menunggu',
                'catatan_admin' => null,
            ]
        );

        return redirect()
            ->route('Unit.submissions.index')
            ->with('success', 'Dokumen bukti berhasil diunggah.');
    }
}
