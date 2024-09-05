<?php
// Koneksi ke database
include'config.php';

// Tambah UMKM
if (isset($_POST['add_umkm'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $jam_operasional = $_POST['jam_operasional'];
    $pemilik = $_POST['pemilik'];
    $detail = $_POST['detail'];
    $link_website = $_POST['link_website'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "new_images/umkm/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $query = "INSERT INTO umkm (nama, deskripsi, kategori, jam_operasional, pemilik, detail, gambar, link_website) 
                  VALUES ('$nama', '$deskripsi', '$kategori', '$jam_operasional', '$pemilik', '$detail', '$gambar', '$link_website')";
        if ($conn->query($query) === TRUE) {
            echo "UMKM berhasil ditambahkan!";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Gagal mengunggah gambar.";
    }
}

// Edit UMKM
if (isset($_POST['edit_umkm'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $jam_operasional = $_POST['jam_operasional'];
    $pemilik = $_POST['pemilik'];
    $detail = $_POST['detail'];
    $link_website = $_POST['link_website'];

    // Cek apakah ada gambar yang diunggah
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "new_images/umkm/";
        $target_file = $target_dir . basename($gambar);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $query = "UPDATE umkm SET nama='$nama', deskripsi='$deskripsi', kategori='$kategori', jam_operasional='$jam_operasional', 
                      pemilik='$pemilik', detail='$detail', gambar='$gambar', link_website='$link_website' WHERE id=$id";
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    } else {
        $query = "UPDATE umkm SET nama='$nama', deskripsi='$deskripsi', kategori='$kategori', jam_operasional='$jam_operasional', 
                  pemilik='$pemilik', detail='$detail', link_website='$link_website' WHERE id=$id";
    }

    if ($conn->query($query) === TRUE) {
        echo "UMKM berhasil diperbarui!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Hapus UMKM
if (isset($_POST['delete_umkm'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM umkm WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        echo "UMKM berhasil dihapus!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Ambil daftar UMKM
$query = "SELECT * FROM umkm";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kelola UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<h2>Dashboard Admin - Kelola UMKM</h2>
        <div class="mt-3">
            <a href="admindashboard.php" class="btn btn-secondary">Kembali ke Menu Utama</a>
        </div>
<!-- Form Tambah UMKM -->
<h3>Tambah UMKM Baru</h3>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="namaUMKM" class="form-label">Nama UMKM:</label>
        <input type="text" class="form-control" id="namaUMKM" name="nama" required>
    </div>
    <div class="mb-3">
        <label for="deskripsiUMKM" class="form-label">Deskripsi:</label>
        <textarea class="form-control" id="deskripsiUMKM" name="deskripsi" required></textarea>
    </div>
    <div class="mb-3">
        <label for="kategoriUMKM" class="form-label">Kategori:</label>
        <input type="text" class="form-control" id="kategoriUMKM" name="kategori" required>
    </div>
    <div class="mb-3">
        <label for="jamOperasionalUMKM" class="form-label">Jam Operasional:</label>
        <input type="text" class="form-control" id="jamOperasionalUMKM" name="jam_operasional" required>
    </div>
    <div class="mb-3">
        <label for="pemilikUMKM" class="form-label">Pemilik:</label>
        <input type="text" class="form-control" id="pemilikUMKM" name="pemilik" required>
    </div>
    <div class="mb-3">
        <label for="detailUMKM" class="form-label">Detail:</label>
        <textarea class="form-control" id="detailUMKM" name="detail" required></textarea>
    </div>
    <div class="mb-3">
        <label for="gambarUMKM" class="form-label">Gambar UMKM:</label>
        <input type="file" class="form-control" id="gambarUMKM" name="gambar" required>
    </div>
    <div class="mb-3">
        <label for="linkWebsiteUMKM" class="form-label">Link Website:</label>
        <input type="text" class="form-control" id="linkWebsiteUMKM" name="link_website">
    </div>
    <button type="submit" class="btn btn-primary" name="add_umkm">Tambah UMKM</button>
</form>

<hr>

<!-- Daftar UMKM -->
<h3>Daftar UMKM</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Jam Operasional</th>
            <th>Pemilik</th>
            <th>Detail</th>
            <th>Gambar</th>
            <th>Link Website</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['deskripsi']; ?></td>
            <td><?php echo $row['kategori']; ?></td>
            <td><?php echo $row['jam_operasional']; ?></td>
            <td><?php echo $row['pemilik']; ?></td>
            <td><?php echo $row['detail']; ?></td>
            <td><img src="new_images/umkm/<?php echo $row['gambar']; ?>" width="100" alt="Gambar UMKM"></td>
            <td><a href="<?php echo $row['link_website']; ?>" target="_blank">Kunjungi Website</a></td>
            <td>
                <!-- Form Edit UMKM -->
                <form method="POST" enctype="multipart/form-data" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="mb-3">
                        <label for="namaUMKM_<?php echo $row['id']; ?>" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="namaUMKM_<?php echo $row['id']; ?>" name="nama" value="<?php echo $row['nama']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsiUMKM_<?php echo $row['id']; ?>" class="form-label">Deskripsi:</label>
                        <textarea class="form-control" id="deskripsiUMKM_<?php echo $row['id']; ?>" name="deskripsi" required><?php echo $row['deskripsi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kategoriUMKM_<?php echo $row['id']; ?>" class="form-label">Kategori:</label>
                        <input type="text" class="form-control" id="kategoriUMKM_<?php echo $row['id']; ?>" name="kategori" value="<?php echo $row['kategori']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jamOperasionalUMKM_<?php echo $row['id']; ?>" class="form-label">Jam Operasional:</label>
                        <input type="text" class="form-control" id="jamOperasionalUMKM_<?php echo $row['id']; ?>" name="jam_operasional" value="<?php echo $row['jam_operasional']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pemilikUMKM_<?php echo $row['id']; ?>" class="form-label">Pemilik:</label>
                        <input type="text" class="form-control" id="pemilikUMKM_<?php echo $row['id']; ?>" name="pemilik" value="<?php echo $row['pemilik']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="detailUMKM_<?php echo $row['id']; ?>" class="form-label">Detail:</label>
                        <textarea class="form-control" id="detailUMKM_<?php echo $row['id']; ?>" name="detail" required><?php echo $row['detail']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambarUMKM_<?php echo $row['id']; ?>" class="form-label">Gambar UMKM (kosongkan jika tidak ingin mengganti):</label>
                        <input type="file" class="form-control" id="gambarUMKM_<?php echo $row['id']; ?>" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="linkWebsiteUMKM_<?php echo $row['id']; ?>" class="form-label">Link Website:</label>
                        <input type="text" class="form-control" id="linkWebsiteUMKM_<?php echo $row['id']; ?>" name="link_website" value="<?php echo $row['link_website']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="edit_umkm">Perbarui UMKM</button>
                </form>
                <!-- Form Hapus UMKM -->
                <form method="POST" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-danger" name="delete_umkm" onclick="return confirm('Anda yakin ingin menghapus UMKM ini?');">Hapus UMKM</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
