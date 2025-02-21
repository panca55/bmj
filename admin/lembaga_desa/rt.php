<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil data perangkat desa
$sql = "SELECT * FROM tb_rt";
$result = $conn->query($sql);
$rt = [];
while ($row = $result->fetch_assoc()) {
    $rt[] = $row;
}

// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['delete']);
    $stmt = $conn->prepare("DELETE FROM tb_rt WHERE id_rt = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt");
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
        <h3 class="fw-bold">Daftar Nama-Nama</h3>
        <h3>Ketua Rukun Tetangga (RT)</h3>
        <h3>DESA BUMI HARJO</h3>
        <div class="d-flex flex-row justify-content-end my-2">
            <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt/tambah_data_rt" class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jabatan</th>
                    <th>Nama Lengkap</th>
                    <th>Foto</th>
                    <th>No Telp/Hp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rt as $index => $dataRt): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($dataRt['jabatan']); ?></td>
                        <td><?= htmlspecialchars($dataRt['nama']); ?></td>
                        <td><img src="<?= htmlspecialchars($dataRt['foto']); ?>" alt="Foto <?= htmlspecialchars($dataRt['nama']); ?>" style="max-width: 100px; max-height: 100px;"></td>
                        <td><?= htmlspecialchars($dataRt['hp']); ?></td>
                        <td>
                            <a href="/admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt/edit_data_rt&id=<?= $dataRt['id_rt']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
                                <input type="hidden" name="delete" value="<?= $dataRt['id_rt']; ?>">
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
        window.history.pushState({}, '', 'admin/admin_dashboard.php?page=lembaga_desa/lembaga_desa&subpage=rt/tambah_data_rt');

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