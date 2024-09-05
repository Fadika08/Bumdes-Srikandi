<?php
include 'config.php';

// Ambil jumlah anggota dari database
$sql = "SELECT COUNT(*) AS total FROM users";
$result = $conn->query($sql);
$totalMembers = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalMembers = $row['total'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jumlah Anggota</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <div class="container">
                <h2>Jumlah Anggota</h2>
                <p>Total Anggota: <?php echo $totalMembers; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
