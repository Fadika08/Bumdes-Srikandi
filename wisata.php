<?php
include 'admin/config.php';


// Mendapatkan kategori yang dipilih dari URL, default ke 'semua' jika tidak ada yang dipilih
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'semua';

// Query untuk mendapatkan daftar wisata berdasarkan kategori
if ($kategori == 'semua') {
    $query = "SELECT * FROM wisata";
} else {
    // Pastikan kategori aman dari SQL Injection
    $kategori = $conn->real_escape_string($kategori);
    $query = "SELECT * FROM wisata WHERE kategori = '$kategori'";
}

$result = $conn->query($query);

// Mendapatkan daftar kategori untuk dropdown
$kategori_query = "SELECT DISTINCT kategori FROM wisata";
$kategori_result = $conn->query($kategori_query);

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wisata</title>

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">

    <style>
        .umkm-item {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .umkm-item img {
            max-width: 600px;
            max-height: 600px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 5px;
        }

        .umkm-item h3 {
            margin-top: 0;
        }

        .umkm-item p {
            margin-bottom: 10px;
        }
        /* Responsif untuk tablet (768px ke atas) */
@media screen and (max-width: 768px) {
    .umkm-item {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .umkm-item img {
        margin: 0 auto 20px;
        max-width: 100%;
        max-height: auto;
    }

    .umkm-item h3 {
        margin-top: 10px;
    }
}

/* Responsif untuk perangkat seluler (max-width 576px) */
@media screen and (max-width: 576px) {
    .umkm-item {
        padding: 5px;
    }

    .umkm-item img {
        max-width: 100%;
        max-height: auto;
    }

    .umkm-item h3 {
        font-size: 1.5rem;
    }

    .umkm-item p {
        font-size: 1rem;
    }

    .navbar-brand img {
        max-width: 50px;
    }

    .navbar-brand span {
        font-size: 1rem;
    }

    .site-footer-title {
        font-size: 1.2rem;
    }

    .site-footer-link {
        font-size: 0.9rem;
    }
}
    </style>
</head>

<body>

    <!-- navbar start -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="./index.html">
                <img src="./images/logo.png" class="logo" alt="logo">
                <span>
                        Bumdes Srikandi
                        <small>Badan Usaha Milik Desa Kuningan</small>
                    </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link click-scroll dropdown-toggle" href="#section_5" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profile</a>

                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                            <li><a class="dropdown-item" href="profile.php">Visi & Misi</a></li>

                            <li><a class="dropdown-item" href="struktur.php">Struktur</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link click-scroll dropdown-toggle"  id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Unit</a>

                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                            <li><a class="dropdown-item" href="UMKM.php">UMKM</a></li>

                            <li><a class="dropdown-item" href="news-detail.html">Kel. Wanita Tani</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link click-scroll" href="galeri.php">Galeri</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link click-scroll" href="wisata.php">Wisata</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <main>
        <div class="container mt-4">
            <h2>Wisata</h2>
            <form method="GET" action="wisata.php">
                <label for="filter">Filter Kategori:</label>
                <select id="filter" name="kategori" onchange="this.form.submit()">
                    <option value="semua">Semua Kategori</option>
                    <?php while ($row = $kategori_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['kategori']; ?>" <?php if ($kategori == $row['kategori']) echo 'selected'; ?>>
                            <?php echo $row['kategori']; ?>
                        </option>
                    <?php } ?>
                </select>
            </form>

            <div id="daftar-wisata" class="mt-4">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="umkm-item">
                        <img src="admin/new_images/wisata/<?php echo $row['gambar']; ?>" alt="Gambar Wisata">
                        <div>
                            <h3><?php echo $row['nama']; ?></h3>
                            <p><?php echo $row['deskripsi']; ?></p>
                            <a href="wisata_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Kunjungi</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 mb-4">
                    <img src="images/logo.png" class="logo img-fluid" alt="">
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <h5 class="site-footer-title mb-3">Quick Links</h5>

                    <ul class="footer-menu">
                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Our Story</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Newsroom</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Causes</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Become a volunteer</a></li>

                        <li class="footer-menu-item"><a href="#" class="footer-menu-link">Partner with us</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mx-auto">
                    <h5 class="site-footer-title mb-3">Kontak Kami</h5>

                    <p class="text-white d-flex mb-2">
                        <i class="bi-telephone me-2"></i>

                        <a href="tel: 120-240-9600" class="site-footer-link">
                            120-240-9600
                        </a>
                    </p>

                    <p class="text-white d-flex">
                        <i class="bi-envelope me-2"></i>

                        <a href="info@yourgmail.com" class="site-footer-link">
                            info@gmail.com
                        </a>
                    </p>

                    <p class="text-white d-flex mt-3">
                        <i class="bi-geo-alt me-2"></i> Kuningan, Blitar
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>
