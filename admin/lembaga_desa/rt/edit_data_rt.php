<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id_rt']);
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/rt/';
    $uploadFile = $uploadDir . basename($_FILES['foto']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['foto']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['foto']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
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

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
            $foto = '/uploads/rt/' . basename($_FILES['foto']['name']);
            $nama = $_POST['nama'];
            $jabatan = $_POST['jabatan'];
            $keterangan = $_POST['keterangan'];
            $hp = $_POST['hp'];

            // Update data
            $stmt = $conn->prepare("UPDATE tb_rt SET keterangan=?, nama=?, hp=?, jabatan=?, foto=? WHERE id_rt=?");
            $stmt->bind_param("sssssi", $keterangan, $nama, $hp, $jabatan, $foto, $id);
            $stmt->execute();
            $stmt->close();
            header("Location: /admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch data perangkat desa
$stmt = $conn->prepare("SELECT * FROM tb_rt WHERE id_rt = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$profil = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <div class="judul text-center">
        <h2>Tambah Data Daftar Nama-Nama</h2>
        <h2>Rukun Tetangga (RT)</h2>
        <h2>Desa Bumi Harjo</h2>
    </div>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_rt" value="<?= htmlspecialchars($profil['id_rt'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($profil['keterangan'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($profil['jabatan'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($profil['nama'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">No Telp/Hp</label>
            <input type="text" name="hp" class="form-control" value="<?= htmlspecialchars($profil['hp'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>