<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Unit | ML SCM App</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f3f6f9;
            color: #173451;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
        }

        button,
        input,
        textarea {
            font-family: inherit;
        }

        .page {
            width: calc(100% - 48px);
            max-width: 1500px;
            margin: 20px auto 36px;
        }

        .page-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 16px;
        }

        .back-link {
            color: #0755a0;
            text-decoration: none;
            font-size: 12px;
        }

        .unit-select {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #647b92;
        }

        .unit-select select {
            min-width: 145px;
            padding: 10px 12px;
            border: 1px solid #d5dfeb;
            border-radius: 8px;
            background: white;
            color: #173451;
        }

        /* Sidebar dan konten utama */
        .layout {
            display: grid;
            grid-template-columns: 250px minmax(0, 1fr);
            align-items: start;
            gap: 16px;
            width: 100%;
        }

        .sidebar,
        .main-card {
            border: 1px solid #dce4ed;
            border-radius: 10px;
            background: #fff;
        }

        .sidebar {
            padding: 16px 10px;
            min-width: 0;
        }

        .main-card {
            width: 100%;
            min-width: 0;
            padding: 20px;
            overflow: hidden;
        }

        .sidebar-label {
            margin: 0 5px 3px;
            color: #75869a;
            font-size: 10px;
        }

        .sidebar h3 {
            margin: 0 5px 14px;
            font-size: 13px;
        }

        .side-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 7px;
            margin-bottom: 5px;
            padding: 10px 8px;
            border: 1px solid transparent;
            border-radius: 8px;
            color: #17416b;
            font-size: 10px;
            line-height: 1.5;
        }

        .side-item.active {
            border-color: #1d4774;
            box-shadow: inset 3px 0 #173d63;
            background: #f8fafc;
            font-weight: 600;
        }

        .side-score {
            flex-shrink: 0;
            padding: 4px 7px;
            border-radius: 12px;
            background: #fff0dc;
            color: #a65c05;
            font-size: 9px;
        }

        /* .main-card {
            min-width: 0;
            padding: 20px;
        } */

        /* Kurangi ruang kosong pada bagian judul */
        .overview {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 190px;
            align-items: stretch;
            gap: 22px;
            margin-bottom: 18px;
        }

        .eyebrow {
            color: #657b93;
            font-size: 10px;
        }

        .overview h1 {
            margin: 6px 0;
            color: #153b61;
            font-size: 22px;
        }

        /* .description {
            max-width: 490px;
            margin: 0;
            color: #607994;
            font-size: 11px;
            line-height: 1.7;
        } */

        .description {
            max-width: 650px;
            line-height: 1.65;
        }

        .score-card {
            width: 100%;
            min-width: 0;
            flex-shrink: 0;
            padding: 14px;
            border-left: 2px solid #00a9bd;
            border-radius: 0 7px 7px 0;
            background: #f7f9fb;
        }

        .score-card span {
            color: #657b93;
            font-size: 10px;
        }

        .score-card strong {
            display: block;
            margin: 3px 0;
            font-size: 27px;
        }

        .score-card p {
            margin: 0;
            color: #657b93;
            font-size: 9px;
            line-height: 1.5;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px 0 10px;
        }

        .section-heading small {
            color: #71859a;
            font-size: 10px;
        }

        .section-heading h2 {
            margin: 3px 0 0;
            font-size: 14px;
        }

        .section-meta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .criteria-count {
            color: #71859a;
            font-size: 10px;
            white-space: nowrap;
        }

        .level-score {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 9px;
            border: 1px solid #d8e2ec;
            border-radius: 8px;
            background: #fff;
        }

        .level-score span {
            color: #657b93;
            font-size: 10px;
            white-space: nowrap;
        }

        .level-score strong {
            display: flex;
            min-width: 33px;
            height: 28px;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: #e1f4f3;
            color: #008c91;
            font-size: 12px;
            font-weight: 600;
        }

        .criteria-card {
            margin-bottom: 10px;
            /* padding: 14px 16px; */
            padding-top: 12px;
            padding-bottom: 12px;
            border: 1px solid #d8e2ec;
            border-radius: 9px;
            background: white;
            width: 100%;

        }

        .criteria-card.locked {
            background: #fbfcfd;
        }

        .criteria-header {
            display: grid;
            grid-template-columns: 27px minmax(0px, 1fr) 108px 168px;
            align-items: center;
            gap: 10px;
        }

        .number {
            display: flex;
            width: 24px;
            height: 24px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e1f4e8;
            color: #17834a;
            font-size: 10px;
        }

        .number.error {
            background: #fde7e5;
            color: #d93025;
        }

        .criteria-title {
            padding-top: 4px;
            font-size: 12px;
            line-height: 1.6;
            font-weight: 500;
        }

        .locked .criteria-title {
            color: #778797;
        }

        .index-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            min-height: 35px;
            padding: 6px 8px;
            border: 1px solid #d9e2ec;
            border-radius: 7px;
            color: #657b93;
            font-size: 9px;
        }

        .index-value {
            display: flex;
            width: 21px;
            height: 21px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e1f4e8;
            color: #17834a;
            font-weight: 600;
        }

        .index-value.zero {
            background: #fde7e5;
            color: #d93025;
        }

        .actions {
            display: flex;
            overflow: hidden;
            min-height: 35px;
            border: 1px solid #d9e2ec;
            border-radius: 7px;
        }

        .actions button {
            flex: 1;
            padding: 6px;
            border: 0;
            border-right: 1px solid #d9e2ec;
            background: white;
            color: #173451;
            font-size: 10px;
            cursor: pointer;
        }

        .actions button:last-child {
            border-right: 0;
        }

        .actions .yes.active {
            background: #e1f4e8;
            color: #17834a;
        }

        .actions .no.active {
            background: #fde7e5;
            color: #c62828;
        }

        .actions button:disabled {
            background: #f8fafc;
            color: #a6b1bd;
            cursor: not-allowed;
        }

        .locked-message {
            margin: 11px 0 12px 31px;
            padding: 10px;
            border-left: 2px solid #d93025;
            background: #fde9e7;
            color: #bd2823;
            font-size: 10px;
            line-height: 1.6;
        }

        .field,
        .evidence,
        .locked-message {
            margin-left: 37px;
        }

        /* .field {
            margin: 12px 0 10px 31px;
        } */

        .field {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            color: #71859a;
            font-size: 10px;
        }

        .field textarea {
            display: block;
            width: 100%;
            min-height: 36px;
            padding: 8px 10px;
            resize: vertical;
            border: 1px solid #d8e2ec;
            border-radius: 7px;
            outline: none;
            color: #173451;
            background: #fff;
            font-size: 10px;
        }

        .field textarea:focus {
            border-color: #69b8d7;
        }

        .field textarea:disabled {
            background: #f7f9fb;
            color: #9aa8b8;
        }

        .save-note {
            margin-top: 5px;
            padding: 6px 10px;
            border: 1px solid #d5e1eb;
            border-radius: 6px;
            background: white;
            color: #087e9d;
            font-size: 10px;
            cursor: pointer;
        }

        .evidence {
            margin-left: 31px;
            /* padding: 11px 10px 9px; */
            padding: 10px;
            border: 1px dashed #d6e0eb;
            border-radius: 8px;
            background: #f8fafc;
        }

        .evidence h4 {
            margin: 0 0 5px;
            font-size: 10px;
            font-weight: 600;
        }

        .evidence-description {
            margin: 0;
            color: #7489a0;
            font-size: 9px;
            line-height: 1.5;
        }

        .evidence-content {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #dce4ed;
        }

        .empty-file {
            padding: 7px 0;
            color: #8797a8;
            font-size: 10px;
        }

        .file-row {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px;
            border: 1px solid #dce4ed;
            border-radius: 7px;
            background: white;
        }

        .file-icon {
            display: flex;
            width: 27px;
            height: 25px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border: 1px solid #91d9e4;
            border-radius: 4px;
            background: #f0fcfd;
            color: #128da3;
            font-size: 8px;
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-info strong,
        .file-info span {
            display: block;
            overflow-wrap: anywhere;
        }

        .file-info strong {
            margin-bottom: 4px;
            font-size: 10px;
            font-weight: 500;
        }

        .file-info span {
            color: #7b8da1;
            font-size: 9px;
        }

        .file-links {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-links a {
            color: #087e9d;
            font-size: 9px;
            text-decoration: none;
            white-space: nowrap;
        }

        .file-links .open {
            padding: 7px 12px;
            border: 1px solid #9aafc7;
            border-radius: 6px;
            background: #f8fafc;
            color: #173451;
        }

        .locked .evidence {
            opacity: .7;
        }

        .file-links a.disabled {
            pointer-events: none;
            opacity: .45;
        }

        .flash {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 7px;
            background: #e1f4e8;
            color: #17834a;
        }

        .flash.error {
            background: #fde9e7;
            color: #bd2823;
        }

        .save-note:disabled {
            opacity: .45;
            cursor: not-allowed;
        }



        /* NEW */
        /* Laptop ukuran sedang */
        @media (min-width: 901px) and (max-width: 1200px) {
            .page {
                width: calc(100% - 32px);
            }

            .layout {
                grid-template-columns: 220px minmax(0, 1fr);
                gap: 12px;
            }

            .main-card {
                padding: 16px;
            }

            .overview {
                grid-template-columns: minmax(0, 1fr) 165px;
                gap: 12px;
            }

            .criteria-header {
                grid-template-columns: 25px minmax(0, 1fr) 100px 150px;
                gap: 7px;
            }

            .field,
            .evidence,
            .locked-message {
                margin-left: 32px;
            }
        }

        /* Tablet dan HP */
        @media (max-width: 900px) {
            .page {
                width: calc(100% - 24px);
            }

            .layout {
                grid-template-columns: minmax(0, 1fr);
            }

            .sidebar {
                display: none;
            }

            .main-card {
                padding: 16px;
            }
        }

        @media (max-width: 560px) {
            .overview {
                grid-template-columns: minmax(0, 1fr);
            }

            .criteria-header {
                grid-template-columns: 25px minmax(0, 1fr);
                align-items: start;
            }

            .index-box,
            .actions {
                grid-column: 2;
            }

            .field,
            .evidence,
            .locked-message {
                margin-left: 0;
            }

        }

        @media (max-width: 900px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .criteria-header {
                grid-template-columns: 27px minmax(0, 1fr) 108px;
            }

            .actions {
                grid-column: 2 / -1;
            }
        }

        @media (max-width: 600px) {
            .page {
                width: calc(100% - 20px);
                margin-top: 14px;
            }

            .main-card {
                padding: 12px;
            }

            .overview {
                flex-direction: column;
            }

            .score-card {
                width: 100%;
            }

            .criteria-header {
                grid-template-columns: 25px minmax(0, 1fr);
            }

            .index-box {
                grid-column: 2;
                width: 130px;
            }

            .actions {
                grid-column: 2;
            }

            .field,
            .evidence,
            .locked-message {
                margin-left: 0;
            }

            .file-row {
                flex-wrap: wrap;
            }

            .file-info {
                flex-basis: calc(100% - 45px);
            }

            .file-links {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 480px) {
            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .section-meta {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* MERAPIKAN HALAMAN NEW */

        /* ========================================
   PERAPIAN HALAMAN VERIFIKASI UNIT
======================================== */

        /* Area halaman */
        .page {
            width: calc(100% - 40px);
            max-width: 1500px;
            margin: 20px auto 35px;
        }

        /* Konten utama */
        .layout {
            grid-template-columns: 250px minmax(0, 1fr);
            gap: 16px;
            align-items: start;
        }

        .main-card {
            min-width: 0;
            padding: 20px;
            border-radius: 10px;
        }

        /* Header Catalogue */
        .overview {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 190px;
            gap: 22px;
            align-items: stretch;
            margin-bottom: 18px;
        }

        .overview h1 {
            margin: 5px 0 7px;
            font-size: 22px;
            line-height: 1.35;
        }

        .description {
            max-width: 650px;
            line-height: 1.65;
        }

        .score-card {
            width: 100%;
            padding: 14px;
            border-radius: 0 8px 8px 0;
        }

        /* Header Level 1 dan Fire Fighting */
        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 0 0 10px;
        }

        .section-heading h2 {
            margin: 3px 0 0;
            font-size: 15px;
            line-height: 1.4;
        }

        .section-meta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .criteria-count {
            white-space: nowrap;
            font-size: 10px;
            color: #657b93;
        }

        .level-score {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 9px;
            border: 1px solid #d8e2ec;
            border-radius: 8px;
            white-space: nowrap;
        }

        .level-score strong {
            min-width: 33px;
            height: 28px;
            border-radius: 6px;
            font-size: 12px;
        }

        /* Kartu kriteria */
        .criteria-card {
            margin: 0 0 10px;
            padding: 13px 14px;
            border: 1px solid #d8e2ec;
            border-radius: 9px;
            background: #fff;
        }

        .criteria-card.locked {
            background: #fcfdfe;
        }

        /* Nomor, judul, indeks, dan tombol sejajar */
        .criteria-header {
            display: grid;
            grid-template-columns: 27px minmax(0, 1fr) 108px 168px;
            align-items: center;
            gap: 10px;
        }

        .number {
            width: 24px;
            height: 24px;
        }

        .criteria-title {
            padding: 0;
            font-size: 11px;
            line-height: 1.55;
            font-weight: 500;
        }

        .index-box {
            min-height: 35px;
            padding: 5px 8px;
        }

        .actions {
            min-height: 35px;
        }

        .actions button {
            padding: 7px 5px;
            font-size: 10px;
        }

        /* Catatan verifikator */
        .field {
            margin: 10px 0 10px 37px;
        }

        .field label {
            margin-bottom: 6px;
            font-size: 10px;
        }

        .field textarea {
            display: block;
            width: 100%;
            min-height: 36px;
            padding: 9px 10px;
            border-radius: 7px;
            font-size: 10px;
            line-height: 1.5;
        }

        /* Tombol simpan catatan */
        .save-note {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            margin-top: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 10px;
        }

        .save-note:disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        /* Pesan ketika kriteria terkunci */
        .locked-message {
            margin: 10px 0 10px 37px;
            padding: 9px 11px;
            line-height: 1.55;
            border-left-width: 2px;
            font-size: 10px;
        }

        /* Lampiran bukti */
        .evidence {
            margin-left: 37px;
            padding: 11px;
            border-radius: 8px;
        }

        .evidence h4 {
            margin: 0 0 5px;
            font-size: 10px;
        }

        .evidence-description {
            line-height: 1.55;
        }

        .evidence-content {
            margin-top: 9px;
            padding-top: 8px;
        }

        .file-row {
            min-height: 48px;
            padding: 8px;
            gap: 9px;
        }

        .file-icon {
            width: 27px;
            height: 25px;
        }

        .file-info strong {
            font-size: 10px;
            line-height: 1.45;
        }

        .file-info span {
            font-size: 9px;
        }

        .file-links {
            gap: 12px;
        }

        .file-links .open {
            padding: 7px 12px;
        }

        /* Sidebar agar konsisten */
        .sidebar {
            padding: 15px 10px;
            border-radius: 10px;
        }

        .side-item {
            min-height: 43px;
            margin-bottom: 4px;
            padding: 9px 8px;
        }

        /* Laptop */
        @media (min-width: 901px) {
            .sidebar {
                position: sticky;
                top: 15px;
            }
        }

        /* Laptop kecil dan tablet */
        @media (max-width: 1100px) {
            .layout {
                grid-template-columns: 215px minmax(0, 1fr);
                gap: 12px;
            }

            .main-card {
                padding: 15px;
            }

            .overview {
                grid-template-columns: minmax(0, 1fr) 160px;
                gap: 12px;
            }

            .criteria-header {
                grid-template-columns: 25px minmax(0, 1fr) 100px 150px;
                gap: 7px;
            }

            .field,
            .evidence,
            .locked-message {
                margin-left: 32px;
            }
        }

        /* Tablet dan HP */
        @media (max-width: 900px) {
            .page {
                width: calc(100% - 24px);
            }

            .layout {
                grid-template-columns: minmax(0, 1fr);
            }

            .sidebar {
                display: none;
            }

            .main-card {
                padding: 14px;
            }

            .criteria-header {
                grid-template-columns: 25px minmax(0, 1fr);
                align-items: start;
            }

            .index-box,
            .actions {
                grid-column: 2;
            }
        }

        @media (max-width: 560px) {
            .overview {
                grid-template-columns: minmax(0, 1fr);
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .section-meta {
                width: 100%;
                justify-content: flex-end;
            }

            .field,
            .evidence,
            .locked-message {
                margin-left: 0;
            }

            .file-row {
                flex-wrap: wrap;
            }

            .file-info {
                flex-basis: calc(100% - 45px);
            }

            .file-links {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* NEWWWW */

        /* =========================================
   PLN NPS - VISUAL REFINEMENT VERIFIKASI
   Mengikuti desain dashboard admin
========================================= */

        body {
            background:
                radial-gradient(ellipse at 8% 100%,
                    rgba(102, 215, 255, .20), transparent 35%),
                linear-gradient(135deg, #edf8ff 0%, #f5f9fd 55%, #e4f5ff 100%);
            color: #17436b;
            overflow-x: hidden;
        }

        .page {
            position: relative;
            z-index: 1;
            width: calc(100% - 64px);
            max-width: 1600px;
            margin: 24px auto 45px;
        }

        /* Navigasi atas */
        .page-top {
            min-height: 48px;
            margin-bottom: 22px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid #d6eafb;
            border-radius: 11px;
            background: rgba(255, 255, 255, .9);
            color: #087fca;
            font-weight: 600;
            transition: .2s ease;
        }

        .back-link:hover {
            background: #e7f6ff;
            border-color: #9cdef4;
            transform: translateX(-2px);
        }

        .unit-select {
            color: #66849d;
            font-weight: 500;
        }

        .unit-select select {
            min-height: 42px;
            padding: 10px 35px 10px 14px;
            border: 1px solid #cfe4f4;
            border-radius: 11px;
            background: #fff;
            color: #17436b;
            box-shadow: 0 3px 10px rgba(23, 86, 132, .04);
        }

        .unit-select select:focus {
            outline: none;
            border-color: #12b9d7;
            box-shadow: 0 0 0 3px rgba(18, 185, 215, .12);
        }

        /* Layout utama */
        .layout {
            grid-template-columns: 255px minmax(0, 1fr);
            gap: 20px;
            align-items: start;
        }

        /* Sidebar sub-area */
        .sidebar {
            padding: 20px 14px;
            border: 1px solid #d8eaf7;
            border-radius: 18px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 8px 28px rgba(34, 100, 148, .07);
        }

        .sidebar-label {
            color: #7895ad;
            font-size: 11px;
        }

        .sidebar h3 {
            color: #17436b;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 18px;
        }

        .side-item {
            min-height: 43px;
            margin-bottom: 7px;
            padding: 11px 9px;
            border-radius: 10px;
            font-size: 10.5px;
            transition: background .2s, border-color .2s;
        }

        .side-item.active {
            background: linear-gradient(110deg, #e6f5ff, #f8fcff);
            border-color: #a6ddf5;
            box-shadow: inset 4px 0 #087fca;
            color: #0755a0;
        }

        .side-score {
            border-radius: 20px;
            padding: 5px 8px;
            background: #fff0dc;
            color: #a65c05;
            font-weight: 700;
        }

        /* Panel utama */
        .main-card {
            padding: 26px;
            border: 1px solid #d7e9f6;
            border-radius: 20px;
            background: rgba(255, 255, 255, .95);
            box-shadow: 0 10px 32px rgba(28, 94, 145, .075);
        }

        /* Bagian judul dan score ML */
        .overview {
            grid-template-columns: minmax(0, 1fr) 205px;
            gap: 25px;
            margin-bottom: 23px;
        }

        .eyebrow {
            color: #087fca;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .overview h1 {
            color: #17436b;
            font-size: clamp(24px, 2vw, 30px);
            font-weight: 800;
            letter-spacing: -.6px;
        }

        .description {
            color: #64839e;
            font-size: 12px;
            line-height: 1.8;
        }

        .score-card {
            padding: 18px;
            border: 1px solid #d6edf9;
            border-left: 4px solid #12b9d7;
            border-radius: 14px;
            background: linear-gradient(145deg, #eefaff, #ffffff);
        }

        .score-card strong {
            color: #17436b;
            font-size: 31px;
            font-weight: 800;
        }

        .score-card p {
            color: #6987a0;
            font-size: 10px;
            line-height: 1.65;
        }

        /* Judul level dan nilai */
        .section-heading {
            margin: 24px 0 14px;
            align-items: center;
        }

        .section-heading h2 {
            color: #17436b;
            font-size: 17px;
            font-weight: 800;
        }

        .section-heading small {
            color: #087fca;
        }

        .section-meta {
            gap: 12px;
        }

        .criteria-count {
            color: #64839e;
            font-size: 11px;
        }

        .level-score {
            padding: 6px 10px;
            border: 1px solid #d6e8f5;
            border-radius: 11px;
            background: #fff;
        }

        .level-score strong {
            background: #dff8f6;
            color: #008f9d;
            border-radius: 8px;
        }

        /* Kartu kriteria */
        .criteria-card {
            margin-bottom: 14px;
            padding: 17px;
            border: 1px solid #d6e7f4;
            border-radius: 15px;
            background: rgba(255, 255, 255, .98);
            box-shadow: 0 4px 15px rgba(28, 94, 145, .035);
            transition: border-color .2s, box-shadow .2s;
        }

        .criteria-card:hover {
            border-color: #b9dff3;
            box-shadow: 0 7px 20px rgba(28, 94, 145, .07);
        }

        .criteria-card.locked {
            background: #f8fafc;
            border-color: #e0e8f0;
            box-shadow: none;
        }

        .criteria-header {
            grid-template-columns: 30px minmax(0, 1fr) 108px 168px;
            gap: 12px;
        }

        .number {
            width: 28px;
            height: 28px;
            background: #dcf7eb;
            color: #16885d;
            font-weight: 700;
        }

        .number.error {
            background: #ffe8e8;
            color: #d83b48;
        }

        .criteria-title {
            color: #17436b;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.7;
        }

        .index-box {
            min-height: 39px;
            border-color: #d7e7f4;
            border-radius: 10px;
            background: #fbfdff;
        }

        .index-value {
            width: 24px;
            height: 24px;
            background: #dff8eb;
            color: #16885d;
        }

        .index-value.zero {
            background: #ffe8e8;
            color: #d83b48;
        }

        /* Tombol Sesuai dan Tidak sesuai */
        .actions {
            min-height: 39px;
            border-radius: 10px;
            border-color: #d7e7f4;
        }

        .actions button {
            font-size: 10px;
            transition: background .2s, color .2s;
        }

        .actions .yes.active {
            background: #dcf7e9;
            color: #148353;
            font-weight: 700;
        }

        .actions .no.active {
            background: #ffe7e7;
            color: #c62835;
            font-weight: 700;
        }

        .actions button:disabled {
            opacity: .65;
        }

        /* Pesan kriteria terkunci */
        .locked-message {
            margin-top: 13px;
            margin-bottom: 13px;
            padding: 11px 13px;
            border-left: 3px solid #e05c64;
            border-radius: 0 9px 9px 0;
            background: #fff0f0;
            color: #bd3b42;
            line-height: 1.7;
        }

        /* Catatan verifikator */
        .field label {
            display: block;
            margin-bottom: 9px;
            color: #6987a0;
            font-size: 11px;
            font-weight: 600;
        }

        .field textarea {
            display: block;
            width: 100%;
            min-height: 80px;
            padding: 12px 14px;
            border: 1px solid #d2e4f1;
            border-radius: 11px;
            background: #fff;
            color: #244b68;
            font-size: 11px;
            line-height: 1.7;
            resize: vertical;
            transition: border-color .2s, box-shadow .2s;
        }

        .field textarea:focus {
            outline: none;
            border-color: #12b9d7;
            box-shadow: 0 0 0 3px rgba(18, 185, 215, .10);
        }

        .field textarea:disabled {
            background: #f5f8fb;
            color: #98a8b7;
        }

        .save-note {
            margin-top: 9px;
            padding: 10px 15px;
            border: 1px solid #cde4f5;
            border-radius: 10px;
            background: #fff;
            color: #087fca;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .save-note:hover {
            background: #eaf7ff;
            border-color: #9bdcf4;
        }

        /* Lampiran bukti */
        .evidence {
            padding: 15px;
            border: 1px dashed #c4ddec;
            border-radius: 12px;
            background: #f7fbff;
        }

        .evidence h4 {
            margin: 0 0 5px;
            color: #17436b;
            font-size: 12px;
            font-weight: 700;
        }

        .evidence-description {
            margin: 0;
            color: #7893aa;
            font-size: 10px;
            line-height: 1.7;
        }

        .evidence-content {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #dceaf5;
        }

        /* File yang sudah diunggah unit */
        .file-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border: 1px solid #d9e9f5;
            border-radius: 10px;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }

        .file-row:hover {
            border-color: #a7dff2;
            box-shadow: 0 3px 12px rgba(28, 94, 145, .05);
        }

        .file-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border: 1px solid #a8e2f4;
            border-radius: 8px;
            background: #eafaff;
            color: #0786b9;
            font-size: 9px;
            font-weight: 700;
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-info strong {
            display: block;
            overflow-wrap: anywhere;
            color: #17436b;
            font-size: 11px;
        }

        .file-info span {
            display: block;
            margin-top: 5px;
            color: #7893aa;
            font-size: 9px;
            line-height: 1.6;
        }

        .file-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .file-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 7px 13px;
            border: 1px solid #d2e5f3;
            border-radius: 9px;
            background: #fff;
            color: #087fca;
            font-size: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
        }

        .file-links a:hover:not(.disabled) {
            background: #eaf7ff;
            border-color: #9bdcf4;
        }

        .file-links a.open {
            color: #17436b;
        }

        .file-links a.disabled {
            opacity: .45;
            pointer-events: none;
        }

        /* Kondisi unit belum upload dokumen */
        .empty-file {
            padding: 18px 14px;
            border: 1px dashed #d1e1ee;
            border-radius: 9px;
            background: #fff;
            color: #879caf;
            font-size: 11px;
            text-align: center;
        }

        /* Notifikasi sukses / error */
        .flash {
            margin-bottom: 18px;
            padding: 13px 16px;
            border: 1px solid #bcebd5;
            border-radius: 11px;
            background: #e9fbf2;
            color: #168353;
        }

        .flash.error {
            border-color: #f2c9cc;
            background: #fff0f0;
            color: #c83e48;
        }

        /* Robot watermark */
        .robot-watermark {
            position: fixed;
            left: -22px;
            bottom: -8px;
            z-index: 0;
            width: 235px;
            pointer-events: none;
            opacity: .27;
        }

        .robot-watermark img {
            display: block;
            width: 100%;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 8px 18px rgba(18, 115, 173, .15));
            animation: robotFloat 4s ease-in-out infinite;
        }

        @keyframes robotFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-9px);
            }
        }

        /* Responsif */
        @media (max-width: 1100px) {
            .page {
                width: calc(100% - 36px);
            }

            .layout {
                grid-template-columns: 220px minmax(0, 1fr);
                gap: 15px;
            }

            .main-card {
                padding: 20px;
            }

            .criteria-header {
                grid-template-columns: 28px minmax(0, 1fr) 100px;
            }

            .criteria-header .actions {
                grid-column: 2 / -1;
                width: 100%;
            }
        }

        @media (max-width: 900px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }

            .main-card {
                padding: 18px;
            }

            .robot-watermark {
                width: 175px;
                opacity: .17;
            }
        }

        @media (max-width: 560px) {
            .page {
                width: calc(100% - 20px);
                margin-top: 12px;
            }

            .page-top {
                align-items: flex-start;
            }

            .overview {
                grid-template-columns: 1fr;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .section-meta {
                width: 100%;
                justify-content: space-between;
            }

            .criteria-card {
                padding: 13px;
            }

            .criteria-header {
                grid-template-columns: 28px minmax(0, 1fr);
            }

            .criteria-header .index-box {
                grid-column: 1 / -1;
            }

            .criteria-header .actions {
                grid-column: 1 / -1;
            }

            .field,
            .evidence,
            .locked-message {
                margin-left: 0;
            }

            .file-row {
                flex-wrap: wrap;
            }

            .file-info {
                flex-basis: calc(100% - 50px);
            }

            .file-links {
                width: 100%;
                justify-content: flex-end;
            }

            .robot-watermark {
                width: 135px;
                left: -25px;
                opacity: .12;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .robot-watermark img {
                animation: none;
            }
        }


        /* =========================================
   TAB LEVEL 1-5 ADMIN
========================================= */

        .level-tabs {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
            width: 100%;
            margin-bottom: 24px;
        }

        .level-tab {
            display: flex;
            min-width: 0;
            min-height: 90px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px 8px;
            border: 1px solid #d8e2ec;
            border-radius: 11px;
            background: #fff;
            color: #17436b;
            text-align: center;
            text-decoration: none;
            transition: .2s ease;
        }

        .level-tab:hover {
            transform: translateY(-2px);
            border-color: #9acde9;
            background: #f4faff;
        }

        .level-tab.active {
            border-color: #173f73;
            background: #173f73;
            color: #fff;
            box-shadow: 0 4px 12px rgba(23, 63, 115, .16);
        }

        .level-tab-title {
            font-size: 12px;
            font-weight: 700;
        }

        .level-tab-range {
            margin-top: 5px;
            font-size: 10px;
            font-weight: 600;
        }

        .level-tab-value {
            margin-top: 5px;
            color: #657b93;
            font-size: 10px;
        }

        .level-tab.active .level-tab-value,
        .level-tab.active .level-tab-status {
            color: #dbeafe;
        }

        .level-tab-status {
            margin-top: 4px;
            color: #17834a;
            font-size: 9px;
            font-weight: 600;
        }

        .level-tab-status.incomplete {
            color: #657b93;
        }

        @media (max-width: 600px) {
            .level-tabs {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .level-tab {
                min-height: 82px;
            }
        }
    </style>
</head>

<body>
    <!-- Robot dekorasi, berada di belakang konten -->
    <div class="robot-watermark" aria-hidden="true">
        <img src="{{ asset('assets/images/robot-pln.png') }}" alt="">
    </div>

    <div class="page">

        <div class="page-top">
            <a href="{{ route('dashboardAdmin') }}" class="back-link">
                Kembali ke dashboard admin
            </a>

            <div class="unit-select">
                <label for="unit">Unit</label>

                <select id="unit" onchange="changeUnit(this.value)">
                    @foreach ($units as $item)
                        <option value="{{ $item->id }}" {{ $unit && $unit->id === $item->id ? 'selected' : '' }}>
                            {{ $item->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @if (session('success'))
            <div class="flash">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flash error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="flash error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="layout">

            <aside class="sidebar">
                <p class="sidebar-label">Unit</p>

                <h3>{{ $unit?->nama_unit ?? 'Pilih Unit' }}</h3>

                @foreach ($subAreas as $item)
                    <a href="{{ route('verifkasiUnit', [
                        'unit_id' => $unit?->id,
                        'sub_area_id' => $item->id,
                        'level' => $selectedLevel,
                    ]) }}"
                        class="side-item {{ $subArea?->id === $item->id ? 'active' : '' }}"
                        style="text-decoration: none;">

                        <span>{{ $item->nama_sub_area }}</span>

                        <span class="side-score">—</span>
                    </a>
                @endforeach
            </aside>

            <main class="main-card">

                <div class="overview">
                    <div>
                        <h1>
                            {{ $subArea?->nama_sub_area ?? 'Pilih Sub Area' }}
                        </h1>
                        <p class="description">
                            {{ $subArea?->deskripsi ?? 'Deskripsi sub area belum tersedia.' }}
                        </p>
                    </div>

                    <div class="score-card">
                        <span>Score ML Sub Area</span>

                        <strong>{{ number_format($scoreMlSubArea, 2) }}</strong>

                        <p>
                            Nilai dihitung berdasarkan jumlah dokumen
                            yang telah diunggah oleh unit pada setiap level.
                        </p>
                    </div>

                </div>




                <!-- TAB LEVEL 1 - 5 -->
                <div class="level-tabs">

                    @foreach ($levelTabs as $tab)
                        @php
                            $isActive = $tab['level'] == $selectedLevel;

                            $range = $tab['level'] == 1 ? '0 < x ≤ 1' : $tab['level'] - 1 . ' < x ≤ ' . $tab['level'];
                        @endphp

                        <a href="{{ route('verifkasiUnit', [
                            'unit_id' => $unit->id,
                            'sub_area_id' => $subArea->id,
                            'level' => $tab['level'],
                        ]) }}"
                            class="level-tab {{ $isActive ? 'active' : '' }}">

                            <span class="level-tab-title">
                                Level {{ $tab['level'] }}
                            </span>

                            <span class="level-tab-range">
                                {{ $range }}
                            </span>

                            <span class="level-tab-value">
                                Nilai {{ number_format($tab['value'], 2) }}
                            </span>

                            @if ($tab['complete'])
                                <span class="level-tab-status">
                                    Selesai
                                </span>
                            @else
                                <span class="level-tab-status incomplete">
                                    {{ $tab['uploaded'] }}/{{ $tab['total'] }} dokumen
                                </span>
                            @endif

                        </a>
                    @endforeach

                </div>


                <div class="section-heading">
                    <div>
                        <small>Level {{ $level?->level ?? '-' }}</small>
                        <h2>{{ $level?->nama_level ?? 'Nama Level Belum Tersedia' }}</h2>
                    </div>

                    <div class="section-meta">
                        <span class="criteria-count">
                            {{ $totalKriteria }} kriteria
                        </span>

                        <div class="level-score">
                            <span>Sesuai</span>
                            <strong>{{ $totalSesuai }}/{{ $totalKriteria }}</strong>
                        </div>
                    </div>
                </div>

                @forelse ($kriteria as $i => $item)
                    @php
                        // Mengambil data bukti dari tabel criterion_submissions.
                        $submission = $submissions->get($item->id);

                        $status = $submission?->status_verifikasi ?? 'menunggu';

                        $catatan = $submission?->catatan_admin ?? '';

                        $filePath = $submission?->file_bukti;

                        $fileAda = !empty($filePath);

                        $namaFile = $fileAda ? basename($filePath) : null;

                        $ekstensiFile = $fileAda ? strtoupper(pathinfo($filePath, PATHINFO_EXTENSION)) : 'FILE';
                    @endphp

                    <section class="criteria-card" data-criterion-id="{{ $item->id }}"
                        data-unit-id="{{ $unit->id }}" data-status="{{ $status ?? '' }}"
                        data-status-url="{{ route('verifkasiUnit.updateStatus', $item->id) }}"
                        data-note-url="{{ route('verifkasiUnit.updateCatatan', $item->id) }}">
                        <div class="criteria-header">
                            <div class="number">
                                {{ $i + 1 }}
                            </div>

                            <div class="criteria-title">
                                {{ $item->nama_kriteria }}
                            </div>

                            <div class="index-box">
                                <span>Indeks dokumen</span>

                                <strong class="index-value {{ !$fileAda ? 'zero' : '' }}">
                                    {{ $fileAda ? 1 : 0 }}
                                </strong>
                            </div>

                            <div class="actions">
                                <button type="button" class="yes {{ $status === 'sesuai' ? 'active' : '' }}"
                                    onclick="submitVerification({{ $i + 1 }}, 'sesuai')">
                                    Sesuai
                                </button>

                                <button type="button" class="no {{ $status === 'tidak_sesuai' ? 'active' : '' }}"
                                    onclick="submitVerification({{ $i + 1 }}, 'tidak_sesuai')">
                                    Tidak sesuai
                                </button>
                            </div>
                        </div>

                        <div class="field">
                            <label>Catatan verifikator</label>

                            <textarea id="note-{{ $item->id }}" placeholder="Tambahkan catatan hasil pemeriksaan">{{ $catatan }}</textarea>
                            <button type="button" class="save-note" onclick="saveNote({{ $i + 1 }})">
                                Simpan catatan
                            </button>
                        </div>


                        <div class="evidence">
                            <h4>Lampiran bukti</h4>

                            <p class="evidence-description">
                                Buka file untuk diperiksa, lalu tentukan hasil verifikasinya.
                            </p>

                            <div class="evidence-content">
                                @if ($fileAda)
                                    <div class="file-row">
                                        <div class="file-icon">
                                            {{ $ekstensiFile }}
                                        </div>

                                        <div class="file-info">
                                            <strong>{{ $namaFile }}</strong>

                                            <span>
                                                Bukti yang diunggah oleh unit
                                            </span>
                                        </div>

                                        <div class="file-links">
                                            <a class="open"
                                                href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($filePath) }}"
                                                target="_blank" rel="noopener noreferrer">
                                                Open
                                            </a>

                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($filePath) }}"
                                                download>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="empty-file">
                                        Belum ada lampiran yang diunggah oleh unit.
                                    </div>
                                @endif
                            </div>
                        </div>

                    </section>
                @empty
                    <div class="empty-file">
                        Belum ada kriteria untuk sub area dan level ini.
                    </div>
                @endforelse

                {{-- HAPUS ?? --}}
                {{-- @endphp

                @php
                    $sebelumnyaSesuai = true;
                @endphp

                @foreach ($kriteria as $i => $item)
                    @php
                        $nomor = $i + 1;
                        $fileAda = !empty($item['file']);
                        $terkunci = !$sebelumnyaSesuai;
                        $indeks = !$terkunci && $fileAda ? 1 : 0;
                        $bisaVerifikasi = !$terkunci && $fileAda;
                        $status = $item['status'] ?? null;
                    @endphp

                    <section class="criteria-card {{ $terkunci ? 'locked' : '' }}" data-status="{{ $status ?? '' }}">

                        <div class="criteria-header">

                            <div class="number {{ $status === 'tidak_sesuai' ? 'error' : '' }}">
                                {{ $nomor }}
                            </div>

                            <div class="criteria-title">
                                {{ $item['nama'] }}
                            </div>

                            <div class="index-box">
                                <span>Indeks dokumen</span>
                                <strong class="index-value {{ $indeks === 0 ? 'zero' : '' }}">
                                    {{ $indeks }}
                                </strong>
                            </div>

                            <div class="actions">
                                @foreach (['sesuai' => 'Sesuai', 'tidak_sesuai' => 'Tidak sesuai'] as $nilai => $label)
                                    <button type="button"
                                        class="{{ $nilai === 'sesuai' ? 'yes' : 'no' }} {{ $status === $nilai ? 'active' : '' }}"
                                        {{ !$bisaVerifikasi ? 'disabled' : '' }}
                                        onclick="submitVerification({{ $nomor }}, '{{ $nilai }}')">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        @if ($terkunci)
                            <div class="locked-message">
                                Indeks otomatis 0 karena kriteria sebelumnya belum terpenuhi.
                                Selesaikan dan setujui kriteria sebelumnya untuk melanjutkan.
                            </div>
                        @endif

                        <div class="field">
                            <label for="note-{{ $nomor }}">Catatan verifikator</label>

                            <textarea id="note-{{ $nomor }}"
                                placeholder="{{ $terkunci ? 'Kriteria sebelumnya belum terpenuhi' : 'Tambahkan catatan hasil pemeriksaan' }}"
                                {{ !$bisaVerifikasi ? 'disabled' : '' }}>{{ $item['catatan'] ?? '' }}</textarea>

                            @if ($bisaVerifikasi)
                                <button type="button" class="save-note" onclick="saveNote({{ $nomor }})">
                                    Simpan catatan
                                </button>
                            @endif
                        </div>

                        <div class="evidence">
                            <h4>Lampiran bukti</h4>
                            <p class="evidence-description">
                                Buka file untuk diperiksa, lalu tentukan hasil verifikasinya.
                            </p>

                            <div class="evidence-content">
                                @if ($fileAda)
                                    <div class="file-row">
                                        <div class="file-icon">
                                            {{ strtoupper(pathinfo($item['nama_file'] ?? $item['file'], PATHINFO_EXTENSION) ?: 'FILE') }}
                                        </div>

                                        <div class="file-info">
                                            <strong>
                                                {{ $item['nama_file'] ?? basename($item['file']) }}
                                            </strong>
                                            <span>
                                                {{ $item['ukuran_file'] ?? '' }}
                                                @if (!empty($item['tanggal_upload']))
                                                    · Diunggah {{ $item['tanggal_upload'] }}
                                                @endif
                                            </span>
                                        </div>

                                        <div class="file-links">
                                            <a class="open {{ $terkunci ? 'disabled' : '' }}"
                                                href="{{ $terkunci ? '#' : (str_starts_with($item['file'], 'contoh/') ? '#' : \Illuminate\Support\Facades\Storage::url($item['file'])) }}"
                                                target="_blank" rel="noopener noreferrer">
                                                Open
                                            </a>

                                            <a class="{{ $terkunci ? 'disabled' : '' }}"
                                                href="{{ $terkunci ? '#' : (str_starts_with($item['file'], 'contoh/') ? '#' : \Illuminate\Support\Facades\Storage::url($item['file'])) }}"
                                                download>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="empty-file">
                                        Belum ada lampiran yang diunggah oleh unit.
                                    </div>
                                @endif
                            </div>
                        </div>

                    </section>

                    @php
                        $sebelumnyaSesuai = $sebelumnyaSesuai && $fileAda && $status === 'sesuai';
                    @endphp
                @endforeach --}}

            </main>
        </div>
    </div>

    <script>
        async function submitVerification(nomor, status) {
            const cards = [...document.querySelectorAll('.criteria-card')];
            const card = cards[nomor - 1];

            if (!card || card.classList.contains('locked')) return;
            const indexValue = card.querySelector('.index-value');

            if (!indexValue || indexValue.textContent.trim() !== '1') {
                alert('Kriteria belum dapat diverifikasi karena belum ada lampiran bukti.');
                return;
            }

            const buttons = card.querySelectorAll('.actions button');
            buttons.forEach(button => button.disabled = true);

            try {
                const response = await fetch(card.dataset.statusUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        unit_id: card.dataset.unitId,
                        status: status
                    })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Status gagal disimpan.');
                }

                card.dataset.status = result.status || status;
                updateCriteria();
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat menyimpan status.');
            } finally {
                updateCriteria();
            }
        }

        async function saveNote(nomor) {
            const cards = [...document.querySelectorAll('.criteria-card')];
            const card = cards[nomor - 1];

            if (!card || card.classList.contains('locked')) return;

            const textarea = card.querySelector('textarea');
            const saveButton = card.querySelector('.save-note');

            const indexValue = card.querySelector('.index-value');

            if (!indexValue || indexValue.textContent.trim() !== '1') {
                alert('Catatan belum dapat disimpan karena belum ada lampiran bukti.');
                return;
            }

            saveButton.disabled = true;

            try {
                const response = await fetch(card.dataset.noteUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        unit_id: card.dataset.unitId,
                        catatan: textarea.value
                    })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Catatan gagal disimpan.');
                }

                alert(result.message || 'Catatan berhasil disimpan.');
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat menyimpan catatan.');
            } finally {
                updateCriteria();
            }
        }


        function updateCriteria() {
            const cards = [...document.querySelectorAll('.criteria-card')];

            let sebelumnyaSesuai = true;

            cards.forEach((card) => {
                const indexValue = card.querySelector('.index-value');

                const fileAda = indexValue &&
                    indexValue.textContent.trim() === '1';

                const terkunci = !sebelumnyaSesuai;

                const status = card.dataset.status || '';

                const indeks = !terkunci && fileAda ? 1 : 0;

                card.classList.toggle('locked', terkunci);

                if (indexValue) {
                    indexValue.textContent = indeks;
                    indexValue.classList.toggle('zero', indeks === 0);
                }

                const number = card.querySelector('.number');

                number.classList.toggle(
                    'error',
                    status === 'tidak_sesuai'
                );

                const buttons = card.querySelectorAll('.actions button');

                buttons.forEach((button) => {
                    const isYes = button.classList.contains('yes');

                    const buttonStatus = isYes ?
                        'sesuai' :
                        'tidak_sesuai';

                    button.disabled = terkunci || !fileAda;

                    button.classList.toggle(
                        'active',
                        status === buttonStatus
                    );
                });

                const textarea = card.querySelector('textarea');

                if (textarea) {
                    textarea.disabled = terkunci || !fileAda;
                }

                const saveButton = card.querySelector('.save-note');

                if (saveButton) {
                    saveButton.disabled = terkunci || !fileAda;
                }

                let message = card.querySelector('.locked-message');

                if (terkunci && !message) {
                    message = document.createElement('div');

                    message.className = 'locked-message';

                    message.textContent =
                        'Indeks otomatis 0 karena kriteria sebelumnya belum terpenuhi. ' +
                        'Selesaikan dan setujui kriteria sebelumnya untuk melanjutkan.';

                    card.querySelector('.criteria-header').after(message);

                } else if (!terkunci && message) {
                    message.remove();
                }

                card.querySelectorAll('.file-links a').forEach((link) => {
                    link.classList.toggle('disabled', terkunci);

                    if (terkunci) {
                        link.setAttribute('aria-disabled', 'true');
                        link.setAttribute('tabindex', '-1');
                    } else {
                        link.removeAttribute('aria-disabled');
                        link.removeAttribute('tabindex');
                    }
                });

                sebelumnyaSesuai =
                    sebelumnyaSesuai &&
                    fileAda &&
                    status === 'sesuai';
            });
        }


        // Terapkan status dan penguncian kriteria saat halaman pertama kali dibuka.
        document.addEventListener('DOMContentLoaded', updateCriteria);
    </script>

    <script>
        function changeUnit(unitId) {
            const url = new URL(window.location.href);

            url.searchParams.set('unit_id', unitId);

            window.location.href = url.toString();
        }
    </script>
</body>

</html>
