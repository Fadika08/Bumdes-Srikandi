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
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Carousel</h2>
                <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>

        <?php
        // Menghubungkan ke database
        include 'config.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Mengambil data POST
            $slide1Title = $_POST['slide1Title'];
            $slide1Desc = $_POST['slide1Desc'];
            $slide2Title = $_POST['slide2Title'];
            $slide2Desc = $_POST['slide2Desc'];
            $slide3Title = $_POST['slide3Title'];
            $slide3Desc = $_POST['slide3Desc'];

            $target_dir = "new_images/slide/";
            $errors = [];

            // Menghandle upload file dan update database untuk setiap slide
            for ($i = 1; $i <= 3; $i++) {
                $titleVar = ${"slide" . $i . "Title"};
                $descVar = ${"slide" . $i . "Desc"};
                $imageVar = "slide" . $i . "Image";
                $imageName = isset($_FILES[$imageVar]) ? $_FILES[$imageVar]["name"] : '';

                if (!empty($imageName)) {
                    $imagePath = "slide" . $i . "_" . basename($imageName);
                    $fullImagePath = $target_dir . $imagePath;  // Jalur relatif untuk disimpan di database

                    // Upload gambar
                    if (move_uploaded_file($_FILES[$imageVar]["tmp_name"], $fullImagePath)) {
                        echo '<div class="alert alert-success">Gambar berhasil diunggah: ' . $fullImagePath . '</div>';
                        // Jika upload berhasil, tambahkan ke query
                        $query = "UPDATE carousel SET title=?, description=?, image=? WHERE id=?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("sssi", $titleVar, $descVar, $imagePath, $i);

                        if (!$stmt->execute()) {
                            $errors[] = 'Error: ' . $stmt->error;
                        }
                        $stmt->close();
                    } else {
                        $errors[] = 'Gagal mengunggah gambar untuk slide ' . $i;
                    }
                } else {
                    // Jika tidak ada gambar baru yang diupload
                    $query = "UPDATE carousel SET title=?, description=? WHERE id=?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssi", $titleVar, $descVar, $i);

                    if (!$stmt->execute()) {
                        $errors[] = 'Error: ' . $stmt->error;
                    }
                    $stmt->close();
                }
            }

            // Tampilkan pesan sukses atau error
            if (empty($errors)) {
                echo '<div class="alert alert-success">Carousel berhasil diperbarui.</div>';
            } else {
                echo '<div class="alert alert-danger">' . implode("<br>", $errors) . '</div>';
            }

            // Tutup koneksi
            $conn->close();
        }
        ?>

        <!-- Formulir dengan enctype="multipart/form-data" untuk mengizinkan upload file -->
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <!-- Slide 1 -->
                <div class="mb-3">
                    <label for="slide1Title" class="form-label">Judul Slide 1:</label>
                    <input type="text" class="form-control" id="slide1Title" name="slide1Title">
                </div>
                <div class="mb-3">
                    <label for="slide1Desc" class="form-label">Deskripsi Slide 1:</label>
                    <input type="text" class="form-control" id="slide1Desc" name="slide1Desc">
                </div>
                <div class="mb-3">
                    <label for="slide1Image" class="form-label">Gambar Slide 1:</label>
                    <input type="file" class="form-control" id="slide1Image" name="slide1Image">
                </div>

                <!-- Slide 2 -->
                <div class="mb-3">
                    <label for="slide2Title" class="form-label">Judul Slide 2:</label>
                    <input type="text" class="form-control" id="slide2Title" name="slide2Title">
                </div>
                <div class="mb-3">
                    <label for="slide2Desc" class="form-label">Deskripsi Slide 2:</label>
                    <input type="text" class="form-control" id="slide2Desc" name="slide2Desc">
                </div>
                <div class="mb-3">
                    <label for="slide2Image" class="form-label">Gambar Slide 2:</label>
                    <input type="file" class="form-control" id="slide2Image" name="slide2Image">
                </div>

                <!-- Slide 3 -->
                <div class="mb-3">
                    <label for="slide3Title" class="form-label">Judul Slide 3:</label>
                    <input type="text" class="form-control" id="slide3Title" name="slide3Title">
                </div>
                <div class="mb-3">
                    <label for="slide3Desc" class="form-label">Deskripsi Slide 3:</label>
                    <input type="text" class="form-control" id="slide3Desc" name="slide3Desc">
                </div>
                <div class="mb-3">
                    <label for="slide3Image" class="form-label">Gambar Slide 3:</label>
                    <input type="file" class="form-control" id="slide3Image" name="slide3Image">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
