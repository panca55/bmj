<?php
include '../db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_profil_desa'] ?? '';
    $sejarah = $_POST['sejarah_desa'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE tb_profil_desa SET sejarah_desa=? WHERE id_profil_desa=?");
        $stmt->bind_param("si", $sejarah, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO tb_profil_desa (sejarah_desa) VALUES (?)");
        $stmt->bind_param("s", $sejarah);
    }
    $stmt->execute();
    $stmt->close();

    // Mengembalikan respons JSON untuk AJAX
    echo json_encode(["status" => "success", "message" => "Data berhasil disimpan"]);
    exit();
}

// Fetch data
$result = $conn->query("SELECT * FROM tb_profil_desa");
$profil = $result->fetch_assoc();
?>

<div class="container mt-5">
    <h2>Tambah Data Sejarah Desa</h2>
    <form id="form-sejarah" class="mt-4">
        <input type="hidden" name="id_profil_desa" value="<?= $profil['id_profil_desa'] ?? '' ?>">
        <div class="mb-3">
            <label class="form-label">Sejarah Desa</label>
            <textarea class="form-control" name="sejarah_desa" required><?= $profil['sejarah_desa'] ?? '' ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary ms-3" id="batal">Batal</button>
    </form>
</div>

<script>
    document.getElementById('form-sejarah').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('sejarah/tambah_data_sejarah.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    // Kembali ke halaman sejarah setelah simpan
                    window.history.pushState({}, '', 'admin_dashboard.php?page=profile_desa');
                    loadSejarahPage();
                } else {
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Fungsi untuk kembali ke halaman sejarah
    document.getElementById('batal').addEventListener('click', function() {
        window.history.pushState({}, '', 'admin_dashboard.php?page=profile_desa');
        loadSejarahPage();
    });

    // Fungsi untuk memuat halaman sejarah.php kembali
    function loadSejarahPage() {
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        spinner.style.display = 'block';

        fetch('sejarah.php')
            .then(response => response.text())
            .then(html => {
                spinner.style.display = 'none';
                subpageContent.innerHTML = html;
            })
            .catch(error => {
                spinner.style.display = 'none';
                subpageContent.innerHTML = 'Error loading content.';
            });
    }
</script>