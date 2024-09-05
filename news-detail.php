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

// Mendapatkan ID berita dari parameter URL
$id = intval($_GET['id']);

// Mengambil berita berdasarkan ID
$query = "SELECT * FROM news WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($news['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Batasan untuk gambar berita */
.container img {
    max-width: 100%; /* Agar gambar tidak melebar dari container */
    height: auto;    /* Menjaga proporsi gambar */
    border: 2px solid #ddd; /* Batas gambar */
    border-radius: 8px; /* Sudut membulat */
    margin-bottom: 20px; /* Jarak bawah gambar */
}

/* Gaya untuk detail berita */
.container {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto; /* Pusatkan container */
}

/* Gaya untuk judul berita */
.container h1 {
    font-size: 2rem;
    margin-bottom: 15px;
}

/* Gaya untuk tanggal berita */
.container p i {
    margin-right: 5px;
    color: #6c757d; /* Warna ikon */
}

/* Gaya untuk konten berita */
.container p {
    font-size: 1.2rem;
    line-height: 1.6;
    color: #333;
}

/* Responsif untuk perangkat seluler */
@media (max-width: 576px) {
    .container h1 {
        font-size: 1.5rem; /* Ukuran font lebih kecil pada perangkat seluler */
    }

    .container p {
        font-size: 1rem; /* Ukuran font yang lebih kecil */
    }

    .container img {
        border-width: 1px; /* Batas yang lebih tipis */
    }
}

/* Responsif untuk tablet */
@media (min-width: 577px) and (max-width: 768px) {
    .container h1 {
        font-size: 1.75rem; /* Ukuran font lebih kecil pada tablet */
    }

    .container p {
        font-size: 1.1rem; /* Ukuran font yang sedikit lebih besar */
    }
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <?php if ($news): ?>
            <h1><?php echo htmlspecialchars($news['title']); ?></h1>
            <p>
                <i class="bi-calendar4 custom-icon me-1"></i> <?php echo date('F j, Y', strtotime($news['created_at'])); ?>
            </p>
            <?php if ($news['image']): ?>
                <img src="/admin<?php echo $news['image']; ?>" class="img-fluid mb-3" alt="">
            <?php endif; ?>
            <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
        <?php else: ?>
            <p>Berita tidak ditemukan.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
