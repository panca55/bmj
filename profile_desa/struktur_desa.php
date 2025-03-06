<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

$id = 3;
// Ambil data struktur_desa desa dalam satu query
$sql = "SELECT struktur_desa FROM tb_profil_desa LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$struktur = $row['struktur_desa'] ?? '';
// Hapus data jika ada request POST 'delete'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $stmt = $conn->prepare("UPDATE tb_profil_desa SET struktur_desa = NULL WHERE id_profil_desa = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /dashboard.php?page=profile_desa/profil_desa&subpage=struktur_desa");
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
        <h5>STRUKTUR ORGAMISASI PEMERINTAHAN</h5>
        <h5>DESA BUMI HARJO</h5>
        <h5>KECAMATAN PINANG RAYA KABUPATEN BENGKULU UTARA</h5>
        <div class="visi rounded-2 border-2 border-black border pb-2 pe-2 ps-2 w-100 text-start mt-4">
            <div class="d-flex flex-column justify-content-between align-content-center align-items-center">
                <?php if ($struktur): ?>
                    <img src="<?= $struktur ?>" class="img-fluid" alt="Struktur Desa">
                <?php else: ?>
                    <p>Belum ada gambar struktur desa.</p>
                <?php endif; ?>
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
        window.history.pushState({}, '', 'dashboard.php?page=profile_desa/profil_desa&subpage=struktur_desa/tambah_data_struktur_desa');

        // Load tambah_data_struktur_desa.php content using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'profile_desa/struktur_desa/tambah_data_struktur_desa', true);
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
        xhr.open('GET', 'profile_desa/struktur_desa.php', true);
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