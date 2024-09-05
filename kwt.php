<?php
include 'admin/config.php';

// Mengambil semua item KWT untuk ditampilkan
$result = $conn->query("SELECT * FROM kwt");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri KWT</title>
        <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/index.css" rel="stylesheet">
    <style>
        .gallery-item {
            margin-bottom: 30px;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
        }
        .card-body {
            text-align: center;
        }
        .gallery-header {
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="./index.php">
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

                            <li><a class="dropdown-item" href="kwt.php">Kel. Wanita Tani</a></li>

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

    <div class="container mt-5">
        <div class="gallery-header">
            <h1>Kelompok Wanita Tani</h1>
        </div>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-8 mx-auto gallery-item">
                    <div class="card">
                        <img src="admin/new_images/kwt/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <p class="card-text"><small class="text-muted"><?php echo $row['date']; ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
