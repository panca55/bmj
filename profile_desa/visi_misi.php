<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = 3;
// Ambil data visi_misi desa dalam satu query
$sql = "SELECT visi_desa, misi_desa FROM tb_profil_desa LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$visi = $row['visi_desa'] ?? 'Data tidak ditemukan.';
$misi = $row['misi_desa'] ?? 'Data tidak ditemukan.';
$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h3>Visi Misi Desa Bumi Harjo</h3>
        <div class="d-flex flex-row justify-content-evenly mt-4">
            <div class="visi rounded-2 border-2 border-black border pb-2 pe-2 ps-2 w-100 text-start">
                <div class="d-flex flex-column justify-content-between align-content-center align-items-center">
                    <div style="background-color: black; width:fit-content;" class="border border-1 border-black p-1 text-white">
                        <h5>VISI</h5>
                    </div>
                    <?= htmlspecialchars($visi); ?>
                </div>
            </div>
            <div style="width: 20px;"></div>
            <div class="misi rounded-2 border-2 border-black border pb-2 pe-2 ps-2 w-100 text-start">
                <div class="d-flex flex-column justify-content-between align-content-center align-items-center">
                    <div style="background-color: black; width:fit-content;" class="border border-1 border-black p-1 text-white">
                        <h5>MISI</h5>
                    </div>
                    <?= htmlspecialchars($misi); ?>
                </div>
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
        window.history.pushState({}, '', 'dashboard.php?page=profile_desa/profil_desa&subpage=visi_misi/tambah_data_visi_misi');

        // Load tambah_data_visi_misi.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'profile_desa/visi_misi/tambah_data_visi_misi', true);
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
        xhr.open('GET', 'profile_desa/visi_misi.php', true);
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