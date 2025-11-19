<?php
include 'connection.php';

// Jika admin menyelesaikan pesanan
if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];
    mysqli_query($conn, "DELETE FROM detail_pesanan WHERE id_pesanan='$id'");
    echo "<script>alert('Pesanan selesai!');window.location='admin_detail_pesanan.php';</script>";
    exit;
}

// Jika admin membatalkan pesanan
if (isset($_GET['batal'])) {
    $id = $_GET['batal'];

    // Kembalikan stok ke tabel menu
    $detail = mysqli_query($conn, "SELECT id_menu, jumlah FROM detail_pesanan WHERE id_pesanan='$id'");
    while ($row = mysqli_fetch_assoc($detail)) {
        mysqli_query($conn, "UPDATE menu SET stok_menu = stok_menu + {$row['jumlah']} WHERE id_menu='{$row['id_menu']}'");
    }

    // Hapus dari detail_pesanan
    mysqli_query($conn, "DELETE FROM detail_pesanan WHERE id_pesanan='$id'");

    // Pindahkan ke riwayat
    mysqli_query($conn, "
      INSERT INTO riwayat_pemesanan (id_pesanan, id_menu, nama_pemesan, jumlah, subtotal, status_pesanan, keterangan)
      SELECT id_pesanan, id_menu, nama_pemesan, jumlah, subtotal, 'dibatalkan', 'Pesanan dibatalkan oleh admin'
      FROM detail_pesanan WHERE id_pesanan='$id'
    ");

    echo "<script>alert('Pesanan dibatalkan!');window.location='admin_detail_pesanan.php';</script>";
    exit;
}

// Ambil semua pesanan aktif
$result = mysqli_query($conn, "
  SELECT d.id_pesanan, d.nama_pemesan, m.nama_menu, d.jumlah, d.subtotal
  FROM detail_pesanan d
  JOIN menu m ON d.id_menu = m.id_menu
  ORDER BY d.id_pesanan DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pesanan | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-success text-white">
      <h4 class="mb-0">📋 Daftar Pesanan Pelanggan</h4>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped text-center">
        <thead class="table-success">
          <tr>
            <th>No</th>
            <th>Nama Pemesan</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
              <td><?= htmlspecialchars($row['nama_menu']); ?></td>
              <td><?= $row['jumlah']; ?></td>
              <td>Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
              <td>
                <a href="?selesai=<?= $row['id_pesanan']; ?>" class="btn btn-success btn-sm"
                   onclick="return confirm('Tandai pesanan ini selesai?')">✅ Selesai</a>
                <a href="?batal=<?= $row['id_pesanan']; ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Batalkan pesanan ini?')">❌ Batal</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <div class="text-center mt-3">
        <a href="riwayat_pemesanan.php" class="btn btn-outline-primary">📜 Lihat Riwayat Pemesanan</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
