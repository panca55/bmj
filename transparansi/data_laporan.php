<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data persyaratan desa
$sql = "SELECT * FROM tb_data_laporan";
$result = $conn->query($sql);
$data_laporan = [];
while ($row = $result->fetch_assoc()) {
    $data_laporan[] = $row;
}
$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h3 class="fw-bold">DATA LAPORAN</h3>
        <h3>Data Laporan Desa Bumi Harjo Kecamatan Pinang Raya</h3>
        <h3>Kabupaten Bengkulu Utara</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Data Laporan</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_laporan as $index => $persyaratan): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($persyaratan['keterangan']); ?></td>
                        <td>
                            <?php if (!empty($persyaratan['file'])): ?>
                                <a href="<?= htmlspecialchars($persyaratan['file']); ?>" download>Download</a>
                            <?php else: ?>
                                File tidak tersedia
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
        window.history.pushState({}, '', 'dashboard.php?page=transparansi/transparansi&subpage=data_laporan/tambah_data_data_laporan');

        // Load tambah_data_data_laporan.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'transparansi/data_laporan/tambah_data_data_laporan.php', true);
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
        xhr.open('GET', 'transparansi/data_laporan.php', true);
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