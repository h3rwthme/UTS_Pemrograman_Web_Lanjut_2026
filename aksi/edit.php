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

$query = mysqli_query($koneksi, "SELECT * FROM actions WHERE id = '$id' AND deleted_at IS NULL LIMIT 1");
$aksi = mysqli_fetch_assoc($query);

if (!$aksi) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $now = date('Y-m-d H:i:s');

    $update = mysqli_query($koneksi, "UPDATE actions SET name = '$name', description = '$description', updated_at = '$now' WHERE id = '$id'");

    if ($update) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal memperbarui jenis aksi: " . mysqli_error($koneksi);
    }
}

require_once "../header.php";
?>

<div class="container" style="max-width: 600px;">
    <div class="page-header">
        <h2>PERBARUI DATA JENIS AKSI</h2>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>

    <?php if ($error != ""): ?>
        <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #dc2626; padding: 10px; margin-bottom: 15px; font-weight: bold; font-size: 12px;">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= urlencode($id); ?>">
        <label>Nama Aksi Sistem</label>
        <input type="text" name="name" value="<?= htmlspecialchars($aksi['name']); ?>" required>

        <label>Deskripsi Fungsi Aksi</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($aksi['description']); ?></textarea>

        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
            <button type="submit" class="btn">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
