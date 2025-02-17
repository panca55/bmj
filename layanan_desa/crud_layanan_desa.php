<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Handle insert and update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_layanan'] ?? '';
    $layanan = $_POST['layanan_desa'];
    $persyaratan = $_POST['persyaratan_surat'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE tb_layanan SET layanan_desa=?, persyaratan_surat=? WHERE id_layanan=?");
        $stmt->bind_param("ssi", $layanan, $persyaratan, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO tb_layanan (layanan_desa, persyaratan_surat) VALUES (?, ?)");
        $stmt->bind_param("ss", $layanan, $persyaratan);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: crud_layanan.php");
    exit();
}

// Fetch data
$result = $conn->query("SELECT * FROM tb_layanan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Layanan Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Kelola Layanan Desa</h2>
        <form method="post" class="mt-4">
            <input type="hidden" name="id_layanan" value="">
            <div class="mb-3">
                <label class="form-label">Nama Layanan</label>
                <input type="text" class="form-control" name="layanan_desa" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Persyaratan Surat</label>
                <input type="text" class="form-control" name="persyaratan_surat" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <h3 class="mt-5">Daftar Layanan Desa</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Layanan</th>
                    <th>Persyaratan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id_layanan'] ?></td>
                        <td><?= $row['layanan_desa'] ?></td>
                        <td><?= $row['persyaratan_surat'] ?></td>
                        <td>
                            <a href="edit_layanan.php?id=<?= $row['id_layanan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_layanan.php?id=<?= $row['id_layanan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus layanan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>