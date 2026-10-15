<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';

$query = mysqli_query($koneksi, "SELECT * FROM accounts WHERE id = '$id' AND deleted_at IS NULL LIMIT 1");
$akun = mysqli_fetch_assoc($query);

if (!$akun) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $account_type_id = mysqli_real_escape_string($koneksi, $_POST['account_type_id']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $identification_type = mysqli_real_escape_string($koneksi, $_POST['identification_type']);
    $identification_number = mysqli_real_escape_string($koneksi, $_POST['identification_number']);
    $now = date('Y-m-d H:i:s');

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE accounts SET name = '$name', email = '$email', password = '$password', account_type_id = '$account_type_id', status = '$status', identification_type = '$identification_type', identification_number = '$identification_number', updated_at = '$now' WHERE id = '$id'");
    } else {
        mysqli_query($koneksi, "UPDATE accounts SET name = '$name', email = '$email', account_type_id = '$account_type_id', status = '$status', identification_type = '$identification_type', identification_number = '$identification_number', updated_at = '$now' WHERE id = '$id'");
    }

    header("Location: index.php");
    exit;
}

$tipe_query = mysqli_query($koneksi, "SELECT * FROM account_type WHERE deleted_at IS NULL ORDER BY name ASC");
require_once "../header.php";
?>

<div class="container" style="max-width: 650px;">
    <div class="page-header">
        <h2>PERBARUI DATA AKUN</h2>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>

    <form method="POST" action="edit.php?id=<?= urlencode($id); ?>">
        <label>Nama Lengkap Operator / Pengguna</label>
        <input type="text" name="name" value="<?= htmlspecialchars($akun['name']); ?>" required>

        <label>Alamat Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($akun['email']); ?>" required>

        <label>Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
        <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin ganti password">

        <label>Tipe Akun (Hak Akses)</label>
        <select name="account_type_id" required>
            <?php while ($t = mysqli_fetch_assoc($tipe_query)): ?>
                <option value="<?= htmlspecialchars($t['id']); ?>" <?= $t['id'] == $akun['account_type_id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($t['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Status Akun</label>
        <select name="status" required>
            <option value="Aktif" <?= $akun['status'] == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
            <option value="Nonaktif" <?= $akun['status'] == 'Nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
        </select>

        <label>Jenis Nomor Identitas</label>
        <select name="identification_type" required>
            <option value="NIM" <?= $akun['identification_type'] == 'NIM' ? 'selected' : ''; ?>>NIM (Mahasiswa)</option>
            <option value="NIP" <?= $akun['identification_type'] == 'NIP' ? 'selected' : ''; ?>>NIP (Dosen / Staf)</option>
        </select>

        <label>Nomor Identitas (NIM / NIP)</label>
        <input type="text" name="identification_number" value="<?= htmlspecialchars($akun['identification_number']); ?>" required>

        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
