<?php
include 'connection.php';

// ========================================
// QUERY PENDAPATAN HARI INI
// ========================================
$query_hari_ini = "SELECT 
    tanggal,
    total_transaksi,
    total_item_terjual,
    total_pendapatan,
    DATE_FORMAT(tanggal, '%d %M %Y') AS tanggal_format
FROM rekap_pendapatan
WHERE periode_type = 'harian' 
AND tanggal = CURDATE()";

$result_hari_ini = $conn->query($query_hari_ini);
$pendapatan_hari_ini = $result_hari_ini->fetch_assoc();

// ========================================
// QUERY PENDAPATAN MINGGU INI
// ========================================
$query_minggu_ini = "SELECT 
    tanggal AS minggu_mulai,
    DATE_ADD(tanggal, INTERVAL 6 DAY) AS minggu_selesai,
    total_transaksi,
    total_item_terjual,
    total_pendapatan,
    CONCAT(DATE_FORMAT(tanggal, '%d %M'), ' - ', 
           DATE_FORMAT(DATE_ADD(tanggal, INTERVAL 6 DAY), '%d %M %Y')) AS periode_format
FROM rekap_pendapatan
WHERE periode_type = 'mingguan'
AND tanggal = DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)";

$result_minggu_ini = $conn->query($query_minggu_ini);
$pendapatan_minggu_ini = $result_minggu_ini->fetch_assoc();

// ========================================
// QUERY PENDAPATAN BULAN INI
// ========================================
$query_bulan_ini = "SELECT 
    tanggal,
    total_transaksi,
    total_item_terjual,
    total_pendapatan,
    DATE_FORMAT(tanggal, '%M %Y') AS periode_format
FROM rekap_pendapatan
WHERE periode_type = 'bulanan'
AND tanggal = DATE_FORMAT(CURDATE(), '%Y-%m-01')";

$result_bulan_ini = $conn->query($query_bulan_ini);
$pendapatan_bulan_ini = $result_bulan_ini->fetch_assoc();

// ========================================
// QUERY GRAFIK 7 HARI TERAKHIR
// ========================================
$query_grafik = "SELECT 
    tanggal,
    total_pendapatan,
    total_transaksi,
    DATE_FORMAT(tanggal, '%a, %d %b') AS hari_format
FROM rekap_pendapatan
WHERE periode_type = 'harian'
AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
ORDER BY tanggal ASC";

$grafik_7_hari = $conn->query($query_grafik);

// ========================================
// QUERY TOP MENU HARI INI
// ========================================
$query_top_menu = "SELECT 
    m.id_menu,
    m.nama_menu,
    m.kategori_menu,
    m.harga,
    dp.jumlah_terjual,
    dp.total_pendapatan,
    dp.tanggal
FROM detail_pendapatan dp
JOIN menu m ON dp.id_menu = m.id_menu
WHERE dp.tanggal = CURDATE()
ORDER BY dp.jumlah_terjual DESC
LIMIT 5";

$top_menu = $conn->query($query_top_menu);

// ========================================
// QUERY STATISTIK KESELURUHAN (dari halaman profit)
// ========================================
$total_selesai = $conn->query("SELECT COUNT(*) as total FROM riwayat_pemesanan WHERE status_pesanan='selesai'")->fetch_assoc()['total'];
$total_batal = $conn->query("SELECT COUNT(*) as total FROM riwayat_pemesanan WHERE status_pesanan='batal'")->fetch_assoc()['total'];
$total_pending = $conn->query("SELECT COUNT(*) as total FROM detail_pesanan WHERE status_pesanan='pending'")->fetch_assoc()['total'];
$total_profit = $conn->query("SELECT SUM(subtotal) as total FROM riwayat_pemesanan WHERE status_pesanan='selesai'")->fetch_assoc()['total'] ?? 0;

