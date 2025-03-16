<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_kades']) ? intval($_POST['id_kades']) : 0;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/kepala_desa/';
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
            $foto = '/uploads/kepala_desa/' . basename($_FILES['foto']['name']);
            $nama = $_POST['nama'];
            $tempat_tanggal_lahir = $_POST['tempat_tanggal_lahir'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $status = $_POST['status'];
            $alamat = $_POST['alamat'];
            $hp = $_POST['hp'];
            $nama_pasangan = $_POST['nama_pasangan'];
            $keterangan_jabatan = $_POST['keterangan_jabatan'];
            $no_sk = $_POST['no_sk'];

            if ($id > 0) {
                // Update data jika ID ada
                $stmt = $conn->prepare("UPDATE tb_kepala_desa SET nama=?, tempat_tanggal_lahir=?, jenis_kelamin=?, status=?, alamat=?, hp=?, nama_pasangan=?, foto=?, keterangan_jabatan=?, no_sk=? WHERE id_kades=?");
                $stmt->bind_param("ssssssssssi", $nama, $tempat_tanggal_lahir, $jenis_kelamin, $status, $alamat, $hp, $nama_pasangan, $foto, $keterangan_jabatan, $no_sk, $id);
            } else {
                // Insert data baru jika ID kosong
                $stmt = $conn->prepare("INSERT INTO tb_kepala_desa (nama, tempat_tanggal_lahir, jenis_kelamin, status, alamat, hp, nama_pasangan, foto, keterangan_jabatan, no_sk) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssss", $nama, $tempat_tanggal_lahir, $jenis_kelamin, $status, $alamat, $hp, $nama_pasangan, $foto, $keterangan_jabatan, $no_sk);
            }
            $stmt->execute();
            $stmt->close();
            header("Location: /admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_kepala_desa");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch data profil kepala desa
$result = $conn->query("SELECT * FROM tb_kepala_desa LIMIT 1");
$profil = $result->fetch_assoc();
$result->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Profil Kepala Desa Bumi Harjo</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_kades" value="<?= htmlspecialchars($profil['id_kades'] ?? '') ?>">
        <div class="d-flex flex-row-reverse">
            <div class="d-flex flex-column container">
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
                    <label class="form-label">Status</label>
                    <input type="text" name="status" class="form-control" value="<?= htmlspecialchars($profil['status'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($profil['alamat'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Telp/Hp</label>
                    <input type="text" name="hp" class="form-control" value="<?= htmlspecialchars($profil['hp'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Suami/Istri</label>
                    <input type="text" name="nama_pasangan" class="form-control" value="<?= htmlspecialchars($profil['nama_pasangan'] ?? '') ?>">
                </div>
            </div>
            <div class="d-flex flex-column container">
                <div class="mb-3">
                    <label class="form-label">Upload Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan Jabatan</label>
                    <input type="text" name="keterangan_jabatan" class="form-control" value="<?= htmlspecialchars($profil['keterangan_jabatan'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor SK</label>
                    <input type="text" name="no_sk" class="form-control" value="<?= htmlspecialchars($profil['no_sk'] ?? '') ?>">
                </div>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_kepala_desa" class="btn btn-secondary ms-3">Batal</a>
        </div>
    </form>
</div>