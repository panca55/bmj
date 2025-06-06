<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id_perangkat_desa']);
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/perangkat_desa/';
    $foto = $_POST['existing_foto']; // Default to existing photo if no new file is uploaded

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

    // Update data
    $stmt = $conn->prepare("UPDATE tb_perangkat_desa SET nama=?, tempat_tanggal_lahir=?, jenis_kelamin=?, jabatan=?, alamat=?, foto=? WHERE id_perangkat_desa=?");
    $stmt->bind_param("ssssssi", $nama, $tempat_tanggal_lahir, $jenis_kelamin, $jabatan, $alamat, $foto, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: /admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa");
    exit();
}

// Fetch data perangkat desa
$stmt = $conn->prepare("SELECT * FROM tb_perangkat_desa WHERE id_perangkat_desa = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$profil = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Edit Data Perangkat Desa Bumi Harjo</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_perangkat_desa" value="<?= htmlspecialchars($profil['id_perangkat_desa'] ?? '') ?>">
        <input type="hidden" name="existing_foto" value="<?= htmlspecialchars($profil['foto'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($profil['nama'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Tempat Tanggal Lahir</label>
            <input type="text" name="tempat_tanggal_lahir" class="form-control" value="<?= htmlspecialchars($profil['tempat_tanggal_lahir'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <input type="text" name="jenis_kelamin" class="form-control" value="<?= htmlspecialchars($profil['jenis_kelamin'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($profil['jabatan'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($profil['alamat'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>