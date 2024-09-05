<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Admin</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
    <div class="sidebar">
    <button class="sidebar-close">&times;</button>
    <h2>Web Admin</h2>
    <ul>
        <li><a href="editslide.php">Edit Slide</a></li>
        <li><a href="tentangKamiEdit.php">Edit Tentang Kami</a></li>
        <li><a href="kepalaBumdesEdit.php">Edit Profil Ketua</a></li>
        <li><a href="TambahBerita.php">Tambah Berita</a></li>
        <li><a href="updatevisimisi.php">Edit Visi Misi</a></li>
        <li><a href="updatestruktur.php">Edit Struktur</a></li>
        <li><a href="daftarUMKM.php">Edit UMKM</a></li>
        <li><a href="editkwt.php">Edit KWT</a></li>
        <li><a href="editgallery.php">Edit Galery</a></li>
        <li><a href="daftarwisata.php">Edit Wisata</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<!-- Tombol Toggle untuk membuka sidebar di mobile -->
<button class="sidebar-toggle">☰</button>

        <div class="main-content">
            <div class="container">
                <h2>Selamat Datang di Dasbor Admin</h2>
                <p>Silakan pilih salah satu fitur di sidebar.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Sidebar dan Fitur Lainnya -->

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector('.sidebar');
        const toggleButton = document.querySelector('.sidebar-toggle');
        const closeButton = document.querySelector('.sidebar-close');

        // Toggle sidebar ketika tombol menu diklik di mobile
        toggleButton.addEventListener('click', function () {
            sidebar.classList.add('active');
            toggleButton.style.display = 'none'; // Sembunyikan tombol toggle
        });

        // Tutup sidebar ketika tombol tutup diklik
        closeButton.addEventListener('click', function () {
            sidebar.classList.remove('active');
            toggleButton.style.display = 'block'; // Tampilkan kembali tombol toggle
        });

        // Tutup sidebar jika area luar sidebar diklik
        document.addEventListener('click', function (event) {
            if (sidebar.classList.contains('active') && !sidebar.contains(event.target) && event.target !== toggleButton) {
                sidebar.classList.remove('active');
                toggleButton.style.display = 'block'; // Tampilkan kembali tombol toggle
            }
        });
    });
</script>




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
</body>
</html>
