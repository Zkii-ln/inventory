<?php
include 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_barang = mysqli_real_escape_string($conn, $_POST['id_barang']);
    $id_guru = mysqli_real_escape_string($conn, $_POST['id_guru']);
    $id_kelas = mysqli_real_escape_string($conn, $_POST['id_kelas']);
    $tgl_pinjam = mysqli_real_escape_string($conn, $_POST['tgl_pinjam']);
    $tgl_kembali = mysqli_real_escape_string($conn, $_POST['tgl_kembali']);
    $status = 'Dipinjam';
    $quantity = $_POST['quantity'];

    // Cek stok
    $cek = mysqli_query($conn, "SELECT quantity FROM barang WHERE id_barang = '$id_barang'");
    $barang = mysqli_fetch_assoc($cek);

    if (!$barang) {
        echo "<script>alert('Barang tidak ditemukan!'); window.location='tambah_peminjaman.php';</script>";
        exit;
    }

    if ($barang['quantity'] <= 0) {
        echo "<script>alert('Stok barang habis!'); window.location='tambah_peminjaman.php';</script>";
        exit;
    }

    if ($quantity > $barang['quantity']) {
        echo "<script>alert('Jumlah pinjam melebihi stok yang tersedia! Stok saat ini: {$barang['quantity']}'); window.location='tambah_peminjaman.php';</script>";
        exit;
    }

    // Kurangi stok
    mysqli_query($conn, "UPDATE barang SET quantity = quantity - $quantity WHERE id_barang = '$id_barang'");

    $id_user = $_SESSION['id_user']; 

    $query = "INSERT INTO peminjaman (id_user, id_barang, id_guru, id_kelas, tgl_pinjam, tgl_kembali, quantity, status)
              VALUES ('$id_user','$id_barang', '$id_guru','$id_kelas', '$tgl_pinjam', '$tgl_kembali', '$quantity', '$status')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Peminjaman berhasil ditambahkan!'); window.location='tambah_peminjaman.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah peminjaman!'); window.location='tambah_peminjaman.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory Sekolah</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="wrapper">
    <aside id="sidebar">
      <div class="d-flex">
        <button id="toggle-btn" type="button">
          <i class="lni lni-menu-hamburger-1"></i>
        </button>
        <div class="sidebar-logo">
          <a href="">EduInventory</a>
        </div>
      </div>
      <ul class="sidebar-nav">
        <li class="sidebar-item">
          <a href="users.php" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg>
            <span>Profile</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="users.php" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16">
              <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 2h-4v3h4zm0 4h-4v3h4zm0 4h-4v3h3a1 1 0 0 0 1-1zm-5 3v-3H6v3zm-5 0v-3H1v2a1 1 0 0 0 1 1zm-4-4h4V8H1zm0-4h4V4H1zm5-3v3h4V4zm4 4H6v3h4z"/>
            </svg>
            <span>Data Barang</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="tambah_peminjaman.php" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket3-fill" viewBox="0 0 16 16">
              <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.468 15.426.943 9h14.114l-1.525 6.426a.75.75 0 0 1-.729.574H3.197a.75.75 0 0 1-.73-.574z"/>
            </svg>
            <span>Daftar Barang</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="tambah_barang.php" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
              <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
            </svg>
            <span>Tambah Barang</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="users.php" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
              <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
              <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
              <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
            </svg>
            <span>History</span>
          </a>
        </li>
      </ul>
      <div class="sidebar-footer">
        <a href="home.html" class="sidebar-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
          </svg>
          <span>Logout</span>
        </a>
      </div>
    </aside>
    <main class="p-3">
    <div id="peminjaman" class="page">
      <h3 class="mb-3">Peminjaman Barang</h3>

      <!-- Tombol Tambah (buka modal) -->
      <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Peminjaman
      </button>

      <!-- Modal Form Tambah -->
      <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="modalTambahLabel">Tambah Peminjaman</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="tambah_peminjaman.php" method="POST">
              <div class="modal-body">

                <div class="mb-3">
                  <label for="id_barang" class="form-label">Pilih Barang</label>
                  <select name="id_barang" id="id_barang" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    $barang = mysqli_query($conn, "SELECT * FROM barang");
                    while ($b = mysqli_fetch_assoc($barang)) {
                      echo "<option value='{$b['id_barang']}'>{$b['nama_barang']} (stok: {$b['quantity']})</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
                  <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                  <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label for="quantity" class="form-label">Jumlah</label>
                  <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                  <label for="id_guru" class="form-label">Guru Penanggung Jawab</label>
                  <select name="id_guru" id="id_guru" class="form-select" required>
                    <option value="">-- Pilih Guru --</option>
                    <?php
                    $guru = mysqli_query($conn, "SELECT * FROM guru");
                    while ($g = mysqli_fetch_assoc($guru)) {
                      echo "<option value='{$g['id_guru']}'>{$g['nama_guru']}</option>";
                    }?>
                  </select>
                </div>

                 <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select name="id_kelas" id="id_kelas" class="form-control" required>
              <option value="">-- Pilih Kelas --</option>
              <?php
                    $kelas = mysqli_query($conn, "SELECT * FROM kelas");
                    while ($k = mysqli_fetch_assoc($kelas)) {
                      echo "<option value='{$k['id_kelas']}'>{$k['tingkat']} {$k['nama_kelas']}</option>";
                    }?>
            </select>
          </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>

          </div>
        </div>
      </div>

      <!-- Tabel Data Peminjaman -->
      <div class="card">
        <div class="card-header bg-secondary text-white">Data Peminjaman</div>
        <div class="card-body">
          <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Jumlah</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "
                SELECT p.*, b.nama_barang, g.nama_guru, k.nama_kelas
                FROM peminjaman p
                JOIN barang b ON p.id_barang = b.id_barang
                JOIN guru g ON p.id_guru = g.id_guru
                JOIN kelas k ON p.id_kelas = k.id_kelas
              ";
              $result = mysqli_query($conn, $query);
              $no = 1;

              if (mysqli_num_rows($result) > 0) {
                while ($p = mysqli_fetch_assoc($result)) {
                  echo "<tr>
                          <td>{$no}</td>
                          <td>{$p['nama_barang']}</td>
                          <td>{$p['tgl_pinjam']}</td>
                          <td>{$p['tgl_kembali']}</td>
                          <td>{$p['quantity']}</td>
                          <td>{$p['nama_guru']}</td>
                          <td>{$p['nama_kelas']}</td>
                          <td><span class='badge " . ($p['status'] == 'Dikembalikan' ? 'bg-success' : 'bg-warning text-dark') . "'>{$p['status']}</span></td>
                          <td>";
                  if ($p['status'] == 'Dipinjam') {
                    echo "<a href='kembalikan_barang.php?id={$p['id_peminjaman']}' 
                            class='btn btn-sm btn-primary' 
                            onclick='return confirm(\"Yakin ingin mengembalikan barang ini?\")'>Kembalikan</a>";
                  } else {
                    echo "<span class='text-muted'>Selesai</span>";
                  }
                  echo "</td></tr>";
                  $no++;
                }
              } else {
                echo "<tr><td colspan='7'>Belum ada peminjaman.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
