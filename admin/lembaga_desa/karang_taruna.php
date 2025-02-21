<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = 3;
// Ambil data karang_taruna desa dalam satu query
$sql = "SELECT * FROM tb_karang_taruna LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$keterangan = $row['keterangan'] ?? 'Belum ada keterangan';
$foto = $row['foto'] ?? '';
// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $stmt = $conn->prepare("UPDATE tb_karang_taruna SET keterangan = NULL, foto = NULL WHERE id_karang_taruna = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus.');</script>";
        header("Location: /admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna");
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
        <h5>Karang Taruna Bumi Harjo</h5>
        <div class="d-flex flex-row justify-content-end my-2">
            <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna/tambah_data_karang_taruna"
                class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
        </div>
        <div class="pb-2 pe-2 ps-2 w-100 text-start mb-2">
            <div class="d-flex flex-column justify-content-between align-content-center align-items-center">
                <?php if ($foto): ?>
                    <img src="<?= $foto ?>" class="img-fluid" alt="Foto Karang Taruna" loading="lazy">
                <?php else: ?>
                    <p>Belum ada foto karang taruna</p>
                <?php endif; ?>
            </div>
            <div class="keterangan rounded-2 border-2 border-black border p-2 mb-2 text-start">
                <?= htmlspecialchars($keterangan); ?>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-end">
        <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna/edit_data_karang_taruna"
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
        window.history.pushState({}, '', 'admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=karang_taruna/tambah_data_karang_taruna');

        // Load tambah_data_karang_taruna.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'lembaga_desa/karang_taruna/tambah_data_karang_taruna.php', true);
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
        xhr.open('GET', 'lembaga_desa/karang_taruna.php', true);
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