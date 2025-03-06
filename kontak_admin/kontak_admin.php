<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data kontak_admin desa dalam satu query
$sql = "SELECT * FROM tb_kontak LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$email = $row['email'] ?? 'Data belum ada.';
$facebook = $row['facebook'] ?? 'Data belum ada.';
$instagram = $row['instagram'] ?? 'Data belum ada.';
$id_kontak = $row['id_kontak'] ?? 0;
$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center align-items-center">
        <h3 class="border border-1 py-1 px-5 border-black" style="width: fit-content;">Kontak Person</h3>
        <h4>Desa Bumi Harjo Kecamatan Pinang Raya</h4>
        <h4>Kabupaten Bengkulu Utara</h4>
        <h4>Jl. Raya Wijaya Kusuma</h4>
        <h4>Kode Pos 38362</h4>
    </div>
    <div class="d-flex flex-column text-start my-4">
        <div class="d-flex flex-row">
            <p>E-mail &ThickSpace;</p>
            <p>: &ThickSpace;</p>
            <p class="text-wrap"><?= htmlspecialchars($email) ?></p>
        </div>
        <div class="d-flex flex-row">
            <p>Facebook &ThickSpace;</p>
            <p>: &ThickSpace;</p>
            <p class="text-wrap"><?= htmlspecialchars($facebook) ?></p>
        </div>
        <div class="d-flex flex-row">
            <p>Instagram &ThickSpace;</p>
            <p>: &ThickSpace;</p>
            <p class="text-wrap"><?= htmlspecialchars($instagram) ?></p>
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