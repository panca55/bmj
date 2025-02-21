<?php
session_start();

// Ambil path dari URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Jika pengguna mengakses URL dengan 'admin'
if (strpos($path, 'admin') !== false) {
    // Jika pengguna sudah login, arahkan ke admin_dashboard.php
    if (isset($_SESSION['admin_id'])) {
        header("Location: admin/admin_dashboard.php");
        exit();
    } else {
        // Jika belum login, arahkan ke halaman login
        header("Location: login.php");
        exit();
    }
} else {
    // Default endpoint mengarah ke dashboard.php
    header("Location: dashboard.php");
    exit();
}
