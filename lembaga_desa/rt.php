<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data perangkat desa
$sql = "SELECT * FROM tb_rt";
$result = $conn->query($sql);
$rt = [];
while ($row = $result->fetch_assoc()) {
    $rt[] = $row;
}

$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h3 class="fw-bold">Daftar Nama-Nama</h3>
        <h3>Ketua Rukun Tetangga (RT)</h3>
        <h3>DESA BUMI HARJO</h3>
            <?php foreach ($rt as $index => $dataRt): ?>
                <a href="/dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt_detail&id=<?= $dataRt['id_rt'] ?>" class="w-100 border border-2 border-black text-decoration-none text-black fw-bold py-2 my-2"> <?= htmlspecialchars($dataRt['jabatan']); ?></a>
            <?php endforeach; ?>
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
        window.history.pushState({}, '', 'dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt/tambah_data_rt');

        // Load tambah_data_rt.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'lembaga_desa/rt/tambah_data_rt.php', true);
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
        xhr.open('GET', 'lembaga_desa/rt.php', true);
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