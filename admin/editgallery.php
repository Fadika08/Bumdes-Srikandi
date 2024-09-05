<?php
include 'config.php';

// Menangani pengiriman formulir untuk menambahkan item galeri baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Menangani upload file gambar utama
    $target_dir = "new_images/gallery/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    // Menangani upload file gambar latar belakang
    $background_image_name = basename($_FILES["background_image"]["name"]);
    $background_target_file = $target_dir . $background_image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        if (move_uploaded_file($_FILES["background_image"]["tmp_name"], $background_target_file)) {
            // Masukkan data ke dalam database dengan gambar latar belakang
            $stmt = $conn->prepare("INSERT INTO gallery (title, description, image, background_image, date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $description, $image_name, $background_image_name, $date);
        } else {
            // Masukkan data ke dalam database tanpa gambar latar belakang jika tidak ada
            $stmt = $conn->prepare("INSERT INTO gallery (title, description, image, date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $title, $description, $image_name, $date);
        }
        $stmt->execute();
        $stmt->close();
        echo "Item galeri baru berhasil ditambahkan!";
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file Anda.";
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    // Mengambil nama file gambar untuk dihapus dari server
    $query = $conn->prepare("SELECT image FROM gallery WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Hapus file gambar dari server
        unlink("new_images/gallery/" . $row['image']);
        
        // Hapus item galeri dari database
        $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        echo '<div class="alert alert-success">Item galeri berhasil dihapus!</div>';
    } else {
        echo '<div class="alert alert-danger">Item galeri tidak ditemukan!</div>';
    }
}
// Mengambil semua item galeri untuk ditampilkan
$result = $conn->query("SELECT * FROM gallery");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Galeri</title>
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
        <h1 class="mb-4">Kelola Galeri</h1>
                <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>

        <!-- Formulir untuk menambahkan item galeri baru -->
        <div class="form-container mb-5">
            <form method="post" enctype="multipart/form-data">
                
                <div class="mb-3">
                <label for="background_image" class="form-label">Gambar Latar Belakang:</label>
                <input type="file" class="form-control" id="background_image" name="background_image">
                </div>


                <div class="mb-3">
                    <label for="title" class="form-label">Judul:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi:</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal:</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar:</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>

                <button type="submit" name="add" class="btn btn-primary">Tambah Item Galeri</button>
            </form>
        </div>

        <h2 class="mb-4">Item Galeri</h2>
        <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
             <div class="col-md-4 mb-3">
             <div class="card">
            <!-- Gunakan gambar latar belakang yang diunggah -->
            <div class="card-img-top" style="background-image: url('new_images/gallery/<?php echo $row['background_image']; ?>'); height: 200px; background-size: cover;"></div>
            <img src="new_images/gallery/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                <p class="card-text"><?php echo $row['description']; ?></p>
                <p class="card-text"><small class="text-muted"><?php echo $row['date']; ?></small></p>
                <form method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
<?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
