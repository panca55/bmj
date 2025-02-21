<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bulan = $_POST['bulan'];
    $tanggal = $_POST['tanggal'];
    $kegiatan = $_POST['kegiatan'];

    // Insert data baru
    $stmt = $conn->prepare("INSERT INTO tb_kalender_kegiatan (bulan, tanggal, kegiatan) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $bulan, $tanggal, $kegiatan);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan");
        exit();
    } else {
        echo "Sorry, there was an error inserting your data.";
    }
}

$conn->close();
?>

<div class="container mt-5">
    <div class="judul text-center">
        <h2>Tambah Data Kalender Kegiatan</h2>
        <h2>Desa Bumi Harjo</h2>
    </div>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-control" required>
                <option value="">Pilih Bulan</option>
                <option value="Januari">Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <option value="Mei">Mei</option>
                <option value="Juni">Juni</option>
                <option value="Juli">Juli</option>
                <option value="Agustus">Agustus</option>
                <option value="September">September</option>
                <option value="Oktober">Oktober</option>
                <option value="November">November</option>
                <option value="Desember">Desember</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <select name="tanggal" class="form-control" required>
                <option value="">Pilih Tanggal</option>
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kegiatan</label>
            <input type="text" name="kegiatan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan" class="btn btn-secondary ms-3">Batal</a>
    </form>
</div>