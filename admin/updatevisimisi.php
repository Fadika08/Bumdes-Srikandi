<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_section = $_POST['judul_section'];
    $subjudul_section = $_POST['subjudul_section'];
    $teks_section = $_POST['teks_section'];
    $judul_tujuan = $_POST['judul_tujuan'];
    $teks_tujuan = $_POST['teks_tujuan'];
    $daftar_tujuan = $_POST['daftar_tujuan'];

    // Handle image upload
    $gambar_section = $_FILES['gambar_section']['name'];
    $target_dir = "new_images/visimisi/";
    $target_file = $target_dir . basename($_FILES["gambar_section"]["name"]);

    if (move_uploaded_file($_FILES["gambar_section"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["gambar_section"]["name"])) . " Berhasil Uploud";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $query = "UPDATE visimisi SET judul_section = '$judul_section', subjudul_section = '$subjudul_section', teks_section = '$teks_section', gambar_section = '$gambar_section', judul_tujuan = '$judul_tujuan', teks_tujuan = '$teks_tujuan', daftar_tujuan = '$daftar_tujuan' WHERE id = 1";

    if (mysqli_query($conn, $query)) {
        echo "Berhasil Update";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

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
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Visi Misi</h2>
                <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>
        <form class="form-container" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul_section" class="form-label">Judul Section</label>
                <input type="text" class="form-control" id="judul_section" name="judul_section" required>
            </div>
            <div class="mb-3">
                <label for="subjudul_section" class="form-label">Subjudul Section</label>
                <input type="text" class="form-control" id="subjudul_section" name="subjudul_section" required>
            </div>
            <div class="mb-3">
                <label for="teks_section" class="form-label">Teks Section</label>
                <textarea class="form-control" id="teks_section" name="teks_section" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar_section" class="form-label">Gambar Section</label>
                <input type="file" class="form-control" id="gambar_section" name="gambar_section">
            </div>
            <div class="mb-3">
                <label for="judul_tujuan" class="form-label">Judul Tujuan</label>
                <input type="text" class="form-control" id="judul_tujuan" name="judul_tujuan" required>
            </div>
            <div class="mb-3">
                <label for="teks_tujuan" class="form-label">Teks Tujuan</label>
                <textarea class="form-control" id="teks_tujuan" name="teks_tujuan" rows="2" required></textarea>
            </div>
            <div class="mb-3">
                <label for="daftar_tujuan" class="form-label">Daftar Tujuan (pisahkan dengan koma)</label>
                <textarea class="form-control" id="daftar_tujuan" name="daftar_tujuan" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn">Perbarui</button>
        </form>
    </div>
</body>
</html>
