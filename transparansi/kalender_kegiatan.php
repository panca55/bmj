<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data kalender kegiatan
$sql = "SELECT * FROM tb_kalender_kegiatan";
$result = $conn->query($sql);
$kalenderKegiatan = [];
while ($row = $result->fetch_assoc()) {
    $kalenderKegiatan[] = $row;
}

// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['delete']);
    $stmt = $conn->prepare("DELETE FROM tb_kalender_kegiatan WHERE id_kegiatan = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan");
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
        <h3 class="fw-bold">Kalender Kegiatan</h3>
        <h3>Desa Bumi Harjo</h3>
        <div class="d-flex flex-row justify-content-end my-2">
            <a href="/dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan/tambah_data_kalender_kegiatan" class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kalenderKegiatan as $index => $kegiatan): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($kegiatan['bulan']); ?></td>
                        <td><?= htmlspecialchars($kegiatan['tanggal']); ?></td>
                        <td><?= htmlspecialchars($kegiatan['kegiatan']); ?></td>
                        <td>
                            <a href="/dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan/edit_data_kalender_kegiatan&id=<?= $kegiatan['id_kegiatan']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
                                <input type="hidden" name="delete" value="<?= $kegiatan['id_kegiatan']; ?>">
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
        window.history.pushState({}, '', 'dashboard.php?page=transparansi/transparansi&subpage=kalender_kegiatan/tambah_data_kalender_kegiatan');

        // Load tambah_data_kalender_kegiatan.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'transparansi/kalender_kegiatan/tambah_data_kalender_kegiatan.php', true);
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
        xhr.open('GET', 'transparansi/kalender_kegiatan.php', true);
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