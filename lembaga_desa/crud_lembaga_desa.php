<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Handle insert and update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_lembaga'] ?? '';
    $karang_taruna = $_POST['karang_taruna'];
    $bpd = $_POST['bpd'];
    $rt = $_POST['rt'];
    $bumdes = $_POST['bumdes'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE tb_lembaga SET karang_taruna=?, bpd=?, rt=?, bumdes=? WHERE id_lembaga=?");
        $stmt->bind_param("ssisi", $karang_taruna, $bpd, $rt, $bumdes, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO tb_lembaga (karang_taruna, bpd, rt, bumdes) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $karang_taruna, $bpd, $rt, $bumdes);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: crud_lembaga.php");
    exit();
}

// Fetch data
$result = $conn->query("SELECT * FROM tb_lembaga");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lembaga Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Kelola Lembaga Desa</h2>
        <form method="post" class="mt-4">
            <input type="hidden" name="id_lembaga" value="">
            <div class="mb-3">
                <label class="form-label">Karang Taruna</label>
                <input type="text" class="form-control" name="karang_taruna" required>
            </div>
            <div class="mb-3">
                <label class="form-label">BPD</label>
                <input type="text" class="form-control" name="bpd" required>
            </div>
            <div class="mb-3">
                <label class="form-label">RT</label>
                <input type="number" class="form-control" name="rt" required>
            </div>
            <div class="mb-3">
                <label class="form-label">BUMDes</label>
                <input type="text" class="form-control" name="bumdes" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <h3 class="mt-5">Daftar Lembaga Desa</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Karang Taruna</th>
                    <th>BPD</th>
                    <th>RT</th>
                    <th>BUMDes</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id_lembaga'] ?></td>
                        <td><?= $row['karang_taruna'] ?></td>
                        <td><?= $row['bpd'] ?></td>
                        <td><?= $row['rt'] ?></td>
                        <td><?= $row['bumdes'] ?></td>
                        <td>
                            <a href="edit_lembaga.php?id=<?= $row['id_lembaga'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_lembaga.php?id=<?= $row['id_lembaga'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus lembaga ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>