<?php
session_start();

// Jika pengguna sudah login, arahkan ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
