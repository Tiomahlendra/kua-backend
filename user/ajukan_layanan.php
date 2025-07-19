<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../koneksi.php';

// Validasi awal
if (!isset($_POST['user_id'], $_POST['layanan'], $_POST['catatan'])) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$user_id = $_POST['user_id'];
$layanan = $_POST['layanan'];
$catatan = $_POST['catatan'];

// Insert ke tabel layanan
$query = "INSERT INTO layanan (user_id, nama_layanan, catatan, status, tanggal_pengajuan)
          VALUES ('$user_id', '$layanan', '$catatan', 'pending', NOW())";
mysqli_query($conn, $query);

$layanan_id = mysqli_insert_id($conn);

// Upload file persyaratan
$uploaded_files = [];
if (!empty($_FILES['files']['name'][0])) {
    $total = count($_FILES['files']['name']);
    for ($i = 0; $i < $total; $i++) {
        $nama_file = $_FILES['files']['name'][$i];
        $tmp = $_FILES['files']['tmp_name'][$i];
        $path = "uploads/" . time() . "_" . basename($nama_file);
        move_uploaded_file($tmp, $path);

        $q = "INSERT INTO persyaratan (layanan_id, nama_file, path) VALUES ('$layanan_id', '$nama_file', '$path')";
        mysqli_query($conn, $q);

        $uploaded_files[] = $nama_file;
    }
}

// Ambil data lengkap pengajuan user + nama user
$data = [];
$get = mysqli_query($conn, "SELECT l.id, l.nama_layanan, l.status, l.tanggal_pengajuan AS tanggal, l.catatan, u.nama 
                            FROM layanan l 
                            JOIN users u ON l.user_id = u.id 
                            WHERE l.id = '$layanan_id'");
if ($row = mysqli_fetch_assoc($get)) {
    $data = $row;
}

$data['documents'] = $uploaded_files;

// Kirim satu response JSON lengkap
echo json_encode([
    "success" => true,
    "message" => "Pengajuan berhasil dikirim.",
    "data" => $data
]);
