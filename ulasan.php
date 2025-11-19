<?php
include 'connection.php'; // koneksi ke database

// Hapus data jika ada parameter ?hapus=id
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM ulasan WHERE id_ulasan = '$id'");
    echo "<script>alert('Pesan berhasil dihapus!'); window.location.href='ulasan.php';</script>";
    exit;
}

// Ambil semua data ulasan
$result = $conn->query("SELECT * FROM ulasan ORDER BY tanggal_ulasan DESC");

// Hitung statistik
$total_ulasan = $result->num_rows;
$query_hari_ini = $conn->query("SELECT COUNT(*) as total FROM ulasan WHERE DATE(tanggal_ulasan) = CURDATE()");
$ulasan_hari_ini = $query_hari_ini->fetch_assoc()['total'];
$query_minggu_ini = $conn->query("SELECT COUNT(*) as total FROM ulasan WHERE YEARWEEK(tanggal_ulasan, 1) = YEARWEEK(CURDATE(), 1)");
$ulasan_minggu_ini = $query_minggu_ini->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ulasan Pengunjung - Warung Mie Ayam</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            box-shadow: 0 4px 12px rgba(254, 161, 22, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
            font-size: 36px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--gray);
        }

        .table-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            overflow-x: auto;
        }

        .table-container h3 {
            margin: 0 0 20px 0;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ulasan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ulasan-table thead tr {
            background: linear-gradient(135deg, var(--secondary) 0%, #1e293b 100%);
            color: white;
        }

        .ulasan-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .ulasan-table tbody tr {
            border-bottom: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .ulasan-table tbody tr:hover {
            background: rgba(254, 161, 22, 0.05);
        }

        .ulasan-table td {
            padding: 15px;
            vertical-align: middle;
        }

        .no-badge {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .nama-user {
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nama-user i {
            color: var(--primary);
        }

        .pesan-text {
            color: var(--gray);
            line-height: 1.5;
            max-width: 500px;
        }

        .tanggal-badge {
            background: var(--light);
            color: var(--info);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger), #d32f2f);
            color: white;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
        }

        .no-data i {
            font-size: 64px;
            opacity: 0.3;
            margin-bottom: 15px;
        }

        .no-data p {
            font-size: 16px;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-container {
                padding: 15px;
            }

            .ulasan-table {
                font-size: 14px;
            }

            .ulasan-table th,
            .ulasan-table td {
                padding: 10px;
            }

            .pesan-text {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container" id="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fa fa-comments"></i> Data Ulasan Pengunjung</h1>
        <a href="admin_dashboard.php" class="btn-back">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Total Ulasan -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Total Ulasan</div>
                <div class="stat-icon primary">
                    <i class="fa fa-comment-dots"></i>
                </div>
            </div>
            <div class="stat-value"><?= $total_ulasan ?></div>
            <div class="stat-label">Semua Periode</div>
        </div>

        <!-- Ulasan Hari Ini -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Ulasan Hari Ini</div>
                <div class="stat-icon accent">
                    <i class="fa fa-calendar-day"></i>
                </div>
            </div>
            <div class="stat-value"><?= $ulasan_hari_ini ?></div>
            <div class="stat-label"><?= date('d M Y') ?></div>
        </div>

        <!-- Ulasan Minggu Ini -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Ulasan Minggu Ini</div>
                <div class="stat-icon info">
                    <i class="fa fa-calendar-week"></i>
                </div>
            </div>
            <div class="stat-value"><?= $ulasan_minggu_ini ?></div>
            <div class="stat-label">7 Hari Terakhir</div>
        </div>
    </div>

    <!-- Tabel Ulasan -->
    <div class="table-container">
        <h3><i class="fa fa-list"></i> Daftar Ulasan</h3>
        
        <?php if ($result->num_rows > 0): ?>
            <table class="ulasan-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th style="width: 200px;">Nama</th>
                        <th>Pesan</th>
                        <th style="width: 180px;">Tanggal</th>
                        <th style="width: 100px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td style="text-align: center;">
                            <span class="no-badge"><?= $no ?></span>
                        </td>
                        <td>
                            <div class="nama-user">
                                <i class="fa fa-user-circle"></i>
                                <?= htmlspecialchars($row['nama_pengguna']) ?>
                            </div>
                        </td>
                        <td>
                            <div class="pesan-text">
                                <?= htmlspecialchars($row['pesan']) ?>
                            </div>
                        </td>
                        <td>
                            <span class="tanggal-badge">
                                <i class="fa fa-clock"></i>
                                <?= date('d M Y, H:i', strtotime($row['tanggal_ulasan'])) ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="ulasan.php?hapus=<?= $row['id_ulasan'] ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Yakin ingin hapus pesan ini?');">
                                <i class="fa fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php 
                    $no++;
                    endwhile; 
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <i class="fa fa-inbox"></i>
                <p>Belum ada ulasan dari pengunjung</p>
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
});
</script>

</body>
</html>