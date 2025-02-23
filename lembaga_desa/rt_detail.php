<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Ambil data kontak_admin desa dalam satu query
$stmt = $conn->prepare("SELECT * FROM tb_rt WHERE id_rt =? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$keterangan = $row['keterangan'] ?? 'Data belum ada.';
$jabatan = $row['jabatan'] ?? 'Data belum ada.';
$nama = $row['nama'] ?? 'Data belum ada.';
$foto = $row['foto'] ?? 0;
$hp = $row['hp'] ?? 0;

$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center align-items-center">
        <h3 class="border border-1 py-1 px-5 border-black" style="width: fit-content;"><?= htmlspecialchars($jabatan) ?></h3>
        <img src="<?= $foto ?>" alt="foto struktur rt">
    </div>
    <div class="d-flex flex-column text-start my-4">
        <div class="d-flex flex-row">
            <p>JABATAN &ThickSpace;</p>
            <p>: &ThickSpace;</p>
            <p class="text-wrap"><?= htmlspecialchars($jabatan) ?></p>
        </div>
        <div class="d-flex flex-row">
            <p>NAMA LENGKAP &ThickSpace;</p>
            <p>: &ThickSpace;</p>
            <p class="text-wrap"><?= htmlspecialchars($nama) ?></p>
        </div>
        <div class="d-flex flex-row">
            <p>NO TELP/HP &ThickSpace;</p>
            <p>: &ThickSpace;</p>
            <p class="text-wrap"><?= htmlspecialchars($hp) ?></p>
        </div>
    </div>
</div>

<!-- AJAX and loading spinner -->
<div id="loading-spinner" style="display:none;">Loading...</div>
<div id="subpage-content"></div>

<script>
    document.getElementById('crud-data-link')?.addEventListener('click', function(event) {
        event.preventDefault();
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        // Show spinner
        spinner.style.display = 'block';

        // Update the URL
        window.history.pushState({}, '', 'dashboard.php?page=kontak_admin/kontak_admin/crud_kontak_admin');

        // Load crud_kontak_admin.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'kontak_admin/kontak_admin/crud_kontak_admin', true);
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
        xhr.open('GET', 'kontak_admin/kontak_admin.php', true);
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