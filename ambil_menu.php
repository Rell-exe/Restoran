<?php
include 'koneksi.php';

// Beri tahu browser bahwa ini adalah data JSON
header('Content-Type: application/json');

// Ambil data
$query = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY id DESC");

if (!$query) {
    // Jika query gagal, beri tahu alasannya dalam format JSON
    echo json_encode(["status" => "error", "message" => mysqli_error($koneksi)]);
    exit;
}

$data = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Tampilkan hanya JSON, jangan ada echo atau teks lain di luar ini
echo json_encode($data);
?>