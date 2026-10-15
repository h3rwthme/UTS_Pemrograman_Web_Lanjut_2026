<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: akun/index.php");
    exit;
}

require_once "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT accounts.*, account_type.name AS nama_tipe 
                                     FROM accounts 
                                     LEFT JOIN account_type ON accounts.account_type_id = account_type.id 
                                     WHERE accounts.email = '$email' AND accounts.deleted_at IS NULL LIMIT 1");

    if ($query && mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['tipe'] = $user['nama_tipe'] ?? 'User';
            header("Location: akun/index.php");
            exit;
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Terminal - POS Manajemen Akun</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            background-color: #cbd5e1;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background-color: #ffffff;
            width: 100%;
            max-width: 380px;
            border: 2px solid #0f172a;
            box-shadow: 6px 6px 0px #334155;
        }
        .login-header {
            background-color: #0f172a;
            color: #ffffff;
            padding: 12px 18px;
            border-bottom: 3px solid #0284c7;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .login-header h2 {
            margin: 0;
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .login-header .tag {
            background-color: #0284c7;
            color: #ffffff;
            font-size: 10px;
            font-family: Consolas, monospace;
            padding: 2px 6px;
            border: 1px solid #38bdf8;
        }
        .login-body {
            padding: 24px;
        }
        .login-desc {
            font-size: 12px;
            color: #475569;
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 3px solid #0284c7;
            padding-left: 8px;
        }
        .alert {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #dc2626;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }
        label {
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e293b;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 9px 10px;
            margin-bottom: 14px;
            border: 2px solid #64748b;
            border-radius: 0;
            box-sizing: border-box;
            font-size: 13px;
            font-family: inherit;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #0284c7;
            background-color: #f8fafc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #0284c7;
            color: #ffffff;
            border: 1px solid #0f172a;
            border-radius: 0;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 2px 2px 0px #0f172a;
            margin-top: 5px;
        }
        button:hover {
            background-color: #0369a1;
        }
        button:active {
            transform: translate(1px, 1px);
            box-shadow: 1px 1px 0px #0f172a;
        }
        .footer-note {
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
            font-family: Consolas, monospace;
            font-size: 11px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-header">
        <h2>TERMINAL OTORISASI</h2>
        <span class="tag">POS V1.0</span>
    </div>
    <div class="login-body">
        <p class="login-desc">Silakan masukkan kredensial operator sistem.</p>
        <?php if ($error != ""): ?>
            <div class="alert"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <label>Alamat Email Operator</label>
            <input type="email" name="email" required autofocus placeholder="nama@pnj.ac.id">
            
            <label>Kata Sandi</label>
            <input type="password" name="password" required placeholder="********">
            
            <button type="submit">Masuk Terminal</button>
        </form>
        <div class="footer-note">
            PBL TI 2026 B - SISTEM MANAJEMEN AKUN
        </div>
    </div>
</div>
</body>
</html>
