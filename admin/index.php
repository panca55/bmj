<?php
session_start();

// Jika pengguna sudah login, arahkan ke dashboard
if (isset($_SESSION['id_login'])) {
    header("Location: /admin/admin_dashboard.php");
    exit();
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
