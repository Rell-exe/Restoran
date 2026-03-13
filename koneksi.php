<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_restoran";

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Mengecek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>