<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = 3;
// Ambil data profil_kepala_desa desa dalam satu query
$sql = "SELECT * FROM tb_kepala_desa LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nama = $row['nama'] ?? 'Data belum ada.';
$tempat_tanggal_lahir = $row['tempat_tanggal_lahir'] ?? 'Data belum ada.';
$jenis_kelamin = $row['jenis_kelamin'] ?? 'Data belum ada.';
$status = $row['status'] ?? 'Data belum ada.';
$alamat = $row['alamat'] ?? 'Data belum ada.';
$hp = $row['hp'] ?? 'Data belum ada.';
$nama_pasangan = $row['nama_pasangan'] ?? 'Data belum ada.';
$foto = $row['foto'] ?? 'Data belum ada.';
$keterangan_jabatan = $row['keterangan_jabatan'] ?? 'Data belum ada.';
$no_sk = $row['no_sk'] ?? 'Data belum ada.';
// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM tb_kepala_desa WHERE id_kades = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_kepala_desa");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-row justify-content-around my-2">
        <div class="d-flex flex-column text-start">
            <?php if ($foto): ?>
                <img src="<?= $foto ?>" class="img-fluid w-50" alt="Foto Kepala Desa">
            <?php else: ?>
                <p>Belum ada gambar struktur desa.</p>
            <?php endif; ?>
            <img src="" alt="">
            <div class="d-flex flex-row">
                <p>jabatan &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $keterangan_jabatan ?></p>
            </div>
            <div class="d-flex flex-row">
                <p>Nomor SK &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $no_sk ?></p>
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex flex-row">
                <p>nama &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $nama ?></p>
            </div>
            <div class="d-flex flex-row">
                <p>Tempat Tanggal Lahir &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $tempat_tanggal_lahir ?></p>
            </div>
            <div class="d-flex flex-row">
                <p>Jenis Kelamin &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $jenis_kelamin ?></p>
            </div>
            <div class="d-flex flex-row">
                <p>Status &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $status ?></p>
            </div>
            <div class="d-flex flex-row">
                <p>ALamat &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $alamat ?></p>
            </div>
            <div class="d-flex flex-row">
                <p>Telp/Hp &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $hp ?></p>
            </div>
            <div class="d-flex flex-row">
                <p>Nama Suami/Istri &ThickSpace;</p>
                <p>: &ThickSpace;</p>
                <p class="text-wrap"><?= $nama_pasangan ?></p>
            </div>
        </div>
        <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_kepala_desa/tambah_data_profil_kepala_desa"
            class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
    </div>
    <div class="d-flex flex-row justify-content-end">
        <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_kepala_desa/edit_data_profil_kepala_desa"
            class="btn btn-primary me-2">Edit</a>
        <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
            <input type="hidden" name="delete" value="<?= $id; ?>">
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>

<!-- AJAX and loading spinner -->
<div id="loading-spinner" style="display:none;">Loading...</div>
<div id="subpage-content"></div>

<script>
    document.getElementById('tambah-data-link').addEventListener('click', function(event) {
        event.preventDefault();
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        // Show spinner
        spinner.style.display = 'block';

        // Update the URL
        window.history.pushState({}, '', 'admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_kepala_desa/tambah_data_profil_kepala_desa');

        // Load tambah_data_profil_kepala_desa.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'profile_desa/profil_kepala_desa/tambah_data_profil_kepala_desa', true);
        xhr.onload = function() {
            spinner.style.display = 'none';

            if (xhr.status === 200) {
                subpageContent.innerHTML = xhr.responseText;
            } else {
                subpageContent.innerHTML = 'Error loading content.';
            }
        };
        xhr.send();
    });

    window.addEventListener('popstate', function(event) {
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        spinner.style.display = 'block';

        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'profile_desa/profil_kepala_desa.php', true);
        xhr.onload = function() {
            spinner.style.display = 'none';

            if (xhr.status === 200) {
                subpageContent.innerHTML = xhr.responseText;
            } else {
                subpageContent.innerHTML = 'Error loading content.';
            }
        };
        xhr.send();
    });
</script>