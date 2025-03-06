<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_layanan']) ? intval($_POST['id_layanan']) : 0;
    $layanan_desa = trim($_POST['layanan_desa']);

    if (!empty($layanan_desa)) {
        if ($id > 0) {
            // Update data jika ID ada
            $stmt = $conn->prepare("UPDATE tb_layanan SET layanan_desa=? WHERE id_layanan=?");
            $stmt->bind_param("si", $layanan_desa, $id);
        } else {
            // Insert data baru jika ID kosong
            $stmt = $conn->prepare("INSERT INTO tb_layanan (layanan_desa) VALUES (?)");
            $stmt->bind_param("s", $layanan_desa);
        }
        $stmt->execute();
        $stmt->close();
    }

    header("Location: /admin/admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=pelayanan_desa");
    exit();
}

// Fetch data layanan_desa desa
$result = $conn->query("SELECT * FROM tb_layanan LIMIT 1");
$profil = $result->fetch_assoc();
$result->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data layanan_desa Desa</h2>
    <form method="post" class="mt-4">
        <input type="hidden" name="id_layanan" value="<?= htmlspecialchars($profil['id_layanan'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Keterangan pelayanan desa Desa</label>
            <textarea class="form-control" name="layanan_desa" required><?= htmlspecialchars($profil['layanan_desa'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=layanan_desa" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>