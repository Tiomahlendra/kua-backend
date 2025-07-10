<?php
include "koneksi.php";

// Tangkap data dari frontend React
$nama      = $_POST['nama'];
$nik       = $_POST['nik'];
$tanggal   = $_POST['tanggal'];
$layanan   = $_POST['layanan'];
$catatan   = $_POST['catatan'];

$sql = "INSERT INTO pengajuan (nama, nik, tanggal, layanan, catatan)
        VALUES ('$nama', '$nik', '$tanggal', '$layanan', '$catatan')";

if (mysqli_query($conn, $sql)) {
    echo "Berhasil disimpan!";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>
