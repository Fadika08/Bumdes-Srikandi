<?php
 include 'config.php';

session_start();

// Periksa jika form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi username dan password
    if ($username === "admin" && $password === "admin123") { // Ganti dengan validasi sesuai kebutuhan
        $_SESSION['admin_logged_in'] = true; // Set session untuk menandakan admin sudah login
        header('Location: admindashboard.php'); // Redirect ke halaman admin dashboard
        exit;
    } else {
        // Redirect dengan pesan kesalahan
        header('Location: index.php?error=1');
        exit;
    }
}
?>