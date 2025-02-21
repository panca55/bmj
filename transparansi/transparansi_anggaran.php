<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data transparansi anggaran desa
$sql = "SELECT * FROM tb_transparansi_anggaran";
$result = $conn->query($sql);
$transparansiAnggaran = [];
while ($row = $result->fetch_assoc()) {
    $transparansiAnggaran[] = $row;
}

// Ambil keterangan
$sql = "SELECT keterangan, id_transparansi_anggaran FROM tb_transparansi_anggaran LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$keterangan = $row['keterangan'] ?? 'Belum ada keterangan';
$id = $row['id_transparansi_anggaran'];
// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    // $id = intval($_POST['delete']);
    $stmt = $conn->prepare("UPDATE tb_transparansi_anggaran SET keterangan = NULL, apbd_desa = NULL, dana_desa = NULL, pendapatan_asli_desa = NULL WHERE id_transparansi_anggaran = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /admin/admin_dashboard.php?page=transparansi/transparansi&subpage=transparansi_anggaran");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h5>Transparansi Anggaran Desa Bumi Harjo</h5>
        <div class="pb-2 pe-2 ps-2 w-100 text-start mb-2">
            <div class="d-flex flex-row justify-content-end my-2">
                <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=transparansi_anggaran/tambah_data_transparansi_anggaran"
                    class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
            </div>
            <div class="keterangan rounded-2 border-2 border-black border p-2 mb-2 text-start">
                <?= htmlspecialchars($keterangan); ?>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column">
        <h5 class="fw-bold">Tabel Transparansi Anggaran Desa Tahun <?= date('Y'); ?></h5>
        <table class="table table-bordered">
            <tbody>
                <?php foreach ($transparansiAnggaran as $index => $anggaran): ?>
                    <tr>
                        <td>
                            APBDesa Tahun <?= date('Y'); ?>
                            <?php if ($anggaran['apbd_desa']): ?>
                                <a href="data:application/octet-stream;base64,<?= base64_encode($anggaran['apbd_desa']); ?>" class="btn btn-link" download>Download</a>
                            <?php else: ?>
                                <span class="text-muted">File tidak tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Dana Desa Tahun <?= date('Y'); ?>
                            <?php if ($anggaran['dana_desa']): ?>
                                <a href="data:application/octet-stream;base64,<?= base64_encode($anggaran['dana_desa']); ?>" class="btn btn-link" download>Download</a>
                            <?php else: ?>
                                <span class="text-muted">File tidak tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Pendapatan Asli Desa Tahun <?= date('Y'); ?>
                            <?php if ($anggaran['pendapatan_asli_desa']): ?>
                                <a href="data:application/octet-stream;base64,<?= base64_encode($anggaran['pendapatan_asli_desa']); ?>" class="btn btn-link" download>Download</a>
                            <?php else: ?>
                                <span class="text-muted">File tidak tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex flex-row justify-content-end">
        <a href="/admin/admin_dashboard.php?page=transparansi/transparansi&subpage=transparansi_anggaran/edit_data_transparansi_anggaran"
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
        window.history.pushState({}, '', 'admin/admin_dashboard.php?page=transparansi/transparansi&subpage=transparansi_anggaran/tambah_data_transparansi_anggaran');

        // Load tambah_data_transparansi_anggaran.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'transparansi/transparansi_anggaran/tambah_data_transparansi_anggaran.php', true);
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
        xhr.open('GET', 'transparansi/transparansi_anggaran.php', true);
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