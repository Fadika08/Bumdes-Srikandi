<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Average Calculator</title>
    <link rel="stylesheet" href="calculator.css">
</head>
<body>
    <div class="container">
        <h2>Calculator Rata Rata Penjualan</h2>
        <form action="calculate.php" method="POST">
            <label for="sales">Masukkan jumlah penjualan:</label>
            <input type="text" id="sales" name="sales" required>
            <button type="submit">Hitung</button>
        </form>
    </div>
</body>
</html>
