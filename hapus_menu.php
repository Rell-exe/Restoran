<?php
include 'koneksi.php';

// Ambil ID dari parameter URL (GET) atau dari Body (POST)
$id = $_GET['id']; 

$query = "DELETE FROM menu WHERE id = '$id'";
$sql = mysqli_query($koneksi, $query);

if($sql){
    echo json_encode(["status" => "success", "message" => "Menu berhasil dihapus"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menghapus menu"]);
}
?>