<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];

    // Ambil data peminjaman
    $query = mysqli_query($conn, "
        SELECT id_barang, quantity, status 
        FROM peminjaman 
        WHERE id_peminjaman = '$id_peminjaman'
    ");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Data peminjaman tidak ditemukan!'); window.location='tambah_peminjaman.php';</script>";
        exit;
    }

    // Pastikan belum dikembalikan
    if ($data['status'] == 'Dikembalikan') {
        echo "<script>alert('Barang sudah dikembalikan sebelumnya!'); window.location='tambah_peminjaman.php';</script>";
        exit;
    }

    $id_barang = $data['id_barang'];
    $jumlah = $data['quantity'];

    // Update status peminjaman
    $update_peminjaman = mysqli_query($conn, "
        UPDATE peminjaman 
        SET status = 'Dikembalikan' 
        WHERE id_peminjaman = '$id_peminjaman'
    ");

    if ($update_peminjaman) {
        // Tambahkan kembali stok barang
        mysqli_query($conn, "
            UPDATE barang 
            SET quantity = quantity + $jumlah 
            WHERE id_barang = '$id_barang'
        ");

        echo "<script>alert('Barang berhasil dikembalikan!'); window.location='tambah_peminjaman.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status peminjaman!'); window.location='tambah_peminjaman.php';</script>";
    }
} else {
    echo "<script>alert('ID peminjaman tidak ditemukan!'); window.location='tambah_peminjaman.php';</script>";
}
?>
