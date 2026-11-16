<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Unit - Banjarsari | PLN NPS</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #123f70;
            --blue: #078bd0;
            --cyan: #20c5e8;
            --green: #10b981;
            --purple: #6555ed;
            --text: #244f77;
            --muted: #7190b0;
            --border: #dcecf9;
            --background: #eaf6ff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            background: var(--background);
            min-height: 100vh;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        /* TOPBAR */
        .topbar {
            height: 92px;
            padding: 0 2.7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: rgba(255, 255, 255, .96);
            border-bottom: 1px solid #dceefa;
            position: relative;
            z-index: 10;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 0;
        }

        .brand-logo {
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -.3px;
        }

        .brand-subtitle {
            font-size: 11px;
            margin-top: 3px;
            color: #7190b0;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 17px;
        }

        .icon-button {
            width: 51px;
            height: 51px;
            display: grid;
            place-items: center;
            color: #28649b;
            background: white;
            border: 1px solid #d7eafa;
            border-radius: 15px;
            font-size: 21px;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
        }

        .icon-button:hover {
            background: #eefaff;
            border-color: #8edff5;
            transform: translateY(-1px);
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 49px;
            height: 49px;
            display: grid;
            place-items: center;
            background: #d8f6ff;
            color: #087bc1;
            border-radius: 16px;
            font-size: 24px;
            font-weight: 800;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
        }

        .profile-role {
            color: #7e9bb7;
            font-size: 11px;
            margin-top: 3px;
        }

        /* BACKGROUND & ANIMASI ROBOT */
        .dashboard {
            position: relative;
            isolation: isolate;
            min-height: calc(100vh - 92px);
            padding: 35px 4.3% 65px;
            overflow: hidden;
            background: radial-gradient(ellipse at 10% 10%, #ffffff 0%, transparent 48%), linear-gradient(140deg, #f5fbff 0%, #e6f5ff 55%, #d9f0ff 100%);
        }

        .dashboard::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -2;
            pointer-events: none;
            background: radial-gradient(ellipse at 0% 45%, #c5efff88, transparent 32%), radial-gradient(ellipse at 100% 75%, #a9eaff75, transparent 35%);
        }

        /* KODE ROBOT DIAKTIFKAN KEMBALI */
        .robot-top {
            position: absolute;
            z-index: -1;
            top: 12px;
            right: 7%;
            width: 280px;
            max-height: 220px;
            object-fit: contain;
            opacity: .98;
            pointer-events: none;
            animation: floatRobot 4s ease-in-out infinite;
        }

        .robot-bottom {
            position: absolute;
            z-index: -1;
            left: -75px;
            bottom: -35px;
            width: 270px;
            max-height: 400px;
            object-fit: contain;
            opacity: .38;
            pointer-events: none;
            animation: floatRobot 5s ease-in-out infinite;
        }

        @keyframes floatRobot {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-9px);
            }
        }

        /* JUDUL */
        .page-heading {
            position: relative;
            z-index: 1;
            margin-bottom: 28px;
        }

        .page-heading h1 {
            color: #103f78;
            font-size: clamp(25px, 2.2vw, 37px);
            line-height: 1.35;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .title-underline {
            width: 49px;
            height: 5px;
            margin: 14px 0 17px;
            border-radius: 10px;
            background: linear-gradient(90deg, #20c9f0, #70e4f7);
        }

        .page-heading p {
            color: #6c94ba;
            font-size: 13px;
            line-height: 1.8;
        }

        /* KARTU RINGKASAN */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
            position: relative;
            z-index: 1;
            margin-bottom: 21px;
        }

        .stat-card {
            position: relative;
            min-height: 165px;
            padding: 25px 22px;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            border: 1px solid #ccecff;
            border-radius: 20px;
            background: rgba(255, 255, 255, .91);
            box-shadow: 0 8px 23px #5ba8e51a;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 27px #5ba8e52a;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 135px;
            height: 85px;
            right: -18px;
            bottom: -42px;
            transform: rotate(-30deg);
            background: var(--card-shape);
            opacity: .8;
        }

        .stat-card.blue {
            --card-shape: #b8edff;
            border-color: #c5ecff;
        }

        .stat-card.green {
            --card-shape: #a9f5d7;
            border-color: #d1f8e7;
            background: linear-gradient(130deg, #fff, #f2fff9);
        }

        .stat-card.purple {
            --card-shape: #dedbff;
            border-color: #dedaff;
            background: linear-gradient(130deg, #fff, #f7f6ff);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            font-size: 29px;
        }

        .blue .stat-icon {
            color: #0798d7;
            background: #d4f4ff;
        }

        .green .stat-icon {
            color: #0bb57d;
            background: #d2ffeb;
        }

        .purple .stat-icon {
            color: #5548ed;
            background: #e0dcff;
        }

        .stat-content {
            position: relative;
            z-index: 1;
            min-width: 0;
            padding-top: 7px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: #25517e;
            line-height: 1.6;
        }

        .stat-number {
            margin-top: 4px;
            color: #164b7c;
            font-size: 37px;
            line-height: 1.3;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stat-description {
            margin-top: 5px;
            color: #7097bc;
            font-size: 11px;
        }

        /* KARTU TABEL */
        .table-card {
            position: relative;
            z-index: 1;
            padding: 25px 27px 12px;
            border: 1px solid #d6eafa;
            border-radius: 21px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 9px 28px #5ba8e51c;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 20px;
        }

        .table-heading {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .table-heading-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: linear-gradient(140deg, #0795d8, #0876c7);
            color: white;
            font-size: 22px;
            box-shadow: 0 4px 10px #008ed52b;
        }

        .table-heading h2 {
            color: #174779;
            font-size: 16px;
            font-weight: 700;
        }

        .table-heading p {
            margin-top: 3px;
            color: #7c9dbb;
            font-size: 11px;
        }

        .table-tools {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-outline {
            height: 44px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 1px solid #d1e7f8;
            border-radius: 14px;
            background: white;
            color: #145487;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
        }

        .btn-outline:hover {
            background: #eaf8ff;
            border-color: #91d7f4;
        }

        /* Styling Tabel Include */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
        }

        .table-wrapper table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            white-space: nowrap;
            font-family: inherit;
        }

        .table-wrapper thead th {
            padding: 18px 17px;
            text-align: left;
            background: #eaf5ff;
            color: #28618f;
            font-size: 12px;
            font-weight: 700;
        }

        .table-wrapper thead th:first-child {
            border-radius: 12px 0 0 12px;
        }

        .table-wrapper thead th:last-child {
            border-radius: 0 12px 12px 0;
        }

        .table-wrapper tbody td {
            padding: 14px 17px;
            height: 78px;
            border-bottom: 1px solid #e5f1fa;
            font-size: 12px;
            color: #46759e;
            transition: background .2s;
        }

        .table-wrapper tbody tr:hover td {
            background: #f2faff;
        }

        .table-wrapper tbody tr:last-child td {
            border-bottom: 0;
        }

        .table-wrapper td strong {
            display: block;
            color: #164779;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .table-wrapper td small {
            color: #7c9dbb;
            font-size: 11px;
        }

        /* Tombol Aksi di Tabel (Lengkapi / Tinjau) */
        .table-wrapper .btn-action {
            display: inline-block;
            padding: 8px 20px;
            background: white;
            border: 1px solid #d5eafa;
            border-radius: 8px;
            color: #078bd0;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .table-wrapper .btn-action:hover {
            background: #edf9ff;
            border-color: #8bd8f5;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .dashboard {
                padding-left: 3%;
                padding-right: 3%;
            }

            .stat-card {
                padding: 20px 16px;
                gap: 11px;
            }

            .stat-icon {
                width: 55px;
                height: 55px;
                font-size: 24px;
            }

            .stat-number {
                font-size: 31px;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                height: auto;
                min-height: 76px;
                padding: 12px 16px;
            }

            .profile-name,
            .profile-role {
                display: none;
            }

            .dashboard {
                padding: 27px 16px 45px;
            }

            .page-heading h1 {
                font-size: 27px;
            }

            .robot-top {
                width: 135px;
                right: 0;
                top: 0;
                opacity: .48;
            }

            .robot-bottom {
                width: 145px;
                left: -55px;
                opacity: .2;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                min-height: 125px;
                padding: 19px;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .table-tools {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="brand">
            <div class="brand-logo">
                <img src="{{ asset('assets/images/logopln.png') }}" alt="Logo PLN"
                    style="width: 50px; height: 50px; border-radius: 5px">
            </div>
            <div>
                <div class="brand-name">PLN NUSANTARA POWER SERVICES</div>
                <div class="brand-subtitle">Sistem Verifikasi Maturity Level SCM</div>
            </div>
        </div>

        <div class="topbar-actions">
            <div class="profile">
                <div class="avatar">B</div>
                <div class="profile-info">
                    <div class="profile-name">Unit Banjarsari</div>
                    <div class="profile-role">Pekerja</div>
                </div>
                <a href="{{ url('/logout') }}" class="icon-button"
                    style="width: 80px; font-size: 12px; font-weight: bold; text-decoration: none;">
                    Keluar
                </a>
            </div>
        </div>
    </header>

    <!-- DASHBOARD -->
    <main class="dashboard">

        <!-- Maskot Robot (Animasi Melayang) -->
        <img src="{{ asset('assets/images/robot-pln.png') }}" class="robot-top" alt=""
            onerror="this.style.display='none'">
        <img src="{{ asset('assets/images/robot-pln.png') }}" class="robot-bottom" alt=""
            onerror="this.style.display='none'">

        <!-- Judul Halaman -->
        <section class="page-heading">
            <h1>Portal Unit Banjarsari</h1>
            <div class="title-underline"></div>
            <p>Lengkapi dokumen bukti dan pantau capaian self-assessment unit Anda.</p>
        </section>

        <!-- RINGKASAN (Animasi Hover Terangkat) -->
        <section class="stats-grid">
            <article class="stat-card blue">
                <div class="stat-icon">♟</div>
                <div class="stat-content">
                    <div class="stat-label">Nilai ML Sementara</div>
                    <div class="stat-number">3.8</div>
                    <div class="stat-description">Dari bukti saat ini</div>
                </div>
            </article>

            <article class="stat-card green">
                <div class="stat-icon">◎</div>
                <div class="stat-content">
                    <div class="stat-label">Nilai Konkin</div>
                    <div class="stat-number">3.72</div>
                    <div class="stat-description">Target tercapai</div>
                </div>
            </article>

            <article class="stat-card purple">
                <div class="stat-icon">▦</div>
                <div class="stat-content">
                    <div class="stat-label">KPI Keterlaksanaan</div>
                    <div class="stat-number">91%</div>
                    <div class="stat-description">9 sub area lengkap</div>
                </div>
            </article>
        </section>

        <!-- KARTU TABEL -->
        <section class="table-card">
            <div class="table-header">
                <div class="table-heading">
                    <div class="table-heading-icon">▤</div>
                    <div>
                        <h2>LAMPIRAN PEDOMAN MATURITY LEVEL SUPPLY CHAIN MANAGEMENT (MATURITY)</h2>
                        <p>Pilih sub area untuk melengkapi atau meninjau dokumen bukti</p>
                    </div>
                </div>

                <div class="table-tools">
                    <a href="{{ route('riwayatKpi') }}" class="btn-outline">
                        Riwayat KPI
                    </a>
                </div>
            </div>

            <!-- Tabel dari Include -->
            <div class="table-wrapper">
                @include('Unit.tabel_sub_area')
            </div>
        </section>

    </main>

</body>

</html>
