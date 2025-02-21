<?php
include '../db_connect.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard/dashboard';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(60, 61, 63);
            transition: width 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar a {
            padding: 20px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: flex;
            align-items: center;
        }

        .sidebar a:hover {
            background-color: #007bff;
        }

        .sidebar a.active {
            background-color: #007bff;
            color: white;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgb(6, 81, 161);
            color: white;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            left: 250px;
            width: calc(100% - 250px);
            transition: left 0.3s, width 0.3s;
            border-bottom: 2px solid black;
        }

        .navbar .toggle-btn {
            font-size: 24px;
            cursor: pointer;
        }

        .navbar .title {
            font-size: 24px;
        }

        .navbar .admin-info {
            display: flex;
            align-items: center;
        }

        .navbar .admin-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .collapsed-sidebar {
            width: 0;
            overflow: hidden;
        }

        .collapsed-content {
            margin-left: 0;
        }

        .collapsed-navbar {
            left: 0;
            width: 100%;
        }

        .logout {
            border: 2px solid black;
            width: fit-content;
        }
    </style>
</head>

<body>
    <div class="sidebar d-flex flex-column" id="sidebar">
        <div>
            <a href="dashboard.php?page=dashboard/dashboard" class="<?= $page == 'dashboard/dashboard' ? 'active' : '' ?>"><i class="bi bi-speedometer2"></i>Dashboard</a>
            <a href="dashboard.php?page=profile_desa/profil_desa" class="<?= $page == 'profile_desa/profil_desa' ? 'active' : '' ?>"><i class="bi bi-house-door"></i>Profil Desa</a>
            <a href="dashboard.php?page=layanan_desa/layanan_desa" class="<?= $page == 'layanan_desa/layanan_desa' ? 'active' : '' ?>"><i class="bi bi-briefcase"></i>Layanan Desa</a>
            <a href="dashboard.php?page=lembaga_desa/lembaga_desa" class="<?= $page == 'lembaga_desa/lembaga_desa' ? 'active' : '' ?>"><i class="bi bi-people"></i>Lembaga Desa</a>
            <a href="dashboard.php?page=transparansi/transparansi" class="<?= $page == 'transparansi/transparansi' ? 'active' : '' ?>"><i class="bi bi-bar-chart"></i>Transparansi Desa</a>
            <a href="dashboard.php?page=kontak_admin/kontak_admin" class="<?= $page == 'kontak_admin/kontak_admin' ? 'active' : '' ?>"><i class="bi bi-telephone"></i>Kontak Admin</a>
        </div>
        <a href="logout.php" class="btn btn-danger shadow-lg logout d-flex flex-row justify-content-center px-5 py-2 mx-auto end-0 start-0 mb-4"><i class="bi bi-box-arrow-right"></i>Logout</a>
    </div>
    <div class="navbar top-0" id="navbar">
        <span class="toggle-btn btn text-white border-1 border border-white" style="height: fit-content; width: fit-content; font-size: 20px;" onclick="toggleSidebar()"><i class="bi bi-list"></i></span>
        <span class="title">BMJ WEBSITE</span>
        <div class="admin-info">
            <i class="bi bi-person me-2" style="font-size: 30px;"></i>
            <span>Admin</span>
        </div>
    </div>
    <div class="content" id="content">
        <?php include $page . ".php"; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const navbar = document.getElementById('navbar');
            sidebar.classList.toggle('collapsed-sidebar');
            content.classList.toggle('collapsed-content');
            navbar.classList.toggle('collapsed-navbar');
        }
    </script>
</body>

</html>