<?php
include 'config.php';

if (isset($_GET['amount'])) {
    $amount = $_GET['amount'];
    // Update data penjualan terbaru
    $sql = "INSERT INTO sales (amount) VALUES ('$amount')";
    if ($conn->query($sql) === TRUE) {
        echo "Data penjualan berhasil diperbarui.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
header("Location: admindashboard.php");
exit;
?>
