<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_barang = intval($_POST['id_barang']);
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $id_kategori = intval($_POST['id_kategori']);
    $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);
    $quantity = intval($_POST['quantity']);

    $query = "UPDATE barang 
              SET  nama_barang='$nama_barang', id_kategori=$id_kategori, kondisi='$kondisi', quantity=$quantity 
              WHERE id_barang=$id_barang";
              
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data barang berhasil diupdate!');
                window.location.href = 'tambah_barang.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengupdate barang: " . mysqli_error($conn) . "');
                window.location.href = 'tambah_barang.php';
              </script>";
    }
}
?>
