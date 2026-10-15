<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$user_role = $_SESSION['tipe'] ?? 'User';

$current_page = $_SERVER['PHP_SELF'] ?? '';
$is_akun_active = (strpos($current_page, '/akun/') !== false);
$is_tipe_active = (strpos($current_page, '/tipe_akun/') !== false);
$is_aksi_active = (strpos($current_page, '/aksi/') !== false);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sistem Manajemen Akun</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            background-color: #cbd5e1;
            margin: 0;
            padding: 24px 30px 40px 280px;
            color: #0f172a;
            box-sizing: border-box;
            min-height: 100vh;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #0f172a;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 3px solid #0284c7;
            box-sizing: border-box;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-top {
            padding: 20px 16px;
        }
        .sidebar-brand {
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #f8fafc;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 15px;
            border-bottom: 2px solid #1e293b;
            margin-bottom: 16px;
        }
        .sidebar-brand span {
            background-color: #0284c7;
            color: #ffffff;
            padding: 3px 7px;
            font-size: 11px;
            font-family: Consolas, monospace;
            border: 1px solid #38bdf8;
            box-shadow: 1px 1px 0px #000000;
        }
        .user-panel {
            background-color: #1e293b;
            border: 1px solid #334155;
            padding: 12px;
            margin-bottom: 18px;
            box-shadow: 2px 2px 0px #000000;
        }
        .user-role-badge {
            display: inline-block;
            padding: 2px 7px;
            font-size: 10px;
            font-weight: 800;
            font-family: Consolas, monospace;
            text-transform: uppercase;
            margin-bottom: 6px;
            border: 1px solid #38bdf8;
            background-color: #0284c7;
            color: #ffffff;
        }
        .user-name {
            font-weight: 700;
            font-size: 13px;
            color: #f8fafc;
            word-break: break-all;
        }
        .user-email {
            font-size: 11px;
            color: #94a3b8;
            font-family: Consolas, monospace;
            margin-top: 3px;
            word-break: break-all;
        }
        .nav-menu-title {
            font-size: 10px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 14px 0 8px 4px;
        }
        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .nav-links a {
            background-color: #1e293b;
            color: #f1f5f9;
            text-decoration: none;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #334155;
            box-shadow: 1px 1px 0px #000000;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-links a span {
            color: #38bdf8;
            font-family: Consolas, monospace;
        }
        .nav-links a:hover {
            background-color: #0284c7;
            color: #ffffff;
            border-color: #38bdf8;
        }
        .nav-links a:hover span {
            color: #ffffff;
        }
        .nav-links a.active {
            background-color: #0284c7;
            color: #ffffff;
            border-color: #38bdf8;
            box-shadow: 2px 2px 0px #000000;
        }
        .nav-links a.active span {
            color: #ffffff;
        }
        .sidebar-bottom {
            padding: 16px;
            border-top: 2px solid #1e293b;
            background-color: #090d16;
        }
        .btn-logout {
            background-color: #b91c1c;
            color: #ffffff;
            text-decoration: none;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            border: 1px solid #7f1d1d;
            box-shadow: 1px 1px 0px #000000;
            display: block;
            text-align: center;
            letter-spacing: 0.5px;
        }
        .btn-logout:hover {
            background-color: #dc2626;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 24px 28px;
            border: 2px solid #334155;
            box-shadow: 5px 5px 0px #475569;
            box-sizing: border-box;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .page-header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 2px solid #334155;
            background-color: #ffffff;
        }
        table th {
            background-color: #1e293b;
            color: #ffffff;
            padding: 9px 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #475569;
            text-align: left;
        }
        table td {
            padding: 8px 12px;
            font-size: 13px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        table tbody tr:hover {
            background-color: #f1f5f9;
        }
        label {
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #1e293b;
            letter-spacing: 0.5px;
        }
        input[type="text"], input[type="email"], input[type="password"], select, textarea {
            width: 100%;
            padding: 8px 10px;
            margin: 2px 0 14px 0;
            display: inline-block;
            border: 2px solid #64748b;
            border-radius: 0;
            background-color: #ffffff;
            box-sizing: border-box;
            font-size: 13px;
            font-family: inherit;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #0284c7;
            background-color: #f8fafc;
        }
        .btn {
            background-color: #0284c7;
            color: #ffffff;
            padding: 7px 15px;
            border: 1px solid #0f172a;
            border-radius: 0;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 2px 2px 0px #0f172a;
        }
        .btn:hover {
            background-color: #0369a1;
        }
        .btn:active {
            transform: translate(1px, 1px);
            box-shadow: 1px 1px 0px #0f172a;
        }
        .btn-danger {
            background-color: #dc2626;
            border-color: #7f1d1d;
        }
        .btn-danger:hover {
            background-color: #b91c1c;
        }
        .btn-secondary {
            background-color: #475569;
            border-color: #1e293b;
        }
        .btn-secondary:hover {
            background-color: #334155;
        }
        .search-bar {
            display: flex;
            gap: 8px;
            background-color: #f1f5f9;
            padding: 10px;
            border: 1px solid #94a3b8;
            margin-bottom: 15px;
            align-items: center;
        }
        .search-bar input[type="text"] {
            margin: 0;
            flex-grow: 1;
            padding: 7px 10px;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-family: Consolas, monospace;
        }
        .badge-aktif {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #059669;
        }
        .badge-nonaktif {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #dc2626;
        }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-brand">
            <span>POS-SYS</span> SISTEM MANAJEMEN AKUN
        </div>

        <div class="user-panel">
            <span class="user-role-badge">
                <?= htmlspecialchars(strtoupper($user_role)); ?>
            </span>
            <div class="user-name"><?= htmlspecialchars($_SESSION['nama'] ?? 'Pengguna'); ?></div>
            <div class="user-email"><?= htmlspecialchars($_SESSION['email'] ?? ''); ?></div>
        </div>

        <div class="nav-menu-title">NAVIGASI MODUL</div>
        <div class="nav-links">
            <a href="../akun/index.php" class="<?= $is_akun_active ? 'active' : ''; ?>">
                <span>[1]</span> Modul Akun
            </a>
            <a href="../tipe_akun/index.php" class="<?= $is_tipe_active ? 'active' : ''; ?>">
                <span>[2]</span> Tipe Akun
            </a>
            <a href="../aksi/index.php" class="<?= $is_aksi_active ? 'active' : ''; ?>">
                <span>[3]</span> Jenis Aksi
            </a>
        </div>
    </div>

    <div class="sidebar-bottom">
        <div style="font-size: 10px; color: #64748b; font-family: Consolas, monospace; margin-bottom: 10px; line-height: 1.4;">
            PBL TI 2026<br>
            <span style="color: #38bdf8;">PHP Native + MySQL</span>
        </div>
        <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
</aside>
