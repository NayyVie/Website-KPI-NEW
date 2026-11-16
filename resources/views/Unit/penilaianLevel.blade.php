<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Level - {{ $namaUnit }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
    </style>
</head>

<body class="min-h-screen p-6 text-gray-800">

    {{-- NOTIFIKASI --}}
    <div id="notification-container"
        class="fixed top-4 left-1/2 -translate-x-1/2 z-[9999] w-[calc(100%-2rem)] max-w-3xl flex flex-col gap-2">

        @if (session('success'))
            <div class="notification-alert flex items-center justify-between gap-3 p-3 rounded-lg bg-green-100 text-green-700 shadow-md transition-all duration-300"
                role="alert">

                <span>{{ session('success') }}</span>

                <button type="button" onclick="closeNotification(this)"
                    class="text-green-700 hover:text-green-900 font-bold text-lg px-2">
                    &times;
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="notification-alert flex items-center justify-between gap-3 p-3 rounded-lg bg-red-100 text-red-700 shadow-md transition-all duration-300"
                role="alert">

                <span>{{ session('error') }}</span>

                <button type="button" onclick="closeNotification(this)"
                    class="text-red-700 hover:text-red-900 font-bold text-lg px-2">
                    &times;
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="notification-alert flex items-center justify-between gap-3 p-3 rounded-lg bg-red-100 text-red-700 shadow-md transition-all duration-300"
                role="alert">

                <span>{{ $errors->first() }}</span>

                <button type="button" onclick="closeNotification(this)"
                    class="text-red-700 hover:text-red-900 font-bold text-lg px-2">
                    &times;
                </button>
            </div>
        @endif

    </div>

    <!-- Top Navbar -->
    <div class="max-w-7xl mx-auto mb-6 flex justify-between items-center text-sm">

        <a href="{{ route('dashboardUnit') }}" class="text-gray-600 hover:text-gray-900 font-medium">
            Kembali
        </a>
    </div>

    <div class="max-w-7xl mx-auto flex gap-6">

        <!-- SIDEBAR KIRI -->
        <div class="w-1/4 bg-white rounded-xl shadow-sm border border-gray-200 p-4 h-fit">

            <div class="mb-4">
                <p class="text-xs text-gray-500">Nama Unit</p>

                <h2 class="text-lg font-bold text-gray-900">
                    {{ $namaUnit }}
                </h2>
            </div>

            <div class="flex flex-col gap-1">

                @foreach ($subAreas as $sa)
                    <a href="{{ route('penilaian', ['id' => $sa['id']]) }}"
                        class="flex justify-between items-center px-3 py-2.5 rounded-lg text-sm transition-colors
                        {{ $sa['id'] == $subArea->id
                            ? 'bg-gray-50 font-bold text-blue-700 border border-gray-200'
                            : 'text-gray-600 hover:bg-gray-50' }}">

                        <span class="pr-2">
                            {{ $sa['nama_sub_area'] }}
                        </span>

                        <span
                            class="px-2 py-0.5 rounded text-xs font-semibold
                            {{ $sa['score'] >= 3
                                ? 'bg-green-100 text-green-700'
                                : ($sa['score'] >= 2
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">

                            {{ number_format($sa['score'], 2) }}

                        </span>

                    </a>
                @endforeach

            </div>
        </div>

        <!-- KONTEN UTAMA KANAN -->
        <div class="w-3/4 flex flex-col gap-6">

            <!-- Header Sub Area -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex justify-between items-start">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ $penilaian->sub_area }}
                    </h1>

                    <p class="text-sm text-gray-600 max-w-xl">
                        {{ $penilaian->deskripsi }}
                    </p>
                </div>

                <div class="border-l-4 border-blue-600 pl-4 py-1">

                    <p class="text-xs text-gray-500 font-semibold">
                        Score ML sub area
                    </p>

                    <h2 class="text-3xl font-bold text-gray-900">
                        {{ number_format($penilaian->score_ml, 2) }}
                    </h2>

                    <p class="text-[11px] text-gray-400 mt-1 max-w-50 leading-tight">
                        Level berikutnya terbuka setelah seluruh dokumen pada level sebelumnya diunggah.
                    </p>

                </div>
            </div>

            <!-- TAB LEVEL 1 - 5 -->
            <div class="grid grid-cols-5 gap-3">

                @foreach ($levelTabs as $tab)
                    @php
                        $isActive = $tab['level'] == $selectedLevel['level'];

                        $range = $tab['level'] == 1 ? '0 < x ≤ 1' : $tab['level'] - 1 . ' < x ≤ ' . $tab['level'];
                    @endphp

                    @if ($tab['can_access'])
                        <a href="{{ route('penilaian', [
                            'id' => $subArea->id,
                            'level' => $tab['level'],
                        ]) }}"
                            class="border rounded-lg p-2 flex flex-col items-center justify-center transition-transform hover:scale-105
                            {{ $isActive
                                ? 'border-blue-900 bg-blue-900 text-white shadow-md'
                                : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50' }}">

                            <span class="font-bold text-sm">
                                Level {{ $tab['level'] }}
                            </span>

                            <span class="text-xs font-semibold mt-1">
                                {{ $range }}
                            </span>

                            <span
                                class="text-[10px] mt-1
                                {{ $isActive ? 'text-blue-200' : 'text-gray-500' }}">

                                Nilai {{ number_format($tab['value'], 2) }}

                            </span>

                            @if ($tab['complete'])
                                <span
                                    class="text-[9px] mt-0.5
                                    {{ $isActive ? 'text-blue-200' : 'text-green-600' }}">
                                    Selesai
                                </span>
                            @endif

                        </a>
                    @else
                        <div
                            class="border border-gray-200 bg-gray-50 text-gray-400 rounded-lg p-2 flex flex-col items-center justify-center cursor-not-allowed">

                            <span class="font-bold text-sm">
                                Level {{ $tab['level'] }}
                            </span>

                            <span class="text-xs font-semibold mt-1">
                                {{ $range }}
                            </span>

                            <span class="text-[10px] mt-1">
                                Terkunci
                            </span>

                            <span class="text-[9px] mt-0.5">
                                {{ $tab['uploaded'] }}/{{ $tab['total'] }} dokumen
                            </span>

                        </div>
                    @endif
                @endforeach

            </div>

            <!-- KONTEN LEVEL TERPILIH -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="flex justify-between items-center mb-6">

                    <div>
                        <p class="text-sm text-gray-500 mb-1">
                            Level {{ $selectedLevel['level'] }}
                        </p>

                        <h2 class="text-xl font-bold text-gray-900">
                            {{ $levelModel->nama_level }}
                        </h2>
                    </div>

                    <div class="flex items-center gap-4 text-sm">

                        <span class="text-gray-500">
                            {{ $penilaian->jumlah_kriteria }} kriteria
                        </span>

                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-md font-semibold">
                            Nilai level

                            <span class="text-blue-600">
                                {{ number_format($penilaian->nilai_level, 2) }}
                            </span>
                        </span>

                    </div>

                </div>

                <!-- Informasi progres upload -->
                <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-100">

                    <div class="flex justify-between items-center mb-2">

                        <p class="text-sm font-semibold text-blue-900">
                            Progres pengunggahan dokumen
                        </p>

                        <span class="text-sm font-bold text-blue-700">
                            {{ $penilaian->jumlah_terunggah }}/{{ $penilaian->jumlah_kriteria }}
                        </span>

                    </div>

                    @php
                        $persentase =
                            $penilaian->jumlah_kriteria > 0
                                ? ($penilaian->jumlah_terunggah / $penilaian->jumlah_kriteria) * 100
                                : 0;
                    @endphp

                    <div class="w-full bg-blue-100 rounded-full h-2.5">

                        <div class="bg-blue-600 h-2.5 rounded-full transition-all" style="width: {{ $persentase }}%">
                        </div>

                    </div>

                    <p class="text-xs text-blue-700 mt-2">
                        Dokumen yang sudah diunggah tetap dihitung meskipun belum diverifikasi Admin.
                    </p>

                </div>

                <!-- DAFTAR KRITERIA -->
                <div class="flex flex-col gap-6">

                    @forelse ($penilaian->kriteria_level as $krit)
                        <div id="criterion-{{ $krit->id }}"
                            class="border border-gray-200 rounded-xl p-5 relative
    {{ $krit->status == 'terkunci' ? 'opacity-60 pointer-events-none' : '' }}">

                            <!-- Header Kriteria -->
                            <div class="flex justify-between items-start mb-4">

                                <div class="flex gap-3">

                                    <div
                                        class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold text-sm shrink-0">

                                        {{ $krit->no }}

                                    </div>

                                    <h3 class="font-bold text-gray-900 mt-1">
                                        {{ $krit->judul }}
                                    </h3>

                                </div>

                                <div
                                    class="text-xs
                                    {{ $krit->indeks_dokumen > 0
                                        ? 'bg-green-50 text-green-700 border-green-200'
                                        : 'bg-red-50 text-red-600 border-red-200' }}
                                    border px-3 py-1 rounded-md flex items-center gap-2">

                                    Indeks dokumen

                                    <span class="font-bold">
                                        {{ $krit->indeks_dokumen }}
                                    </span>

                                </div>

                            </div>

                            @if ($krit->status == 'terkunci')
                                <div
                                    class="mb-4 bg-red-50 text-red-600 text-sm p-3 rounded-md border-l-4 border-red-500">

                                    <span class="font-semibold">
                                        Kriteria terkunci.
                                    </span>

                                    Unggah dokumen pada kriteria sebelumnya terlebih dahulu
                                    untuk melanjutkan.

                                </div>
                            @endif

                            {{-- Catatan Verifikator --}}
                            <div class="mb-4">

                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Catatan verifikator
                                </label>

                                <textarea rows="2" readonly placeholder="Belum ada catatan dari verifikator"
                                    class="w-full border border-gray-200 rounded-md p-2.5 text-sm bg-gray-50 resize-y cursor-not-allowed">{{ $krit->catatan }}</textarea>

                            </div>


                            <!-- Lampiran Bukti -->
                            <div
                                class="border border-gray-100 rounded-lg p-4 flex justify-between items-center bg-white shadow-sm gap-4">

                                <div class="min-w-0">

                                    <p class="font-semibold text-sm text-gray-800 mb-0.5">
                                        Lampiran bukti
                                    </p>

                                    <p class="text-xs text-gray-500 break-all">

                                        @if ($krit->file)
                                            File terunggah:

                                            <a href="{{ asset('storage/' . $krit->file_path) }}" target="_blank"
                                                class="text-blue-600 font-semibold hover:underline">

                                                {{ $krit->file }}

                                            </a>
                                        @else
                                            Belum ada dokumen yang diunggah.
                                        @endif

                                    </p>

                                    @if ($krit->file)
                                        @if ($krit->status_verifikasi == 'menunggu')
                                            <p class="text-xs text-yellow-600 mt-1">
                                                Menunggu verifikasi Admin
                                            </p>
                                        @elseif ($krit->status_verifikasi == 'sesuai')
                                            <p class="text-xs text-green-600 mt-1">
                                                Dokumen telah disetujui Admin
                                            </p>
                                        @elseif ($krit->status_verifikasi == 'tidak_sesuai')
                                            <p class="text-xs text-red-600 mt-1">
                                                Dokumen tidak sesuai. Silakan unggah ulang.
                                            </p>
                                        @endif
                                    @endif

                                </div>

                                <div class="flex items-center gap-2 shrink-0">

                                    @if ($krit->status_verifikasi != 'sesuai')
                                        {{-- Tombol Ganti / Pilih File --}}
                                        <form data-preserve-scroll
                                            action="{{ route('Unit.penilaian.upload', [
                                                'id' => $subArea->id,
                                                'kriteria' => $krit->id,
                                            ]) }}"
                                            method="POST" enctype="multipart/form-data">

                                            @csrf

                                            <input type="file" name="file_bukti" id="file-{{ $krit->id }}"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required
                                                class="hidden" onchange="this.form.requestSubmit()">

                                            <label for="file-{{ $krit->id }}"
                                                class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-1.5 rounded-md text-xs font-semibold hover:bg-gray-50 whitespace-nowrap">

                                                {{ $krit->file ? 'Ganti file' : 'Pilih file' }}

                                            </label>

                                        </form>

                                        {{-- Tombol Hapus hanya muncul jika ada file --}}
                                        @if ($krit->file)
                                            <form data-preserve-scroll
                                                action="{{ route('Unit.penilaian.hapus', [
                                                    'id' => $subArea->id,
                                                    'kriteria' => $krit->id,
                                                ]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah kamu yakin ingin menghapus dokumen ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="bg-red-50 border border-red-200 text-red-600 px-4 py-1.5 rounded-md text-xs font-semibold hover:bg-red-100 whitespace-nowrap">

                                                    Hapus

                                                </button>

                                            </form>
                                        @endif
                                    @else
                                        <button type="button" disabled
                                            class="bg-gray-100 border border-gray-200 text-gray-400 px-4 py-1.5 rounded-md text-xs font-semibold cursor-not-allowed">

                                            Disetujui

                                        </button>
                                    @endif

                                </div>

                            </div>


                        </div>

                    @empty

                        <div class="text-center py-10 text-gray-500">

                            <p class="font-semibold">
                                Belum ada kriteria pada level ini.
                            </p>

                            <p class="text-sm mt-1">
                                Silakan periksa data kriteria pada database.
                            </p>

                        </div>
                    @endforelse

                </div>

            </div>

        </div>
    </div>

    <script>
        // Simpan posisi scroll sebelum form dikirim.

        document.addEventListener('DOMContentLoaded', function() {

            // =========================================
            // 1. SIMPAN POSISI KARTU SEBELUM FORM DIKIRIM
            // =========================================

            document.querySelectorAll('form[data-preserve-scroll]').forEach(form => {

                form.addEventListener('submit', function() {

                    const card = form.closest('[id^="criterion-"]');

                    if (card) {

                        const cardPosition = card.getBoundingClientRect();

                        const scrollData = {
                            id: card.id,
                            top: cardPosition.top
                        };

                        sessionStorage.setItem(
                            'penilaian_scroll_position',
                            JSON.stringify(scrollData)
                        );
                    }

                });

            });


            // =========================================
            // 2. KEMBALIKAN POSISI SETELAH HALAMAN DIMUAT
            // =========================================

            const savedPosition = sessionStorage.getItem(
                'penilaian_scroll_position'
            );

            if (savedPosition) {

                sessionStorage.removeItem('penilaian_scroll_position');

                try {

                    const position = JSON.parse(savedPosition);

                    window.addEventListener('load', function() {

                        // Tunggu browser menyelesaikan layout halaman.
                        requestAnimationFrame(() => {

                            requestAnimationFrame(() => {

                                const card = document.getElementById(position.id);

                                if (card) {

                                    const currentPosition = card.getBoundingClientRect();

                                    const difference = currentPosition.top - position.top;

                                    window.scrollTo({
                                        top: window.scrollY + difference,
                                        left: 0,
                                        behavior: 'auto'
                                    });

                                }

                            });

                        });

                    }, {
                        once: true
                    });

                } catch (error) {
                    console.error('Gagal mengembalikan posisi halaman:', error);
                }

            }


            // =========================================
            // 3. NOTIFIKASI HILANG OTOMATIS
            // =========================================

            document.querySelectorAll('.notification-alert').forEach(notification => {

                setTimeout(() => {
                    closeNotification(notification.querySelector('button'));
                }, 4000);

            });

        });


        // =========================================
        // 4. TUTUP NOTIFIKASI DENGAN ANIMASI
        // =========================================

        function closeNotification(button) {

            if (!button) return;

            const notification = button.closest('.notification-alert');

            if (!notification) return;

            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                notification.remove();
            }, 300);

        }
    </script>
</body>

</html>
