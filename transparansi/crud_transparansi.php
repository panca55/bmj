<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Handle insert and update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_transparasi'] ?? '';
    $kalender_kegiatan = $_POST['kalender_kegiatan'];
    $transparasi_anggaran = $_POST['transparasi_anggaran'];
    $data_laporan = $_POST['data_laporan'];
    $apbdesa = $_POST['apbdesa'];
    $kegiatan_pembangunan = $_POST['kegiatan_pembangunan'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE tb_transparasi SET kalender_kegiatan=?, transparasi_anggaran=?, data_laporan=?, apbdesa=?, kegiatan_pembangunan=? WHERE id_transparasi=?");
        $stmt->bind_param("sssssi", $kalender_kegiatan, $transparasi_anggaran, $data_laporan, $apbdesa, $kegiatan_pembangunan, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO tb_transparasi (kalender_kegiatan, transparasi_anggaran, data_laporan, apbdesa, kegiatan_pembangunan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $kalender_kegiatan, $transparasi_anggaran, $data_laporan, $apbdesa, $kegiatan_pembangunan);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: crud_transparansi.php");
    exit();
}

// Fetch data
$result = $conn->query("SELECT * FROM tb_transparasi");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transparansi Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Kelola Transparansi Desa</h2>
        <form method="post" class="mt-4">
            <input type="hidden" name="id_transparasi" value="">
            <div class="mb-3">
                <label class="form-label">Kalender Kegiatan</label>
                <input type="text" class="form-control" name="kalender_kegiatan" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Transparasi Anggaran</label>
                <input type="text" class="form-control" name="transparasi_anggaran" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Data Laporan</label>
                <input type="text" class="form-control" name="data_laporan" required>
            </div>
            <div class="mb-3">
                <label class="form-label">APBDesa</label>
                <input type="text" class="form-control" name="apbdesa" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kegiatan Pembangunan</label>
                <input type="text" class="form-control" name="kegiatan_pembangunan" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <h3 class="mt-5">Daftar Transparansi Desa</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kalender Kegiatan</th>
                    <th>Transparasi Anggaran</th>
                    <th>Data Laporan</th>
                    <th>APBDesa</th>
                    <th>Kegiatan Pembangunan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id_transparasi'] ?></td>
                        <td><?= $row['kalender_kegiatan'] ?></td>
                        <td><?= $row['transparasi_anggaran'] ?></td>
                        <td><?= $row['data_laporan'] ?></td>
                        <td><?= $row['apbdesa'] ?></td>
                        <td><?= $row['kegiatan_pembangunan'] ?></td>
                        <td>
                            <a href="edit_transparansi.php?id=<?= $row['id_transparasi'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_transparansi.php?id=<?= $row['id_transparasi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>