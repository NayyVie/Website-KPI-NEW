<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan KPI - {{ $namaUnit }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #244f77;
            background: radial-gradient(ellipse at 10% 10%, #ffffff 0%, transparent 48%), linear-gradient(140deg, #f5fbff 0%, #e6f5ff 55%, #d9f0ff 100%);
            min-height: 100vh;
        }

        /* Gaya Kustom untuk meniru Card Admin */
        .glass-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid #d6eafa;
            border-radius: 21px;
            box-shadow: 0 9px 28px rgba(91, 168, 229, 0.11);
        }

        .custom-table th {
            background-color: #eaf5ff;
            color: #28618f;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-table td {
            border-bottom: 1px solid #e5f1fa;
            color: #46759e;
            font-size: 13px;
        }

        .custom-table tr:hover td {
            background-color: #f2faff;
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        /* Gaya Dropdown Filter */
        .custom-select {
            border: 1px solid #d1e7f8;
            border-radius: 12px;
            background-color: white;
            color: #145487;
            font-size: 13px;
            font-weight: 500;
            padding: 8px 12px;
            outline: none;
            transition: all 0.2s;
        }

        .custom-select:focus {
            border-color: #38bde8;
            box-shadow: 0 0 0 3px rgba(56, 189, 232, 0.15);
        }

        /* Gaya Tombol */
        .btn-primary {
            height: 40px;
            padding: 0 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d1e7f8;
            border-radius: 12px;
            background: white;
            color: #145487;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #eaf8ff;
            border-color: #91d7f4;
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="p-6 md:p-10">

    <!-- Top Navigation -->
    <div class="max-w-6xl mx-auto mb-8 flex justify-between items-center">
        <a href="{{ url('/dashboardUnit') }}"
            class="text-sm font-semibold text-[#078bd0] hover:text-[#005a8a] flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Portal Unit
        </a>
        <a href="{{ url('/') }}" class="btn-primary">
            Keluar
        </a>
    </div>

    <!-- Header Title -->
    <div class="max-w-6xl mx-auto mb-8 relative z-10">
        <div class="flex items-center gap-3 mb-3">
            <span
                class="bg-[#d8f6ff] text-[#087bc1] text-xs font-bold px-3 py-1 rounded-md border border-[#bceeff]">Portal
                Unit</span>
            <span class="text-sm font-medium text-[#7e9bb7]">{{ $namaUnit }}</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#103f78] tracking-tight mb-2">Riwayat Laporan KPI</h1>
        <p class="text-[#6c94ba] text-sm md:text-base">Lihat kembali dokumen KPI yang pernah diunggah beserta status
            pemeriksaannya.</p>
    </div>

    <!-- Main Card Container -->
    <div class="max-w-6xl mx-auto glass-card relative z-10">

        <!-- Card Header & Filters -->
        <div
            class="p-6 md:p-8 border-b border-[#e5f1fa] flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <h2 class="text-xl font-bold text-[#174779]">Dokumen yang pernah diunggah</h2>
                <p class="text-xs font-medium text-[#7c9dbb] mt-1">{{ $dokumen->count() }} dokumen ditemukan</p>
            </div>

            <form action="{{ route('riwayatKpi') }}" method="GET" class="flex flex-wrap gap-4 w-full md:w-auto">
                <!-- Filter Bulan -->
                <div class="flex flex-col gap-1.5 flex-1 min-w-[120px]">
                    <label class="text-xs font-semibold text-[#7190b0]">Bulan</label>
                    <select name="bulan" onchange="this.form.submit()" class="custom-select w-full">
                        <option value="Semua" {{ $filterBulan == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="Januari" {{ $filterBulan == 'Januari' ? 'selected' : '' }}>Januari</option>
                        <option value="Februari" {{ $filterBulan == 'Februari' ? 'selected' : '' }}>Februari</option>
                        <option value="Maret" {{ $filterBulan == 'Maret' ? 'selected' : '' }}>Maret</option>
                        <option value="April" {{ $filterBulan == 'April' ? 'selected' : '' }}>April</option>
                        <option value="Mei" {{ $filterBulan == 'Mei' ? 'selected' : '' }}>Mei</option>
                        <option value="Juni" {{ $filterBulan == 'Juni' ? 'selected' : '' }}>Juni</option>
                    </select>
                </div>
                <!-- Filter Tahun -->
                <div class="flex flex-col gap-1.5 flex-1 min-w-[100px]">
                    <label class="text-xs font-semibold text-[#7190b0]">Tahun</label>
                    <select name="tahun" onchange="this.form.submit()" class="custom-select w-full">
                        <option value="2026" {{ $filterTahun == '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2025" {{ $filterTahun == '2025' ? 'selected' : '' }}>2025</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto rounded-b-[21px]">
            <table class="w-full text-left border-collapse custom-table">
                <thead>
                    <tr>
                        <th class="px-6 py-4">Nama Dokumen</th>
                        <th class="px-6 py-4">Tanggal Unggah</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokumen as $doc)
                        <tr>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <!-- Ikon File -->
                                    <div
                                        class="w-12 h-12 {{ $doc->tipe == 'excel' ? 'bg-[#dcfce7] text-[#16a34a] border-[#bbf7d0]' : 'bg-[#fee2e2] text-[#dc2626] border-[#fecaca]' }} rounded-xl flex items-center justify-center font-bold text-[10px] border uppercase tracking-wider shadow-sm">
                                        {{ $doc->tipe }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-[#164779]">{{ $doc->nama_file }}</p>
                                        <p class="text-xs font-medium text-[#7097bc] mt-1">{{ $doc->ukuran }} •
                                            {{ $doc->periode }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap font-medium">
                                {{ $doc->tanggal_unggah }}
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @if ($doc->status == 'Disetujui')
                                    <span
                                        class="bg-[#ddfaed] text-[#07966a] text-xs font-bold px-3 py-1.5 rounded-lg border border-[#b9f3d9]">Disetujui</span>
                                @elseif($doc->status == 'Revisi')
                                    <span
                                        class="bg-[#ffe5e6] text-[#d3313d] text-xs font-bold px-3 py-1.5 rounded-lg border border-[#ffc5c8]">Revisi</span>
                                @else
                                    <span
                                        class="bg-[#fff0d9] text-[#a55b0c] text-xs font-bold px-3 py-1.5 rounded-lg border border-[#ffe0b2]">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('detailKpi', $doc->id) }}"
                                        class="border border-[#d5eafa] text-[#078bd0] bg-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-[#edf9ff] hover:border-[#8bd8f5] transition-colors shadow-sm">
                                        Lihat Detail
                                    </a>
                                    <a href="#"
                                        class="text-[#0798d7] hover:text-[#005a8a] text-xs font-bold transition-colors">
                                        Unduh
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-[#7190b0] font-medium">
                                Tidak ada dokumen pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
