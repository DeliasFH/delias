<?php
$host = "localhost";
$username = "root"; // default XAMPP
$password = ""; // default XAMPP kosong
$database = "sekolah_app"; // ganti dengan nama database Anda

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>