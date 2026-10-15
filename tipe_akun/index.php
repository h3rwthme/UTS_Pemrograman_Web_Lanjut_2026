<?php
require_once "../koneksi.php";
require_once "../header.php";

$cari = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, trim($_GET['cari'])) : '';

$sql = "SELECT * FROM account_type WHERE deleted_at IS NULL";

if ($cari !== '') {
    $sql .= " AND (name LIKE '%$cari%' OR description LIKE '%$cari%')";
}

$sql .= " ORDER BY created_at DESC";
$result = mysqli_query($koneksi, $sql);
?>

<div class="container">
    <div class="page-header">
        <h2>MODUL DATA TIPE AKUN</h2>
        <a href="tambah.php" class="btn">+ Tambah Tipe Akun</a>
    </div>

    <form method="GET" action="index.php" class="search-bar">
        <strong style="font-size: 11px; text-transform: uppercase;">Cari:</strong>
        <input type="text" name="cari" placeholder="Ketik nama atau deskripsi peran..." value="<?= htmlspecialchars($cari); ?>">
        <button type="submit" class="btn">Filter</button>
        <?php if ($cari !== ''): ?>
            <a href="index.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th style="width: 40px; text-align: center;">No</th>
                <th style="width: 200px;">Nama Tipe Akun</th>
                <th>Deskripsi Peran</th>
                <th style="width: 170px;">Waktu Dibuat</th>
                <th style="width: 140px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if ($result && mysqli_num_rows($result) > 0): 
                while ($row = mysqli_fetch_assoc($result)): 
            ?>
                <tr>
                    <td style="text-align: center; font-family: Consolas, monospace;"><?= $no++; ?></td>
                    <td><strong><?= htmlspecialchars($row['name']); ?></strong></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td style="font-family: Consolas, monospace; font-size: 12px;"><?= htmlspecialchars($row['created_at']); ?></td>
                    <td style="text-align: center;">
                        <a href="edit.php?id=<?= urlencode($row['id']); ?>" class="btn" style="padding: 3px 8px; font-size: 11px;">Ubah</a>
                        <a href="hapus.php?id=<?= urlencode($row['id']); ?>" class="btn btn-danger" style="padding: 3px 8px; font-size: 11px;" onclick="return confirm('Hapus tipe akun ini?');">Hapus</a>
                    </td>
                </tr>
            <?php 
                endwhile; 
            else: 
            ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">[ TIDAK ADA DATA TIPE AKUN ]</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
