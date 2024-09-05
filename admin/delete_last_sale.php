<?php
include 'config.php';

// Hapus data penjualan terakhir
$sql = "DELETE FROM sales ORDER BY id DESC LIMIT 1";
if ($conn->query($sql) === TRUE) {
    echo "Entri penjualan terakhir berhasil dihapus.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
header("Location: admindashboard.php");
exit;
?>
