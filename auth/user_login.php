<?php
// ✅ CORS header agar bisa diakses dari React (localhost:8080)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// ✅ Koneksi DB
include '../koneksi.php';

// ✅ Ambil data dari frontend (React)
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['username']; // dikirim dari form, tapi field-nya email
$password = $data['password'];

// ✅ Ambil user berdasarkan email
$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

// ✅ Cek user dan password
if ($user && password_verify($password, $user['password'])) {
  echo json_encode(["success" => true, "role" => $user['role']]);
} else {
  echo json_encode(["success" => false, "message" => "Email atau password salah"]);
}
?>
