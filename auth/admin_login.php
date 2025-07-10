<?php
session_start();
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email=? AND role='admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $admin = $result->fetch_assoc();
    if ($admin && password_verify($password, $admin["password"])) {
        $_SESSION["admin"] = $admin;
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        echo "Login gagal (bukan admin atau password salah)";
    }
}
?>

<form method="post">
  <input type="email" name="email" placeholder="Email Admin" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Login Admin</button>
</form>
