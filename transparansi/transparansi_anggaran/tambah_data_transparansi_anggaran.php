<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keterangan = $_POST['keterangan'];
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/transparansi_anggaran/';
    $uploadOk = 1;

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle APBDesa file upload
    $apbdDesaFile = $uploadDir . basename($_FILES['apbd_desa']['name']);
    $apbdDesaFileType = strtolower(pathinfo($apbdDesaFile, PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES['apbd_desa']['tmp_name'], $apbdDesaFile)) {
        $apbdDesa = '/uploads/transparansi_anggaran/' . basename($_FILES['apbd_desa']['name']);
    } else {
        $apbdDesa = NULL;
    }

    // Handle Dana Desa file upload
    $danaDesaFile = $uploadDir . basename($_FILES['dana_desa']['name']);
    $danaDesaFileType = strtolower(pathinfo($danaDesaFile, PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES['dana_desa']['tmp_name'], $danaDesaFile)) {
        $danaDesa = '/uploads/transparansi_anggaran/' . basename($_FILES['dana_desa']['name']);
    } else {
        $danaDesa = NULL;
    }

    // Handle Pendapatan Asli Desa file upload
    $pendapatanAsliDesaFile = $uploadDir . basename($_FILES['pendapatan_asli_desa']['name']);
    $pendapatanAsliDesaFileType = strtolower(pathinfo($pendapatanAsliDesaFile, PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES['pendapatan_asli_desa']['tmp_name'], $pendapatanAsliDesaFile)) {
        $pendapatanAsliDesa = '/uploads/transparansi_anggaran/' . basename($_FILES['pendapatan_asli_desa']['name']);
    } else {
        $pendapatanAsliDesa = NULL;
    }

    // Insert data baru
    $stmt = $conn->prepare("INSERT INTO tb_transparansi_anggaran (keterangan, apbd_desa, dana_desa, pendapatan_asli_desa) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $keterangan, $apbdDesa, $danaDesa, $pendapatanAsliDesa);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=transparansi_anggaran");
        exit();
    } else {
        echo "Sorry, there was an error inserting your data.";
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Transparansi Anggaran</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload APBDesa</label>
            <input type="file" name="apbd_desa" class="form-control" accept="*/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Dana Desa</label>
            <input type="file" name="dana_desa" class="form-control" accept="*/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Pendapatan Asli Desa</label>
            <input type="file" name="pendapatan_asli_desa" class="form-control" accept="*/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=transparansi_anggaran" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>