// ========================================
// QUERY TOP 5 MENU TERLARIS (dari halaman profit)
// ========================================
$top_menu_all_time = $conn->query("
    SELECT 
        m.nama_menu,
        SUM(dp.jumlah) as total_terjual,
        SUM(dp.subtotal) as total_pendapatan
    FROM detail_pesanan dp
    JOIN menu m ON dp.id_menu = m.id_menu
    WHERE dp.status_pesanan != 'pending'
    GROUP BY dp.id_menu
    ORDER BY total_terjual DESC
    LIMIT 5
");

// Default values jika tidak ada data
if (!$pendapatan_hari_ini) {
    $pendapatan_hari_ini = ['total_pendapatan' => 0, 'total_transaksi' => 0, 'total_item_terjual' => 0, 'tanggal_format' => date('d M Y')];
}
if (!$pendapatan_minggu_ini) {
    $pendapatan_minggu_ini = ['total_pendapatan' => 0, 'total_transaksi' => 0, 'total_item_terjual' => 0, 'periode_format' => '-'];
}
if (!$pendapatan_bulan_ini) {
    $pendapatan_bulan_ini = ['total_pendapatan' => 0, 'total_transaksi' => 0, 'total_item_terjual' => 0, 'periode_format' => date('M Y')];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Pendapatan - Warung Mie Ayam</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    :root {
        --primary: #FEA116;
        --primary-dark: #e55c00;
        --secondary: #0F172B;
        --accent: #4CAF50;
        --danger: #f44336;
        --warning: #ff9800;
        --info: #2196F3;
        --light: #F1F8FF;
        --dark: #0F172B;
        --gray: #6c757d;
        --gray-light: #e9ecef;
        --border-radius: 10px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        color: var(--dark);
        line-height: 1.6;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        opacity: 0;
        transform: translateY(20px);
    }

    .container.show {
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--box-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header h1 {
        color: var(--light);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .header-buttons {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-back {
        background: var(--secondary);
        color: white;
        padding: 10px 20px;
        border-radius: var(--border-radius);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        font-weight: 600;
    }

    .btn-back:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-reset {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 10px 20px;
        border-radius: var(--border-radius);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .btn-reset:hover {
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    .section {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--box-shadow);
        margin-bottom: 30px;
    }

    .section h2 {
        color: var(--dark);
        margin: 0 0 20px 0;
        font-size: 24px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        padding-bottom: 10px;
    }

    .section h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary);
        border-radius: 2px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        opacity: 0;
        transform: translateY(20px);
    }

    .stat-card.show {
        animation: fadeInUp 0.5s ease forwards;
    }

    .stat-card:nth-child(1) { animation-delay: 0.2s; }
    .stat-card:nth-child(2) { animation-delay: 0.3s; }
    .stat-card:nth-child(3) { animation-delay: 0.4s; }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .stat-title {
        font-size: 14px;
        color: var(--gray);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
    }

    .stat-icon.primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    }

    .stat-icon.accent {
        background: linear-gradient(135deg, var(--accent), #388e3c);
    }

    .stat-icon.info {
        background: linear-gradient(135deg, var(--info), #0b7dda);
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--gray);
    }

    .stat-detail {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--gray-light);
    }

    .stat-detail-item {
        text-align: center;
    }

    .stat-detail-item strong {
        display: block;
        font-size: 18px;
        color: var(--dark);
    }

    .stat-detail-item span {
        font-size: 12px;
        color: var(--gray);
    }

    .chart-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--box-shadow);
        margin-bottom: 30px;
    }

    .chart-container h3 {
        margin: 0 0 20px 0;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .top-menu-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--box-shadow);
    }

    .top-menu-container h3 {
        margin: 0 0 20px 0;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .top-menu-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid var(--gray-light);
        transition: var(--transition);
    }

    .top-menu-item:last-child {
        border-bottom: none;
    }

    .top-menu-item:hover {
        background: rgba(254, 161, 22, 0.05);
    }

    .menu-rank {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .menu-info {
        flex: 1;
        margin-left: 15px;
    }

    .menu-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 3px;
    }

    .menu-category {
        font-size: 12px;
        color: var(--gray);
    }

    .menu-stats {
        text-align: right;
    }

    .menu-sales {
        font-weight: 700;
        color: var(--primary);
        font-size: 18px;
    }

    .menu-revenue {
        font-size: 12px;
        color: var(--gray);
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: var(--gray);
        font-style: italic;
    }

    .table-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-top: 20px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        min-width: 800px;
    }

    th, td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid var(--gray-light);
    }

    th {
        background: var(--primary);
        color: white;
        font-weight: 600;
        position: sticky;
        top: 0;
    }

    tr {
        transition: var(--transition);
    }

    tr:hover {
        background: rgba(255, 102, 0, 0.05);
        transform: scale(1.01);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-buttons {
            width: 100%;
            flex-direction: column;
        }

        .btn-back, .btn-reset {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-value {
            font-size: 28px;
        }

        .stat-detail {
            flex-direction: column;
            gap: 10px;
        }

        .menu-stats {
            text-align: left;
            margin-top: 10px;
        }
    }
</style>
</head>
<body>

<div class="container" id="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fa fa-chart-line"></i> Laporan Pendapatan Lengkap</h1>
        <div class="header-buttons">
            <a href="reset_pendapatan.php" class="btn-reset" onclick="return confirm('Apakah Anda yakin ingin mereset semua data pendapatan? Tindakan ini tidak dapat dibatalkan!')">
                <i class="fa fa-trash-alt"></i> Reset Pendapatan
            </a>
            <a href="admin_dashboard.php?page=menu" class="btn-back">
                <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Bagian Statistik & Keuntungan (dari halaman profit) -->
    <div class="section">
        <h2><i class='fa fa-chart-line'></i> Statistik & Keuntungan Keseluruhan</h2>
        
        <div class='stats-grid'>
            <div class='stat-card'>
                <div class='stat-header'>
                    <div class='stat-title'>Total Keuntungan</div>
                    <div class='stat-icon primary'>
                        <i class='fa fa-money-bill-wave'></i>
                    </div>
                </div>
                <div class='stat-value'>Rp <?= number_format($total_profit, 0, ',', '.') ?></div>
                <div class='stat-label'>Total pendapatan dari semua pesanan selesai</div>
            </div>
            
            <div class='stat-card'>
                <div class='stat-header'>
                    <div class='stat-title'>Pesanan Selesai</div>
                    <div class='stat-icon accent'>
                        <i class='fa fa-check-circle'></i>
                    </div>
                </div>
                <div class='stat-value'><?= $total_selesai ?></div>
                <div class='stat-label'>Total pesanan yang berhasil diselesaikan</div>
            </div>
            
            <div class='stat-card'>
                <div class='stat-header'>
                    <div class='stat-title'>Pesanan Pending</div>
                    <div class='stat-icon info'>
                        <i class='fa fa-clock'></i>
                    </div>
                </div>
                <div class='stat-value'><?= $total_pending ?></div>
                <div class='stat-label'>Pesanan yang sedang menunggu diproses</div>
            </div>
            
            <div class='stat-card'>
                <div class='stat-header'>
                    <div class='stat-title'>Pesanan Batal</div>
                    <div class='stat-icon danger'> 
                        <i class='fa fa-times-circle'></i>
                    </div>
                </div>
                <div class='stat-value'><?= $total_batal ?></div>
                <div class='stat-label'>Pesanan yang dibatalkan</div>
            </div>
        </div>

      

    <!-- Bagian Rekap Pendapatan Periodik -->
    <div class="section">
        <h2><i class="fa fa-receipt"></i> Rekap Pendapatan Periodik</h2>
        
        <div class="stats-grid">
            <!-- Pendapatan Hari Ini -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Pendapatan Hari Ini</div>
                    <div class="stat-icon primary">
                        <i class="fa fa-calendar-day"></i>
                    </div>
                </div>
                <div class="stat-value">Rp <?= number_format($pendapatan_hari_ini['total_pendapatan'], 0, ',', '.') ?></div>
                <div class="stat-label"><?= $pendapatan_hari_ini['tanggal_format'] ?></div>
                <div class="stat-detail">
                    <div class="stat-detail-item">
                        <strong><?= $pendapatan_hari_ini['total_transaksi'] ?></strong>
                        <span>Transaksi</span>
                    </div>
                    <div class="stat-detail-item">
                        <strong><?= $pendapatan_hari_ini['total_item_terjual'] ?></strong>
                        <span>Item Terjual</span>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Minggu Ini -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Pendapatan Minggu Ini</div>
                    <div class="stat-icon accent">
                        <i class="fa fa-calendar-week"></i>
                    </div>
                </div>
                <div class="stat-value">Rp <?= number_format($pendapatan_minggu_ini['total_pendapatan'], 0, ',', '.') ?></div>
                <div class="stat-label"><?= $pendapatan_minggu_ini['periode_format'] ?></div>
                <div class="stat-detail">
                    <div class="stat-detail-item">
                        <strong><?= $pendapatan_minggu_ini['total_transaksi'] ?></strong>
                        <span>Transaksi</span>
                    </div>
                    <div class="stat-detail-item">
                        <strong><?= $pendapatan_minggu_ini['total_item_terjual'] ?></strong>
                        <span>Item Terjual</span>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Pendapatan Bulan Ini</div>
                    <div class="stat-icon info">
                        <i class="fa fa-calendar-alt"></i>
                    </div>
                </div>
                <div class="stat-value">Rp <?= number_format($pendapatan_bulan_ini['total_pendapatan'], 0, ',', '.') ?></div>
                <div class="stat-label"><?= $pendapatan_bulan_ini['periode_format'] ?></div>
                <div class="stat-detail">
                    <div class="stat-detail-item">
                        <strong><?= $pendapatan_bulan_ini['total_transaksi'] ?></strong>
                        <span>Transaksi</span>
                    </div>
                    <div class="stat-detail-item">
                        <strong><?= $pendapatan_bulan_ini['total_item_terjual'] ?></strong>
                        <span>Item Terjual</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pendapatan 7 Hari -->
    <div class="chart-container">
        <h3><i class="fa fa-chart-area"></i> Grafik Pendapatan 7 Hari Terakhir</h3>
        <canvas id="chartPendapatan" height="80"></canvas>
    </div>

    <!-- Top 5 Menu Hari Ini -->
    <div class="top-menu-container">
        <h3><i class="fa fa-trophy"></i> Top 5 Menu Terlaris Hari Ini</h3>
        <?php if ($top_menu->num_rows > 0): ?>
            <?php $rank = 1; while ($menu = $top_menu->fetch_assoc()): ?>
                <div class="top-menu-item">
                    <div class="menu-rank"><?= $rank ?></div>
                    <div class="menu-info">
                        <div class="menu-name"><?= htmlspecialchars($menu['nama_menu']) ?></div>
                        <div class="menu-category"><?= htmlspecialchars($menu['kategori_menu']) ?> • Rp <?= number_format($menu['harga'], 0, ',', '.') ?></div>
                    </div>
                    <div class="menu-stats">
                        <div class="menu-sales"><?= $menu['jumlah_terjual'] ?> terjual</div>
                        <div class="menu-revenue">Rp <?= number_format($menu['total_pendapatan'], 0, ',', '.') ?></div>
                    </div>
                </div>
            <?php $rank++; endwhile; ?>
        <?php else: ?>
            <div class="no-data">
                <i class="fa fa-inbox" style="font-size: 48px; margin-bottom: 10px; opacity: 0.3;"></i>
                <p>Belum ada data penjualan hari ini</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Animasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Animasi container
    setTimeout(() => {
        document.getElementById('container').classList.add('show');
    }, 100);
    
    // Animasi stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('show');
        }, 300 + (index * 100));
    });
    
    // Data untuk chart
    const chartData = {
        labels: [
            <?php 
            $labels = [];
            while ($data = $grafik_7_hari->fetch_assoc()) {
                $labels[] = "'" . $data['hari_format'] . "'";
            }
            echo implode(', ', $labels);
            ?>
        ],
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: [
                <?php 
                $grafik_7_hari->data_seek(0);
                $values = [];
                while ($data = $grafik_7_hari->fetch_assoc()) {
                    $values[] = $data['total_pendapatan'];
                }
                echo implode(', ', $values);
                ?>
            ],
            backgroundColor: 'rgba(254, 161, 22, 0.1)',
            borderColor: 'rgba(254, 161, 22, 1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: '#FEA116',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointHoverRadius: 7
        }]
    };
    
    // Konfigurasi chart
    const config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 43, 0.9)',
                    padding: 12,
                    titleColor: '#FEA116',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    };
    
    // Render chart
    const ctx = document.getElementById('chartPendapatan').getContext('2d');
    new Chart(ctx, config);
});
</script>

</body>
</html>