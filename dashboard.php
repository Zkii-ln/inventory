<?php
include 'koneksi.php';

// Total semua barang
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(quantity) AS total FROM barang"))['total'] ?? 0;

// Jumlah peminjaman dengan status Dipinjam
$dipinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM peminjaman WHERE status='Dipinjam'"))['total'] ?? 0;

// Jumlah barang rusak
$rusak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang WHERE kondisi='Rusak'"))['total'] ?? 0;

// Jumlah peminjaman yang dikembalikan
$dikembalikan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM peminjaman WHERE status='Dikembalikan'"))['total'] ?? 0;

echo json_encode([
  'total_barang' => $total_barang,
  'dipinjam' => $dipinjam,
  'rusak' => $rusak,
  'dikembalikan' => $dikembalikan
]);
?>
