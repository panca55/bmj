<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/persyaratan_surat/';
    $file = null; // Default value if no file is uploaded

    if (isset($_FILES['file']) && file_exists($_FILES['file']['tmp_name'])) {
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Allow certain file formats
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
        if (in_array($fileType, $allowedFileTypes)) {
            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                $file = '/uploads/persyaratan_surat/' . basename($_FILES['file']['name']);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, and DOCX files are allowed.";
        }
    }

    $keterangan = $_POST['keterangan'];

    // Insert data baru
    $stmt = $conn->prepare("INSERT INTO tb_persyaratan_surat (keterangan, file) VALUES (?, ?)");
    $stmt->bind_param("ss", $keterangan, $file);

    $stmt->execute();
    $stmt->close();
    header("Location: /admin/admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat");
    exit();
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Persyaratan Surat</h2>
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
        <a href="/admin/admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>