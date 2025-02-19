<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data persyaratan desa
$sql = "SELECT * FROM tb_persyaratan_surat";
$result = $conn->query($sql);
$persyaratan_surat = [];
while ($row = $result->fetch_assoc()) {
    $persyaratan_surat[] = $row;
}

// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['delete']);
    $stmt = $conn->prepare("DELETE FROM tb_persyaratan_surat WHERE id_persyaratan_surat = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat");
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
        <h3>PERSYARATAN SURAT DESA BUMI HARJO</h3>
        <div class="d-flex flex-row justify-content-end my-2">
            <a href="/admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat/tambah_data_persyaratan_surat" class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Permohonan Surat</th>
                    <th>Download Blanko Isian Surat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($persyaratan_surat as $index => $persyaratan): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($persyaratan['keterangan']); ?></td>
                        <td><a href="<?= htmlspecialchars($persyaratan['file']); ?>" download>Download</a></td>
                        <td>
                            <a href="/admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat/edit_data_persyaratan_surat&id=<?= $persyaratan['id_persyaratan_surat']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
                                <input type="hidden" name="delete" value="<?= $persyaratan['id_persyaratan_surat']; ?>">
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
        window.history.pushState({}, '', 'admin_dashboard.php?page=layanan_desa/layanan_desa&subpage=persyaratan_surat/tambah_data_persyaratan_surat');

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