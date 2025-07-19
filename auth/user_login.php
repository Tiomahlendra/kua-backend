<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new mysqli("localhost", "root", "", "kua");

$data = json_decode(file_get_contents("php://input"), true);

$email = $data["username"];
$password = $data["password"];

$response = [];

$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user["password"])) {
       $response["success"] = true;
        $response["user"] = [
    "id" => $user["id"],
    "nama" => $user["nama"],
    "email" => $user["email"],
    "nik" => $user["nik"],
    "role" => $user["role"]
];

    } else {
        $response["success"] = false;
        $response["message"] = "Password salah.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Akun tidak ditemukan.";
}

echo json_encode($response);
?>
