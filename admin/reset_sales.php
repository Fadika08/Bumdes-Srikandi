<?php
include 'config.php';

// Hapus semua data penjualan
$sql = "DELETE FROM sales";
if ($conn->query($sql) === TRUE) {
    echo "Data penjualan berhasil direset.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
header("Location: admindashboard.php");
exit;
?>
