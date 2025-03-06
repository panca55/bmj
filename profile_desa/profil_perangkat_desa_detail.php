<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data perangkat desa
$stmt = $conn->prepare("SELECT * FROM tb_perangkat_desa WHERE id_perangkat_desa = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$jabatan = $row['jabatan'] ?? 'Data belum ada.';
$foto = $row['foto'] ?? 'Data belum ada.';
$alamat = $row['alamat'] ?? 'Data belum ada.';
$nama = $row['nama'] ?? 'Data belum ada.';
$jenis_kelamin = $row['jenis_kelamin'] ?? 'Data belum ada.';
$tempat_tanggal_lahir = $row['tempat_tanggal_lahir'] ?? 'Data belum ada.';
$conn->close();
?>

<div class="container mt-5">
    <div class="text-center">
        <h3><?= htmlspecialchars($jabatan) ?></h3>
    </div>
    <div class="text-center">
        <img src="<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($jabatan) ?> Bumi Harjo" class="img-fluid mb-3" style="max-width: 200px;">
        <div class="table-responsive">
            <table class="table table-borderless text-start">
                <tbody>
                    <tr>
                        <th scope="row">Nama</th>
                        <th scope="row">:</th>
                        <td class="text-uppercase"><?= htmlspecialchars($nama) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Tempat Tanggal Lahir</th>
                        <th scope="row">:</th>
                        <td class="text-uppercase"><?= htmlspecialchars($tempat_tanggal_lahir) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Jenis Kelamin</th>
                        <th scope="row">:</th>
                        <td class="text-uppercase"><?= htmlspecialchars($jenis_kelamin) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Jabatan</th>
                        <th scope="row">:</th>
                        <td class="text-uppercase"><?= htmlspecialchars($jabatan) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Alamat</th>
                        <th scope="row">:</th>
                        <td class="text-uppercase"><?= htmlspecialchars($alamat) ?></td>
                    </tr>
                </tbody>
            </table>
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

<style>
    .container {
        max-width: 800px;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
        color: white;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }
</style>