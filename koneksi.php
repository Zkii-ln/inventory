<?php
$host = "localhost";
$user = "root";       
$pass = "";           
$db   = "inventory";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Mengecek koneksi berhasil atau tidak
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} 
?>