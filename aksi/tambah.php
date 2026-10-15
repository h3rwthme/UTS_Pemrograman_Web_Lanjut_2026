<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uuid();
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $now = date('Y-m-d H:i:s');

    $simpan = mysqli_query($koneksi, "INSERT INTO actions (id, name, description, created_at, updated_at, deleted_at) VALUES ('$id', '$name', '$description', '$now', '$now', NULL)");

    if ($simpan) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal menyimpan jenis aksi: " . mysqli_error($koneksi);
    }
}

require_once "../header.php";
?>

<div class="container" style="max-width: 600px;">
    <div class="page-header">
        <h2>INPUT DATA JENIS AKSI</h2>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>

    <?php if ($error != ""): ?>
        <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #dc2626; padding: 10px; margin-bottom: 15px; font-weight: bold; font-size: 12px;">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="tambah.php">
        <label>Nama Aksi Sistem</label>
        <input type="text" name="name" required placeholder="Contoh: Create / Read / Update / Delete">

        <label>Deskripsi Fungsi Aksi</label>
        <textarea name="description" rows="4" placeholder="Tuliskan keterangan fungsional aksi ini"></textarea>

        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
            <button type="submit" class="btn">Simpan Aksi</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
