<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sales = $_POST['sales'];
    $salesArray = array_map('floatval', explode(',', $sales));
    $totalSales = array_sum($salesArray);
    $numSales = count($salesArray);
    $averageSales = $numSales > 0 ? $totalSales / $numSales : 0;

    // Simpan setiap penjualan ke database
    foreach ($salesArray as $sale) {
        $sql = "INSERT INTO sales (amount) VALUES ('$sale')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    header("Location: result.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Average Result</title>
    <link rel="stylesheet" href="calculator.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h2>Hasil Rata Rata </h2>
        <canvas id="salesChart"></canvas>
        <div class="average-result">
            <h3>Rata Rata : <?php echo round($averageSales, 2); ?></h3>
        </div>
        <a href="calculator.php" class="btn">Hitung Kembali</a>
    </div>
    <script>
        var salesData = <?php echo $salesData; ?>;
        var averageSalesData = <?php echo $averageSalesData; ?>;

        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: salesData.map((_, index) => `Sale ${index + 1}`),
                datasets: [{
                    label: 'Sales Amount',
                    data: salesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Average Sales',
                    data: averageSalesData,
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    type: 'line'
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
