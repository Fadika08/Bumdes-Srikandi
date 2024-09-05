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

// Tambah/Edit Berita
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $news_id = isset($_POST['news_id']) ? $_POST['news_id'] : null;

    // Direktori target untuk menyimpan gambar
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/new_images/news/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $errors = [];
    $imageName = isset($_FILES['image']) ? $_FILES['image']["name"] : '';

    if (!empty($imageName)) {
        $imagePath = basename($imageName);
        $fullImagePath = "/new_images/news/" . $imagePath;

        // Upload gambar
        if (move_uploaded_file($_FILES['image']["tmp_name"], $targetDir . $imagePath)) {
            // Berhasil mengunggah gambar
        } else {
            $errors[] = 'Gagal mengunggah gambar.';
        }
    } else {
        $fullImagePath = null;
    }

    if (empty($errors)) {
        if ($news_id) {
            // Update berita yang sudah ada
            if ($fullImagePath) {
                $query = "UPDATE news SET title = ?, content = ?, category = ?, tags = ?, image = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssssi", $title, $content, $category, $tags, $fullImagePath, $news_id);
            } else {
                $query = "UPDATE news SET title = ?, content = ?, category = ?, tags = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssssi", $title, $content, $category, $tags, $news_id);
            }
        } else {
            // Tambah berita baru
            if ($fullImagePath) {
                $query = "INSERT INTO news (title, content, category, tags, image) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssss", $title, $content, $category, $tags, $fullImagePath);
            } else {
                $query = "INSERT INTO news (title, content, category, tags) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssss", $title, $content, $category, $tags);
            }
        }

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Berita berhasil ' . ($news_id ? 'diedit' : 'ditambahkan') . '.</div>';
        } else {
            $errors[] = 'Error: ' . $conn->error;
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">' . implode("<br>", $errors) . '</div>';
    }
}

// Hapus Berita
if (isset($_GET['delete_id'])) {
    $news_id = $_GET['delete_id'];
    $query = "DELETE FROM news WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $news_id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Berita berhasil dihapus.</div>';
    } else {
        echo '<div class="alert alert-danger">Gagal menghapus berita: ' . $conn->error . '</div>';
    }
    $stmt->close();
}

// Ambil data berita untuk diedit
$edit_news = null;
if (isset($_GET['edit_id'])) {
    $news_id = $_GET['edit_id'];
    $query = "SELECT * FROM news WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $news_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_news = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_news ? 'Edit Berita' : 'Tambah Berita'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2><?php echo $edit_news ? 'Edit Berita' : 'Tambah Berita'; ?></h2>
                <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="news_id" value="<?php echo $edit_news['id'] ?? ''; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $edit_news['title'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Konten Berita</label>
                <textarea class="form-control" id="content" name="content" rows="4" required><?php echo $edit_news['content'] ?? ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori Berita</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="politik" <?php echo (isset($edit_news['category']) && $edit_news['category'] == 'politik') ? 'selected' : ''; ?>>Politik</option>
                    <option value="ekonomi" <?php echo (isset($edit_news['category']) && $edit_news['category'] == 'ekonomi') ? 'selected' : ''; ?>>Ekonomi</option>
                    <option value="olahraga" <?php echo (isset($edit_news['category']) && $edit_news['category'] == 'olahraga') ? 'selected' : ''; ?>>Olahraga</option>
                    <option value="hiburan" <?php echo (isset($edit_news['category']) && $edit_news['category'] == 'hiburan') ? 'selected' : ''; ?>>Hiburan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">Tag Berita (pisahkan dengan koma)</label>
                <input type="text" class="form-control" id="tags" name="tags" value="<?php echo $edit_news['tags'] ?? ''; ?>">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Berita</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $edit_news ? 'Edit Berita' : 'Simpan Berita'; ?></button>
        </form>

        <h3 class="mt-5">Daftar Berita</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tags</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ulang untuk ambil data berita
                $conn = new mysqli($servername, $username, $password, $dbname);
                $query = "SELECT * FROM news";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['title']}</td>
                                <td>{$row['category']}</td>
                                <td>{$row['tags']}</td>
                                <td><img src='{$row['image']}' alt='{$row['title']}' width='100'></td>
                                <td>
                                    <a href='?edit_id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus berita ini?\")'>Hapus</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada berita.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
