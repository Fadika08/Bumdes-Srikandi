<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tentang Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Struktur</h2>
        <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>
        <?php
include 'config.php'; // Include your database configuration file

// Fetch current "Tentang Kami" content
$query = "SELECT * FROM struktur WHERE id = 1 LIMIT 1";
$result = $conn->query($query);
$tentangKami = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    $target_dir = "new_images/struktur/";
    $imagePath = '';

    if (!empty($image)) {
        $imagePath = basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $imagePath);
    } else {
        $imagePath = $struktur['image'];
    }

    // The SQL query
    $updateQuery = "UPDATE struktur SET title = ?, subtitle = ?, description = ?, image = ? WHERE id = 1";

    // Prepare the statement
    $stmt = $conn->prepare($updateQuery);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Prepare() failed: ' . htmlspecialchars($conn->error));
    }

    // Bind the parameters and execute
    $stmt->bind_param("ssss", $title, $subtitle, $description, $imagePath);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Data berhasil diperbarui.</div>';
    } else {
        echo '<div class="alert alert-danger">Terjadi kesalahan: ' . $stmt->error . '</div>';
    }

    $stmt->close();
}

$conn->close();
?>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Judul:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($tentangKami['title']); ?>">
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Subjudul:</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($tentangKami['subtitle']); ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($tentangKami['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar:</label>
                <input type="file" class="form-control" id="image" name="image">
                <?php if (!empty($tentangKami['image'])): ?>
                    <img src="images/<?php echo htmlspecialchars($tentangKami['image']); ?>" alt="Current image" style="max-width: 150px; margin-top: 10px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
