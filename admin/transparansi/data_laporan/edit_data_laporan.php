<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM tb_data_laporan WHERE id_data_laporan = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/data_laporan/';
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
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
    if (!in_array($fileType, $allowedFileTypes)) {
        echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, and DOCX files are allowed.";
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
            $file = '/uploads/data_laporan/' . basename($_FILES['file']['name']);
            $keterangan = $_POST['keterangan'];

            // Update existing data
            $stmt = $conn->prepare("UPDATE tb_data_laporan SET keterangan = ?, file = ? WHERE id_data_laporan = ?");
            $stmt->bind_param("ssi", $keterangan, $file, $id);

            $stmt->execute();
            $stmt->close();
            header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=data_laporan");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Edit Data Laporan</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($existingData['keterangan'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" name="file" class="form-control" value="<?= htmlspecialchars($existingData['file'] ?? '') ?>" accept="*/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=data_laporan" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>