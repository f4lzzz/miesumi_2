<?php
include 'connection.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'menu';

// Handle logout
if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header('Location: login.php'); // Ganti dengan halaman login Anda
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin - Warung Mie Ayam</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* CSS Variables */
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

    /* Base Styles */
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
        display: flex;
        flex-direction: column;
        opacity: 0;
    }

    body.loaded {
        animation: fadeIn 0.5s ease forwards;
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    /* Header Styles */
    header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--box-shadow);
        position: sticky;
        top: 0;
        z-index: 100;
        opacity: 0;
        transform: translateY(-20px);
    }

    header.show {
        animation: slideDown 0.6s ease forwards;
    }

    @keyframes slideDown {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Header Actions (Logout) */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-logout {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 8px 16px;
        border-radius: var(--border-radius);
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: var(--transition);
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-logout:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-logout:active {
        transform: translateY(0);
    }

    /* Navigation Styles */
    nav {
        background: var(--secondary);
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 12px 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 68px;
        z-index: 99;
        opacity: 0;
        transform: translateY(-10px);
    }

    nav.show {
        animation: slideDown 0.6s ease 0.2s forwards;
    }

    nav a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }

    nav a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: var(--transition);
    }

    nav a:hover::before {
        left: 0;
    }

    nav a.active, nav a:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Mobile Menu Button */
    .mobile-menu-btn {
        display: none;
        background: transparent;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: var(--transition);
    }

    .mobile-menu-btn:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* Mobile Navigation Overlay */
    .mobile-nav-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        opacity: 0;
        transition: var(--transition);
    }

    .mobile-nav-overlay.active {
        opacity: 1;
    }

    .mobile-nav {
        position: fixed;
        top: 0;
        right: -300px;
        width: 300px;
        height: 100%;
        background: var(--secondary);
        z-index: 1001;
        overflow-y: auto;
        transition: var(--transition);
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.3);
    }

    .mobile-nav.active {
        right: 0;
    }

    .mobile-nav-header {
        background: var(--primary);
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .mobile-nav-header h3 {
        margin: 0;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .mobile-nav-close {
        background: transparent;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: var(--transition);
    }

    .mobile-nav-close:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .mobile-nav-links {
        padding: 20px 0;
    }

    .mobile-nav-links a {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .mobile-nav-links a:hover {
        background: var(--primary);
    }

    .mobile-nav-links a.active {
        background: var(--primary);
        border-left: 4px solid white;
    }

    /* Container Styles */
    .container {
        padding: 25px;
        flex: 1;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        opacity: 0;
        transform: translateY(20px);
    }

    .container.show {
        animation: fadeInUp 0.6s ease 0.4s forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h2 {
        color: var(--dark);
        margin: 0 0 20px 0;
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        padding-bottom: 10px;
    }

    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary);
        border-radius: 2px;
    }

    /* Stats Card untuk Profit */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--box-shadow);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: var(--transition);
        opacity: 0;
        transform: translateY(20px);
    }

    .stat-card.show {
        animation: fadeInUp 0.5s ease forwards;
    }

    .stat-card:nth-child(1) { animation-delay: 0.5s; }
    .stat-card:nth-child(2) { animation-delay: 0.6s; }
    .stat-card:nth-child(3) { animation-delay: 0.7s; }
    .stat-card:nth-child(4) { animation-delay: 0.8s; }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-icon.primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); }
    .stat-icon.accent { background: linear-gradient(135deg, var(--accent), #388e3c); }
    .stat-icon.info { background: linear-gradient(135deg, var(--info), #0b7dda); }
    .stat-icon.danger { background: linear-gradient(135deg, var(--danger), #d32f2f); }

    .stat-content h3 {
        margin: 0;
        color: var(--gray);
        font-size: 14px;
        font-weight: 500;
    }

    .stat-content p {
        margin: 5px 0 0 0;
        font-size: 24px;
        font-weight: 700;
        color: var(--dark);
    }

    /* Table Styles */
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

    /* Button Styles */
    .btn {
        padding: 10px 16px;
        border-radius: var(--border-radius);
        border: none;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: var(--transition);
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-edit {
        background: var(--info);
    }

    .btn-edit:hover {
        background: #0b7dda;
    }

    .btn-delete {
        background: var(--danger);
    }

    .btn-delete:hover {
        background: #d32f2f;
    }

    .btn-add {
        background: var(--accent);
        margin-bottom: 20px;
    }

    .btn-add:hover {
        background: #388e3c;
    }

    .btn-finish {
        background: var(--accent);
    }

    .btn-finish:hover {
        background: #388e3c;
    }

    .btn-cancel {
        background: var(--danger);
    }

    .btn-cancel:hover {
        background: #d32f2f;
    }

    /* Status Styles */
    .status {
        padding: 6px 12px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status.pending {
        background: var(--warning);
    }

    .status.selesai {
        background: var(--accent);
    }

    .status.batal {
        background: var(--danger);
    }

    /* Form Styles */
    form {
        display: inline;
    }

    /* Notification Toast */
    .toast-container {
        position: fixed;
        top: 90px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .toast {
        background: white;
        border-radius: var(--border-radius);
        padding: 15px 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 300px;
        opacity: 0;
        transform: translateX(400px);
        animation: slideInRight 0.4s ease forwards;
    }

    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .toast.hide {
        animation: slideOutRight 0.4s ease forwards;
    }

    @keyframes slideOutRight {
        to {
            opacity: 0;
            transform: translateX(400px);
        }
    }

    .toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
    }

    .toast.success .toast-icon {
        background: var(--accent);
    }

    .toast.error .toast-icon {
        background: var(--danger);
    }

    .toast.info .toast-icon {
        background: var(--info);
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 700;
        margin-bottom: 3px;
        color: var(--dark);
    }

    .toast-message {
        font-size: 14px;
        color: var(--gray);
    }

    .toast-close {
        cursor: pointer;
        color: var(--gray);
        font-size: 18px;
        transition: var(--transition);
    }

    .toast-close:hover {
        color: var(--dark);
    }

    /* Footer Styles */
    footer {
        text-align: center;
        padding: 20px;
        background: var(--secondary);
        color: white;
        margin-top: 40px;
        font-size: 14px;
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        nav {
            flex-wrap: wrap;
            gap: 5px;
        }
        
        nav a {
            flex: 1;
            min-width: 120px;
            justify-content: center;
        }
        
        .container {
            padding: 15px;
        }

        .stats-container {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    }

    @media (max-width: 768px) {
        header {
            flex-direction: row;
            gap: 10px;
            padding: 15px;
        }
        
        header h1 {
            font-size: 20px;
        }
        
        .header-actions {
            gap: 10px;
        }
        
        .btn-logout {
            padding: 6px 12px;
            font-size: 13px;
        }
        
        /* Hide regular nav on mobile */
        nav {
            display: none;
        }
        
        /* Show mobile menu button */
        .mobile-menu-btn {
            display: block;
        }
        
        h2 {
            font-size: 24px;
        }
        
        .btn {
            padding: 8px 12px;
            font-size: 13px;
        }
        
        th, td {
            padding: 10px 8px;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .toast {
            min-width: 280px;
        }

        .toast-container {
            right: 10px;
            left: 10px;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding: 10px;
        }
        
        h2 {
            font-size: 20px;
        }
        
        th, td {
            padding: 8px 5px;
            font-size: 14px;
        }
        
        .btn {
            padding: 6px 10px;
            font-size: 12px;
        }

        .btn-logout {
            padding: 5px 10px;
            font-size: 12px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .stat-content p {
            font-size: 20px;
        }
    }

    /* Empty state styling */
    td[colspan] {
        padding: 40px 20px;
        text-align: center;
        color: var(--gray);
        font-style: italic;
    }

    /* Card layout for better mobile experience */
    .card-view {
        display: none;
    }

    @media (max-width: 768px) {
        .table-container {
            display: none;
        }
        
        .card-view {
            display: block;
        }
        
        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            margin-bottom: 15px;
            transition: var(--transition);
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .card-field {
            margin-bottom: 8px;
        }
        
        .card-field strong {
            display: block;
            color: var(--gray);
            font-size: 12px;
            margin-bottom: 3px;
        }
        
        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            justify-content: center;
        }
        
        .card-actions .btn {
            flex: 1;
            max-width: 120px;
        }
    }
</style>
</head>
<body>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<header id="header">
    <h1><i class="fa fa-chart-line"></i> Dashboard Admin - Mie Sumi</h1>
    <div class="header-actions">
        <a href="?logout=true" class="btn-logout" onclick="return confirmLogout()">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
</header>

<!-- Mobile Navigation Overlay -->
<div class="mobile-nav-overlay" id="mobileNavOverlay"></div>

<!-- Mobile Navigation Menu -->
<div class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-header">
        <h3><i class="fa fa-bars"></i> Menu</h3>
        <button class="mobile-nav-close" id="mobileNavClose">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="mobile-nav-links">
        <!-- Hapus Beranda dari menu mobile -->
        <a href="?page=menu" class="<?= $page=='menu'?'active':'' ?>"><i class="fa fa-utensils"></i> Menu</a>
        <a href="?page=pesanan" class="<?= $page=='pesanan'?'active':'' ?>"><i class="fa fa-list"></i> Detail Pesanan</a>
        <a href="?page=riwayat" class="<?= $page=='riwayat'?'active':'' ?>"><i class="fa fa-clock-rotate-left"></i> Riwayat Pesanan</a>
        <a href="rekap_pendapatan.php"><i class="fa fa-receipt"></i> Laporan Pendapatan</a>
        <a href="ulasan.php"><i class="fa fa-envelope"></i> Ulasan</a>
        <!-- Tambah Logout di menu mobile -->
        <a href="?logout=true" onclick="return confirmLogout()"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<nav id="nav">
    <!-- Hapus Beranda dari navigasi utama -->
    <a href="?page=menu" class="<?= $page=='menu'?'active':'' ?>"><i class="fa fa-utensils"></i> Menu</a>
    <a href="?page=pesanan" class="<?= $page=='pesanan'?'active':'' ?>"><i class="fa fa-list"></i> Detail Pesanan</a>
    <a href="?page=riwayat" class="<?= $page=='riwayat'?'active':'' ?>"><i class="fa fa-clock-rotate-left"></i> Riwayat Pesanan</a>
    <a href="rekap_pendapatan.php"><i class="fa fa-receipt"></i> Laporan Pendapatan</a>
    <a href="ulasan.php"><i class="fa fa-envelope"></i> Ulasan</a>
</nav>

<div class="container" id="container">
<?php

// ========== HALAMAN MENU ==========
if ($page == 'menu') {
    $menu = $conn->query("SELECT * FROM menu ORDER BY id_menu ASC");
    echo "<h2><i class='fa fa-utensils'></i> Daftar Menu</h2>";
    echo '<a href="tambah_menu.php" class="btn btn-add"><i class="fa fa-plus"></i> Tambah Menu</a>';
    
    // Table view for desktop
    echo "<div class='table-container'>";
    echo "<table>
            <thead><tr>
                <th>ID</th><th>Nama Menu</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th>
            </tr></thead><tbody>";
    while ($m = $menu->fetch_assoc()) {
        echo "<tr>
                <td>{$m['id_menu']}</td>
                <td>{$m['nama_menu']}</td>
                <td>{$m['kategori_menu']}</td>
                <td>Rp" . number_format($m['harga'], 0, ',', '.') . "</td>
                <td>{$m['stok_menu']}</td>
                <td>
                    <a href='edit_menu.php?id={$m['id_menu']}' class='btn btn-edit'><i class='fa fa-pen'></i> Edit</a>
                    <a href='hapus_menu.php?id={$m['id_menu']}' onclick='return confirmDelete(\"{$m['nama_menu']}\")' class='btn btn-delete'><i class='fa fa-trash'></i> Hapus</a>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
    
    // Reset pointer for card view
    $menu->data_seek(0);
    
    // Card view for mobile
    echo "<div class='card-view'>";
    while ($m = $menu->fetch_assoc()) {
        echo "<div class='card'>
                <div class='card-header'>
                    <span>{$m['nama_menu']}</span>
                    <span class='status'>ID: {$m['id_menu']}</span>
                </div>
                <div class='card-body'>
                    <div class='card-field'>
                        <strong>Kategori</strong>
                        <span>{$m['kategori_menu']}</span>
                    </div>
                    <div class='card-field'>
                        <strong>Harga</strong>
                        <span>Rp" . number_format($m['harga'], 0, ',', '.') . "</span>
                    </div>
                    <div class='card-field'>
                        <strong>Stok</strong>
                        <span>{$m['stok_menu']}</span>
                    </div>
                </div>
                <div class='card-actions'>
                    <a href='edit_menu.php?id={$m['id_menu']}' class='btn btn-edit'><i class='fa fa-pen'></i> Edit</a>
                    <a href='hapus_menu.php?id={$m['id_menu']}' onclick='return confirmDelete(\"{$m['nama_menu']}\")' class='btn btn-delete'><i class='fa fa-trash'></i> Hapus</a>
                </div>
              </div>";
    }
    echo "</div>";
}

// ========== HALAMAN DETAIL PESANAN ==========
elseif ($page == 'pesanan') {
    // MODIFIKASI DI SINI: Menambahkan ORDER BY waktu DESC untuk menampilkan pesanan terbaru paling atas
    // Asumsi: tabel detail_pesanan memiliki kolom 'waktu' atau 'created_at'
    // Jika tidak ada, ganti dengan kolom timestamp yang sesuai di database Anda
    
    $detail = $conn->query("
        SELECT 
            dp.nama_pemesan,
            GROUP_CONCAT(CONCAT(m.nama_menu, ' × ', dp.jumlah) SEPARATOR ', ') AS items,
            SUM(dp.jumlah) AS total_jumlah,
            SUM(dp.subtotal) AS total_subtotal,
            MAX(dp.waktu) AS waktu_terbaru  -- Mengambil waktu terbaru untuk sorting
        FROM detail_pesanan dp
        JOIN menu m ON dp.id_menu = m.id_menu
        WHERE dp.status_pesanan = 'pending'
        GROUP BY dp.nama_pemesan
        ORDER BY waktu_terbaru DESC  -- MODIFIKASI: Urutkan dari yang terbaru ke terlama
    ");

    echo "<h2><i class='fa fa-list'></i> Detail Pesanan (Pending)</h2>";
    
    // Table view for desktop
    echo "<div class='table-container'>";
    echo "<table>
            <thead><tr>
                <th>Nama Pemesan</th><th>Item</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th>
            </tr></thead><tbody>";
    if ($detail->num_rows > 0) {
        while ($d = $detail->fetch_assoc()) {
            echo "<tr>
                    <td>{$d['nama_pemesan']}</td>
                    <td>{$d['items']}</td>
                    <td>{$d['total_jumlah']}</td>
                    <td>Rp" . number_format($d['total_subtotal'], 0, ',', '.') . "</td>
                    <td>
                        <form method='POST' action='update_pesanan_group.php' style='display:inline;'>
                            <input type='hidden' name='nama_pemesan' value='{$d['nama_pemesan']}'>
                            <input type='hidden' name='aksi' value='selesai'>
                            <button class='btn btn-finish'><i class='fa fa-check'></i> Selesai</button>
                        </form>
                        <form method='POST' action='update_pesanan_group.php' style='display:inline;'>
                            <input type='hidden' name='nama_pemesan' value='{$d['nama_pemesan']}'>
                            <input type='hidden' name='aksi' value='batal'>
                            <button class='btn btn-cancel'><i class='fa fa-times'></i> Batal</button>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Tidak ada pesanan pending.</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
    
    // Reset pointer for card view
    $detail->data_seek(0);
    
    // Card view for mobile
    echo "<div class='card-view'>";
    if ($detail->num_rows > 0) {
        while ($d = $detail->fetch_assoc()) {
            echo "<div class='card'>
                    <div class='card-header'>
                        <span>{$d['nama_pemesan']}</span>
                    </div>
                    <div class='card-body'>
                        <div class='card-field'>
                            <strong>Item</strong>
                            <span>{$d['items']}</span>
                        </div>
                        <div class='card-field'>
                            <strong>Jumlah</strong>
                            <span>{$d['total_jumlah']}</span>
                        </div>
                        <div class='card-field'>
                            <strong>Subtotal</strong>
                            <span>Rp" . number_format($d['total_subtotal'], 0, ',', '.') . "</span>
                        </div>
                    </div>
                    <div class='card-actions'>
                        <form method='POST' action='update_pesanan_group.php' style='display:inline; width: 100%;'>
                            <input type='hidden' name='nama_pemesan' value='{$d['nama_pemesan']}'>
                            <input type='hidden' name='aksi' value='selesai'>
                            <button class='btn btn-finish' style='width: 100%;'><i class='fa fa-check'></i> Selesai</button>
                        </form>
                        <form method='POST' action='update_pesanan_group.php' style='display:inline; width: 100%;'>
                            <input type='hidden' name='nama_pemesan' value='{$d['nama_pemesan']}'>
                            <input type='hidden' name='aksi' value='batal'>
                            <button class='btn btn-cancel' style='width: 100%;'><i class='fa fa-times'></i> Batal</button>
                        </form>
                    </div>
                  </div>";
        }
    } else {
        echo "<div class='card'><div class='card-body'><p>Tidak ada pesanan pending.</p></div></div>";
    }
    echo "</div>";
}
// ========== HALAMAN RIWAYAT PESANAN ==========
elseif ($page == 'riwayat') {
$riwayat = $conn->query("
    SELECT 
        MIN(id_riwayat) AS id_riwayat,
        nama_pemesan,
        GROUP_CONCAT(rincian_menu SEPARATOR ', ') AS items,
        SUM(jumlah) AS total_jumlah,
        SUM(subtotal) AS total_subtotal,
        MAX(status_pesanan) AS status_pesanan,
        MAX(waktu) AS waktu
    FROM riwayat_pemesanan
    GROUP BY nama_pemesan, DATE(waktu)
    ORDER BY waktu DESC
");

    if (!$riwayat) {
        die("<div style='color:red;font-weight:bold;'>Query riwayat gagal: " . $conn->error . "</div>");
    }

    echo "<h2><i class='fa fa-clock-rotate-left'></i> Riwayat Pesanan (Selesai / Batal)</h2>";
    
    // Table view for desktop
    echo "<div class='table-container'>";
    echo "<table>
            <thead><tr>
                <th>ID</th><th>Nama Pemesan</th><th>Item</th><th>Jumlah</th><th>Subtotal</th><th>Status</th><th>Waktu</th><th>Aksi</th>
            </tr></thead><tbody>";
    if ($riwayat->num_rows > 0) {
        while ($r = $riwayat->fetch_assoc()) {
            echo "<tr>
                    <td>{$r['id_riwayat']}</td>
                    <td>{$r['nama_pemesan']}</td>
                    <td>{$r['items']}</td>
                    <td>{$r['total_jumlah']}</td>
                    <td>Rp" . number_format($r['total_subtotal'], 0, ',', '.') . "</td>
                    <td><span class='status {$r['status_pesanan']}'>{$r['status_pesanan']}</span></td>
                    <td>{$r['waktu']}</td>
                    <td>
                        <a href='hapus_riwayat.php?id={$r['id_riwayat']}' 
                           onclick='return confirmDeleteHistory()' 
                           class='btn btn-delete'>
                           <i class='fa fa-trash'></i> Hapus
                        </a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Belum ada riwayat pesanan.</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
    
    // Reset pointer for card view
    $riwayat->data_seek(0);
    
    // Card view for mobile
    echo "<div class='card-view'>";
    if ($riwayat->num_rows > 0) {
        while ($r = $riwayat->fetch_assoc()) {
            echo "<div class='card'>
                    <div class='card-header'>
                        <span>{$r['nama_pemesan']}</span>
                        <span class='status {$r['status_pesanan']}'>{$r['status_pesanan']}</span>
                    </div>
                    <div class='card-body'>
                        <div class='card-field'>
                            <strong>ID</strong>
                            <span>{$r['id_riwayat']}</span>
                        </div>
                        <div class='card-field'>
                            <strong>Item</strong>
                            <span>{$r['items']}</span>
                        </div>
                        <div class='card-field'>
                            <strong>Jumlah</strong>
                            <span>{$r['total_jumlah']}</span>
                        </div>
                        <div class='card-field'>
                            <strong>Subtotal</strong>
                            <span>Rp" . number_format($r['total_subtotal'], 0, ',', '.') . "</span>
                        </div>
                        <div class='card-field'>
                            <strong>Waktu</strong>
                            <span>{$r['waktu']}</span>
                        </div>
                    </div>
                    <div class='card-actions'>
                        <a href='hapus_riwayat.php?id={$r['id_riwayat']}' 
                           onclick='return confirmDeleteHistory()' 
                           class='btn btn-delete'>
                           <i class='fa fa-trash'></i> Hapus
                        </a>
                    </div>
                  </div>";
        }
    } else {
        echo "<div class='card'><div class='card-body'><p>Belum ada riwayat pesanan.</p></div></div>";
    }
    echo "</div>";
}
?>
</div>

<footer>&copy; <?= date('Y') ?> Mie Sumi | Admin Dashboard</footer>

<script>
// Animasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Animasi body
    document.body.classList.add('loaded');
    
    // Animasi header
    setTimeout(() => {
        document.getElementById('header').classList.add('show');
    }, 100);
    
    // Animasi nav
    setTimeout(() => {
        document.getElementById('nav').classList.add('show');
    }, 200);
    
    // Animasi container
    setTimeout(() => {
        document.getElementById('container').classList.add('show');
    }, 400);
    
    // Animasi stat cards jika ada
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('show');
        }, 600 + (index * 100));
    });
});

// Mobile Menu Functionality
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const mobileNavOverlay = document.getElementById('mobileNavOverlay');
const mobileNav = document.getElementById('mobileNav');
const mobileNavClose = document.getElementById('mobileNavClose');

// Open mobile menu
mobileMenuBtn.addEventListener('click', function() {
    mobileNavOverlay.classList.add('active');
    mobileNav.classList.add('active');
    document.body.style.overflow = 'hidden';
});

// Close mobile menu
function closeMobileMenu() {
    mobileNavOverlay.classList.remove('active');
    mobileNav.classList.remove('active');
    document.body.style.overflow = '';
}

mobileNavOverlay.addEventListener('click', closeMobileMenu);
mobileNavClose.addEventListener('click', closeMobileMenu);

// Close mobile menu when clicking on a link
const mobileNavLinks = document.querySelectorAll('.mobile-nav-links a');
mobileNavLinks.forEach(link => {
    link.addEventListener('click', closeMobileMenu);
});

// Toast Notification System
function showToast(type, title, message) {
    const toastContainer = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    let icon = '';
    switch(type) {
        case 'success':
            icon = '<i class="fa fa-check-circle"></i>';
            break;
        case 'error':
            icon = '<i class="fa fa-times-circle"></i>';
            break;
        case 'info':
            icon = '<i class="fa fa-info-circle"></i>';
            break;
    }
    
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <div class="toast-close" onclick="closeToast(this)">
            <i class="fa fa-times"></i>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 400);
    }, 5000);
}

function closeToast(element) {
    const toast = element.closest('.toast');
    toast.classList.add('hide');
    setTimeout(() => {
        toast.remove();
    }, 400);
}

// Confirm Logout
function confirmLogout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        showToast('info', 'Logout', 'Anda akan diarahkan ke halaman login...');
        return true;
    }
    return false;
}

// Confirm Delete Menu
function confirmDelete(menuName) {
    if (confirm(`Apakah Anda yakin ingin menghapus menu "${menuName}"?`)) {
        showToast('info', 'Menghapus Menu', `Menu "${menuName}" sedang dihapus...`);
        return true;
    }
    return false;
}

// Confirm Delete History
function confirmDeleteHistory() {
    if (confirm('Apakah Anda yakin ingin menghapus riwayat ini?')) {
        showToast('info', 'Menghapus Riwayat', 'Riwayat pesanan sedang dihapus...');
        return true;
    }   
    return false;
}

// Check for success/error messages from URL
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('success') === 'add') {
    showToast('success', 'Berhasil!', 'Menu baru berhasil ditambahkan.');
} else if (urlParams.get('success') === 'edit') {
    showToast('success', 'Berhasil!', 'Menu berhasil diperbarui.');
} else if (urlParams.get('success') === 'delete') {
    showToast('success', 'Berhasil!', 'Menu berhasil dihapus.');
} else if (urlParams.get('success') === 'delete_history') {
    showToast('success', 'Berhasil!', 'Riwayat pesanan berhasil dihapus.');
} else if (urlParams.get('error')) {
    showToast('error', 'Gagal!', 'Terjadi kesalahan. Silakan coba lagi.');
}
</script>

</body>
</html>