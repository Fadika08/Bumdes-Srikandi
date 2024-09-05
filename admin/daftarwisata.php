<?php
// Koneksi ke database
include'config.php';

// Tambah Wisata
if (isset($_POST['add_wisata'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $jam_operasional = $_POST['jam_operasional'];
    $pemilik = $_POST['pemilik'];
    $detail = $_POST['detail'];
    $link_website = $_POST['link_website'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "new_images/wisata/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $query = "INSERT INTO wisata (nama, deskripsi, kategori, jam_operasional, pemilik, detail, gambar, link_website) 
                  VALUES ('$nama', '$deskripsi', '$kategori', '$jam_operasional', '$pemilik', '$detail', '$gambar', '$link_website')";
        if ($conn->query($query) === TRUE) {
            echo "Wisata berhasil ditambahkan!";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Gagal mengunggah gambar.";
    }
}

// Edit Wisata
if (isset($_POST['edit_wisata'])) {
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
        $target_dir = "new_images/wisata/";
        $target_file = $target_dir . basename($gambar);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $query = "UPDATE wisata SET nama='$nama', deskripsi='$deskripsi', kategori='$kategori', jam_operasional='$jam_operasional', 
                      pemilik='$pemilik', detail='$detail', gambar='$gambar', link_website='$link_website' WHERE id=$id";
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    } else {
        $query = "UPDATE wisata SET nama='$nama', deskripsi='$deskripsi', kategori='$kategori', jam_operasional='$jam_operasional', 
                  pemilik='$pemilik', detail='$detail', link_website='$link_website' WHERE id=$id";
    }

    if ($conn->query($query) === TRUE) {
        echo "wisata berhasil diperbarui!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Hapus Wisata
if (isset($_POST['delete_wisata'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM wisata WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        echo "Wisata berhasil dihapus!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Ambil daftar Wisata
$query = "SELECT * FROM wisata";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kelola Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<h2>Dashboard Admin - Kelola Wisata</h2>

<!-- Form Tambah UMKM -->
<h3>Tambah Wisata Baru</h3>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="namawisata" class="form-label">Nama Wisata:</label>
        <input type="text" class="form-control" id="namawisata" name="nama" required>
    </div>
    <div class="mb-3">
        <label for="deskripsiwisata" class="form-label">Deskripsi:</label>
        <textarea class="form-control" id="deskripsiwisata" name="deskripsi" required></textarea>
    </div>
    <div class="mb-3">
        <label for="kategoriwisata" class="form-label">Kategori:</label>
        <input type="text" class="form-control" id="kategoriwisata" name="kategori" required>
    </div>
    <div class="mb-3">
        <label for="jamOperasionalwisata" class="form-label">Jam Operasional:</label>
        <input type="text" class="form-control" id="jamOperasionalwisata" name="jam_operasional" required>
    </div>
    <div class="mb-3">
        <label for="pemilikwisata" class="form-label">Pemilik:</label>
        <input type="text" class="form-control" id="pemilikwisata" name="pemilik" required>
    </div>
    <div class="mb-3">
        <label for="detailwisata" class="form-label">Detail:</label>
        <textarea class="form-control" id="detailwisata" name="detail" required></textarea>
    </div>
    <div class="mb-3">
        <label for="gambarwisata" class="form-label">Gambar Wisata:</label>
        <input type="file" class="form-control" id="gambarwisata" name="gambar" required>
    </div>
    <div class="mb-3">
        <label for="linkWebsitewisata" class="form-label">Link Website:</label>
        <input type="text" class="form-control" id="linkWebsitewisata" name="link_website">
    </div>
    <button type="submit" class="btn btn-primary" name="add_wisata">Tambah Wisata</button>
</form>

<hr>

<!-- Daftar Wisata -->
<h3>Daftar Wisata</h3>
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
            <td><img src="new_images/wisata/<?php echo $row['gambar']; ?>" width="100" alt="Gambar Wisata"></td>
            <td><a href="<?php echo $row['link_website']; ?>" target="_blank">Kunjungi Website</a></td>
            <td>
                <!-- Form Edit Wisata -->
                <form method="POST" enctype="multipart/form-data" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="mb-3">
                        <label for="namawisata_<?php echo $row['id']; ?>" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="namawisata_<?php echo $row['id']; ?>" name="nama" value="<?php echo $row['nama']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsiwisata_<?php echo $row['id']; ?>" class="form-label">Deskripsi:</label>
                        <textarea class="form-control" id="deskripsiwisata_<?php echo $row['id']; ?>" name="deskripsi" required><?php echo $row['deskripsi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kategoriwisata_<?php echo $row['id']; ?>" class="form-label">Kategori:</label>
                        <input type="text" class="form-control" id="kategoriwisata_<?php echo $row['id']; ?>" name="kategori" value="<?php echo $row['kategori']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jamOperasionalwisata_<?php echo $row['id']; ?>" class="form-label">Jam Operasional:</label>
                        <input type="text" class="form-control" id="jamOperasionalwisata_<?php echo $row['id']; ?>" name="jam_operasional" value="<?php echo $row['jam_operasional']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pemilikwisata_<?php echo $row['id']; ?>" class="form-label">Pemilik:</label>
                        <input type="text" class="form-control" id="pemilikwisata_<?php echo $row['id']; ?>" name="pemilik" value="<?php echo $row['pemilik']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="detailwisata_<?php echo $row['id']; ?>" class="form-label">Detail:</label>
                        <textarea class="form-control" id="detailwisata_<?php echo $row['id']; ?>" name="detail" required><?php echo $row['detail']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambarwisata_<?php echo $row['id']; ?>" class="form-label">Gambar Wisata (kosongkan jika tidak ingin mengganti):</label>
                        <input type="file" class="form-control" id="gambarwisata_<?php echo $row['id']; ?>" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="linkWebsitewisata_<?php echo $row['id']; ?>" class="form-label">Link Website:</label>
                        <input type="text" class="form-control" id="linkWebsitewisata_<?php echo $row['id']; ?>" name="link_website" value="<?php echo $row['link_website']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="edit_wisata">Perbarui Wisata</button>
                </form>
                <!-- Form Hapus UMKM -->
                <form method="POST" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-danger" name="delete_wisata" onclick="return confirm('Anda yakin ingin menghapus Wisata ini?');">Hapus Wisata</button>
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
