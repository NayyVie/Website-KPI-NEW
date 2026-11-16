
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifikasiUnitController;
use App\Http\Controllers\CriterionSubmissionController;
use App\Http\Controllers\PenilaianLevelController;
use App\Http\Controllers\DashboardAdminController;

// =========================
// LOGIN
// =========================
Route::get('/', function () {
    return view('Auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// =========================
// DASHBOARD UNIT
// =========================
Route::middleware(['auth', 'role:unit'])->group(function () {

    Route::get('/dashboardUnit', function () {
        return view('Unit.dashboardUnit');
    })->name('dashboardUnit');


    // Pengiriman bukti kriteria
 Route::prefix('Unit')
    ->name('Unit.')
    ->middleware(['auth', 'role:unit'])
    ->group(function () {
        Route::get('/submissions', [
            CriterionSubmissionController::class,
            'index',
        ])->name('submissions.index');

        Route::post('/submissions/{criterionId}', [
            CriterionSubmissionController::class,
            'store',
        ])->name('submissions.store');
    });

    // Halaman Unit
    Route::get('/detailKpi', function () {
        return view('Unit.detailKpi');
    })->name('detailKpi');

    Route::get('/lengkapiBukti', function () {
        return view('Unit.lengkapiBukti');
    })->name('lengkapiBukti');

    Route::get('/riwayatKpi', function () {
        return view('Unit.riwayatKpi');
    })->name('riwayatKpi');
});

// =========================
// DASHBOARD ADMIN
// =========================
Route::middleware(['auth', 'role:admin'])->group(function () {

   Route::get('/dashboardAdmin', [
    DashboardAdminController::class,
    'index'
])->name('dashboardAdmin');

    // Halaman verifikasi unit
    Route::get('/admin/unit/{unit}/verifikasi', [
        VerifikasiUnitController::class,
        'show'
    ])->name('admin.unit.verifikasi');

    Route::get('/verifkasiUnit', [
        VerifikasiUnitController::class,
        'index'
    ])->name('verifkasiUnit');

    // Penyimpanan status verifikasi
    Route::post('/verifkasiUnit/{criterion}/status', [
        VerifikasiUnitController::class,
        'updateStatus'
    ])->name('verifkasiUnit.updateStatus');

    // Penyimpanan catatan Admin
    Route::post('/verifkasiUnit/{criterion}/catatan', [
        VerifikasiUnitController::class,
        'updateCatatan'
    ])->name('verifkasiUnit.updateCatatan');
});

// UJI COBA
Route::middleware(['auth', 'role:unit'])->group(function () {

    Route::get('/Unit/penilaian/{id}', [
        PenilaianLevelController::class,
        'show'
    ])->name('penilaian');

    Route::post('/Unit/penilaian/{id}/kriteria/{kriteria}/upload', [
        PenilaianLevelController::class,
        'upload'
    ])->name('Unit.penilaian.upload');

    Route::delete('/Unit/penilaian/{id}/kriteria/{kriteria}/hapus', [
    PenilaianLevelController::class,
    'hapus'
])->name('Unit.penilaian.hapus');

});

// COBA
// PINDAHAN DARI PRJECT SATUNYA
// UNIT - LENGKAPI BUKTI
Route::get('/lengkapiBukti', function () {
    $namaUnit = 'Banjarsari';

    $subAreas = [
        [
            'nama' => 'Catalogue',
            'area' => 'Inventory',
            'score' => 2.2,
            'kriteria' => [
                ['nama' => 'Data katalog terdokumentasi dalam SIT'],
                ['nama' => 'Katalog material memiliki kode dan deskripsi yang seragam'],
                ['nama' => 'Pemutakhiran katalog dilakukan secara berkala'],
                ['nama' => 'Penanggung jawab pengelolaan katalog telah ditetapkan'],
                ['nama' => 'Kualitas data katalog dievaluasi dan ditindaklanjuti'],
            ]
        ],
        [
            'nama' => 'Mengelola Permintaan Penyediaan Barang dan Jasa',
            'area' => 'Inventory',
            'score' => 3.1,
            'kriteria' => [
                ['nama' => 'Prosedur pengelolaan permintaan telah disahkan'],
                ['nama' => 'Permintaan diverifikasi sebelum diproses'],
                ['nama' => 'Dokumen permintaan terdokumentasi dengan baik'],
            ]
        ],
        [
            'nama' => 'Setting Minimum Stock',
            'area' => 'Inventory',
            'score' => 3.8,
            'kriteria' => [
                ['nama' => 'Minimum stock ditetapkan untuk setiap item'],
                ['nama' => 'Minimum stock ditinjau secara berkala'],
            ]
        ],
        [
            'nama' => 'Persediaan dan Perputaran Material',
            'area' => 'Inventory',
            'score' => 2.9,
            'kriteria' => [
                ['nama' => 'Perputaran material dipantau secara berkala'],
                ['nama' => 'Laporan perputaran material tersedia'],
            ]
        ],
        [
            'nama' => 'Mengevaluasi dan Membina Kinerja Penyedia',
            'area' => 'Procurement',
            'score' => 3.7,
            'kriteria' => [
                ['nama' => 'Evaluasi kinerja penyedia dilakukan berkala'],
                ['nama' => 'Hasil evaluasi ditindaklanjuti'],
            ]
        ],
        [
            'nama' => 'Monitoring, Pengendalian dan Purchase Effectiveness',
            'area' => 'Procurement',
            'score' => 2.6,
            'kriteria' => [
                ['nama' => 'Monitoring purchase effectiveness dilakukan'],
                ['nama' => 'Laporan pengendalian tersedia'],
            ]
        ],
        [
            'nama' => 'Implementasi Sistem Kontrak Payung',
            'area' => 'Procurement',
            'score' => 1.8,
            'kriteria' => [
                ['nama' => 'Sistem kontrak payung telah diimplementasikan'],
                ['nama' => 'Dokumen kontrak payung tersedia'],
            ]
        ],
        [
            'nama' => 'Pengelolaan Penerimaan dan Pengeluaran Barang',
            'area' => 'Gudang',
            'score' => 4.1,
            'kriteria' => [
                ['nama' => 'Prosedur penerimaan barang terdokumentasi'],
                ['nama' => 'Prosedur pengeluaran barang terdokumentasi'],
            ]
        ],
        [
            'nama' => 'Administrasi & Pengelolaan Barang',
            'area' => 'Gudang',
            'score' => 3.4,
            'kriteria' => [
                ['nama' => 'Administrasi barang tertata dengan baik'],
                ['nama' => 'Laporan administrasi tersedia berkala'],
            ]
        ],
        [
            'nama' => 'Stock Opname',
            'area' => 'Gudang',
            'score' => 3.9,
            'kriteria' => [
                ['nama' => 'Stock opname dilakukan secara berkala'],
                ['nama' => 'Hasil stock opname terdokumentasi'],
            ]
        ],
    ];

    return view('Unit.lengkapiBukti', compact('namaUnit', 'subAreas'));
})->name('lengkapiBukti');


// UNIT - RIWAYAT LAPORAN KPI (Dengan Logika Filter)
Route::get('/riwayatKpi', function (Request $request) {
    $namaUnit = 'Banjarsari';
    
    // Menangkap data dari form filter
    $filterBulan = $request->query('bulan', 'Semua');
    $filterTahun = $request->query('tahun', '2026');
    
    // Data dummy
    $semuaDokumen = [
        (object) [
            'id' => 1,
            'nama_file' => 'Laporan KPI SCM Juni 2026.xlsx',
            'ukuran' => '2.4 MB',
            'tanggal_unggah' => '28 Jun 2026, 14.32',
            'bulan' => 'Juni',
            'tahun' => '2026',
            'periode' => 'Juni 2026',
            'tipe' => 'excel',
            'status' => 'Disetujui'
        ],
        (object) [
            'id' => 2,
            'nama_file' => 'Laporan KPI SCM Mei 2026.xlsx',
            'ukuran' => '2.1 MB',
            'tanggal_unggah' => '30 Mei 2026, 09.18',
            'bulan' => 'Mei',
            'tahun' => '2026',
            'periode' => 'Mei 2026',
            'tipe' => 'excel',
            'status' => 'Revisi'
        ],
        (object) [
            'id' => 3,
            'nama_file' => 'Realisasi KPI Logistik April 2026.pdf',
            'ukuran' => '1.8 MB',
            'tanggal_unggah' => '29 Apr 2026, 16.45',
            'bulan' => 'April',
            'tahun' => '2026',
            'periode' => 'April 2026',
            'tipe' => 'pdf',
            'status' => 'Disetujui'
        ],
        (object) [
            'id' => 4,
            'nama_file' => 'Laporan KPI SCM Maret 2026.xlsx',
            'ukuran' => '2.2 MB',
            'tanggal_unggah' => '27 Mar 2026, 11.06',
            'bulan' => 'Maret',
            'tahun' => '2026',
            'periode' => 'Maret 2026',
            'tipe' => 'excel',
            'status' => 'Menunggu Review'
        ],
    ];

    // Logika menyaring data berdasarkan filter
    $dokumen = collect($semuaDokumen)->filter(function ($doc) use ($filterBulan, $filterTahun) {
        $matchBulan = ($filterBulan == 'Semua') || ($doc->bulan == $filterBulan);
        $matchTahun = ($doc->tahun == $filterTahun);
        return $matchBulan && $matchTahun;
    });

    return view('Unit.riwayatKpi', compact('namaUnit', 'dokumen', 'filterBulan', 'filterTahun'));
})->name('riwayatKpi');

// UNIT - DETAIL RIWAYAT KPI (Halaman Rincian)
Route::get('/riwayatKpi/{id}', function ($id) {
    $namaUnit = 'Banjarsari';
    
    // Data dummy detail
    $detail = (object) [
        'id' => $id,
        'nama_file' => 'Laporan KPI SCM Mei 2026.xlsx',
        'periode' => 'Mei 2026',
        'tanggal_unggah' => '30 Mei 2026, 09.18',
        'status' => 'Revisi',
        'catatan_admin' => 'Foto bukti untuk sub area Stock Opname kurang jelas, mohon diunggah ulang.',
        'rincian_skor' => [
            ['sub_area' => 'Catalogue', 'skor' => 2.2, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Mengelola Permintaan Penyediaan Barang dan Jasa', 'skor' => 3.1, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Setting Minimum Stock', 'skor' => 3.8, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Persediaan dan Perputaran Material', 'skor' => 2.9, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Mengevaluasi dan Membina Kinerja Penyedia', 'skor' => 3.7, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Monitoring, Pengendalian dan Purchase Effectiveness', 'skor' => 2.6, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Implementasi Sistem Kontrak Payung', 'skor' => 1.8, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Pengelolaan Penerimaan dan Pengeluaran Barang', 'skor' => 4.1, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Administrasi & Pengelolaan Barang', 'skor' => 3.4, 'keterangan' => 'Sesuai'],
            ['sub_area' => 'Stock Opname', 'skor' => 0.0, 'keterangan' => 'Perlu Revisi'],
        ]
    ];

    return view('Unit.detailKpi', compact('namaUnit', 'detail'));
})->name('detailKpi');
