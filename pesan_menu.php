<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nama_pemesan = $_POST['nama_pemesan'];
  $pesanan = json_decode($_POST['pesanan'], true);

  foreach ($pesanan as $item) {
    $nama_menu = mysqli_real_escape_string($conn, $item['nama']);
    $jumlah = intval($item['jumlah']);

    // Ambil data menu dari DB
    $menu = mysqli_query($conn, "SELECT id_menu, harga, stok_menu FROM menu WHERE nama_menu='$nama_menu'");
    $data = mysqli_fetch_assoc($menu);

    if ($data) {
      $id_menu = $data['id_menu'];
      $harga = $data['harga'];
      $stok_tersedia = $data['stok_menu'];
      
      // Cek apakah stok cukup
      if ($stok_tersedia < $jumlah) {
        echo "error_stok_" . $nama_menu;
        exit;
      }
      
      $subtotal = $harga * $jumlah;

      // Insert ke detail_pesanan
      mysqli_query($conn, "INSERT INTO detail_pesanan (id_menu, jumlah, subtotal, nama_pemesan)
                           VALUES ('$id_menu', '$jumlah', '$subtotal', '$nama_pemesan')");

      // Kurangi stok menu
      mysqli_query($conn, "UPDATE menu SET stok_menu = stok_menu - $jumlah WHERE id_menu = '$id_menu'");
    }
  }

  echo "success";
  exit;
}

