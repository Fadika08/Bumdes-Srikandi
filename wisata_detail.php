<?php
// Koneksi ke database
include'admin/config.php';

// Mendapatkan ID UMKM dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mendapatkan detail UMKM berdasarkan ID
$query = "SELECT * FROM wisata WHERE id = $id";
$result = $conn->query($query);

// Cek apakah UMKM ditemukan
if ($result->num_rows > 0) {
    $umkm = $result->fetch_assoc();
} else {
    echo "Wisata tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Wisata - <?php echo $umkm['nama']; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/bootstrap-icons.css" rel="stylesheet">

<link href="css/index.css" rel="stylesheet"><!-- Tambahkan path CSS Anda -->

<style>
    /* Batasan untuk gambar UMKM */
.umkm-detail img {
    max-width: 100%; /* Agar gambar tidak melebar dari container */
    height: auto;    /* Menjaga proporsi gambar */
    border: 2px solid #ddd; /* Batas gambar */
    border-radius: 8px; /* Sudut membulat */
    margin-bottom: 20px; /* Jarak bawah gambar */
}

/* Gaya untuk detail UMKM */
.umkm-detail {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto; /* Pusatkan container */
}

  /* Container untuk tombol */
  .button-container {
            text-align: center; /* Pusatkan teks di dalam container */
            margin-top: 20px; /* Jarak atas dari konten */
        }

        .button-container button {
            margin: 0; /* Hapus margin default */
        }

/* Responsif untuk perangkat seluler */
@media (max-width: 576px) {
    .umkm-detail h2 {
        font-size: 1.5rem; /* Ukuran font lebih kecil pada perangkat seluler */
    }

    .umkm-detail p {
        font-size: 1rem; /* Ukuran font yang lebih kecil */
    }

    .umkm-detail img {
        border-width: 1px; /* Batas yang lebih tipis */
    }
}

/* Responsif untuk tablet */
@media (min-width: 577px) and (max-width: 768px) {
    .umkm-detail h2 {
        font-size: 1.75rem; /* Ukuran font lebih kecil pada tablet */
    }

    .umkm-detail p {
        font-size: 1.1rem; /* Ukuran font yang sedikit lebih besar */
    }
}
</style>
</head>
<body>

<div class="umkm-detail">
    <h2><?php echo $umkm['nama']; ?></h2>
    <img src="admin/new_images/wisata/<?php echo $umkm['gambar']; ?>" alt="Gambar UMKM">
    <p><strong>Deskripsi:</strong> <?php echo $umkm['deskripsi']; ?></p>
    <p><strong>Jam Operasional:</strong> <?php echo $umkm['jam_operasional']; ?></p>
    <p><strong>Pemilik:</strong> <?php echo $umkm['pemilik']; ?></p>
    <p><strong>Detail:</strong> <?php echo nl2br($umkm['detail']); ?></p>
    <?php if($umkm['link_website']) { ?>
        <a href="<?php echo $umkm['link_website']; ?>" target="_blank">Kunjungi Website</a>
    <?php } ?>
</div>


<div class="button-container">
    <a href="wisata.php"><button type="button" class="btn btn-primary">Kembali ke Daftar Wisata</button></a>
</div>
</body>
</html>

<?php
$conn->close();
?>
