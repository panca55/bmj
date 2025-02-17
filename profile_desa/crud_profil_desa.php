<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../db_connect.php';

// Handle insert and update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_profil_desa'] ?? '';
    $sejarah = $_POST['sejarah_desa'];
    $visi_misi = $_POST['visi_misi_desa'];
    $profil_kepala = $_POST['profil_kepala_desa'];
    $profil_perangkat = $_POST['profil_perangkat_desa'];
    $monografi = $_POST['monografi_kependudukan'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE tb_profil_desa SET sejarah_desa=?, visi_misi_desa=?, profil_kepala_desa=?, profil_perangkat_desa=?, monografi_kependudukan=? WHERE id_profil_desa=?");
        $stmt->bind_param("sssssi", $sejarah, $visi_misi, $profil_kepala, $profil_perangkat, $monografi, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO tb_profil_desa (sejarah_desa, visi_misi_desa, profil_kepala_desa, profil_perangkat_desa, monografi_kependudukan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $sejarah, $visi_misi, $profil_kepala, $profil_perangkat, $monografi);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: crud_profil_desa.php");
    exit();
}

// Fetch data
$result = $conn->query("SELECT * FROM tb_profil_desa");
$profil = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Profil Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Kelola Profil Desa</h2>
        <form method="post" class="mt-4">
            <input type="hidden" name="id_profil_desa" value="<?= $profil['id_profil_desa'] ?? '' ?>">
            <div class="mb-3">
                <label class="form-label">Sejarah Desa</label>
                <textarea class="form-control" name="sejarah_desa" required><?= $profil['sejarah_desa'] ?? '' ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Visi Misi</label>
                <textarea class="form-control" name="visi_misi_desa" required><?= $profil['visi_misi_desa'] ?? '' ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Profil Kepala Desa</label>
                <input type="text" class="form-control" name="profil_kepala_desa" value="<?= $profil['profil_kepala_desa'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Profil Perangkat Desa</label>
                <input type="text" class="form-control" name="profil_perangkat_desa" value="<?= $profil['profil_perangkat_desa'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Monografi Kependudukan</label>
                <input type="text" class="form-control" name="monografi_kependudukan" value="<?= $profil['monografi_kependudukan'] ?? '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>