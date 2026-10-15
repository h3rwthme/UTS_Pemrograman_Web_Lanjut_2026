<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: akun/index.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
