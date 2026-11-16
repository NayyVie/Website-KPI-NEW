<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | PLN NPS</title>

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
            background: #eaf6ff;
            min-height: 100vh;
        }

        button,
        input,
        select {
            font-family: inherit;
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
            font-size: 31px;
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
            position: relative;
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
        }

        .icon-button:hover,
        .dropdown-item:hover,
        .logout-button:hover {
            background: #eefaff;
            border-color: #8edff5;
            transform: translateY(-1px);
        }

        .dropdown-item {
            gap: 11px;
            border-radius: 10px;

            background: #edf6ff;
            color: #176bc0;

            text-decoration: none;

            font-family: inherit;

            font-size: 13px;

            cursor: pointer;

            box-sizing: border-box;

            transition: background 0.2s ease;

            width: 100%;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* .dropdown-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        } */

        /* .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 10px;
            height: 10px;
            border: 2px solid white;
            border-radius: 50%;
            background: #ff5284;
        } */

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
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

        .profile-menu {
            position: absolute;
            display: none;
            right: 0;
            top: 62px;
            width: 220px;
            padding: 15px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 10px 30px #194d7720;
        }

        .profile-menu.open {
            display: block;
        }

        .profile-menu button {
            width: 100%;
            border: 0;
            background: #ffe4eb;
            color: #f31616b0;
            padding: 10px;
            border-radius: 9px;
            transition: background 0.2s ease;
            cursor: pointer;
        }

        /* .profile-menu-logout {
            height: 50px;
            padding: 0 19px;
            align-items: center;
            gap: 9px;
            border: 1px solid #cfe5fa;
            border-radius: 15px;
            background: rgb(211, 70, 70);
            
            color: #f31616b0;
            font-size: 13px;
            cursor: pointer;
            transition: .2s;
        }  */

        /* BACKGROUND DAN ROBOT */
        .dashboard {
            position: relative;
            isolation: isolate;
            min-height: calc(100vh - 92px);
            padding: 35px 4.3% 65px;
            overflow: hidden;
            background:
                radial-gradient(ellipse at 10% 10%, #ffffff 0%, transparent 48%),
                linear-gradient(140deg, #f5fbff 0%, #e6f5ff 55%, #d9f0ff 100%);
        }

        .dashboard::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -2;
            pointer-events: none;
            background:
                radial-gradient(ellipse at 0% 45%, #c5efff88, transparent 32%),
                radial-gradient(ellipse at 100% 75%, #a9eaff75, transparent 35%);
        }

        .robot-top {
            position: absolute;
            z-index: -1;
            top: 12px;
            right: 7%;
            width: 280px;
            max-height: 220px;
            object-fit: contain;
            object-position: center;
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

        .stat-trend {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #dffcf0;
            color: #059669;
            font-size: 10px;
            font-weight: 700;
            vertical-align: middle;
        }

        .progress-ring {
            position: absolute;
            right: 20px;
            top: 29px;
            width: 75px;
            height: 75px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: conic-gradient(#5b4bfa 0deg 112deg, #e2e9ff 112deg 360deg);
        }

        .progress-ring::before {
            content: "";
            position: absolute;
            inset: 9px;
            border-radius: 50%;
            background: #f9f8ff;
        }

        .progress-ring span {
            position: relative;
            color: #4539d8;
            font-size: 15px;
            font-weight: 800;
        }

        /* TABEL REKAP */
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
            font-size: 18px;
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

        .search-box {
            width: 270px;
            height: 44px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 13px;
            border: 1px solid #d1e7f8;
            border-radius: 14px;
            background: white;
            color: #5790bd;
        }

        .search-box span {
            font-size: 20px;
        }

        .search-box input {
            width: 100%;
            border: 0;
            outline: none;
            color: #244f77;
            background: transparent;
            font-size: 11px;
        }

        .search-box:focus-within {
            border-color: #38bde8;
            box-shadow: 0 0 0 3px #38bde817;
        }

        .export-button {
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
        }

        .export-button:hover {
            background: #eaf8ff;
            border-color: #91d7f4;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
        }

        .unit-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            white-space: nowrap;
        }

        .unit-table thead th {
            padding: 18px 17px;
            text-align: left;
            background: #eaf5ff;
            color: #28618f;
            font-size: 12px;
            font-weight: 700;
        }

        .unit-table thead th:first-child {
            border-radius: 12px 0 0 12px;
        }

        .unit-table thead th:last-child {
            border-radius: 0 12px 12px 0;
        }

        .unit-table tbody td {
            padding: 14px 17px;
            height: 78px;
            border-bottom: 1px solid #e5f1fa;
            font-size: 12px;
            color: #46759e;
        }

        .unit-table tbody tr {
            transition: background .2s;
        }

        .unit-table tbody tr:hover {
            background: #f2faff;
        }

        .unit-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .unit-cell {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #164779;
            font-weight: 700;
        }

        .unit-icon {
            width: 51px;
            height: 51px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 50%;
            font-size: 22px;
        }

        .unit-icon.blue {
            background: #dcf5ff;
            color: #078ed0;
        }

        .unit-icon.green {
            background: #dcfff0;
            color: #10b981;
        }

        .unit-icon.orange {
            background: #fff0d9;
            color: #ed901b;
        }

        .unit-icon.purple {
            background: #e9e5ff;
            color: #7058e8;
        }

        .score-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 68px;
            padding: 10px 12px;
            border-radius: 24px;
            background: #ddfaed;
            color: #07966a;
            font-weight: 700;
        }

        .difference {
            color: #079d81;
            font-weight: 700;
        }

        .row-actions {
            display: flex;
            gap: 12px;
        }

        .action-button {
            min-width: 114px;
            height: 45px;
            padding: 0 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 1px solid #d5eafa;
            border-radius: 12px;
            background: white;
            color: #078bd0;
            box-shadow: 0 3px 9px #438bc20c;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: .2s;
        }

        .action-button:hover {
            background: #edf9ff;
            border-color: #8bd8f5;
            transform: translateY(-1px);
        }

        .action-button.export {
            min-width: 114px;
        }

        .empty-state {
            display: none;
            padding: 35px;
            text-align: center;
            color: #819bb5;
            font-size: 13px;
        }

        /* RESPONSIVE */
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

            .progress-ring {
                width: 60px;
                height: 60px;
                right: 12px;
            }

            .progress-ring::before {
                inset: 7px;
            }

            .purple .stat-content {
                padding-right: 50px;
            }

            .search-box {
                width: 220px;
            }
        }

        @media (max-width: 760px) {
            .topbar {
                height: auto;
                min-height: 76px;
                padding: 12px 16px;
            }

            .brand {
                gap: 9px;
            }

            .brand-logo {
                width: 40px;
                height: 40px;
                font-size: 23px;
            }

            .brand-name {
                font-size: 10px;
            }

            .brand-subtitle {
                font-size: 9px;
            }

            .topbar-actions {
                gap: 7px;
            }

            .icon-button {
                width: 39px;
                height: 39px;
            }

            .profile-info,
            .profile-chevron {
                display: none;
            }

            .avatar {
                width: 39px;
                height: 39px;
                font-size: 18px;
            }

            .logout-button {
                width: 40px;
                height: 39px;
                padding: 0;
                justify-content: center;
            }

            .logout-button span {
                display: none;
            }

            .dashboard {
                padding: 27px 16px 45px;
            }

            .page-heading h1 {
                font-size: 27px;
            }

            .page-heading p {
                max-width: 85%;
                font-size: 11px;
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

            .stat-icon {
                width: 58px;
                height: 58px;
            }

            .stat-number {
                font-size: 31px;
            }

            .table-card {
                padding: 18px 14px 10px;
                border-radius: 16px;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .table-tools {
                width: 100%;
            }

            .search-box {
                flex: 1;
                width: auto;
                min-width: 0;
            }

            .export-button {
                padding: 0 10px;
            }

            .unit-table thead th,
            .unit-table tbody td {
                padding-left: 12px;
                padding-right: 12px;
            }

            .unit-table tbody td {
                height: 69px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }
        }


        /* ===== SCORE ML PER SUB AREA ===== */
        .score-subarea-section {
            position: relative;
            z-index: 1;
            margin-top: 28px;
            margin-bottom: 36px;
            padding: 25px 28px 28px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #d5e9fa;
            border-radius: 23px;
            box-shadow: 0 10px 30px rgba(27, 104, 170, 0.08);
            overflow: hidden;
        }

        .score-section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 22px;
        }

        .score-section-header h2 {
            margin: 0 0 7px;
            color: #174b78;
            font-size: 19px;
            font-weight: 700;
        }

        .score-section-header p {
            margin: 0;
            color: #7794ad;
            font-size: 12px;
        }

        .score-legend {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 13px;
            color: #7890a7;
            font-size: 11px;
        }

        .score-legend span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            display: inline-block;
            border-radius: 3px;
        }

        .legend-dot.green {
            background: #d9f3e7;
        }

        .legend-dot.orange {
            background: #ffedcf;
        }

        .legend-dot.red {
            background: #ffe1e3;
        }

        .score-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border-radius: 12px;
        }

        .score-table {
            width: 100%;
            min-width: 1000px;
            border-collapse: separate;
            border-spacing: 0;
            font-family: inherit;
            font-size: 11px;
            color: #315a78;
        }

        .score-table thead th {
            height: 76px;
            padding: 12px 10px;
            background: #eaf5ff;
            color: #32658e;
            font-weight: 700;
            text-align: left;
            border-bottom: 1px solid #d6e9f8;
        }

        .score-table thead th:first-child {
            border-radius: 10px 0 0 10px;
        }

        .score-table thead th:last-child {
            border-radius: 0 10px 10px 0;
        }

        .score-table .unit-heading {
            min-width: 78px;
            text-align: center;
            vertical-align: middle;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
            padding: 8px;
        }

        .score-table tbody td {
            padding: 8px 10px;
            height: 42px;
            border-bottom: 1px solid #e1edf7;
            background: #fff;
            transition: background 0.2s ease;
        }

        .score-table tbody tr:nth-child(even) td {
            background: #fbfdff;
        }

        .score-table tbody tr:hover td {
            background: #eff8ff;
        }

        .score-table tbody td:nth-child(n+3) {
            text-align: center;
        }

        .score-table tbody tr:last-child td {
            border-bottom: none;
        }

        .score-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 55px;
            min-height: 30px;
            padding: 5px 8px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .score-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(36, 92, 140, 0.12);
        }

        .score-badge.good {
            background: #dff4e9;
            color: #168154;
        }

        .score-badge.medium {
            background: #fff0d9;
            color: #a55b0c;
        }

        .score-badge.low {
            background: #ffe5e6;
            color: #d3313d;
        }

        /* Menyesuaikan layar laptop dan tablet */
        @media (max-width: 768px) {
            .score-subarea-section {
                padding: 18px 14px;
                margin-top: 20px;
                border-radius: 17px;
            }

            .score-section-header h2 {
                font-size: 17px;
            }

            .score-legend {
                gap: 9px;
            }
        }

        .score-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .score-badge:hover {
            transform: translateY(-2px);
            filter: brightness(0.95);
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
            <button type="button" class="icon-button" aria-label="Notifikasi"
                onclick="alert('Belum ada notifikasi baru.')">
                <img src="{{ asset('assets/images/icon-notificationT.png') }}" alt="Notifikasi"
                    style="width: 20px; height: 20px">
            </button>

            <div class="profile">
                <div class="avatar">A</div>
                <div class="profile-info">
                    <div class="profile-name">Admin Pusat</div>
                    <div class="profile-role">Administrator</div>
                </div>

                <button type="button" class="icon-button" style="width:28px;height:36px;border:0"
                    onclick="document.getElementById('profileMenu').classList.toggle('open')"
                    aria-label="Menu profil">▾</button>

                <div class="profile-menu" id="profileMenu">
                    <a href="#" class="dropdown-item">
                        {{-- <a href="{{ route('profileEmployee') }}"
                                class="dropdown-item {{ request()->routeIs('profileEmployee') ? 'active' : '' }}"></a> --}}
                        Profil
                    </a>



                    <form action="{{ url('/logout') }}" method="POST""
                        onsubmit="return confirm('Apakah kamu yakin ingin keluar?')">
                        @csrf
                        <button type="submit" class="profile-menu-logout">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- DASHBOARD -->
    <main class="dashboard">

        <!-- Ganti dengan file robot milikmu jika tersedia -->
        <img src="{{ asset('assets/images/robot-pln.png') }}" class="robot-top" alt=""
            onerror="this.style.display='none'">

        <img src="{{ asset('assets/images/robot-pln.png') }}" class="robot-bottom" alt=""
            onerror="this.style.display='none'">

        <section class="page-heading">
            <h1>Verifikasi Maturity Level SCM</h1>
            <div class="title-underline"></div>
            <p>Pantau progres, bandingkan capaian, dan verifikasi seluruh unit pembangkit.</p>
        </section>

        <!-- RINGKASAN -->
        <section class="stats-grid">

            <article class="stat-card blue">
                <div class="stat-icon">♟</div>
                <div class="stat-content">
                    <div class="stat-label">Rata-rata nilai konkin (semua unit)</div>
                    <div class="stat-number">
                        3.4
                        <span class="stat-trend">↑ +0.12</span>
                    </div>
                    <div class="stat-description">Semester berjalan</div>
                </div>
            </article>

            <article class="stat-card green">
                <div class="stat-icon">◎</div>
                <div class="stat-content">
                    <div class="stat-label">Target nilai konkin</div>
                    <div class="stat-number">3.6</div>
                    <div class="stat-description">Target perusahaan</div>
                </div>
            </article>

            <article class="stat-card purple">
                <div class="stat-icon">▦</div>
                <div class="stat-content">
                    <div class="stat-label">Unit mencapai target</div>
                    <div class="stat-number">4 dari 13</div>
                    <div class="stat-description">31% dari seluruh unit</div>
                </div>
                <div class="progress-ring"><span>31%</span></div>
            </article>

        </section>

        <!-- REKAP UNIT -->
        <section class="table-card">

            <div class="table-header">
                <div class="table-heading">
                    <div class="table-heading-icon">▤</div>
                    <div>
                        <h2>Rekap per unit</h2>
                        <p>Ringkasan hasil verifikasi seluruh unit pembangkit</p>
                    </div>
                </div>

                <div class="table-tools">
                    <label class="search-box">
                        <span>⌕</span>
                        <input id="searchUnit" type="search" placeholder="Cari nama unit..."
                            aria-label="Cari nama unit">
                    </label>

                    <button class="export-button" type="button" onclick="exportTable()">
                        Ekspor semua unit
                        <span>⌄</span>
                    </button>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="unit-table" id="unitTable">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>ML</th>
                            <th>KPI</th>
                            <th>Konkin</th>
                            <th>Selisih target</th>
                            <th>Tindakan</th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody id="unitTableBody">

                        @forelse ($rekapUnits as $unit)
                            <tr data-unit="{{ strtolower($unit['name']) }}">
                                <td>
                                    <div class="unit-cell">
                                        <div class="unit-icon {{ $unit['color'] }}">♟</div>
                                        <span>{{ $unit['name'] }}</span>
                                    </div>
                                </td>

                                <td>
                                    @if ($unit['ml'] !== null)
                                        {{ number_format($unit['ml'], 2) }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    {{ $unit['kpi'] ?? '—' }}
                                </td>

                                <td>
                                    <span class="score-pill">
                                        {{ $unit['konkin'] !== null ? '↑ ' . number_format($unit['konkin'], 2) : '—' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="difference">
                                        {{ $unit['difference'] ?? '—' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="row-actions">

                                        <a class="action-button"
                                            href="{{ route('verifkasiUnit', [
                                                'unit_id' => $unit['id'],
                                            ]) }}">
                                            Verifikasi
                                        </a>

                                        <button class="action-button export" type="button"
                                            onclick="exportSingleUnit(@js($unit['name']))">
                                            Ekspor
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;">
                                    Belum ada unit aktif.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

                <div class="empty-state" id="emptyState">
                    Unit tidak ditemukan. Coba kata kunci lainnya.
                </div>
            </div>
        </section>


        <!-- SCORE ML PER SUB AREA -->
        <section class="score-subarea-section">
            <div class="score-section-header">
                <div>
                    <h2>Score ML per sub area</h2>
                    <p>Pilih nilai untuk membuka detail verifikasi unit dan sub area</p>
                </div>

                <div class="score-legend">
                    <span><i class="legend-dot green"></i> ≥ 3.6</span>
                    <span><i class="legend-dot orange"></i> 2–3.59</span>
                    <span><i class="legend-dot red"></i> &lt; 2</span>
                </div>
            </div>

            <div class="score-table-wrapper">

                <table class="score-table">
                    <thead>
                        <tr>
                            <th>Area</th>
                            <th>Sub area</th>

                            @foreach ($unitList as $unit)
                                <th class="unit-heading">
                                    {{ $unit->nama_unit }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($scorePerSubArea as $subArea)
                            <tr>
                                <td>{{ $subArea['area'] }}</td>

                                <td>{{ $subArea['name'] }}</td>

                                @foreach ($unitList as $unit)
                                    @php
                                        $score = $subArea['scores'][$unit->id] ?? null;
                                    @endphp

                                    <td>
                                        @if ($score !== null)
                                            <a href="{{ route('verifkasiUnit', [
                                                'unit_id' => $unit->id,
                                                'sub_area_id' => $subArea['id'],
                                            ]) }}"
                                                class="score-badge
            {{ $score >= 3.6 ? 'good' : ($score >= 2 ? 'medium' : 'low') }}"
                                                title="Lihat verifikasi {{ $unit->nama_unit }} - {{ $subArea['name'] }}">

                                                {{ number_format($score, 2) }}

                                            </a>
                                        @else
                                            <span>—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 2 + $unitList->count() }}" style="text-align:center;">
                                    Belum ada sub area aktif.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </section>


    </main>

    <script>
        // Pencarian unit
        const searchInput = document.getElementById('searchUnit');
        const tableRows = document.querySelectorAll('#unitTableBody tr');
        const emptyState = document.getElementById('emptyState');
        const unitTable = document.getElementById('unitTable');

        searchInput.addEventListener('input', function() {
            const keyword = this.value.trim().toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(function(row) {
                const unitName = row.dataset.unit || '';
                const visible = unitName.includes(keyword);

                row.style.display = visible ? '' : 'none';

                if (visible) visibleCount++;
            });

            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            unitTable.style.display = visibleCount === 0 ? 'none' : 'table';
        });

        // Ekspor tabel ke CSV yang dapat dibuka di Excel
        function exportTable() {
            downloadCSV(
                'rekap-unit-scm.csv',
                [...document.querySelectorAll('#unitTable tr')]
                .filter(row => row.style.display !== 'none')
                .map(row => [...row.querySelectorAll('th, td')]
                    .map(cell => cell.innerText.trim().replace(/\s+/g, ' '))
                )
            );
        }

        function exportSingleUnit(name) {
            const row = [...document.querySelectorAll('#unitTableBody tr')]
                .find(row => row.dataset.unit === name.toLowerCase());

            if (!row) return;

            const headers = [...document.querySelectorAll('#unitTable thead th')]
                .slice(0, 5)
                .map(cell => cell.innerText.trim());

            const values = [...row.querySelectorAll('td')]
                .slice(0, 5)
                .map(cell => cell.innerText.trim().replace(/\s+/g, ' '));

            downloadCSV('rekap-' + name.toLowerCase() + '.csv', [
                headers,
                values
            ]);
        }

        function downloadCSV(filename, rows) {
            const csv = '\uFEFF' + rows.map(row =>
                row.map(value =>
                    '"' + String(value).replace(/"/g, '""') + '"'
                ).join(';')
            ).join('\r\n');

            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });

            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = filename;
            link.click();

            URL.revokeObjectURL(url);
        }

        // Tutup dropdown profil ketika klik di luar
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('profileMenu');
            const profile = document.querySelector('.profile');

            if (!profile.contains(event.target)) {
                menu.classList.remove('open');
            }
        });
    </script>

</body>

</html>
