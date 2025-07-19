<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = mysqli_query($conn, "
        SELECT 
            layanan.id,
            layanan.nama_layanan,
            layanan.status,
            layanan.tanggal_pengajuan,
            users.nama AS nama_pemohon
        FROM layanan
        JOIN users ON layanan.user_id = users.id
        ORDER BY layanan.tanggal_pengajuan DESC
    ");

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}
?>
