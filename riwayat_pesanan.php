<?php
include 'connection.php';

// Ambil data grup berdasarkan nama pemesan
$query = "
    SELECT 
        r.nama_pemesan,
        GROUP_CONCAT(DISTINCT m.nama_menu SEPARATOR ', ') AS item,
        SUM(r.jumlah) AS total_item,
        SUM(r.subtotal) AS total_harga,
        r.status_pesanan,
        MAX(r.waktu) AS waktu
    FROM riwayat_pemesanan r
    LEFT JOIN menu m ON r.id_menu = m.id_menu
    GROUP BY r.nama_pemesan, r.status_pesanan
    ORDER BY waktu DESC
";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">Riwayat Pemesanan</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Pemesan</th>
                        <th>Item</th>
                        <th>Jumlah Item</th>
                        <th>Total (Rp)</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
                                <td><?= htmlspecialchars($row['item'] ?? '-'); ?></td>
                                <td><?= $row['total_item']; ?></td>
                                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($row['status_pesanan'] == 'selesai'): ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Batal</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d-m-Y H:i', strtotime($row['waktu'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-muted">Belum ada riwayat pemesanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="menu.php" class="btn btn-outline-primary">Kembali ke Menu</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
