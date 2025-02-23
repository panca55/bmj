<?php
session_start();

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Jika pengguna mengakses halaman admin
if ($path === '/admin') {
    if (isset($_SESSION['id_login'])) {
        header("Location: /admin/admin_dashboard.php");
        exit();
    } else {
        header("Location: /login.php");
        exit();
    }
} elseif ($path === '' || $path === 'index.php') {
    // Default endpoint mengarah ke dashboard.php
    header("Location: /dashboard.php");
    exit();
} else {
    // Redirect ke halaman 404 jika tidak ada halaman yang cocok
    header("/404.php");
    include '404.php';
    exit();
}
