<?php
// Ambil path dari URL
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Jika file atau folder ada secara fisik, biarkan server menanganinya
if ($path !== "/" && file_exists(__DIR__ . $path)) {
    return false;
}

session_start();

// Tangani navigasi
if ($path === "/" || $path === "/index.php") {
    header("Location: /dashboard.php");
    exit();
} elseif ($path === "/admin") {
    if (isset($_SESSION['id_login'])) {
        header("Location: /admin/admin_dashboard.php");
        exit();
    } else {
        header("Location: /login.php");
        exit();
    }
} else {
    http_response_code(404);
    include "404.php";
    exit();
}
