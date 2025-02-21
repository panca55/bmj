<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = 3;
// Ambil data bumdes desa dalam satu query
$sql = "SELECT * FROM tb_bumdes LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$keterangan = $row['keterangan'] ?? 'Belum ada keterangan';
$foto = $row['foto'] ?? '';
// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $stmt = $conn->prepare("UPDATE tb_bumdes SET keterangan = NULL, foto = NULL WHERE id_bumdes = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus.');</script>";
        header("Location: /admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=bumdes");
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
        <h5>Badan Permusyawaratan Desa Bumi Harjo</h5>
        <div class="pb-2 pe-2 ps-2 w-100 text-start mb-2">
            <div class="d-flex flex-row justify-content-end my-2">
                <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=bumdes/tambah_data_bumdes"
                    class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
            </div>
            <div class="keterangan rounded-2 border-2 border-black border p-2 mb-2 text-start">
                <?= htmlspecialchars($keterangan); ?>
            </div>
            <div class="d-flex flex-column mb-2 text-center">
                <h5>Struktur Pengurus BUMDES</h5>
                <h5>Desa Bumi Harjo</h5>
            </div>
            <div class="d-flex flex-column justify-content-between align-content-center align-items-center">
                <?php if ($foto): ?>
                    <img src="<?= $foto ?>" class="img-fluid" alt="Foto Badan Permusyawaratan Desa" loading="lazy">
                <?php else: ?>
                    <p>Belum ada foto Badan Permusyawaratan Desa</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-end">
        <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=bumdes/edit_data_bumdes"
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
        window.history.pushState({}, '', 'admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=bumdes/tambah_data_bumdes');

        // Load tambah_data_bumdes.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'lembaga_desa/bumdes/tambah_data_bumdes.php', true);
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
        xhr.open('GET', 'lembaga_desa/bumdes.php', true);
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