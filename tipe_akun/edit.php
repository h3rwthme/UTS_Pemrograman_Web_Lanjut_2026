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

$query = mysqli_query($koneksi, "SELECT * FROM account_type WHERE id = '$id' AND deleted_at IS NULL LIMIT 1");
$tipe = mysqli_fetch_assoc($query);

if (!$tipe) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $now = date('Y-m-d H:i:s');

    $update = mysqli_query($koneksi, "UPDATE account_type SET name = '$name', description = '$description', updated_at = '$now' WHERE id = '$id'");

    if ($update) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal memperbarui tipe akun: " . mysqli_error($koneksi);
    }
}

require_once "../header.php";
?>

<div class="container" style="max-width: 600px;">
    <div class="page-header">
        <h2>PERBARUI DATA TIPE AKUN</h2>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>

    <?php if ($error != ""): ?>
        <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #dc2626; padding: 10px; margin-bottom: 15px; font-weight: bold; font-size: 12px;">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= urlencode($id); ?>">
        <label>Nama Tipe Akun (Peran)</label>
        <input type="text" name="name" value="<?= htmlspecialchars($tipe['name']); ?>" required>

        <label>Deskripsi Peran</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($tipe['description']); ?></textarea>

        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
