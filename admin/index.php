<?php
 include 'config.php';
 ?>
     <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <script>
            alert('Username atau password salah');
        </script>
    <?php endif; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="login_process.php" method="POST">
                <div class="textbox">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>