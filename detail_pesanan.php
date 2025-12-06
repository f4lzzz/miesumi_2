<?php
include 'connection.php';

// Query yang lebih sederhana
$result = $conn->query("
    SELECT 
        dp.nama_pemesan,
        GROUP_CONCAT(CONCAT(m.nama_menu, ' (', dp.jumlah, ' porsi)') SEPARATOR ', ') as items_detail,
        GROUP_CONCAT(CONCAT('Rp', FORMAT(dp.subtotal, 0)) SEPARATOR ', ') as subtotals_detail,
        SUM(dp.jumlah) as total_jumlah,
        SUM(dp.subtotal) as total_harga,
        dp.status_pesanan,
        dp.waktu
    FROM detail_pesanan dp
    JOIN menu m ON dp.id_menu = m.id_menu
    WHERE dp.status_pesanan = 'pending'
    GROUP BY dp.nama_pemesan, dp.status_pesanan
    ORDER BY dp.waktu DESC
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
                        <th>Item Pesanan</th>
                        <th>Jumlah per Item</th>
                        <th>Total Item</th>
                        <th>Total Harga (Rp)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        $items = explode(', ', $row['items_detail']);
                        $subtotals = explode(', ', $row['subtotals_detail']);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
                        <td class="text-start">
                            <?php foreach($items as $index => $item): ?>
                                <div class="mb-1">
                                    <strong><?= htmlspecialchars($item); ?></strong><br>
                                    <small class="text-muted"><?= $subtotals[$index] ?? ''; ?></small>
                                </div>
                            <?php endforeach; ?>
                        </td>
                        <td class="text-start">
                            <?php foreach($items as $item): ?>
                                <div class="mb-1">
                                    <?= preg_replace('/.*\((\d+).*\)/', '$1 porsi', $item); ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                        <td><?= $row['total_jumlah']; ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge bg-<?= $row['status_pesanan'] == 'pending' ? 'warning' : ($row['status_pesanan'] == 'selesai' ? 'success' : 'danger') ?>">
                                <?= ucfirst($row['status_pesanan']); ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="update_pesanan_group.php" class="d-inline">
                                <input type="hidden" name="nama_pemesan" value="<?= htmlspecialchars($row['nama_pemesan']); ?>">
                                <div class="d-flex flex-column gap-2">
                                    <button type="submit" name="aksi" value="selesai" 
                                            class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                    <button type="submit" name="aksi" value="batal" 
                                            class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Batal
                                    </button>
                                </div>
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