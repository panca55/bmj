<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_kontak']) ? intval($_POST['id_kontak']) : 0;
    $email = trim($_POST['email']);
    $facebook = trim($_POST['facebook']);
    $instagram = trim($_POST['instagram']);

    if (!empty($email)) {
        if ($id > 0) {
            // Update data jika ID ada
            $stmt = $conn->prepare("UPDATE tb_kontak SET email=?, facebook=?, instagram=? WHERE id_kontak=?");
            $stmt->bind_param("sssi", $email, $facebook, $instagram, $id);
        } else {
            // Insert data baru jika ID kosong
            $stmt = $conn->prepare("INSERT INTO tb_kontak (email, facebook, instagram) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $facebook, $instagram);
        }
        $stmt->execute();
        $stmt->close();
    }

    header("Location: /admin/admin_dashboard.php?page=kontak_admin/kontak_admin");
    exit();
}

// Fetch data desa
$result = $conn->query("SELECT * FROM tb_kontak LIMIT 1");
$kontak = $result->fetch_assoc();
$id_kontak = $kontak['id_kontak'] ?? '';
$email = $kontak['email'] ?? '';
$facebook = $kontak['facebook'] ?? '';
$instagram = $kontak['instagram'] ?? '';
$result->close();
$conn->close();
?>

<div class="container mt-5">
    <?php if ($id_kontak): ?>
        <h2>Edit Data Kontak Person</h2>
    <?php else: ?>
        <h2>Tambah Data Kontak Person</h2>
    <?php endif; ?>
    <form method="post" class="mt-4">
        <input type="hidden" name="id_kontak" value="<?= htmlspecialchars($id_kontak) ?>">
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <textarea class="form-control" name="email" required><?= htmlspecialchars($email) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Facebook</label>
            <textarea class="form-control" name="facebook" required><?= htmlspecialchars($facebook) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Instagram</label>
            <textarea class="form-control" name="instagram" required><?= htmlspecialchars($instagram) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=kontak_admin/kontak_admin" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>