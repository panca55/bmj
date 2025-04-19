<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data persyaratan desa
$sql = "SELECT * FROM tb_persyaratan_surat";
$result = $conn->query($sql);
$persyaratan_surat = [];
while ($row = $result->fetch_assoc()) {
    $persyaratan_surat[] = $row;
}
$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h3 class="fw-bold">PROFIL</h3>
        <h3>PERSYARATAN SURAT DESA BUMI HARJO</h3>
        <div class="mt-2 d-flex flex-column">
            <?php foreach ($persyaratan_surat as $index => $persyaratan): ?>
                <a href="/dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat_detail&id=<?= $persyaratan['id_persyaratan_surat'] ?>" class="w-100 border border-2 border-black text-decoration-none text-black fw-bold py-2 px-2 my-2"> <?= htmlspecialchars($persyaratan['keterangan']); ?></a>
            <?php endforeach; ?>
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
        window.history.pushState({}, '', 'dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat/tambah_data_persyaratan_surat');

        // Load tambah_data_persyaratan_surat.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'layanan_desa/persyaratan_surat/tambah_data_persyaratan_surat.php', true);
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
        xhr.open('GET', 'layanan_desa/persyaratan_surat.php', true);
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