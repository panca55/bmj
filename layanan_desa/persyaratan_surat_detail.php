<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Ambil data kontak_admin desa dalam satu query
$stmt = $conn->prepare("SELECT * FROM tb_persyaratan_surat WHERE id_persyaratan_surat =? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$keterangan = $row['keterangan'] ?? 'Data belum ada.';
$file = $row['file'] ?? 'Data belum ada.';
$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column justify-content-center text-center align-items-center mb-2">
        <div class="border border-1 border-black py-2 w-100">
            <h3>
                <?= htmlspecialchars($keterangan) ?>
            </h3>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-end text-center align-items-center">
        <a href="<?= htmlspecialchars($file) ?>" class="btn btn-primary rounded-2" download>Download</a>
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