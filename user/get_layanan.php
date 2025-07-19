<?php
header("Access-Control-Allow-Origin: http://localhost:8081");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

include '../koneksi.php';

$query = "SELECT l.id, l.nama_layanan, l.catatan, l.status, l.tanggal_pengajuan AS tanggal, u.nama 
FROM layanan l
JOIN users u ON l.user_id = u.id
ORDER BY l.tanggal_pengajuan DESC"; // ✅ tanda kutip ditutup

$result = mysqli_query($conn, $query);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
