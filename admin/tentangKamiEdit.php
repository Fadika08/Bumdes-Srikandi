<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Tentang Kami</h2>
                <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>

        <?php
        // Menghubungkan ke database
        include'config.php';
        // Mengambil konten yang ada dari database
        $query = "SELECT * FROM tentangkami WHERE id = 1";
        $result = mysqli_query($conn, $query);

        $konten = mysqli_fetch_assoc($result);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Memproses pengiriman form
            $judul_section = $_POST['judul_section'];
            $subjudul_section = $_POST['subjudul_section'];
            $teks_section = $_POST['teks_section'];
            $judul_tujuan = $_POST['judul_tujuan'];
            $teks_tujuan = $_POST['teks_tujuan'];
            $daftar_tujuan = $_POST['daftar_tujuan']; // Daftar tujuan yang dipisahkan dengan koma
            $counter_1 = $_POST['counter_1'];
            $counter_2 = $_POST['counter_2'];
        
            // Mengelola file upload
            $target_dir = "new_images/tentangkami/";
            $gambar_section = $_FILES["gambar_section"]["name"];
        
            // Periksa apakah direktori target ada
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true); // Membuat direktori jika belum ada
            }
        
            if (!empty($gambar_section)) {
                $target_file = $target_dir . basename($gambar_section);
        
                // Pindahkan file yang diunggah
                if (move_uploaded_file($_FILES["gambar_section"]["tmp_name"], $target_file)) {
                    echo '<div class="alert alert-success">Gambar berhasil diunggah: ' . htmlspecialchars($target_file) . '</div>';
                    
                    // Memperbarui database dengan gambar
                    $query = "UPDATE tentangkami SET 
                        gambar_section='$gambar_section', 
                        judul_section='$judul_section',
                        subjudul_section='$subjudul_section',
                        teks_section='$teks_section',
                        judul_tujuan='$judul_tujuan',
                        teks_tujuan='$teks_tujuan',
                        daftar_tujuan='$daftar_tujuan',
                        counter_1='$counter_1',
                        counter_2='$counter_2'
                        WHERE id = 1";
                } else {
                    echo '<div class="alert alert-danger">Gagal mengunggah gambar: ' . htmlspecialchars($target_file) . '</div>';
                    $query = "UPDATE tentangkami SET 
                        judul_section='$judul_section',
                        subjudul_section='$subjudul_section',
                        teks_section='$teks_section',
                        judul_tujuan='$judul_tujuan',
                        teks_tujuan='$teks_tujuan',
                        daftar_tujuan='$daftar_tujuan',
                        counter_1='$counter_1',
                        counter_2='$counter_2'
                        WHERE id = 1";
                }
            } else {
                // Memperbarui database tanpa mengganti gambar
                $query = "UPDATE tentangkami SET 
                    judul_section='$judul_section',
                    subjudul_section='$subjudul_section',
                    teks_section='$teks_section',
                    judul_tujuan='$judul_tujuan',
                    teks_tujuan='$teks_tujuan',
                    daftar_tujuan='$daftar_tujuan',
                    counter_1='$counter_1',
                    counter_2='$counter_2'
                    WHERE id = 1";
            }
        
            if (mysqli_query($conn, $query)) {
                echo '<div class="alert alert-success">Konten berhasil diperbarui!</div>';
            } else {
                echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
            }
        }

        // Tutup koneksi
        mysqli_close($conn);
        ?>

        <!-- Formulir dengan enctype="multipart/form-data" untuk mengizinkan upload file -->
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul_section" class="form-label">Judul Section:</label>
                    <input type="text" class="form-control" id="judul_section" name="judul_section" value="<?php echo htmlspecialchars($konten['judul_section']); ?>">
                </div>

                <div class="mb-3">
                    <label for="subjudul_section" class="form-label">Subjudul Section:</label>
                    <input type="text" class="form-control" id="subjudul_section" name="subjudul_section" value="<?php echo htmlspecialchars($konten['subjudul_section']); ?>">
                </div>

                <div class="mb-3">
                    <label for="teks_section" class="form-label">Teks Section:</label>
                    <textarea class="form-control" id="teks_section" name="teks_section"><?php echo htmlspecialchars($konten['teks_section']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="judul_tujuan" class="form-label">Judul Tujuan:</label>
                    <input type="text" class="form-control" id="judul_tujuan" name="judul_tujuan" value="<?php echo htmlspecialchars($konten['judul_tujuan']); ?>">
                </div>

                <div class="mb-3">
                    <label for="teks_tujuan" class="form-label">Teks Tujuan:</label>
                    <textarea class="form-control" id="teks_tujuan" name="teks_tujuan"><?php echo htmlspecialchars($konten['teks_tujuan']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="daftar_tujuan" class="form-label">Daftar Tujuan (pisahkan dengan koma):</label>
                    <input type="text" class="form-control" id="daftar_tujuan" name="daftar_tujuan" value="<?php echo htmlspecialchars($konten['daftar_tujuan']); ?>">
                </div>

                <div class="mb-3">
                    <label for="counter_1" class="form-label">Counter 1:</label>
                    <input type="number" class="form-control" id="counter_1" name="counter_1" value="<?php echo htmlspecialchars($konten['counter_1']); ?>">
                </div>

                <div class="mb-3">
                    <label for="counter_2" class="form-label">Counter 2:</label>
                    <input type="number" class="form-control" id="counter_2" name="counter_2" value="<?php echo htmlspecialchars($konten['counter_2']); ?>">
                </div>

                <div class="mb-3">
                    <label for="gambar_section" class="form-label">Gambar Section:</label>
                    <input type="file" class="form-control" id="gambar_section" name="gambar_section">
                </div>

                <button type="submit" class="btn btn-primary">Update Konten</button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
