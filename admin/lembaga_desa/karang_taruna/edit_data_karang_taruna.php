<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';


// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM tb_karang_taruna LIMIT 1");
$id = isset($_GET['id_karang_taruna']) ? intval($_GET['id_karang_taruna']) : 0;
$stmt->execute();
$result = $stmt->get_result();
$existingData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/karang_taruna/';
    $foto = $existingData['foto']; // Default to existing photo if no new file is uploaded

    if (isset($_FILES['file']) && file_exists($_FILES['file']['tmp_name'])) {
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Allow certain file formats
        $allowedFileTypes = ['jpg', 'jpeg', 'png'];
        if (in_array($fileType, $allowedFileTypes)) {
            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                $foto = '/uploads/karang_taruna/' . basename($_FILES['file']['name']);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
        }
    }

    $keterangan = $_POST['keterangan'];
    $id = $_POST['id_karang_taruna'];

    // Update existing data
    $stmt = $conn->prepare("UPDATE tb_karang_taruna SET keterangan = ?, foto = ? WHERE id_karang_taruna = ?");
    $stmt->bind_param("ssi", $keterangan, $foto, $id);

    $stmt->execute();
    $stmt->close();
    header("Location: /admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna");
    exit();
}
?>

<div class="container mt-5">
    <h2>Edit Data Karang Taruna</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_karang_taruna" value="<?= htmlspecialchars($existingData['id_karang_taruna'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($existingData['keterangan'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="file" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>