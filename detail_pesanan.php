<?php
include 'connection.php';

$result = $conn->query("
    SELECT nama_pemesan, GROUP_CONCAT(m.nama_menu SEPARATOR ', ') AS item, 
           SUM(dp.jumlah) AS total_item, SUM(dp.subtotal) AS total_harga, dp.status_pesanan
    FROM detail_pesanan dp
    JOIN menu m ON dp.id_menu = m.id_menu
    GROUP BY dp.nama_pemesan
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-warning text-white text-center">
            <h4 class="mb-0">Detail Pesanan</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Pemesan</th>
                        <th>Item</th>
                        <th>Total Item</th>
                        <th>Total Harga (Rp)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
                        <td><?= htmlspecialchars($row['item']); ?></td>
                        <td><?= $row['total_item']; ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge bg-<?= $row['status_pesanan'] == 'pending' ? 'warning' : ($row['status_pesanan'] == 'selesai' ? 'success' : 'danger') ?>">
                                <?= ucfirst($row['status_pesanan']); ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="update_pesanan.php" class="d-inline">
                                <input type="hidden" name="nama_pemesan" value="<?= htmlspecialchars($row['nama_pemesan']); ?>">
                                <button type="submit" name="aksi" value="selesai" class="btn btn-success btn-sm">Selesai</button>
                                <button type="submit" name="aksi" value="batal" class="btn btn-danger btn-sm">Batal</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
