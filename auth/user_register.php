<?php
header("Access-Control-Allow-Origin: *"); // 🔥 izinkan dari semua origin (frontend React-mu)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include "../koneksi.php"; // ✅ path benar


$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"];
$nama = $data["nama"];
$nik = $data["nik"];
$password = password_hash($data["password"], PASSWORD_DEFAULT);
$plain_password = $data['password'];
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);


// Cek apakah user sudah terdaftar
$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' OR nik='$nik'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(["success" => false, "message" => "Email atau NIK sudah digunakan."]);
    exit;
}

// Simpan ke DB
$query = "INSERT INTO users (email, nama, nik, password, plain_password) 
          VALUES ('$email', '$nama', '$nik', '$hashed_password', '$plain_password')";
if (mysqli_query($conn, $query)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal menyimpan ke database."]);
}
?>
