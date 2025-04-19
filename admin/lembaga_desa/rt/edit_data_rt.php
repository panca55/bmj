<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch data perangkat desa
$stmt = $conn->prepare("SELECT * FROM tb_rt WHERE id_rt = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$profil = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id_rt']);
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/rt/';
    $foto = $profil['foto']; // Default to existing photo if no new file is uploaded

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
}

$conn->close();
?>

<div class="container mt-5">
    <div class="judul text-center">
        <h2>Edit Data Daftar Nama-Nama</h2>
        <h2>Rukun Tetangga (RT)</h2>
        <h2>Desa Bumi Harjo</h2>
    </div>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_rt" value="<?= htmlspecialchars($profil['id_rt'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= htmlspecialchars($profil['keterangan'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($profil['jabatan'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($profil['nama'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">No Telp/Hp</label>
            <input type="text" name="hp" class="form-control" value="<?= htmlspecialchars($profil['hp'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>