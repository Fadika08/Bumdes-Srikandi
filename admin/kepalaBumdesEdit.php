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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Konten Ketua</h2>
                <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>

        <?php
        // Menghubungkan ke database
        include 'config.php';

        // Mengambil konten dari database
        $query = "SELECT * FROM about_section WHERE id = 1";
        $result = mysqli_query($conn, $query);
        $conten = mysqli_fetch_assoc($result);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Memproses pengiriman form
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $text1 = $_POST['text1'];
            $text2 = $_POST['text2'];

            // Mengelola file upload
            $target_dir = "new_images/about_section/";
            $image = $_FILES["image"]["name"];

            if (!empty($image)) {
                $target_file = $target_dir . basename($image);

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo '<div class="alert alert-success">Gambar berhasil diunggah.</div>';

                    // Memperbarui database dengan gambar
                    $query = "UPDATE about_section SET 
                        title='$title',
                        subtitle='$subtitle',
                        text1='$text1',
                        text2='$text2',
                        image='$image'
                        WHERE id = 1";
                } else {
                    echo '<div class="alert alert-danger">Gagal mengunggah gambar.</div>';
                }
            } else {
                // Memperbarui database tanpa mengganti gambar
                $query = "UPDATE about_section SET 
                    title='$title',
                    subtitle='$subtitle',
                    text1='$text1',
                    text2='$text2'
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
                    <label for="title" class="form-label">Judul:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($conten['title']); ?>">
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">Subjudul:</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($conten['subtitle']); ?>">
                </div>

                <div class="mb-3">
                    <label for="text1" class="form-label">Teks Paragraf 1:</label>
                    <textarea class="form-control" id="text1" name="text1"><?php echo htmlspecialchars($conten['text1']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="text2" class="form-label">Teks Paragraf 2:</label>
                    <textarea class="form-control" id="text2" name="text2"><?php echo htmlspecialchars($conten['text2']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar:</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <button type="submit" class="btn btn-primary">Update Konten</button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
