<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = 3;
// Ambil data monografi_kependudukan desa dalam satu query
$sql = "SELECT monografi_kependudukan FROM tb_profil_desa LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$monografi_kependudukan = $row['monografi_kependudukan'] ?? '';
$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h5 class="fw-bold">MONOGRAFI KEPENDUDUKAN</h5>
        <h5>DESA BUMI HARJO</h5>
        <div class="visi rounded-2 border-2 border-black border pb-2 pe-2 ps-2 w-100 text-start mb-2">
            <div class="d-flex flex-column justify-content-between align-content-center align-items-center">
                <?php if ($monografi_kependudukan): ?>
                    <img src="<?= $monografi_kependudukan ?>" class="img-fluid" alt="Monografi Kependudukan">
                <?php else: ?>
                    <p>Belum ada gambar struktur desa.</p>
                <?php endif; ?>
            </div>
        </div>
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
        window.history.pushState({}, '', 'dashboard.php?page=profile_desa/profil_desa&subpage=monografi_kependudukan/tambah_data_monografi_kependudukan');

        // Load tambah_data_monografi_kependudukan.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'profile_desa/monografi_kependudukan/tambah_data_monografi_kependudukan', true);
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
        xhr.open('GET', 'profile_desa/monografi_kependudukan.php', true);
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