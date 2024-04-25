<?php
session_start();

// Inisialisasi array untuk menyimpan data barang
if (!isset($_SESSION['items'])) {
  $_SESSION['items'] = array();
}

// Fungsi untuk menambah data barang
function tambahBarang($nama, $harga, $jumlah) {
  $_SESSION['items'][] = array(
    'nama' => $nama,
    'harga' => $harga,
    'jumlah' => $jumlah,
    'total' => $harga * $jumlah
  );
}

// Fungsi untuk menghapus data barang berdasarkan indeks
function hapusBarang($index) {
  if (isset($_SESSION['items'][$index])) {
    unset($_SESSION['items'][$index]);
  }
}

// Fungsi untuk menghitung total harga dari barang-barang
function hitung() {
  $total = 0;
  foreach ($_SESSION['items'] as $item) {
    $total += $item['total'];
  }
  return $total;
}

// Menambahkan data barang baru jika tombol submit ditekan
if (isset($_POST['submit']) && isset($_POST['nama']) && isset($_POST['jumlah']) && isset($_POST['harga'])) {
  $nama = $_POST['nama'];
  $jumlah = (int)$_POST['jumlah'];
  $harga = (int)$_POST['harga'];
  tambahBarang($nama, $harga, $jumlah);
}

// Menghapus data barang berdasarkan indeks
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
  $index = (int)$_GET['hapus'];
  hapusBarang($index);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ByMarvell</title>
  <link rel="stylesheet" href="vell.css">
</head>
<body>
  <div class="satu">
  <h1>Form Input Barang</h1>
  <form action="index.php" method="post">
    <label for="nama">Nama Barang:</label>
    <input type="text" id="nama" name="nama" required><br>

    <label for="jumlah">Jumlah Barang:</label>
    <input type="number" id="jumlah" name="jumlah" required><br>

    <label for="harga">Harga Barang:</label>
    <input type="number" id="harga" name="harga" required><br>

    <button type="submit" name="submit">Tambahkan ke Keranjang</button>
  </form>
  </div>
  

  <h2>Keranjang Belanja</h2>
  <table>
    <thead>
      <tr>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Total</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Menampilkan data barang
      $total = hitung();
      foreach ($_SESSION['items'] as $index => $item) {
        echo "<tr>";
        echo "<td>" . $item['nama'] . "</td>";
        echo "<td>" . $item['jumlah'] . "</td>";
        echo "<td>" . $item['harga'] . "</td>";
        echo "<td>" . $item['total'] . "</td>";
        echo "<td><a href='index.php?hapus=$index'>Hapus</a></td>";
        echo "</tr>";
      }
      ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3">Total</th>
        <th><?php echo $total; ?></th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
