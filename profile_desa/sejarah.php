<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';
$sql = "SELECT sejarah_desa FROM tb_profil_desa LIMIT 1";
$result = $conn->query($sql);
$sejarah = $result->num_rows > 0 ? $result->fetch_assoc()['sejarah_desa'] : 'Data tidak ditemukan.';
?>
<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h3>
            Sejarah Desa Bumi Harjo
        </h3>
        <a href="#" class="fw-bold d-flex flex-row justify-content-end my-2 text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
        <div class="sejarah rounded-2 border-2 border-black border p-2 mb-2 text-start">
            <?php echo $sejarah; ?>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-end">
        <a href="#" class="btn btn-primary me-2">Edit</a>
        <a href="#" class="btn btn-danger">Hapus</a>
    </div>
</div>

<!-- Add these elements for AJAX content loading -->
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
        window.history.pushState({}, '', 'admin_dashboard.php?page=profile_desa/profil_desa&subpage=sejarah/tambah_data_sejarah');

        // Load the tambah_data_sejarah.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'sejarah/tambah_data_sejarah.php', true);
        xhr.onload = function() {
            // Hide spinner
            spinner.style.display = 'none';

            if (xhr.status === 200) {
                subpageContent.innerHTML = xhr.responseText;
            } else {
                subpageContent.innerHTML = 'Error loading content.';
            }
        };
        xhr.send();
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        // Show spinner
        spinner.style.display = 'block';

        // Load the sejarah.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'sejarah.php', true);
        xhr.onload = function() {
            // Hide spinner
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