<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/rt/';
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
                $foto = '/uploads/rt/' . basename($_FILES['foto']['name']);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    $jabatan = $_POST['jabatan'];
    $hp = $_POST['hp'];

    // Insert data baru
    $stmt = $conn->prepare("INSERT INTO tb_rt (nama, keterangan, jabatan, hp, foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $keterangan, $jabatan, $hp, $foto);

    $stmt->execute();
    $stmt->close();
    header("Location: /admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt");
    exit();
}

$conn->close();
?>

<div class="container mt-5">
    <div class="judul text-center">
        <h2>Tambah Data Daftar Nama-Nama</h2>
        <h2>Rukun Tetangga (RT)</h2>
        <h2>Desa Bumi Harjo</h2>
    </div>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">No Telp/Hp</label>
            <input type="text" name="hp" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>