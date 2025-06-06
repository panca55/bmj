<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';


// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM tb_bumdes ORDER BY id_bumdes DESC LIMIT 1");
$id = isset($_GET['id_bumdes']) ? intval($_GET['id_bumdes']) : 0;
$stmt->execute();
$result = $stmt->get_result();
$existingData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/bumdes/';
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
                $foto = '/uploads/bumdes/' . basename($_FILES['file']['name']);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
        }
    }

    $keterangan = $_POST['keterangan'];
    $id = $_POST['id_bumdes'];

    // Update existing data
    $stmt = $conn->prepare("UPDATE tb_bumdes SET keterangan = ?, foto = ? WHERE id_bumdes = ?");
    $stmt->bind_param("ssi", $keterangan, $foto, $id);

    $stmt->execute();
    $stmt->close();
    header("Location: /admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=bumdes");
    exit();
}
?>

<div class="container mt-5">
    <h2>Edit Data BUMDES</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_bumdes" value="<?= htmlspecialchars($existingData['id_bumdes'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($existingData['keterangan'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="file" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=bumdes" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>