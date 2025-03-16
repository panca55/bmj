<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM tb_kalender_kegiatan WHERE id_kegiatan = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bulan = $_POST['bulan'];
    $tanggal = $_POST['tanggal'];
    $kegiatan = $_POST['kegiatan'];

    // Update existing data
    $stmt = $conn->prepare("UPDATE tb_kalender_kegiatan SET bulan = ?, tanggal = ?, kegiatan = ? WHERE id_kegiatan = ?");
    $stmt->bind_param("sssi", $bulan, $tanggal, $kegiatan, $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan");
        exit();
    } else {
        echo "Sorry, there was an error updating your data.";
    }
}

$conn->close();
?>

<div class="container mt-5">
    <div class="judul text-center">
        <h2>Edit Data Kalender Kegiatan</h2>
        <h2>Desa Bumi Harjo</h2>
    </div>
    <form method="post" class="mt-4">
        <input type="hidden" name="id_kegiatan" value="<?= htmlspecialchars($existingData['id_kegiatan'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-control">
                <option value="">Pilih Bulan</option>
                <option value="Januari" <?= $existingData['bulan'] == 'Januari' ? 'selected' : '' ?>>Januari</option>
                <option value="Februari" <?= $existingData['bulan'] == 'Februari' ? 'selected' : '' ?>>Februari</option>
                <option value="Maret" <?= $existingData['bulan'] == 'Maret' ? 'selected' : '' ?>>Maret</option>
                <option value="April" <?= $existingData['bulan'] == 'April' ? 'selected' : '' ?>>April</option>
                <option value="Mei" <?= $existingData['bulan'] == 'Mei' ? 'selected' : '' ?>>Mei</option>
                <option value="Juni" <?= $existingData['bulan'] == 'Juni' ? 'selected' : '' ?>>Juni</option>
                <option value="Juli" <?= $existingData['bulan'] == 'Juli' ? 'selected' : '' ?>>Juli</option>
                <option value="Agustus" <?= $existingData['bulan'] == 'Agustus' ? 'selected' : '' ?>>Agustus</option>
                <option value="September" <?= $existingData['bulan'] == 'September' ? 'selected' : '' ?>>September</option>
                <option value="Oktober" <?= $existingData['bulan'] == 'Oktober' ? 'selected' : '' ?>>Oktober</option>
                <option value="November" <?= $existingData['bulan'] == 'November' ? 'selected' : '' ?>>November</option>
                <option value="Desember" <?= $existingData['bulan'] == 'Desember' ? 'selected' : '' ?>>Desember</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <select name="tanggal" class="form-control">
                <option value="">Pilih Tanggal</option>
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option value="<?= $i; ?>" <?= $existingData['tanggal'] == $i ? 'selected' : '' ?>><?= $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kegiatan</label>
            <input type="text" name="kegiatan" class="form-control" value="<?= htmlspecialchars($existingData['kegiatan'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>