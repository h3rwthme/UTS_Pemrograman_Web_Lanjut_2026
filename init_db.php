<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "PBL_TI_2026_B_FARKHANABDILLAH";

$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error() . "\n");
}

$sql = file_get_contents(__DIR__ . "/database.sql");

if (mysqli_multi_query($conn, $sql)) {
    do {
        if ($res = mysqli_store_result($conn)) {
            mysqli_free_result($res);
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
    echo "Database dan tabel berhasil diinisialisasi.\n";
} else {
    echo "Gagal: " . mysqli_error($conn) . "\n";
}

mysqli_close($conn);
