<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../koneksi.php';

if (!isset($_GET['user_id'])) {
    echo json_encode(["success" => false, "message" => "User ID tidak ditemukan"]);
    exit;
}

$user_id = $_GET['user_id'];

$result = mysqli_query($conn, "SELECT nama_layanan AS layanan, tanggal_pengajuan AS tanggal, status FROM layanan WHERE user_id = '$user_id' ORDER BY tanggal_pengajuan DESC");

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
