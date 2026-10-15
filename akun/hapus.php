<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $now = date('Y-m-d H:i:s');
    mysqli_query($koneksi, "UPDATE accounts SET deleted_at = '$now' WHERE id = '$id'");
}

header("Location: index.php");
exit;
