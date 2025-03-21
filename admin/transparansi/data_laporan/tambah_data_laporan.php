<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/data_laporan/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);
    $uploadOk = 1;
    $file = $_POST['existing_file']; // Default to existing file

    // Check if a new file is uploaded
    if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // Check if file is a actual file or fake file
        if (file_exists($_FILES['file']['tmp_name'])) {
            $uploadOk = 1;
        } else {
            echo "File is not valid.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES['file']['size'] > 500000) {
            echo "Sorry, your file is too large.";
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
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    $keterangan = $_POST['keterangan'];

    // Insert data baru
    $stmt = $conn->prepare("INSERT INTO tb_data_laporan (keterangan, file) VALUES (?, ?)");
    $stmt->bind_param("ss", $keterangan, $file);

    $stmt->execute();
    $stmt->close();
    header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=data_laporan");
    exit();
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Laporan</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" name="file" class="form-control" accept="*/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=data_laporan" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>