<?php
$subpage = isset($_GET['subpage']) ? $_GET['subpage'] : 'sejarah';
$id = isset($_GET['id']) ? $_GET['id'] : 1;
?>

<style>
    .nav {
        border-top: 2px solid black;
        border-bottom: 2px solid black;
    }

    .nav-link {
        color: grey;
        text-decoration: none;
    }

    .nav-link:hover {
        color: blue;
    }

    .nav-item .actived {
        font-weight: bold;
        color: black;
    }

    /* Spinner styles */
    .spinner {
        display: none;
        width: 50px;
        height: 50px;
        border: 5px solid lightgray;
        border-top: 5px solid blue;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<ul class="nav nav-tabs d-flex justify-content-around">
    <li class="nav-item"><a class="nav-link actived" href="#" data-subpage="sejarah">Sejarah Desa</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-subpage="visi_misi">Visi Misi</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-subpage="struktur_desa">Struktur Desa</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-subpage="profil_kepala_desa">Profil Kepala Desa</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-subpage="profil_perangkat_desa">Profil Perangkat Desa</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-subpage="monografi_kependudukan">Monografi Kependudukan</a></li>
</ul>
<div class="mt-3" id="subpage-content">
    <?php include $subpage . ".php"; ?>
</div>
<div class="spinner" id="loading-spinner"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        const subpageContent = document.getElementById('subpage-content');
        const spinner = document.getElementById('loading-spinner');

        navLinks.forEach(navLink => {
            navLink.addEventListener('click', function(event) {
                event.preventDefault();
                const subpage = this.getAttribute('data-subpage');
                const id = new URLSearchParams(window.location.search).get('id') || '';

                // Remove active class from all links
                navLinks.forEach(navLink => {
                    navLink.classList.remove('actived');
                });

                // Add active class to the clicked link
                this.classList.add('actived');

                // Show spinner
                spinner.style.display = 'block';

                // Update URL without reloading the page
                history.pushState(null, '', `?page=profile_desa/profil_desa&subpage=${subpage}${id ? '&id=' + id : ''}`);

                // Load the subpage content using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `profile_desa/${subpage}.php${id ? '?id=' + id : ''}`, true);
                xhr.onload = function() {
                    // Hide spinner
                    spinner.style.display = 'none';

                    if (xhr.status === 200) {
                        subpageContent.innerHTML = xhr.responseText;
                    } else {
                        subpageContent.innerHTML = 'Error loading content.';
                    }
                };
                xhr.send();
            });
        });

        // Load the initial subpage content based on the URL
        const initialSubpage = new URLSearchParams(window.location.search).get('subpage') || 'sejarah';
        const id = new URLSearchParams(window.location.search).get('id') || '';
        const initialNavLink = document.querySelector(`.nav-link[data-subpage="${initialSubpage}${id ? '&id=' + id : ''}"]`);
        initialNavLink.click();
    });
</script>