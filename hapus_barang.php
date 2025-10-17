<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM barang WHERE id_barang=$id";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Barang berhasil dihapus!');
                window.location.href = 'users.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus barang: " . mysqli_error($conn) . "');
                window.location.href = 'users.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID barang tidak ditemukan!');
            window.location.href = 'users.php';
          </script>";
}
?>
