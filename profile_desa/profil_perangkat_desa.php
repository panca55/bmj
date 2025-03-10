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
        header("Location: /dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa");
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
        <?php foreach ($perangkat_desa as $index => $perangkat): ?>
            <a href="/dashboard.php?page=profile_desa/profil_perangkat_desa_detail&id=<?= $perangkat['id_perangkat_desa'] ?>" class="w-100 border border-2 border-black text-decoration-none text-black fw-bold py-2 px-2 my-2"> <?= htmlspecialchars($perangkat['jabatan']); ?></a>
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
        window.history.pushState({}, '', 'dashboard.php?page=profile_desa/profil_desa&subpage=profil_perangkat_desa/tambah_data_perangkat_desa');

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