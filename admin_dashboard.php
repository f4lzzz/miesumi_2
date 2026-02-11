<?php
include 'connection.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'menu';

// Handle logout
if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header('Location: login.php');
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

    /* CSS untuk menghilangkan efek hover */
    .table-container table tbody tr {
        transition: none !important;
    }

    .table-container table tbody tr:hover {
        background: inherit !important;
        transform: none !important;
    }

    .card {
        transition: none !important;
    }

    .card:hover {
        transform: none !important;
        box-shadow: var(--box-shadow) !important;
    }

    tr {
        transition: none !important;
        transform: none !important;
    }

    tr:hover {
        background: inherit !important;
        transform: none !important;
    }

    .btn-finish:hover, .btn-cancel:hover, .btn-delete:hover, .btn-edit:hover, .btn-add:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
    }

    .table-container table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-container table tbody tr td {
        border-bottom: 1px solid var(--gray-light);
    }

    .table-container table tbody tr {
        background-color: white;
    }

    .table-container table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    @media (max-width: 768px) {
    /* Untuk card header di riwayat pesanan */
    .card-header > div > div {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }
    
    .card-header .status {
        margin-left: auto;
        white-space: nowrap;
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
    // Query untuk mengambil detail pesanan dengan pengelompokan berdasarkan waktu berdekatan
    $detail_query = $conn->query("
        SELECT 
            dp.nama_pemesan,
            m.nama_menu,
            m.harga,
            dp.jumlah,
            dp.subtotal as subtotal_per_item,
            dp.waktu,
            dp.status_pesanan,
            UNIX_TIMESTAMP(dp.waktu) as timestamp,
            DATE_FORMAT(dp.waktu, '%Y-%m-%d %H:%i') as waktu_grup
        FROM detail_pesanan dp
        JOIN menu m ON dp.id_menu = m.id_menu
        WHERE dp.status_pesanan = 'pending'
        ORDER BY dp.nama_pemesan, dp.waktu DESC
    ");

    // Kelompokkan data berdasarkan pemesan dan waktu (per 10 menit)
    $grouped_orders = [];
    $current_group_key = '';
    
    if ($detail_query && $detail_query->num_rows > 0) {
        while ($row = $detail_query->fetch_assoc()) {
            $nama_pemesan = $row['nama_pemesan'];
            $waktu = $row['waktu'];
            $timestamp = $row['timestamp'];
            
            // Buat grup key berdasarkan nama pemesan dan menit (dibulatkan per 10 menit)
            $minute_group = floor(date('i', strtotime($waktu)) / 10) * 10;
            $group_key = $nama_pemesan . '_' . date('Y-m-d H:') . str_pad($minute_group, 2, '0', STR_PAD_LEFT);
            
            if (!isset($grouped_orders[$group_key])) {
                $grouped_orders[$group_key] = [
                    'nama_pemesan' => $nama_pemesan,
                    'waktu_grup' => date('Y-m-d H:i', strtotime($waktu)),
                    'items' => [],
                    'total_subtotal' => 0,
                    'total_qty' => 0
                ];
            }
            
            // Tambahkan item ke grup
            $grouped_orders[$group_key]['items'][] = [
                'nama_menu' => $row['nama_menu'],
                'harga' => $row['harga'],
                'jumlah' => $row['jumlah'],
                'subtotal_per_item' => $row['subtotal_per_item']
            ];
            
            // Update total
            $grouped_orders[$group_key]['total_subtotal'] += $row['subtotal_per_item'];
            $grouped_orders[$group_key]['total_qty'] += $row['jumlah'];
        }
    }

    echo "<h2><i class='fa fa-list'></i> Detail Pesanan (Pending)</h2>";
    
    if (empty($grouped_orders)) {
        echo "<div class='table-container'><table><tbody><tr><td colspan='8' style='text-align: center; padding: 40px;'>Tidak ada pesanan pending.</td></tr></tbody></table></div>";
    } else {
        // Table view for desktop
        echo "<div class='table-container'>";
        echo "<table>
                <thead><tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Menu</th>
                    <th>Harga per Porsi</th>
                    <th>Jumlah</th>
                    <th>Subtotal Item</th>
                    <th>Waktu Pesan</th>
                    <th>Aksi</th>
                </tr></thead>
                <tbody>";
        
        $group_counter = 1;
        foreach ($grouped_orders as $group_key => $group) {
            $items = $group['items'];
            $item_count = count($items);
            
            foreach ($items as $index => $item) {
                echo "<tr>";
                
                // Nomor grup
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: top; font-weight: 600; background: #f8f9fa; text-align: center;'>Pesanan {$group_counter}</td>";
                }
                
                // Nama pemesan
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: top; font-weight: 600; color: var(--dark);'>
                            " . htmlspecialchars($group['nama_pemesan']) . "
                          </td>";
                }
                
                // Menu
                echo "<td style='text-align: left; font-weight: 500; color: var(--dark);'>" . htmlspecialchars($item['nama_menu']) . "</td>";
                
                // Harga
                echo "<td style='color: var(--dark);'>Rp " . number_format($item['harga'], 0, ',', '.') . "</td>";
                
                // Jumlah
                echo "<td style='font-weight: 600; color: var(--dark);'>" . $item['jumlah'] . "</td>";
                
                // Subtotal
                echo "<td style='font-weight: 600; color: var(--accent);'>Rp " . number_format($item['subtotal_per_item'], 0, ',', '.') . "</td>";
                
                // Waktu
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: middle; color: var(--dark);'>
                            " . date('d-m-Y H:i', strtotime($group['waktu_grup'])) . "
                          </td>";
                }
                
                // Aksi
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: middle;'>
                            <div style='min-width: 120px;'>
                                <form method='POST' action='update_pesanan_group.php' style='margin-bottom: 5px;'>
                                    <input type='hidden' name='nama_pemesan' value='" . htmlspecialchars($group['nama_pemesan']) . "'>
                                    <input type='hidden' name='group_waktu' value='{$group['waktu_grup']}'>
                                    <button type='submit' name='aksi' value='selesai' class='btn btn-finish' style='width: 100%;' onclick='return confirmSelesai()'>
                                        <i class='fa fa-check'></i> Selesai
                                    </button>
                                    <br>
                                    <br>
                                </form>
                                <form method='POST' action='update_pesanan_group.php'>
                                    <input type='hidden' name='nama_pemesan' value='" . htmlspecialchars($group['nama_pemesan']) . "'>
                                    <input type='hidden' name='group_waktu' value='{$group['waktu_grup']}'>
                                    <button type='submit' name='aksi' value='batal' class='btn btn-cancel' style='width: 100%;' onclick='return confirmBatal()'>
                                        <i class='fa fa-times'></i> Batal
                                    </button>
                                </form>
                            </div>
                          </td>";
                }
                
                echo "</tr>";
            }
            
            // Baris total per grup
            echo "<tr style='background-color: #e9ecef; font-weight: 700;'>
                    <td colspan='3' style='text-align: right; color: var(--dark);'>Total Pesanan {$group_counter}:</td>
                    <td style='text-align: center; color: var(--dark);'>" . $group['total_qty'] . "</td>
                    <td style='color: var(--accent);'>Rp " . number_format($group['total_subtotal'], 0, ',', '.') . "</td>
                    <td colspan='3'></td>
                  </tr>";
            
            $group_counter++;
        }
        
        echo "</tbody></table>";
        echo "</div>";
        
        // ========== CARD VIEW UNTUK MOBILE - DETAIL PESANAN ==========
        echo "<div class='card-view'>";
        if (empty($grouped_orders)) {
            echo "<div style='background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow); padding: 40px 20px; text-align: center; color: var(--gray);'>Tidak ada pesanan pending.</div>";
        } else {
            $group_counter = 1;
            foreach ($grouped_orders as $group_key => $group) {
                echo "<div class='card'>";
                // Header
                echo "<div class='card-header'>";
                echo "<div>";
                echo "<span style='font-weight: 600; font-size: 1rem; color: var(--dark);'>Pesanan {$group_counter} - " . htmlspecialchars($group['nama_pemesan']) . "</span>";
                echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-top: 5px;'>";
                echo "<span style='font-size: 0.8rem; color: var(--gray);'><i class='fa fa-clock'></i> " . date('d-m-Y H:i', strtotime($group['waktu_grup'])) . "</span>";
                echo "<span class='status pending' style='padding: 4px 10px;'>Pending</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                
                // Body - items
                echo "<div class='card-body'>";
                foreach ($group['items'] as $item) {
                    echo "<div class='card-field' style='padding: 10px 0; border-bottom: 1px solid var(--gray-light);'>";
                    echo "<div style='display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;'>";
                    echo "<strong style='font-size: 0.95rem; color: var(--dark); flex: 1; min-width: 0; margin-right: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>" . htmlspecialchars($item['nama_menu']) . "</strong>";
                    echo "<span style='background: var(--info); color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; height: fit-content;'>" . $item['jumlah'] . " porsi</span>";
                    echo "</div>";
                    echo "<div style='display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; margin-top: 5px;'>";
                    echo "<span style='color: var(--gray);'>Harga: Rp " . number_format($item['harga'], 0, ',', '.') . "</span>";
                    echo "<span style='font-weight: 600; color: var(--accent);'>Rp " . number_format($item['subtotal_per_item'], 0, ',', '.') . "</span>";
                    echo "</div>";
                    echo "</div>";
                }
                
                // Total
                echo "<div class='card-field' style='margin-top: 15px; padding: 15px 0; border-top: 2px solid var(--gray-light);'>";
                echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
                echo "<div>";
                echo "<strong style='font-size: 1rem; color: var(--dark);'>Total Pesanan</strong>";
                echo "<div style='font-size: 0.85rem; color: var(--gray);'>" . $group['total_qty'] . " item</div>";
                echo "</div>";
                echo "<span style='color: var(--accent); font-weight: 700; font-size: 1.2rem;'>Rp " . number_format($group['total_subtotal'], 0, ',', '.') . "</span>";
                echo "</div>";
                echo "</div>";
                
                echo "</div>"; // card-body
                
                // Actions
                echo "<div class='card-actions' style='display: flex; gap: 10px; margin-top: 15px;'>";
                echo "<form method='POST' action='update_pesanan_group.php' style='flex: 1;'>";
                echo "<input type='hidden' name='nama_pemesan' value='" . htmlspecialchars($group['nama_pemesan']) . "'>";
                echo "<input type='hidden' name='group_waktu' value='{$group['waktu_grup']}'>";
                echo "<button type='submit' name='aksi' value='selesai' class='btn btn-finish' style='width: 100%;' onclick='return confirmSelesai()'><i class='fa fa-check'></i> Selesai</button>";
                echo "</form>";
                echo "<form method='POST' action='update_pesanan_group.php' style='flex: 1;'>";
                echo "<input type='hidden' name='nama_pemesan' value='" . htmlspecialchars($group['nama_pemesan']) . "'>";
                echo "<input type='hidden' name='group_waktu' value='{$group['waktu_grup']}'>";
                echo "<button type='submit' name='aksi' value='batal' class='btn btn-cancel' style='width: 100%;' onclick='return confirmBatal()'><i class='fa fa-times'></i> Batal</button>";
                echo "</form>";
                echo "</div>";
                
                echo "</div>"; // card
                $group_counter++;
            }
        }
        echo "</div>"; // card-view
    }
}
// ========== HALAMAN RIWAYAT PESANAN ==========
elseif ($page == 'riwayat') {
    // Query untuk riwayat dengan pengelompokan berdasarkan waktu berdekatan
    $riwayat_query = $conn->query("
        SELECT 
            rp.nama_pemesan,
            rp.rincian_menu,
            rp.jumlah,
            rp.subtotal,
            rp.waktu,
            rp.status_pesanan,
            UNIX_TIMESTAMP(rp.waktu) as timestamp,
            DATE_FORMAT(rp.waktu, '%Y-%m-%d %H:%i') as waktu_grup
        FROM riwayat_pemesanan rp
        WHERE rp.status_pesanan IN ('selesai', 'batal')
        ORDER BY rp.waktu DESC, rp.nama_pemesan
    ");

    // Kelompokkan data berdasarkan pemesan dan waktu (per 10 menit)
    $grouped_riwayat = [];
    
    if ($riwayat_query && $riwayat_query->num_rows > 0) {
        while ($row = $riwayat_query->fetch_assoc()) {
            $nama_pemesan = $row['nama_pemesan'];
            $waktu = $row['waktu'];
            
            // Buat grup key berdasarkan nama pemesan dan menit (dibulatkan per 10 menit)
            $minute_group = floor(date('i', strtotime($waktu)) / 10) * 10;
            $group_key = $nama_pemesan . '_' . date('Y-m-d H:') . str_pad($minute_group, 2, '0', STR_PAD_LEFT);
            
            if (!isset($grouped_riwayat[$group_key])) {
                $grouped_riwayat[$group_key] = [
                    'nama_pemesan' => $nama_pemesan,
                    'waktu_grup' => date('Y-m-d H:i', strtotime($waktu)),
                    'status_pesanan' => $row['status_pesanan'],
                    'items' => [],
                    'total_subtotal' => 0,
                    'total_qty' => 0
                ];
            }
            
            // Tambahkan item ke grup
            $grouped_riwayat[$group_key]['items'][] = [
                'nama_menu' => $row['rincian_menu'],
                'jumlah' => $row['jumlah'],
                'subtotal_per_item' => $row['subtotal']
            ];
            
            // Update total
            $grouped_riwayat[$group_key]['total_subtotal'] += $row['subtotal'];
            $grouped_riwayat[$group_key]['total_qty'] += $row['jumlah'];
        }
    }

    if (!$riwayat_query) {
        die("<div style='color:red;font-weight:bold;'>Query riwayat gagal: " . $conn->error . "</div>");
    }

    echo "<h2><i class='fa fa-clock-rotate-left'></i> Riwayat Pesanan (Selesai / Batal)</h2>";
    
    if (empty($grouped_riwayat)) {
        echo "<div class='table-container'><table><tbody><tr><td colspan='8' style='text-align: center; padding: 40px;'>Belum ada riwayat pesanan.</td></tr></tbody></table></div>";
    } else {
        // ⭐⭐ BAGI MENJADI KELOMPOK 10 PESANAN ⭐⭐
        $all_groups = array_values($grouped_riwayat); // ubah ke array numerik
        $total_groups = count($all_groups);
        $groups_per_page = 10;
        $total_pages = ceil($total_groups / $groups_per_page);
        
        // Ambil halaman saat ini dari URL
        $current_page = isset($_GET['p']) ? max(1, min($total_pages, intval($_GET['p']))) : 1;
        
        // Hitung grup yang akan ditampilkan
        $start_index = ($current_page - 1) * $groups_per_page;
        $end_index = min($start_index + $groups_per_page, $total_groups);
        $current_groups = array_slice($all_groups, $start_index, $groups_per_page);
        
        // Table view for desktop - TAMPILKAN 10 GRUP SAJA
        echo "<div class='table-container'>";
        echo "<table>
                <thead><tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Subtotal Item</th>
                    <th>Waktu Pesan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr></thead>
                <tbody>";
        
        $group_counter = $start_index + 1;
        foreach ($current_groups as $group) {
            $items = $group['items'];
            $item_count = count($items);
            $status_color = $group['status_pesanan'] == 'selesai' ? 'var(--accent)' : 'var(--danger)';
            
            foreach ($items as $index => $item) {
                echo "<tr>";
                
                // Nomor grup
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: top; font-weight: 600; background: #f8f9fa; text-align: center;'>Pesanan {$group_counter}</td>";
                }
                
                // Nama pemesan
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: top; font-weight: 600; color: var(--dark);'>
                            " . htmlspecialchars($group['nama_pemesan']) . "
                          </td>";
                }
                
                // Menu
                echo "<td style='text-align: left; font-weight: 500; color: var(--dark);'>" . htmlspecialchars($item['nama_menu']) . "</td>";
                
                // Jumlah
                echo "<td style='font-weight: 600; color: var(--dark);'>" . $item['jumlah'] . "</td>";
                
                // Subtotal
                echo "<td style='font-weight: 600; color: var(--accent);'>Rp " . number_format($item['subtotal_per_item'], 0, ',', '.') . "</td>";
                
                // Waktu
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: middle; color: var(--dark);'>
                            " . date('d-m-Y H:i', strtotime($group['waktu_grup'])) . "
                          </td>";
                }
                
                // Status
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: middle;'>
                            <span class='status' style='background-color: {$status_color}; padding: 6px 12px; border-radius: 50px; color: white; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;'>
                                {$group['status_pesanan']}
                            </span>
                          </td>";
                }
                
                // Aksi
                if ($index === 0) {
                    echo "<td rowspan='{$item_count}' style='vertical-align: middle;'>
                            <form method='POST' action='hapus_riwayat_group.php' style='display: inline;' onsubmit='return confirmDeleteHistory()'>
                                <input type='hidden' name='nama_pemesan' value='" . htmlspecialchars($group['nama_pemesan']) . "'>
                                <input type='hidden' name='group_waktu' value='{$group['waktu_grup']}'>
                                <button type='submit' class='btn btn-delete'>
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                            </form>
                          </td>";
                }
                
                echo "</tr>";
            }
            
            // Baris total per grup
            echo "<tr style='background-color: #e9ecef; font-weight: 700;'>
                    <td colspan='2' style='text-align: right; color: var(--dark);'>Total Pesanan {$group_counter}:</td>
                    <td style='text-align: center; color: var(--dark);'>" . $group['total_qty'] . "</td>
                    <td style='color: var(--accent);'>Rp " . number_format($group['total_subtotal'], 0, ',', '.') . "</td>
                    <td colspan='4'></td>
                  </tr>";
            
            $group_counter++;
        }
        
        echo "</tbody></table>";
        echo "</div>";
        
        // ⭐⭐ PAGINATION UNTUK GESER HALAMAN ⭐⭐
        echo "<div style='display: flex; justify-content: center; align-items: center; margin: 20px 0; gap: 10px;'>";
        
        // Tombol Previous
        if ($current_page > 1) {
            echo "<a href='?page=riwayat&p=" . ($current_page - 1) . "' class='btn' style='background: var(--primary); color: white; padding: 8px 16px; border-radius: var(--border-radius); text-decoration: none;'>
                    <i class='fa fa-chevron-left'></i> Sebelumnya
                  </a>";
        }
        
        // Info halaman
        echo "<span style='color: var(--dark); font-weight: 600;'>
                Halaman {$current_page} dari {$total_pages} 
                <span style='color: var(--gray); font-size: 0.9em;'>
                  (Menampilkan " . count($current_groups) . " dari {$total_groups} pesanan)
                </span>
              </span>";
        
        // Tombol Next
        if ($current_page < $total_pages) {
            echo "<a href='?page=riwayat&p=" . ($current_page + 1) . "' class='btn' style='background: var(--primary); color: white; padding: 8px 16px; border-radius: var(--border-radius); text-decoration: none;'>
                    Selanjutnya <i class='fa fa-chevron-right'></i>
                  </a>";
        }
        
        echo "</div>";
        
        // ⭐⭐ CARD VIEW FOR MOBILE - JUGA 10 GRUP SAJA ⭐⭐
        echo "<div class='card-view'>";
        
        // Info untuk mobile
        echo "<div style='background: var(--primary); color: white; padding: 10px 15px; border-radius: var(--border-radius); margin-bottom: 15px; text-align: center; font-weight: 600;'>
                Halaman {$current_page}/{$total_pages} - " . count($current_groups) . " pesanan
              </div>";
        
        $group_counter = $start_index + 1;
        foreach ($current_groups as $group) {
            $status_class = $group['status_pesanan'] == 'selesai' ? 'selesai' : 'batal';
            $status_color = $group['status_pesanan'] == 'selesai' ? 'var(--accent)' : 'var(--danger)';
            
            echo "<div class='card'>
                    <div class='card-header'>
                        <div>
                            <span style='font-weight: 600; font-size: 1rem; color: var(--dark);'>Pesanan {$group_counter} - " . htmlspecialchars($group['nama_pemesan']) . "</span>
                            <div style='display: flex; justify-content: space-between; align-items: center; margin-top: 5px;'>
                                <span style='font-size: 0.8rem; color: var(--gray);'>
                                    <i class='fa fa-clock'></i> " . date('d-m-Y H:i', strtotime($group['waktu_grup'])) . "
                                </span>
                                <span class='status' style='background-color: {$status_color}; padding: 4px 10px; border-radius: 50px; color: white; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;'>
                                    {$group['status_pesanan']}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='card-body'>";
            
            // Tampilkan setiap item
            foreach ($group['items'] as $item) {
                echo "<div class='card-field' style='padding: 10px 0; border-bottom: 1px solid var(--gray-light);'>
                        <div style='display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;'>
                            <strong style='font-size: 0.95rem; color: var(--dark); flex: 1; min-width: 0; margin-right: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>" . htmlspecialchars($item['nama_menu']) . "</strong>
                            <span style='background: var(--info); color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; height: fit-content;'>
                                " . $item['jumlah'] . " porsi
                            </span>
                        </div>
                        <div style='display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; margin-top: 5px;'>
                            <span style='color: var(--gray);'>Subtotal item:</span>
                            <span style='font-weight: 600; color: var(--accent);'>Rp " . number_format($item['subtotal_per_item'], 0, ',', '.') . "</span>
                        </div>
                      </div>";
            }
            
            // Tampilkan total subtotal
            echo "<div class='card-field' style='margin-top: 15px; padding: 15px 0; border-top: 2px solid var(--gray-light);'>
                    <div style='display: flex; justify-content: space-between; align-items: center;'>
                        <div>
                            <strong style='font-size: 1rem; color: var(--dark);'>Total Pesanan</strong>
                            <div style='font-size: 0.85rem; color: var(--gray);'>" . $group['total_qty'] . " item</div>
                        </div>
                        <span style='color: var(--accent); font-weight: 700; font-size: 1.2rem;'>
                            Rp " . number_format($group['total_subtotal'], 0, ',', '.') . "
                        </span>
                    </div>
                  </div>";
            
            echo "</div>
                  <div class='card-actions'>
                    <form method='POST' action='hapus_riwayat_group.php' style='width: 100%;' onsubmit='return confirmDeleteHistory()'>
                        <input type='hidden' name='nama_pemesan' value='" . htmlspecialchars($group['nama_pemesan']) . "'>
                        <input type='hidden' name='group_waktu' value='{$group['waktu_grup']}'>
                        <button class='btn btn-delete' style='width: 100%;'>
                            <i class='fa fa-trash'></i> Hapus Riwayat
                        </button>
                    </form>
                  </div>
                </div>";
            
            $group_counter++;
        }
        
        echo "</div>";
        
        // ⭐⭐ PAGINATION UNTUK MOBILE ⭐⭐
        echo "<div style='display: flex; justify-content: center; align-items: center; margin: 20px 0; gap: 10px; flex-wrap: wrap;'>";
        
        // Tombol Previous (mobile)
        if ($current_page > 1) {
            echo "<a href='?page=riwayat&p=" . ($current_page - 1) . "' class='btn' style='background: var(--primary); color: white; padding: 8px 12px; border-radius: var(--border-radius); text-decoration: none; font-size: 0.9em;'>
                    <i class='fa fa-chevron-left'></i>
                  </a>";
        }
        
        // Tombol halaman (mobile - sederhana)
        echo "<div style='display: flex; gap: 5px;'>";
        for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++) {
            if ($i == $current_page) {
                echo "<span style='background: var(--primary); color: white; padding: 8px 12px; border-radius: var(--border-radius); font-weight: 600;'>
                        {$i}
                      </span>";
            } else {
                echo "<a href='?page=riwayat&p={$i}' style='background: var(--gray-light); color: var(--dark); padding: 8px 12px; border-radius: var(--border-radius); text-decoration: none;'>
                        {$i}
                      </a>";
            }
        }
        echo "</div>";
        
        // Tombol Next (mobile)
        if ($current_page < $total_pages) {
            echo "<a href='?page=riwayat&p=" . ($current_page + 1) . "' class='btn' style='background: var(--primary); color: white; padding: 8px 12px; border-radius: var(--border-radius); text-decoration: none; font-size: 0.9em;'>
                    <i class='fa fa-chevron-right'></i>
                  </a>";
        }
        
        echo "</div>";
    }
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

// Confirm Selesai
function confirmSelesai() {
    return confirm('Tandai pesanan ini sebagai selesai?');
}

// Confirm Batal
function confirmBatal() {
    return confirm('Batalkan pesanan ini?');
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