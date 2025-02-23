<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';

// Ambil semua data kegiatan pembangunan desa
$sql = "SELECT id_kegiatan_pembangunan, keterangan, foto FROM tb_kegiatan_pembangunan ORDER BY id_kegiatan_pembangunan ASC";
$result = $conn->query($sql);
$kegiatanPembangunan = [];
while ($row = $result->fetch_assoc()) {
    $kegiatanPembangunan[] = $row;
}

$conn->close();
?>

<style>
    #slideshow-container {
        position: relative;
        max-width: 100%;
        margin: auto;
    }

    .mySlides {
        display: none;
        animation: fadeEffect 0.5s;
    }

    @keyframes fadeEffect {
        from {opacity: 0.4}
        to {opacity: 1}
    }

    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: auto;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        user-select: none;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

    .dots-container {
        text-align: center;
        margin-top: 10px;
    }

    .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
    }

    .active-dot,
    .dot:hover {
        background-color: #717171;
    }

    .slide-content {
        max-width: 800px;
        margin: 0 auto;
    }

    .slide-image {
        max-height: 500px;
        object-fit: contain;
        width: 100%;
    }
</style>

<div class="d-flex flex-column">
    <div class="d-flex flex-column text-center">
        <h5>Kegiatan Pembangunan Desa Bumi Harjo Tahun <?= date('Y'); ?></h5>

        <div class="pb-2 pe-2 ps-2 w-100 text-start mb-2">
            <div class="d-flex flex-row justify-content-end my-2">
                <a href="/admin_dashboard.php?page=transparansi/transparansi&subpage=kegiatan_pembangunan/tambah_data_kegiatan_pembangunan"
                    class="fw-bold text-decoration-none text-success">Tambah Data</a>
            </div>

            <div class="d-flex flex-column justify-content-between align-content-center align-items-center">
                <?php if (!empty($kegiatanPembangunan)): ?>
                    <div id="slideshow-container" class="position-relative">
                        <?php foreach ($kegiatanPembangunan as $index => $kegiatan): ?>
                            <div class="mySlides">
                                <div class="slide-content">
                                    <div class="d-flex flex-column justify-content-center text-center">
                                        <div class="border border-1 border-black py-2 fw-bold mb-3">
                                            <?= htmlspecialchars($kegiatan['keterangan'] ?? 'Tanpa Keterangan'); ?>
                                        </div>
                                        <?php if ($kegiatan['foto']): ?>
                                            <img src="<?= $kegiatan['foto']; ?>" class="slide-image mb-3" alt="Foto Kegiatan">
                                        <?php else: ?>
                                            <p class="text-muted">Tidak ada foto untuk kegiatan ini</p>
                                        <?php endif; ?>
                                        <div class="d-flex flex-row justify-content-center mt-2">
                                            <a href="/admin_dashboard.php?page=transparansi/transparansi&subpage=kegiatan_pembangunan/edit_data_kegiatan_pembangunan&id=<?= $kegiatan['id_kegiatan_pembangunan']; ?>"
                                                class="btn btn-primary me-2">Edit</a>
                                            <form method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                <input type="hidden" name="delete" value="<?= $kegiatan['id_kegiatan_pembangunan']; ?>">
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <div class="dots-container">
                        <?php for ($i = 0; $i < count($kegiatanPembangunan); $i++): ?>
                            <span class="dot" onclick="currentSlide(<?= $i + 1 ?>)"></span>
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <p>Belum ada data kegiatan pembangunan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    let slideIndex = 1;
    let slideInterval;

    // Initialize the slideshow
    document.addEventListener('DOMContentLoaded', function() {
        showSlides(slideIndex);
        startAutoSlide();
    });

    function startAutoSlide() {
        // Clear any existing interval
        if (slideInterval) {
            clearInterval(slideInterval);
        }
        // Start automatic slideshow
        slideInterval = setInterval(function() {
            plusSlides(1);
        }, 5000); // Change slide every 5 seconds
    }

    function plusSlides(n) {
        showSlides(slideIndex += n);
        startAutoSlide(); // Reset the timer when manually changing slides
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
        startAutoSlide(); // Reset the timer when manually changing slides
    }

    function showSlides(n) {
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        
        if (!slides.length) return; // Guard clause if no slides exist

        // Handle circular navigation
        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }

        // Hide all slides
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        // Remove active state from all dots
        for (let i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active-dot");
        }

        // Show the current slide and activate corresponding dot
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].classList.add("active-dot");
    }

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            plusSlides(-1);
        } else if (e.key === 'ArrowRight') {
            plusSlides(1);
        }
    });

    // Pause autoplay on hover
    const slideshowContainer = document.getElementById('slideshow-container');
    if (slideshowContainer) {
        slideshowContainer.addEventListener('mouseenter', function() {
            clearInterval(slideInterval);
        });

        slideshowContainer.addEventListener('mouseleave', function() {
            startAutoSlide();
        });
    }
</script>