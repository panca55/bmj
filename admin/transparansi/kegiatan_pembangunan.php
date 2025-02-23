<?php
ini_set('memory_limit', '1024M');
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Fetch all development activities
$sql = "SELECT id_kegiatan_pembangunan, keterangan, foto FROM tb_kegiatan_pembangunan ORDER BY id_kegiatan_pembangunan ASC LIMIT 50";
$result = $conn->query($sql);

// Store all records in an array
$kegiatan_array = [];
while ($row = $result->fetch_assoc()) {
    $kegiatan_array[] = [
        'id_kegiatan_pembangunan' => $row['id_kegiatan_pembangunan'],   
        'keterangan' => $row['keterangan'] ?? 'Belum ada keterangan',
        'foto' => $row['foto'] ?? ''
    ];
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id_to_delete = $_POST['delete'];
    $stmt = $conn->prepare("UPDATE tb_kegiatan_pembangunan SET keterangan = NULL, foto = NULL WHERE id_kegiatan_pembangunan = ? LIMIT 1");
    $stmt->bind_param("i", $id_to_delete);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus.');</script>";
        header("Location: /admin_dashboard.php?page=transparansi/transparansi&subpage=kegiatan_pembangunan");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<style>
    .slide {
        display: none;
    }

    .slide.active {
        display: block;
    }
</style>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h5>Kegiatan Pembangunan Desa Bumi Harjo Tahun <?= date('Y'); ?></h5>
        <div class="pb-2 pe-2 ps-2 w-100 text-start mb-2">
            <div class="d-flex flex-row justify-content-end my-2">
                <a href="/admin_dashboard.php?page=transparansi/transparansi&subpage=kegiatan_pembangunan/tambah_data_kegiatan_pembangunan"
                    class="fw-bold text-decoration-none text-success" id="tambah-data-link">Tambah Data</a>
            </div>
            <div class="d-flex flex-column justify-content-between align-conxtent-center align-items-center">
                <?php if (!empty($kegiatan_array)): ?>
                    <div id="slideshow-container">
                        <?php foreach ($kegiatan_array as $index => $kegiatan): ?>
                            <div class="slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" data-id="<?= $kegiatan['id_kegiatan_pembangunan'] ?>">
                                <div class="d-flex flex-column justify-content-between border border-1 border-black py-2 align-content-center align-items-center fw-bold mb-2">
                                    <?= htmlspecialchars($kegiatan['keterangan']); ?>
                                </div>
                                <?php if ($kegiatan['foto']): ?>
                                    <div class="slideshow">
                                        <img src="<?= $kegiatan['foto'] ?>" class="img-fluid" alt="Foto Kegiatan Pembangunan Desa">
                                    </div>
                                <?php else: ?>
                                    <p>Tidak ada foto untuk kegiatan ini</p>
                                <?php endif; ?>
                                <div class="d-flex flex-row justify-content-end mt-2">
                                    <a href="/admin_dashboard.php?page=transparansi/transparansi&subpage=kegiatan_pembangunan/edit_data_kegiatan_pembangunan&id=<?= $kegiatan['id_kegiatan_pembangunan']; ?>"
                                        class="btn btn-primary me-2">Edit</a>
                                    <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
                                        <input type="hidden" name="delete" value="<?= $kegiatan['id_kegiatan_pembangunan']; ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="pagination d-flex justify-content-center gap-2 mt-3">
                            <button class="btn btn-secondary prev" onclick="prevSlide()">&#10094;</button>
                            <span id="slide-counter" class="align-self-center">1 / <?= count($kegiatan_array) ?></span>
                            <button class="btn btn-secondary next" onclick="nextSlide()">&#10095;</button>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Belum ada data Kegiatan Pembangunan Desa Bumi Harjo</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- AJAX and loading spinner -->
<div id="loading-spinner" style="display:none;" class="position-fixed top-50 start-50 translate-middle">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div id="subpage-content"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.slide');
        const counter = document.getElementById('slide-counter');
        let currentIndex = 0;

        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => {
                slide.style.display = 'none';
                slide.classList.remove('active');
            });

            // Show the current slide
            slides[index].style.display = 'block';
            slides[index].classList.add('active');

            // Update counter
            counter.textContent = `${index + 1} / ${slides.length}`;
        }

        window.prevSlide = function() {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : slides.length - 1;
            showSlide(currentIndex);
            console.log(currentIndex);

        }

        window.nextSlide = function() {
            currentIndex = currentIndex < slides.length - 1 ? currentIndex + 1 : 0;
            showSlide(currentIndex);
            console.log(currentIndex);
        }

        // Initialize first slide
        if (slides.length > 0) {
            showSlide(0);
        }

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        });
    });

    // AJAX functionality for adding new data
    document.getElementById('tambah-data-link')?.addEventListener('click', function(event) {
        event.preventDefault();
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        spinner.style.display = 'block';
        window.history.pushState({}, '', this.href);

        fetch('transparansi/kegiatan_pembangunan/tambah_data_kegiatan_pembangunan.php')
            .then(response => response.text())
            .then(html => {
                spinner.style.display = 'none';
                subpageContent.innerHTML = html;
            })
            .catch(error => {
                spinner.style.display = 'none';
                subpageContent.innerHTML = 'Error loading content.';
                console.error('Error:', error);
            });
    });

    // Handle browser back button
    window.addEventListener('popstate', function(event) {
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        spinner.style.display = 'block';

        fetch('transparansi/kegiatan_pembangunan.php')
            .then(response => response.text())
            .then(html => {
                spinner.style.display = 'none';
                subpageContent.innerHTML = html;
            })
            .catch(error => {
                spinner.style.display = 'none';
                subpageContent.innerHTML = 'Error loading content.';
                console.error('Error:', error);
            });
    });
</script>