// Ambil data menu untuk JavaScript
$menu_data = [];
$result = mysqli_query($conn, "SELECT nama_menu, stok_menu FROM menu");
while ($row = mysqli_fetch_assoc($result)) {
  $menu_data[$row['nama_menu']] = $row['stok_menu'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesan Menu | Warung Mie Ayam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
    :root {
      --primary: #FEA116;
      --primary-dark: #e55c00;
      --primary-light: #FFB74D;
      --secondary: #0F172B;
      --accent: #4CAF50;
      --accent-dark: #388E3C;
      --danger: #f44336;
      --warning: #ff9800;
      --info: #2196F3;
      --light: #F1F8FF;
      --dark: #0F172B;
      --gray: #6c757d;
      --gray-light: #e9ecef;  
      --border-radius: 20px;
      --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      --box-shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.2);
      --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: var(--dark);
      font-family: "Poppins", sans-serif;
      min-height: 100vh;
      color: var(--dark);
      padding-top: 80px;
      opacity: 0;
      animation: fadeIn 0.8s ease forwards;
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }

    /* Navbar Styles */
    .navbar {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      padding: 15px 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      transform: translateY(-100%);
      animation: slideDown 0.6s ease forwards 0.2s;
    }

    @keyframes slideDown {
      to {
        transform: translateY(0);
      }
    }

    .navbar-brand {
      font-weight: 800;
      font-size: 1.8rem;
      color: white !important;
      display: flex;
      align-items: center;
      gap: 12px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 60%;
    }

    .navbar-brand:hover {
      transform: scale(1.05);
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .action-btn {
      background: white;
      color: var(--primary);
      border: none;
      padding: 10px 15px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 0.9rem;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
      white-space: nowrap;
      min-width: fit-content;
    }

    .action-btn:hover {
      transform: translateY(-2px);
      color: var(--primary-dark);
      background: rgba(255, 255, 255, 0.95);
    }

    /* Cart Icon Styles */
    .cart-container {
      position: fixed;
      top: 100px;
      right: 20px;
      z-index: 1001; /* Ditambah z-index */
      opacity: 0;
      animation: fadeInRight 0.8s ease forwards 0.4s;
    }

    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .cart-icon {
      position: relative;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--box-shadow);
      cursor: pointer;
      transition: var(--transition);
    }

    .cart-icon:hover {
      transform: scale(1.15);
      box-shadow: var(--box-shadow-hover);
    }

    .cart-icon i {
      font-size: 2rem;
      color: white;
    }

    .cart-count {
      position: absolute;
      top: -5px;
      right: -5px;
      background: var(--danger);
      color: white;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      font-weight: 700;
      box-shadow: 0 3px 10px rgba(220, 53, 69, 0.5);
    }

    .container {
      max-width: 1400px;
    }

    /* Hero Section */
    .hero-section {
      background: linear-gradient(135deg, rgba(255, 102, 0, 0.95) 0%, rgba(229, 92, 0, 0.95) 100%);
      padding: 60px 20px;
      margin: 20px auto 40px;
      border-radius: 30px;
      text-align: center;
      box-shadow: var(--box-shadow);
      position: relative;
      overflow: hidden;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease forwards 0.3s;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero-section h1 {
      color: white;
      font-weight: 800;
      font-size: 3rem;
      margin-bottom: 15px;
    }

    .hero-section p {
      color: rgba(255, 255, 255, 0.95);
      font-size: 1.2rem;
      font-weight: 500;
    }

    /* Menu Section */
    .menu-section {
      background: white;
      padding: 50px 30px;
      margin: 20px auto;
      border-radius: 30px;
      box-shadow: var(--box-shadow);
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease forwards 0.5s;
    }

    .section-title {
      text-align: center;
      font-weight: 800;
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 40px;
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
      border-radius: 2px;
    }

    /* Swiper Container */
    .swiper {
      width: 100%;
      padding: 40px 10px;
    }

    .swiper-slide {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Navigation Buttons */
    .swiper-button-next, .swiper-button-prev {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      box-shadow: 0 8px 25px rgba(255, 102, 0, 0.4);
      transition: var(--transition);
      border: 3px solid white;
    }

    .swiper-button-next:after, .swiper-button-prev:after {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .swiper-button-next:hover, .swiper-button-prev:hover {
      transform: scale(1.15);
      box-shadow: 0 12px 35px rgba(255, 102, 0, 0.6);
    }

    /* Pagination */
    .swiper-pagination-bullet {
      width: 12px;
      height: 12px;
      background: var(--gray-light);
      opacity: 1;
    }

    .swiper-pagination-bullet-active {
      background: var(--primary);
    }

    /* Menu Card Styles */
    .menu-card {
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--box-shadow);
      transition: var(--transition);
      border: none;
      height: 100%;
      background: white;
    }

    .menu-card:hover {
      transform: translateY(-15px);
      box-shadow: var(--box-shadow-hover);
    }

    .menu-card.out-of-stock {
      opacity: 0.6;
      pointer-events: none;
    }

    .menu-img-wrapper {
      position: relative;
      overflow: hidden;
      height: 250px;
    }

    .menu-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .stock-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(25, 135, 84, 0.95);
      color: white;
      padding: 8px 15px;
      border-radius: 25px;
      font-weight: 600;
      font-size: 0.85rem;
    }

    .stock-badge.low-stock {
      background: rgba(255, 193, 7, 0.95);
      color: var(--dark);
    }

    .stock-badge.out-of-stock {
      background: rgba(220, 53, 69, 0.95);
    }

    .card-body {
      padding: 25px;
    }

    .card-title {
      font-weight: 700;
      font-size: 1.4rem;
      color: var(--secondary);
      margin-bottom: 12px;
    }

    .price {
      color: var(--accent);
      font-weight: 800;
      font-size: 1.5rem;
      margin-bottom: 20px;
    }

    /* Quantity Controls */
    .quantity-controls {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      gap: 15px;
    }

    .quantity-btn {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      font-weight: bold;
      transition: var(--transition);
    }

    .quantity-btn:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }

    .decrease-btn {
      background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
      color: white;
    }

    .increase-btn {
      background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
      color: white;
    }

    .quantity-display {
      font-size: 1.4rem;
      font-weight: 800;
      min-width: 50px;
      text-align: center;
    }

    /* Add to Cart Button */
    .add-to-cart-btn {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      color: white;
      padding: 15px 25px;
      border-radius: 50px;
      font-weight: 700;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
    }

    .add-to-cart-btn:hover:not(:disabled) {
      transform: translateY(-3px);
    }

    .add-to-cart-btn:disabled {
      background: var(--gray);
      cursor: not-allowed;
    }

    /* Cart Sidebar Styles */
    .cart-sidebar {
      position: fixed;
      top: 0;
      right: -450px;
      width: 450px;
      height: 100vh;
      background: white;
      z-index: 9999;
      box-shadow: var(--box-shadow);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .cart-sidebar.open {
      right: 0;
    }

    .cart-sidebar-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      padding: 25px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .cart-sidebar-header h4 {
      margin: 0;
      font-weight: 800;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .close-cart-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 1.5rem;
    }

    .cart-sidebar-content {
      flex: 1;
      padding: 30px;
      overflow-y: auto;
    }

    .cart-sidebar-footer {
      padding: 25px 30px;
      background: var(--light);
      border-top: 2px solid var(--gray-light);
    }

    /* Cart Items */
    .cart-items {
      min-height: 120px;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 20px;
      border-bottom: 2px solid #f0f0f0;
    }

    .cart-item-name {
      font-weight: 700;
      font-size: 1.1rem;
    }

    .cart-item-details {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .cart-item-quantity {
      background: var(--light);
      padding: 6px 15px;
      border-radius: 25px;
      font-weight: 700;
    }

    .cart-item-price {
      font-weight: 800;
      color: var(--accent);
      font-size: 1.1rem;
    }

    .cart-item-actions {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .cart-action-btn {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .cart-decrease-btn {
      background: linear-gradient(135deg, var(--warning) 0%, #e0a800 100%);
      color: white;
    }

    .cart-remove-btn {
      background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
      color: white;
    }

    .empty-cart {
      text-align: center;
      color: var(--gray);
      font-style: italic;
      padding: 40px 0;
      font-size: 1.1rem;
    }

    /* Customer Info */
    .customer-info {
      margin-bottom: 25px;
    }

    .customer-info label {
      font-weight: 700;
      margin-bottom: 10px;
      color: var(--secondary);
      font-size: 1.1rem;
    }

    .customer-info input {
      border-radius: 15px;
      padding: 15px 20px;
      border: 2px solid #e9ecef;
      font-size: 1rem;
      width: 100%;
    }

    .customer-info input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.3rem rgba(255, 102, 0, 0.15);
      outline: none;
    }

    /* Submit Button */
    .submit-btn {
      background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
      border: none;
      color: white;
      padding: 18px;
      border-radius: 50px;
      font-weight: 800;
      font-size: 1.2rem;
      transition: var(--transition);
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      cursor: pointer;
    }

    .submit-btn:hover:not(:disabled) {
      transform: translateY(-4px);
    }

    .submit-btn:disabled {
      background: var(--gray);
      cursor: not-allowed;
    }

    /* Notification - DIUBAH DARI KIRI */
    .notification {
      position: fixed;
      top: 100px;
      left: 20px; /* Diubah dari right ke left */
      padding: 15px 25px; /* Diperkecil padding */
      background: var(--accent);
      color: white;
      border-radius: 15px; /* Diperkecil border radius */
      box-shadow: var(--box-shadow);
      display: none;
      z-index: 10000;
      max-width: 300px; /* Dibatasi max-width */
      animation: slideInLeft 0.5s ease; /* Diubah dari slideInRight ke slideInLeft */
      font-weight: 600;
      font-size: 0.9rem; /* Font sedikit lebih kecil */
    }

    @keyframes slideInLeft {
      from {
        transform: translateX(-100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    /* Sidebar Overlay */
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 23, 43, 0.7);
      z-index: 9998;
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
    }

    .sidebar-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    /* Loading */
    .loading {
      display: inline-block;
      width: 22px;
      height: 22px;
      border: 3px solid rgba(255,255,255,.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
      .hero-section h1 {
        font-size: 2rem;
      }
      
      .section-title {
        font-size: 1.8rem;
      }
      
      .menu-img-wrapper {
        height: 200px;
      }
      
      .cart-sidebar {
        width: 100%;
        right: -100%;
      }
      
      .notification {
        left: 15px;
        max-width: calc(100% - 80px); /* Beri ruang untuk cart icon */
        top: 100px;
      }
    }

    @media (max-width: 576px) {
      body {
        padding-top: 80px;
      }
      
      .navbar {
        padding: 10px 0;
      }
      
      .navbar .container {
        padding: 0 10px;
      }
      
      .navbar-brand {
        font-size: 1rem;
        gap: 6px;
        max-width: 50%;
      }
      
      .navbar-brand img {
        width: 30px !important;
        height: 30px !important;
      }
      
      .action-buttons {
        gap: 5px;
      }
      
      .action-btn {
        padding: 8px 12px;
        font-size: 0.8rem;
        min-width: auto;
      }
      
      .action-btn span {
        display: none; /* Sembunyikan teks di mobile */
      }
      
      .action-btn i {
        margin: 0;
        font-size: 0.9rem;
      }
      
      .cart-container {
        top: 70px;
        right: 10px;
        z-index: 1001; /* Pastikan di atas notification */
      }
      
      .cart-icon {
        width: 50px;
        height: 50px;
      }
      
      .cart-icon i {
        font-size: 1.3rem;
      }
      
      .cart-count {
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
        top: -3px;
        right: -3px;
      }
      
      .hero-section {
        padding: 20px 15px;
        margin: 10px auto 25px;
      }
      
      .hero-section h1 {
        font-size: 1.5rem;
      }
      
      .hero-section p {
        font-size: 0.9rem;
      }
      
      .menu-section {
        padding: 20px 15px;
        margin: 10px auto;
      }
      
      .section-title {
        font-size: 1.5rem;
        margin-bottom: 25px;
      }
      
      .card-title {
        font-size: 1.1rem;
      }
      
      .price {
        font-size: 1.2rem;
      }
      
      .quantity-btn {
        width: 35px;
        height: 35px;
      }
      
      .add-to-cart-btn {
        padding: 10px 15px;
        font-size: 0.85rem;
      }
      
      .swiper-button-next, .swiper-button-prev {
        display: none;
      }
      
      /* PERBAIKAN UTAMA: Notification di mobile */
      .notification {
        top: 110px; /* Turunkan agar tidak menutupi cart icon */
        left: 10px;
        right: auto; /* Hapus right agar tidak full width */
        max-width: 250px; /* Lebar maksimal */
        padding: 10px 15px;
        font-size: 0.8rem;
        bottom: auto; /* Pastikan bottom tidak aktif */
      }
      
      /* Untuk layar sangat kecil, sesuaikan lagi */
      @media (max-width: 400px) {
        .notification {
          max-width: 220px;
          top: 100px;
        }
        
        .navbar-brand {
          font-size: 0.9rem;
          max-width: 45%;
        }
        
        .action-btn {
          padding: 6px 10px;
        }
      }
      
      @media (max-width: 350px) {
        .notification {
          max-width: 200px;
          top: 95px;
        }
        
        .navbar-brand {
          font-size: 0.8rem;
          max-width: 40%;
        }
        
        .action-buttons {
          gap: 3px;
        }
        
        .action-btn {
          padding: 5px 8px;
        }
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand" href="#">
       <img src="img/mieayam.png" alt="Logo" width="47" height="47">
        <span class="d-none d-sm-inline">Mie Ayam Bu Suyatmi</span>
        <span class="d-inline d-sm-none">Mie Bu Suyatmi</span>
      </a>
      <div class="d-flex align-items-center gap-3">
        <div class="action-buttons">
          <a href="index.php" class="action-btn">
            <i class="fas fa-home"></i> <span class="d-none d-md-inline">Beranda</span>
          </a>
          <button class="action-btn" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i> <span class="d-none d-md-inline">Refresh</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Cart Icon -->
<div class="cart-container">
  <div class="cart-icon" onclick="toggleCartSidebar()">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-count" id="cartCount">0</span>
  </div>
</div>

<div class="container">
  <!-- Hero Section -->
  <div class="hero-section">
    <h1><img src="img/mieayam.png" alt="Logo" width="63" height="63"> Selamat Datang!</h1>
    <p>Nikmati kelezatan menu kami dengan harga terjangkau rekk !!</p>
  </div>

  <!-- Menu Section -->
  <div class="menu-section" id="menu">
    <h2 class="section-title">
      <i class="fas fa-utensils"></i> Menu Kami
    </h2>

    <!-- Swiper Container -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM menu");
        while ($row = mysqli_fetch_assoc($result)) {
          $isOutOfStock = $row['stok_menu'] <= 0;
          $isLowStock = $row['stok_menu'] > 0 && $row['stok_menu'] <= 5;
        ?>
          <div class="swiper-slide">
            <div class="card menu-card <?= $isOutOfStock ? 'out-of-stock' : '' ?>">
              <div class="menu-img-wrapper">
                <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" class="menu-img" alt="<?= htmlspecialchars($row['nama_menu']); ?>">
                <div class="stock-badge <?= $isOutOfStock ? 'out-of-stock' : ($isLowStock ? 'low-stock' : '') ?>">
                  <i class="fas fa-box"></i> Stok: <?= $row['stok_menu']; ?>
                </div>
              </div>
              <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars($row['nama_menu']); ?></h5>
                <p class="price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>

                <div class="quantity-controls">
                  <button class="quantity-btn decrease-btn" onclick="kurangiJumlah('<?= htmlspecialchars($row['nama_menu']); ?>')">
                    <i class="fas fa-minus"></i>
                  </button>
                  <span class="quantity-display" id="jumlah-<?= htmlspecialchars($row['nama_menu']); ?>">0</span>
                  <button class="quantity-btn increase-btn" onclick="tambahJumlah('<?= htmlspecialchars($row['nama_menu']); ?>')" 
                          <?= $isOutOfStock ? 'disabled' : '' ?>>
                    <i class="fas fa-plus"></i>
                  </button>
                </div>

                <button class="add-to-cart-btn" onclick="tambahKeKeranjang('<?= htmlspecialchars($row['nama_menu']); ?>', <?= $row['harga']; ?>)" 
                        <?= $isOutOfStock ? 'disabled' : '' ?>>
                  <i class="fas fa-cart-plus"></i> <?= $isOutOfStock ? 'Habis' : 'Tambah' ?>
                </button>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</div>

<!-- Cart Sidebar -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeCartSidebar()"></div>

<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-sidebar-header">
    <h4><i class="fas fa-shopping-cart"></i> Keranjang Pesanan</h4>
    <button class="close-cart-btn" onclick="closeCartSidebar()">
      <i class="fas fa-times"></i>
    </button>
  </div>

  <div class="cart-sidebar-content">
    <div class="cart-items" id="cartItems">
      <div class="empty-cart">Belum ada pesanan.</div>
    </div>
  </div>

  <div class="cart-sidebar-footer">
    <div class="customer-info mb-4">
      <label class="form-label">Nama Pemesan:</label>
      <input type="text" id="namaPemesan" class="form-control" placeholder="Masukkan nama anda...">
    </div>

    <button class="submit-btn" onclick="kirimPesanan()" id="submitBtn">
      <i class="fas fa-paper-plane"></i> Kirim Pesanan
    </button>
  </div>
</div>

<!-- Notification -->
<div class="notification" id="notif"></div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Menu stock data from PHP
    const menuStocks = <?= json_encode($menu_data); ?>;

    let cartItems = [];
    let isSubmitting = false;

    // Initialize Swiper
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1400: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        });

        // Update cart count on load
        updateCartCount();
    });

    // Cart Sidebar Functions
    function toggleCartSidebar() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar.classList.contains('open')) {
            closeCartSidebar();
        } else {
            openCartSidebar();
        }
    }

    function openCartSidebar() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCartSidebar() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Notification Function
    function showNotification(message, type = 'success') {
        const notif = document.getElementById('notif');
        notif.textContent = message;
        
        // Set color based on type
        if (type === 'error') {
            notif.style.background = 'linear-gradient(135deg, var(--danger) 0%, #c82333 100%)';
        } else if (type === 'warning') {
            notif.style.background = 'linear-gradient(135deg, var(--warning) 0%, #e0a800 100%)';
        } else {
            notif.style.background = 'linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%)';
        }
        
        notif.style.display = 'block';
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notif.style.display = 'none';
        }, 3000);
    }

    // Menu Quantity Functions
    function tambahJumlah(menu) {
        const el = document.getElementById(`jumlah-${menu}`);
        let val = parseInt(el.textContent) || 0;
        const stockAvailable = menuStocks[menu] || 0;
        
        // Check current item in cart
        const currentInCart = cartItems.find(item => item.nama === menu);
        const totalInCart = currentInCart ? currentInCart.jumlah : 0;
        
        if (val + totalInCart >= stockAvailable) {
            showNotification(`Stok ${menu} tidak mencukupi! Tersisa ${stockAvailable}`, 'warning');
            return;
        }
        
        el.textContent = val + 1;
    }

    function kurangiJumlah(menu) {
        const el = document.getElementById(`jumlah-${menu}`);
        let val = parseInt(el.textContent) || 0;
        
        if (val > 0) {
            el.textContent = val - 1;
        }
    }

    // Cart Functions
    function tambahKeKeranjang(nama, harga) {
        const jumlahEl = document.getElementById(`jumlah-${nama}`);
        let jumlah = parseInt(jumlahEl.textContent) || 0;
        
        if (jumlah <= 0) {
            showNotification(`Jumlah belum diatur untuk ${nama}`, 'warning');
            return;
        }

        const stockAvailable = menuStocks[nama] || 0;
        const existing = cartItems.find(item => item.nama === nama);
        const totalInCart = existing ? existing.jumlah : 0;
        
        if (totalInCart + jumlah > stockAvailable) {
            showNotification(`Stok ${nama} tidak mencukupi! Tersisa ${stockAvailable}`, 'warning');
            return;
        }

        if (existing) {
            existing.jumlah += jumlah;
        } else {
            cartItems.push({ nama, harga, jumlah });
        }

        // Reset quantity display
        jumlahEl.textContent = 0;
        
        // Update cart view
        updateCartView();
        showNotification(`${nama} ditambahkan ke keranjang!`);
    }

    function updateCartView() {
        const cartDiv = document.getElementById('cartItems');
        const cartCount = document.getElementById('cartCount');

        if (cartItems.length === 0) {
            cartDiv.innerHTML = '<div class="empty-cart">Belum ada pesanan.</div>';
            cartCount.textContent = '0';
            return;
        }

        let total = 0;
        let cartHTML = '';
        
        cartItems.forEach((item, index) => {
            const subtotal = item.harga * item.jumlah;
            total += subtotal;
            
            cartHTML += `
                <div class="cart-item">
                    <div class="cart-item-name">${item.nama}</div>
                    <div class="cart-item-details">
                        <span class="cart-item-quantity">${item.jumlah} porsi</span>
                        <span class="cart-item-price">Rp ${subtotal.toLocaleString('id-ID')}</span>
                        <div class="cart-item-actions">
                            <button class="cart-action-btn cart-decrease-btn" onclick="kurangiDariKeranjang(${index})" title="Kurangi jumlah">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button class="cart-action-btn cart-remove-btn" onclick="hapusDariKeranjang(${index})" title="Hapus dari keranjang">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        
        // Add total
        cartHTML += `
            <div class="cart-item" style="border-top: 3px solid var(--primary); margin-top: 15px; padding-top: 15px; font-weight: 800; font-size: 1.2rem;">
                <div style="color: var(--primary);">Total Pembayaran</div>
                <div class="cart-item-price" style="font-size: 1.4rem;">Rp ${total.toLocaleString('id-ID')}</div>
            </div>
        `;
        
        cartDiv.innerHTML = cartHTML;
        cartCount.textContent = cartItems.length;
    }

    function updateCartCount() {
        const cartCount = document.getElementById('cartCount');
        cartCount.textContent = cartItems.length;
    }

    function kurangiDariKeranjang(index) {
        if (cartItems[index].jumlah > 1) {
            cartItems[index].jumlah -= 1;
            showNotification(`Jumlah ${cartItems[index].nama} dikurangi`);
        } else {
            const namaMenu = cartItems[index].nama;
            cartItems.splice(index, 1);
            showNotification(`${namaMenu} dihapus dari keranjang`);
        }
        updateCartView();
    }

    function hapusDariKeranjang(index) {
        const namaMenu = cartItems[index].nama;
        cartItems.splice(index, 1);
        updateCartView();
        showNotification(`${namaMenu} dihapus dari keranjang`);
    }

    // Submit Order Function
    function kirimPesanan() {
        if (isSubmitting) return;
        
        if (cartItems.length === 0) {
            showNotification("Keranjang masih kosong!", 'warning');
            return;
        }

        const namaPemesan = document.getElementById('namaPemesan').value.trim();
        if (namaPemesan === "") {
            showNotification("Masukkan nama pemesan dulu!", 'warning');
            return;
        }

        isSubmitting = true;
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<div class="loading"></div> Memproses...';
        submitBtn.disabled = true;

        // Prepare form data
        const formData = new FormData();
        formData.append('nama_pemesan', namaPemesan);
        formData.append('pesanan', JSON.stringify(cartItems));

        fetch("pesan_menu.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                showNotification("Pesanan berhasil dikirim!");
                
                // Reset cart
                cartItems = [];
                updateCartView();
                document.getElementById('namaPemesan').value = '';
                
                // Close sidebar
                closeCartSidebar();
                
                // Refresh page to update stocks
                setTimeout(() => {
                    location.reload();
                }, 1500);
                
            } else if (result.includes("error_stok_")) {
                const menuName = result.replace("error_stok_", "");
                showNotification(`Stok ${menuName} tidak mencukupi!`, 'error');
            } else {
                showNotification("Gagal mengirim pesanan: " + result, 'error');
            }
        })
        .catch(err => {
            showNotification("Error: " + err, 'error');
        })
        .finally(() => {
            isSubmitting = false;
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    // Close sidebar with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeCartSidebar();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>