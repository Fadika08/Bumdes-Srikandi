<?php
// Konfigurasi database
$servername = "127.0.0.1:3306";
$username = "u779600581_bumdes";
$password = "Bumdes123.";
$dbname = "u779600581_bumdesdb";


// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} 
?>
