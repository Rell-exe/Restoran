<?php
header('Content-Type: application/json');
include 'koneksi.php';

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if ($input) {
    // Pengaman agar karakter seperti tanda kutip (') tidak merusak database
    $nama     = mysqli_real_escape_string($koneksi, $input['name']);
    $harga    = mysqli_real_escape_string($koneksi, $input['price']);
    $kategori = mysqli_real_escape_string($koneksi, $input['category']);
    $gambar   = $input['img'];

    $sql = "INSERT INTO menu (name, price, category, img) VALUES ('$nama', '$harga', '$kategori', '$gambar')";

    if (mysqli_query($koneksi, $sql)) {
        echo json_encode(["status" => "success", "message" => "Menu berhasil ditambahkan!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Tidak ada data yang masuk"]);
}
?>