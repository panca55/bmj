<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_profil_desa']) ? intval($_POST['id_profil_desa']) : 0;
    $sejarah = trim($_POST['sejarah_desa']);

    if (!empty($sejarah)) {
        if ($id > 0) {
            // Update data jika ID ada
            $stmt = $conn->prepare("UPDATE tb_profil_desa SET sejarah_desa=? WHERE id_profil_desa=?");
            $stmt->bind_param("si", $sejarah, $id);
        } else {
            // Insert data baru jika ID kosong
            $stmt = $conn->prepare("INSERT INTO tb_profil_desa (sejarah_desa) VALUES (?)");
            $stmt->bind_param("s", $sejarah);
        }
        $stmt->execute();
        $stmt->close();
    }

    header("Location: /admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=sejarah");
    exit();
}

// Fetch data sejarah desa
$result = $conn->query("SELECT * FROM tb_profil_desa LIMIT 1");
$profil = $result->fetch_assoc();
$result->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Sejarah Desa</h2>
    <form method="post" class="mt-4">
        <input type="hidden" name="id_profil_desa" value="<?= htmlspecialchars($profil['id_profil_desa'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Sejarah Desa</label>
            <textarea class="form-control" name="sejarah_desa" required><?= htmlspecialchars($profil['sejarah_desa'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=sejarah" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>