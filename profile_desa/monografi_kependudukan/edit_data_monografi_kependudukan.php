<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_profil_desa']) ? intval($_POST['id_profil_desa']) : 0;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/monografi_kependudukan/';
    $uploadFile = $uploadDir . basename($_FILES['monografi_kependudukan']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['monografi_kependudukan']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['monografi_kependudukan']['size'] > 500000) {
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
        // if everything is ok, try to upload file
    } else {
        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['monografi_kependudukan']['tmp_name'], $uploadFile)) {
            $struktur = '/uploads/monografi_kependudukan/' . basename($_FILES['monografi_kependudukan']['name']);
            if ($id > 0) {
                // Update data jika ID ada
                $stmt = $conn->prepare("UPDATE tb_profil_desa SET monografi_kependudukan=? WHERE id_profil_desa=?");
                $stmt->bind_param("si", $struktur, $id);
            } else {
                // Insert data baru jika ID kosong
                $stmt = $conn->prepare("INSERT INTO tb_profil_desa (monografi_kependudukan) VALUES (?)");
                $stmt->bind_param("s", $struktur);
            }
            $stmt->execute();
            $stmt->close();
            header("Location: /admin_dashboard.php?page=profile_desa/profil_desa&subpage=monografi_kependudukan");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch data struktur desa
$result = $conn->query("SELECT * FROM tb_profil_desa LIMIT 1");
$profil = $result->fetch_assoc();
$result->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Monografi Kependudukan</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_profil_desa" value="<?= htmlspecialchars($profil['id_profil_desa'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Upload Monografi Kependudukan</label>
            <input type="file" name="monografi_kependudukan" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin_dashboard.php?page=profile_desa/profil_desa&subpage=monografi_kependudukan" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>