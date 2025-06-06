<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';


// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM tb_apbd_desa LIMIT 1");
$id = isset($_GET['id_apbd_desa']) ? intval($_GET['id_apbd_desa']) : 0;
$stmt->execute();
$result = $stmt->get_result();
$existingData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/apbd_desa/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if file is a actual file or fake file
    if (file_exists($_FILES['file']['tmp_name'])) {
        $uploadOk = 1;
    } else {
        echo "File is not valid.";
        $uploadOk = 0;
    }

    // Check file size
    // if ($_FILES['file']['size'] > 500000) {
    //     echo "Sorry, your file is too large.";
    //     $uploadOk = 0;
    // }

    // Allow certain file formats
    $allowedFileTypes = ['jpg', 'jpeg', 'png'];
    if (!in_array($fileType, $allowedFileTypes)) {
        echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $foto = '/uploads/apbd_desa/' . basename($_FILES['file']['name']);
            $keterangan = $_POST['keterangan'];
            $id = $_POST['id_apbd_desa'];

            // Update existing data
            $stmt = $conn->prepare("UPDATE tb_apbd_desa SET keterangan = ?, foto = ? WHERE id_apbd_desa = ?");
            $stmt->bind_param("ssi", $keterangan, $foto, $id);

            $stmt->execute();
            $stmt->close();
            header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=apbd_desa");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<div class="container mt-5">
    <h2>Edit Data APBDesa</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_apbd_desa" value="<?= htmlspecialchars($existingData['id_apbd_desa'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($existingData['keterangan'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="file" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=apbd_desa" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>