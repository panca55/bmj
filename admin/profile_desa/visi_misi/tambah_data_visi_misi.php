<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_profil_desa']) ? intval($_POST['id_profil_desa']) : 0;
    $visi = trim($_POST['visi_desa']);
    $misi = trim($_POST['misi_desa']);

    if (!empty($visi) && !empty($misi)) {
        if ($id > 0) {
            // Update data jika ID ada
            $stmt = $conn->prepare("UPDATE tb_profil_desa SET visi_desa=?, misi_desa=? WHERE id_profil_desa=?");
            $stmt->bind_param("ssi", $visi, $misi, $id);
        } else {
            // Insert data baru jika ID kosong
            $stmt = $conn->prepare("INSERT INTO tb_profil_desa (visi_desa, misi_desa) VALUES (?,?)");
            $stmt->bind_param("ss", $visi, $misi);
        }
        $stmt->execute();
        $stmt->close();
    }

    header("Location: /admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=visi_misi");
    exit();
}

// Fetch data sejarah desa
$result = $conn->query("SELECT * FROM tb_profil_desa LIMIT 1");
$profil = $result->fetch_assoc();
$result->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Tambah Data Visi Misi Desa</h2>
    <form method="post" class="mt-4">
        <input type="hidden" name="id_profil_desa" value="<?= htmlspecialchars($profil['id_profil_desa'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Visi Desa</label>
            <textarea class="form-control" name="visi_desa" required><?= htmlspecialchars($profil['visi_desa'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Misi Desa</label>
            <textarea class="form-control" name="misi_desa" required><?= htmlspecialchars($profil['misi_desa'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=visi_misi" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>