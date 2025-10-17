<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $kondisi = $_POST['kondisi'];
    $quantity = $_POST['quantity'];

    // Ambil kode terakhir dari database
    $queryKode = mysqli_query($conn, "SELECT kode FROM barang ORDER BY id_barang DESC LIMIT 1");
    $lastKode = mysqli_fetch_assoc($queryKode);

    if ($lastKode) {
        // Ambil angka dari kode terakhir (misal BR005 -> 5)
        $lastNumber = (int)substr($lastKode['kode'], 2);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // Kalau belum ada data
    }
    $kode = "BR" . str_pad($newNumber, 3, "0", STR_PAD_LEFT);

    // Insert ke database
    $query = "INSERT INTO barang (kode, nama_barang, id_kategori, kondisi, quantity)
              VALUES ('$kode', '$nama_barang', '$id_kategori', '$kondisi', '$quantity')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Barang berhasil ditambahkan dengan kode $kode!');window.location='tambah_barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan barang.');window.location='tambah_barang.php';</script>";
    }
}
?>
<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory Sekolah</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">
</head>
<body>
  <!-- Sidebar -->
   <div class="wrapper">
    <aside id="sidebar">
      <div class="d-flex">
        <button id="toggle-btn" type="button">
          <i class="lni lni-menu-hamburger-1"></i>
        </button>
        <div class="sidebar-logo">
          <a href="users.php">EduInventory</a>
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
    <div id="barang" class="page">
      <div class="d-flex justify-content-center align-items-center mb-3">
        <h3>Tambah Barang</h3>
      </div>

      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Kondisi</th>
            <th>Quantity</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_query($conn, "SELECT b.*, k.nama_kategori FROM barang b LEFT JOIN kategori k ON b.id_kategori=k.id_kategori");
          if (mysqli_num_rows($query) == 0) {
            echo "<tr><td colspan='6' class='text-center text-muted'>Belum ada data.</td></tr>";
          }
          while ($r = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <td><?= htmlspecialchars($r['kode'] ?? '-') ?></td>
            <td><?= htmlspecialchars($r['nama_barang'] ?? '-') ?></td>
            <td><?= htmlspecialchars($r['nama_kategori'] ?? '-') ?></td>
            <td><?= htmlspecialchars($r['kondisi'] ?? '-') ?></td>
            <td><?= htmlspecialchars($r['quantity'] ?? '0') ?></td>
            <td class="text-center">
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                data-bs-target="#modalEdit<?= $r['id_barang'] ?>">Edit</button>
              <a href="hapus_barang.php?id=<?= $r['id_barang'] ?>" 
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
            </td>
          </tr>

          <!-- Modal Edit -->
          <div class="modal fade" id="modalEdit<?= $r['id_barang'] ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="edit_barang.php" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
  <input type="hidden" name="id_barang" value="<?= $r['id_barang'] ?>">
  <div class="mb-3">
  <label class="form-label">Kode</label>
  <input type="text" name="kode" class="form-control" 
         value="<?= htmlspecialchars($r['kode']) ?>" required readonly>
</div>

  <div class="mb-3">
    <label class="form-label">Nama Barang</label>
    <input type="text" name="nama_barang" class="form-control" value="<?= $r['nama_barang'] ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="id_kategori" class="form-select" required>
      <?php
      $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
      while ($k = mysqli_fetch_assoc($kategori)) {
          $selected = ($k['id_kategori'] == $r['id_kategori']) ? 'selected' : '';
          echo "<option value='{$k['id_kategori']}' $selected>{$k['nama_kategori']}</option>";
      }
      ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Kondisi</label>
    <select name="kondisi" class="form-select">
      <option <?= $r['kondisi']=="Baik"?"selected":"" ?>>Baik</option>
      <option <?= $r['kondisi']=="Rusak"?"selected":"" ?>>Rusak</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Quantity</label>
    <input type="number" name="quantity" class="form-control" value="<?= $r['quantity'] ?>" required>
  </div>
</div>

                  <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php } ?>
        </tbody>
      </table>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Barang</button>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="tambah_barang.php" method="POST">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Barang</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
  <div class="mb-3">
    <label class="form-label">Nama Barang</label>
    <input type="text" name="nama_barang" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="id_kategori" class="form-select" required>
      <option value="">-- Pilih Kategori --</option>
      <?php
      $kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
      while ($k = mysqli_fetch_assoc($kategori)) {
          echo "<option value='{$k['id_kategori']}'>{$k['nama_kategori']}</option>";
      }
      ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Kondisi</label>
    <select name="kondisi" class="form-select">
      <option>Baik</option>
      <option>Rusak</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Quantity</label>
    <input type="number" name="quantity" class="form-control" min="1" required>
  </div>
</div>

            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
   </main>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>

