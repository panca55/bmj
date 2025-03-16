<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';


// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM tb_transparansi_anggaran LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
$existingData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keterangan = $_POST['keterangan'];
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/transparansi_anggaran/';
    $uploadOk = 1;

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle APBDesa file upload
    if ($_FILES['apbd_desa']['name']) {
        $apbdDesaFile = $uploadDir . basename($_FILES['apbd_desa']['name']);
        if (move_uploaded_file($_FILES['apbd_desa']['tmp_name'], $apbdDesaFile)) {
            $apbdDesa = '/uploads/transparansi_anggaran/' . basename($_FILES['apbd_desa']['name']);
        } else {
            $apbdDesa = $existingData['apbd_desa'];
        }
    } else {
        $apbdDesa = $existingData['apbd_desa'];
    }

    // Handle Dana Desa file upload
    if ($_FILES['dana_desa']['name']) {
        $danaDesaFile = $uploadDir . basename($_FILES['dana_desa']['name']);
        if (move_uploaded_file($_FILES['dana_desa']['tmp_name'], $danaDesaFile)) {
            $danaDesa = '/uploads/transparansi_anggaran/' . basename($_FILES['dana_desa']['name']);
        } else {
            $danaDesa = $existingData['dana_desa'];
        }
    } else {
        $danaDesa = $existingData['dana_desa'];
    }

    // Handle Pendapatan Asli Desa file upload
    if ($_FILES['pendapatan_asli_desa']['name']) {
        $pendapatanAsliDesaFile = $uploadDir . basename($_FILES['pendapatan_asli_desa']['name']);
        if (move_uploaded_file($_FILES['pendapatan_asli_desa']['tmp_name'], $pendapatanAsliDesaFile)) {
            $pendapatanAsliDesa = '/uploads/transparansi_anggaran/' . basename($_FILES['pendapatan_asli_desa']['name']);
        } else {
            $pendapatanAsliDesa = $existingData['pendapatan_asli_desa'];
        }
    } else {
        $pendapatanAsliDesa = $existingData['pendapatan_asli_desa'];
    }

    // Update existing data
    $stmt = $conn->prepare("UPDATE tb_transparansi_anggaran SET keterangan = ?, apbd_desa = ?, dana_desa = ?, pendapatan_asli_desa = ? WHERE id_transparansi_anggaran = ?");
    $stmt->bind_param("ssssi", $keterangan, $apbdDesa, $danaDesa, $pendapatanAsliDesa, $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=transparansi_anggaran");
        exit();
    } else {
        echo "Sorry, there was an error updating your data.";
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Edit Data Transparansi Anggaran</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($existingData['keterangan'] ?? '') ?>">
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