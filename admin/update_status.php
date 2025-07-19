<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Ambil input JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['status'])) {
    echo json_encode(["status" => "error", "message" => "ID dan status harus dikirim"]);
    exit;
}

include '../koneksi.php';

$id = $data['id'];
$status = $data['status'];

$query = "UPDATE layanan SET status = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Status berhasil diupdate"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal mengupdate status"]);
}
?>
