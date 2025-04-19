<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/perangkat_desa/';
    $foto = null; // Default value if no file is uploaded

    if (isset($_FILES['foto']) && file_exists($_FILES['foto']['tmp_name'])) {
        $uploadFile = $uploadDir . basename($_FILES['foto']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Allow certain file formats
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedFileTypes)) {
            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
                $foto = '/uploads/perangkat_desa/' . basename($_FILES['foto']['name']);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    $nama = $_POST['nama'];
    $tempat_tanggal_lahir = $_POST['tempat_tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jabatan = $_POST['jabatan'];
    $alamat = $_POST['alamat'];

    // Insert data baru
    $stmt = $conn->prepare("INSERT INTO tb_perangkat_desa (nama, tempat_tanggal_lahir, jenis_kelamin, jabatan, alamat, foto) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nama, $tempat_tanggal_lahir, $jenis_kelamin, $jabatan, $alamat, $foto);

    $stmt->execute();
    $stmt->close();
    header("Location: /admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa");
    exit();
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Perangkat Desa Bumi Harjo</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tempat Tanggal Lahir</label>
            <input type="text" name="tempat_tanggal_lahir" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <input type="text" name="jenis_kelamin" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>