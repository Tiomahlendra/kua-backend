<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

$host = "localhost";
$user = "root";
$pass = "";
$db = "kua";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Koneksi database gagal"]);
  exit();
}

// Ambil semua data pengajuan layanan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $sql = "SELECT layanan.*, users.nama FROM layanan JOIN users ON layanan.user_id = users.id ORDER BY tanggal_pengajuan DESC";
  $result = $conn->query($sql);

  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }

  echo json_encode($data);
  exit();
}

// Update status pengajuan (Disetujui, Ditolak, dst)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents("php://input"), true);
  $id = $conn->real_escape_string($input['id']);
  $status = $conn->real_escape_string($input['status']);
  $alasan = isset($input['alasan_penolakan']) ? $conn->real_escape_string($input['alasan_penolakan']) : null;

  $query = "UPDATE layanan SET status='$status', alasan_penolakan=" . ($alasan ? "'$alasan'" : "NULL") . " WHERE id=$id";

  if ($conn->query($query)) {
    echo json_encode(["message" => "Status berhasil diperbarui."]);
  } else {
    http_response_code(500);
    echo json_encode(["error" => "Gagal mengupdate status."]);
  }
  exit();
}
