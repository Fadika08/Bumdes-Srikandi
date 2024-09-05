<?php
// Konfigurasi database
$servername = "127.0.0.1:3306";
$username = "u779600581_bumdes";
$password = "Bumdes123.";
$dbname = "u779600581_bumdesdb";


// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} 

// Mengambil data carousel dari database
$sql = "SELECT id, title, description, image FROM carousel ORDER BY id";
$result = $conn->query($sql);

$carouselData = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $carouselData[] = $row;
    }
}

   // Mengambil konten dari database
   $query = "SELECT * FROM tentangkami WHERE id = 1";
   $result = mysqli_query($conn, $query);

   if (!$result) {
       die("Query gagal: " . mysqli_error($conn));
   }

   $konten = mysqli_fetch_assoc($result);

   // Mengambil konten dari database
        $query = "SELECT * FROM about_section WHERE id = 1";
        $result = mysqli_query($conn, $query);
        $conten = mysqli_fetch_assoc($result);

    // Mengambil berita terbaru
$latestNewsQuery = "SELECT * FROM news ORDER BY created_at DESC LIMIT 1";
$latestNewsResult = $conn->query($latestNewsQuery);

// Mengambil berita lalu
$olderNewsQuery = "SELECT * FROM news ORDER BY created_at DESC LIMIT 3 OFFSET 1";
$olderNewsResult = $conn->query($olderNewsQuery);



