<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/index.css" rel="stylesheet">


</head>

    <main>

    <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
</head>
<body id="section_1">

    <!-- navbar start -->
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

    <!-- navbar end -->

    <main>
        <section class="section-padding section-bg">
            <div class="container">
                <div class="row">
                    <?php
                    include 'admin/config.php';
                    $query = "SELECT * FROM visimisi WHERE id = 1";
                    $result = mysqli_query($conn, $query);
                    $konten = mysqli_fetch_assoc($result);
                    ?>
                    <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                        <img src="admin/new_images/visimisi/<?php echo $konten['gambar_section']; ?>" class="custom-text-box-image img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="custom-text-box">
                            <h2 class="mb-2"><?php echo $konten['judul_section']; ?></h2>
                            <h5 class="mb-3"><?php echo $konten['subjudul_section']; ?></h5>
                            <p class="mb-0"><?php echo $konten['teks_section']; ?></p>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="custom-text-box mb-lg-0">
                                    <h5 class="mb-3"><?php echo $konten['judul_tujuan']; ?></h5>
                                    <p><?php echo $konten['teks_tujuan']; ?></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="custom-text-box d-flex flex-wrap d-lg-block mb-lg-0">
                                    <h5 class="mb-3">Misi</h5>
                                    <ul class="custom-list mt-2">
                                        <?php 
                                        $daftar_tujuan = explode(',', $konten['daftar_tujuan']);
                                        foreach ($daftar_tujuan as $tujuan) {
                                            echo '<li class="custom-list-item d-flex"><i class="bi-check custom-text-box-icon me-2"></i>' . $tujuan . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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