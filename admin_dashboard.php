<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$page = isset($_GET['page']) ? $_GET['page'] : 'profile_desa/profil_desa';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #007bff;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4 class="text-center text-light">Admin Panel</h4>
        <a href="admin_dashboard.php?page=profile_desa/profil_desa">Profil Desa</a>
        <a href="admin_dashboard.php?page=layanan_desa/layanan_desa">Layanan Desa</a>
        <a href="admin_dashboard.php?page=lembaga_desa/lembaga_desa">Lembaga Desa</a>
        <a href="admin_dashboard.php?page=transparansi/transparansi">Transparansi Desa</a>
        <a href="admin_dashboard.php?page=kontak/kontak">Kontak Admin</a>
        <a href="logout.php" class="text-danger">Logout</a>
    </div>
    <div class="content">
        <?php include $page . ".php"; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>