$conn->close();
?>

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
    <section class="hero-section hero-section-full-height">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-12 p-0">
                <div id="hero-slide" class="carousel carousel-fade slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($carouselData)): ?>
                            <?php foreach ($carouselData as $index => $slide): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="/admin/<?php echo ($slide['image']); ?>" class="carousel-image img-fluid" alt="<?php echo htmlspecialchars($slide['title']); ?>">
                                    <div class="carousel-caption d-flex flex-column justify-content-end">
                                        <h1><?php echo htmlspecialchars($slide['title']); ?></h1>
                                        <p><?php echo htmlspecialchars($slide['description']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="carousel-item active">
                                <img src="placeholder.jpg" class="d-block w-100" alt="Tidak ada slide">
                                <div class="carousel-caption d-flex flex-column justify-content-end">
                                    <h1>Tidak Ada Slide</h1>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#hero-slide" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Sebelumnya</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#hero-slide" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Berikutnya</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

        <section class="section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-10 col-12 text-center mx-auto">
                        <h2 class="mb-5">Selamat Datang di Bumdes Srikandi</h2>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                        <div class="featured-block d-flex justify-content-center align-items-center">
                            <a href="kwt.php" class="d-block">
                                <img src="images/icons/icon1.png" class="featured-block-image img-fluid" alt="">

                                <p class="featured-block-text">Kelompok Wanita Tani</p>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                        <div class="featured-block d-flex justify-content-center align-items-center">
                            <a href="UMKM.php" class="d-block">
                                <img src="images/icons/icon2.png" class="featured-block-image img-fluid" alt="">

                                <p class="featured-block-text">UMKM</p>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                        <div class="featured-block d-flex justify-content-center align-items-center">
                            <a href="galeri.php" class="d-block">
                                <img src="images/icons/scholarship.png" class="featured-block-image img-fluid" alt="">

                                <p class="featured-block-text">Prestasi</p>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                        <div class="featured-block d-flex justify-content-center align-items-center">
                            <a href="wisata.php" class="d-block">
                                <img src="images/icons/heart.png" class="featured-block-image img-fluid" alt="">

                                <p class="featured-block-text">Wisata</p>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="section-padding section-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    <?php if (!empty($konten['gambar_section'])): ?>
                        <img src="admin/new_images/tentangkami/<?php echo htmlspecialchars($konten['gambar_section']); ?>" class="custom-text-box-image img-fluid" alt="Gambar Section">
                    <?php else: ?>
                        <p>Gambar tidak tersedia.</p>
                    <?php endif; ?>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="custom-text-box">
                        <h2 class="mb-2"><?php echo htmlspecialchars($konten['judul_section']); ?></h2>
                        <h5 class="mb-3"><?php echo htmlspecialchars($konten['subjudul_section']); ?></h5>
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($konten['teks_section'])); ?></p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="custom-text-box">
                                <h5 class="mb-3"><?php echo htmlspecialchars($konten['judul_tujuan']); ?></h5>
                                <p><?php echo nl2br(htmlspecialchars($konten['teks_tujuan'])); ?></p>
                                <ul class="custom-list mt-2">
                                    <?php
                                    $daftar_tujuan = explode(',', $konten['daftar_tujuan']);
                                    foreach ($daftar_tujuan as $tujuan) {
                                        echo '<li class="custom-list-item d-flex"><i class="bi-check custom-text-box-icon me-2"></i>' . htmlspecialchars(trim($tujuan)) . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                            <div class="col-lg-6 col-md-6 col-12">
                            <div class="custom-text-box">
                                <div class="counter-thumb">
                                    <div class="d-flex justify-content-left">
                                        <span class="counter-number"><?php echo htmlspecialchars($konten['counter_1']); ?></span>
                                    </div>
                                    <span class="counter-text">Warga</span>
                                </div>

                                <div class="counter-thumb mt-4">
                                    <div class="d-flex justify-content-left">
                                        <span class="counter-number"><?php echo htmlspecialchars($konten['counter_2']); ?></span>
                                    </div>
                                    <span class="counter-text ju">Pemdes</span>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

            </div>
        </div>
        <section class="about-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-5 col-12">
                        <img src="admin/new_images/about_section/<?php echo htmlspecialchars($conten['image'] ?? 'default-image.jpg'); ?>" class="about-image ms-lg-auto bg-light shadow-lg img-fluid" alt="About Image">
                    </div>

                    <div class="col-lg-6 col-md-7 col-12">
                        <div class="custom-text-block">
                            <h2 class="mb-0"><?php echo htmlspecialchars($conten['title'] ?? 'Default Title'); ?></h2>
                            <p class="text-muted mb-lg-4 mb-md-4"><?php echo htmlspecialchars($conten['subtitle'] ?? 'Default Subtitle'); ?></p>
                            <p><?php echo htmlspecialchars($conten['text1'] ?? 'Default Text 1'); ?></p>
                            <p><?php echo htmlspecialchars($conten['text2'] ?? 'Default Text 2'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="news-section section-padding" id="section_5">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-12 mb-5">
                    <h2>Berita Terbaru</h2>
                </div>

                <?php if ($latestNewsResult->num_rows > 0): ?>
                    <?php $latestNews = $latestNewsResult->fetch_assoc(); ?>
                    <div class="col-lg-7 col-12">
                        <div class="news-block">
                            <div class="news-block-top">
                                <a href="news-detail.php?id=<?php echo $latestNews['id']; ?>">
                                    <img src="/admin<?php echo $latestNews['image']; ?>" class="news-image img-fluid" alt="">
                                </a>

                                <div class="news-category-block">
                                    <a href="#" class="category-block-link">
                                        <?php echo $latestNews['category']; ?>
                                    </a>
                                </div>
                            </div>

                            <div class="news-block-info">
                                <div class="d-flex mt-2">
                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i> <?php echo date('F j, Y', strtotime($latestNews['created_at'])); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="news-block-title mb-2">
                                    <h4><a href="news-detail.php?id=<?php echo $latestNews['id']; ?>" class="news-block-title-link"><?php echo $latestNews['title']; ?></a></h4>
                                </div>

        

                                <div class="news-block-body">
                                    <p><?php echo substr($latestNews['content'], 0, 100) . '...'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-7 col-12">
                        <p>Belum ada berita terbaru.</p>
                    </div>
                <?php endif; ?>

                <div class="col-lg-4 col-12 mx-auto">
                    <h5 class="mb-3">Berita Lalu</h5>

                    <?php if ($olderNewsResult->num_rows > 0): ?>
                        <?php while ($news = $olderNewsResult->fetch_assoc()): ?>
                            <div class="news-block news-block-two-col d-flex mt-4">
                                <div class="news-block-two-col-image-wrap">
                                    <a href="news-detail.php?id=<?php echo $news['id']; ?>">
                                        <img src="/admin<?php echo $news['image']; ?>" class="news-image img-fluid" alt="">
                                    </a>
                                </div>

                                <div class="news-block-two-col-info">
                                    <div class="news-block-title mb-2">
                                        <h6><a href="news-detail.php?id=<?php echo $news['id']; ?>" class="news-block-title-link"><?php echo $news['title']; ?></a></h6>
                                    </div>

                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i> <?php echo date('F j, Y', strtotime($news['created_at'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Belum ada berita lalu.</p>
                    <?php endif; ?>
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
    <script src="js/custom.js"></script>

</body>

</html>