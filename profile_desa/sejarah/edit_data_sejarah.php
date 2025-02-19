<?php
include 'db_connect.php';

$message = ""; // Variabel untuk pesan sukses atau error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_profil_desa']) ? intval($_POST['id_profil_desa']) : 0;
    $sejarah = trim($_POST['sejarah_desa']);

    if (!empty($sejarah)) {
        try {
            if ($id > 0) {
                // Update data jika ID tersedia
                $stmt = $conn->prepare("UPDATE tb_profil_desa SET sejarah_desa=? WHERE id_profil_desa=?");
                $stmt->bind_param("si", $sejarah, $id);
            } else {
                // Insert data baru jika ID tidak tersedia
                $stmt = $conn->prepare("INSERT INTO tb_profil_desa (sejarah_desa) VALUES (?)");
                $stmt->bind_param("s", $sejarah);
            }

            if ($stmt->execute()) {
                header("Location: /admin_dashboard.php?page=profile_desa/profil_desa&subpage=sejarah");
                exit();
            } else {
                $message = "Terjadi kesalahan saat menyimpan data.";
            }

            $stmt->close();
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Sejarah desa tidak boleh kosong.";
    }
}

// Fetch data sejarah desa
$profil = null;
if ($result = $conn->query("SELECT * FROM tb_profil_desa LIMIT 1")) {
    $profil = $result->fetch_assoc();
    $result->close();
}

$conn->close();
?>

<div class="container mt-5">
    <h2>Edit Data Sejarah Desa</h2>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="mt-4">
        <input type="hidden" name="id_profil_desa" value="<?= htmlspecialchars($profil['id_profil_desa'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Sejarah Desa</label>
            <textarea class="form-control" name="sejarah_desa" required><?= htmlspecialchars($profil['sejarah_desa'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin_dashboard.php?page=profile_desa/profil_desa&subpage=sejarah" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>