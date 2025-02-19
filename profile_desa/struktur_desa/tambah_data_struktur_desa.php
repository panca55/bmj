<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_profil_desa']) ? intval($_POST['id_profil_desa']) : 0;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/struktur_desa/';
    $uploadFile = $uploadDir . basename($_FILES['struktur_desa']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['struktur_desa']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['struktur_desa']['size'] > 500000) {
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

        if (move_uploaded_file($_FILES['struktur_desa']['tmp_name'], $uploadFile)) {
            $struktur = '/uploads/struktur_desa/' . basename($_FILES['struktur_desa']['name']);
            if ($id > 0) {
                // Update data jika ID ada
                $stmt = $conn->prepare("UPDATE tb_profil_desa SET struktur_desa=? WHERE id_profil_desa=?");
                $stmt->bind_param("si", $struktur, $id);
            } else {
                // Insert data baru jika ID kosong
                $stmt = $conn->prepare("INSERT INTO tb_profil_desa (struktur_desa) VALUES (?)");
                $stmt->bind_param("s", $struktur);
            }
            $stmt->execute();
            $stmt->close();
            header("Location: /admin_dashboard.php?page=profile_desa/profil_desa&subpage=struktur_desa");
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
    <h2>Tambah Data Struktur Desa</h2>
    <form method="post" class="mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_profil_desa" value="<?= htmlspecialchars($profil['id_profil_desa'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Upload Struktur Desa</label>
            <input type="file" name="struktur_desa" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin_dashboard.php?page=profile_desa/profil_desa&subpage=struktur_desa" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>