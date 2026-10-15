<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uuid();
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $account_type_id = mysqli_real_escape_string($koneksi, $_POST['account_type_id']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $identification_type = mysqli_real_escape_string($koneksi, $_POST['identification_type']);
    $identification_number = mysqli_real_escape_string($koneksi, $_POST['identification_number']);
    $now = date('Y-m-d H:i:s');

    mysqli_query($koneksi, "INSERT INTO accounts (id, name, email, password, account_type_id, status, identification_number, identification_type, created_at, updated_at, deleted_at) VALUES ('$id', '$name', '$email', '$password', '$account_type_id', '$status', '$identification_number', '$identification_type', '$now', '$now', NULL)");

    header("Location: index.php");
    exit;
}

$tipe_query = mysqli_query($koneksi, "SELECT * FROM account_type WHERE deleted_at IS NULL ORDER BY name ASC");
require_once "../header.php";
?>

<div class="container" style="max-width: 650px;">
    <div class="page-header">
        <h2>INPUT DATA AKUN BARU</h2>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>

    <form method="POST" action="tambah.php">
        <label>Nama Lengkap Operator / Pengguna</label>
        <input type="text" name="name" required placeholder="Contoh: Farkhan Abdilah">

        <label>Alamat Email</label>
        <input type="email" name="email" required placeholder="Contoh: farkhan@pnj.ac.id">

        <label>Kata Sandi</label>
        <input type="password" name="password" required placeholder="Ketik kata sandi akun">

        <label>Tipe Akun (Hak Akses)</label>
        <select name="account_type_id" required>
            <option value="">-- PILIH TIPE AKUN --</option>
            <?php while ($t = mysqli_fetch_assoc($tipe_query)): ?>
                <option value="<?= htmlspecialchars($t['id']); ?>">
                    <?= htmlspecialchars($t['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Status Akun</label>
        <select name="status" required>
            <option value="Aktif">Aktif</option>
            <option value="Nonaktif">Nonaktif</option>
        </select>

        <label>Jenis Nomor Identitas</label>
        <select name="identification_type" required>
            <option value="NIM">NIM (Mahasiswa)</option>
            <option value="NIP">NIP (Dosen / Staf)</option>
        </select>

        <label>Nomor Identitas (NIM / NIP)</label>
        <input type="text" name="identification_number" required placeholder="Contoh: 2207421045">

        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
            <button type="submit" class="btn">Simpan Data Akun</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
