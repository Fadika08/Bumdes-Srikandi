<?php
include 'config.php';

// Ambil semua data penjualan dari database
$sql = "SELECT * FROM sales";
$result = $conn->query($sql);
$salesFromDb = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $salesFromDb[] = $row['amount'];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Perhitungan Penjualan</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard">
        <div class="main-content">
            <div class="container">
                <h2>Hasil Perhitungan Penjualan</h2>
                <div class="container">
    <button id="resetBtn">Reset Data</button>
    <button id="updateBtn">Update Data</button>
    <button id="deleteBtn">Delete Last Entry</button>
    <canvas id="salesChartFromDb"></canvas>
</div>
                <canvas id="salesChartFromDb"></canvas>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>
        var salesFromDb = <?php echo json_encode($salesFromDb); ?>;
        var ctx = document.getElementById('salesChartFromDb').getContext('2d');
        var salesChartFromDb = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: salesFromDb.map((_, index) => `Penjualan ${index + 1}`),
                datasets: [{
                    label: 'Penjualan dari Database',
                    data: salesFromDb,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
