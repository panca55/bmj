<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/karang_taruna/';
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
    if ($_FILES['file']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

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
            $foto = '/uploads/karang_taruna/' . basename($_FILES['file']['name']);
            $keterangan = $_POST['keterangan'];

            // Insert data baru
            $stmt = $conn->prepare("INSERT INTO tb_karang_taruna (keterangan, foto) VALUES (?, ?)");
            $stmt->bind_param("ss", $keterangan, $foto);

            $stmt->execute();
            $stmt->close();
            header("Location: /admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Karang Taruna</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="file" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>