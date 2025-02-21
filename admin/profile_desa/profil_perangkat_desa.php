<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data perangkat desa
$sql = "SELECT * FROM tb_perangkat_desa";
$result = $conn->query($sql);
$perangkat_desa = [];
while ($row = $result->fetch_assoc()) {
    $perangkat_desa[] = $row;
}

// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['delete']);
    $stmt = $conn->prepare("DELETE FROM tb_perangkat_desa WHERE id_perangkat_desa = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h3 class="fw-bold">PROFIL</h3>
        <h3>PERANGKAT DESA BUMI HARJO</h3>
        <div class="d-flex flex-row justify-content-end my-2">
            <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa/tambah_data_perangkat_desa" class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Jabatan</th>
                    <th>Alamat</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($perangkat_desa as $index => $perangkat): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($perangkat['nama']); ?></td>
                        <td><?= htmlspecialchars($perangkat['tempat_tanggal_lahir']); ?></td>
                        <td><?= htmlspecialchars($perangkat['jenis_kelamin']); ?></td>
                        <td><?= htmlspecialchars($perangkat['jabatan']); ?></td>
                        <td><?= htmlspecialchars($perangkat['alamat']); ?></td>
                        <td><img src="<?= htmlspecialchars($perangkat['foto']); ?>" alt="Foto Perangkat Desa" width="100"></td>
                        <td>
                            <a href="/admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa/edit_data_perangkat_desa&id=<?= $perangkat['id_perangkat_desa']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
                                <input type="hidden" name="delete" value="<?= $perangkat['id_perangkat_desa']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
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
        window.history.pushState({}, '', 'admin/admin_dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa/tambah_data_perangkat_desa');

        // Load tambah_data_perangkat_desa.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'profile_desa/profil_perangkat_desa/tambah_data_perangkat_desa.php', true);
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
        xhr.open('GET', 'profile_desa/profil_perangkat_desa.php', true);
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