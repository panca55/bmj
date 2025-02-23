<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data layanan desa
$sql = "SELECT id_layanan, layanan_desa FROM tb_layanan LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$layanan = $row['layanan_desa'] ?? 'Data tidak ditemukan.';
$id = $row['id_layanan'] ?? 0;

// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $stmt = $conn->prepare("UPDATE tb_layanan SET layanan_desa = NULL WHERE id_layanan = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /dashboard.php?page=layanan_desa/layanan_desa&subpage=pelayanan_desa");
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
        <h3>Pelayanan Desa Bumi Harjo</h3>
        <div class="d-flex flex-row justify-content-end my-2">
            <a href="/dashboard.php?page=layanan_desa/layanan_desa&subpage=pelayanan_desa/tambah_data_layanan_desa" class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
        </div>
        <div class="layanan rounded-2 border-2 border-black border p-2 mb-2 text-start">
            <?= htmlspecialchars($layanan); ?>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-end">
        <a href="/dashboard.php?page=layanan_desa/layanan_desa&subpage=pelayanan_desa/edit_data_layanan_desa" class="btn btn-primary me-2">Edit</a>
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
        window.history.pushState({}, '', 'dashboard.php?page=layanan_desa/layanan_desa&subpage=pelayanan_desa/tambah_data_layanan_desa');

        // Load tambah_data_layanan_desa.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'layanan_desa/pelayanan_desa/tambah_data_layanan_desa.php', true);
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
        xhr.open('GET', 'layanan_desa/pelayanan_desa.php', true);
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