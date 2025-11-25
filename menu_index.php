<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Menu</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        /* =====================
           CUSTOM ANIMATIONS
        ===================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* =====================
           ENHANCED MENU STYLES
        ===================== */
        
        /* Menu Item Container */
        .menu-item-container {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .menu-item-container:nth-child(1) { animation-delay: 0.1s; }
        .menu-item-container:nth-child(2) { animation-delay: 0.15s; }
        .menu-item-container:nth-child(3) { animation-delay: 0.2s; }
        .menu-item-container:nth-child(4) { animation-delay: 0.25s; }
        .menu-item-container:nth-child(5) { animation-delay: 0.3s; }
        .menu-item-container:nth-child(6) { animation-delay: 0.35s; }
        .menu-item-container:nth-child(7) { animation-delay: 0.4s; }
        .menu-item-container:nth-child(8) { animation-delay: 0.45s; }

        /* Enhanced Menu Item */
        .enhanced-menu-item {
            display: flex;
            align-items: center;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .enhanced-menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(254, 161, 22, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .enhanced-menu-item:hover {
            transform: translateX(10px) scale(1.02);
            box-shadow: 0 10px 35px rgba(254, 161, 22, 0.25);
            border-color: rgba(254, 161, 22, 0.3);
        }

        .enhanced-menu-item:hover::before {
            left: 100%;
        }

        /* Menu Image */
        .menu-img-enhanced {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.4s ease;
            position: relative;
            z-index: 1;
        }

        .enhanced-menu-item:hover .menu-img-enhanced {
            transform: scale(1.15) rotate(3deg);
            box-shadow: 0 8px 25px rgba(254, 161, 22, 0.4);
        }

        /* Menu Content */
        .menu-content-enhanced {
            flex: 1;
            padding-left: 25px;
            position: relative;
            z-index: 1;
        }

        .menu-title-enhanced {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0F172B;
            margin-bottom: 5px;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .enhanced-menu-item:hover .menu-title-enhanced {
            color: #FEA116;
        }

        .menu-description {
            color: #6c757d;
            font-size: 0.9rem;
            font-style: italic;
            margin-bottom: 10px;
        }

        .menu-price-enhanced {
            font-size: 1.5rem;
            font-weight: 800;
            color: #FEA116;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-price-enhanced::before {
            content: '';
            width: 4px;
            height: 28px;
            background: linear-gradient(180deg, #FEA116 0%, #e55c00 100%);
            border-radius: 2px;
            display: inline-block;
        }

        /* Stock Badge */
        .stock-badge-enhanced {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stock-badge-enhanced.low-stock {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #000;
            animation: pulse 2s infinite;
        }

        .stock-badge-enhanced.out-of-stock {
            background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%);
        }

        /* Out of Stock Overlay */
        .enhanced-menu-item.out-of-stock {
            opacity: 0.6;
            position: relative;
        }

        .enhanced-menu-item.out-of-stock::after {
            content: 'HABIS';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            background: rgba(220, 53, 69, 0.95);
            color: white;
            padding: 10px 40px;
            font-size: 1.5rem;
            font-weight: 900;
            z-index: 10;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            letter-spacing: 3px;
        }

        /* Tab Enhancement */
        .nav-pills .nav-link {
            border-radius: 15px;
            padding: 15px 30px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            font-weight: 600;
        }

        .nav-pills .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: rgba(254, 161, 22, 0.1);
            transition: width 0.4s ease;
        }

        .nav-pills .nav-link:hover::before {
            width: 100%;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #FEA116 0%, #e55c00 100%);
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(254, 161, 22, 0.4);
        }

        .nav-pills .nav-link i {
            transition: transform 0.4s ease;
            font-size: 2rem;
        }

        .nav-pills .nav-link:hover i {
            transform: rotate(360deg);
        }

        .nav-pills .nav-link div {
            text-align: left;
        }

        .nav-pills .nav-link small {
            display: block;
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .nav-pills .nav-link h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            opacity: 0;
            animation: scaleIn 0.6s ease forwards;
        }

        .empty-state i {
            font-size: 6rem;
            color: #dee2e6;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        .empty-state h4 {
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .empty-state p {
            color: #adb5bd;
            font-size: 1.1rem;
        }

        /* Loading Shimmer */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        /* Hero Animation */
        .hero-header {
            animation: fadeInUp 0.8s ease;
        }

        .hero-header h1 {
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .breadcrumb {
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        /* Detail Button */
        .detail-btn {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: linear-gradient(135deg, #FEA116 0%, #e55c00 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(254, 161, 22, 0.3);
            z-index: 2;
        }

        .detail-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(254, 161, 22, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .enhanced-menu-item {
                padding: 15px;
            }

            .menu-img-enhanced {
                width: 90px;
                height: 90px;
            }

            .menu-title-enhanced {
                font-size: 1.1rem;
            }

            .menu-price-enhanced {
                font-size: 1.3rem;
            }

            .nav-pills .nav-link {
                padding: 12px 20px;
            }

            .nav-pills .nav-link i {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 768px) {
            .enhanced-menu-item {
                flex-direction: column;
                text-align: center;
                padding: 20px 15px;
            }

            .menu-img-enhanced {
                margin-bottom: 15px;
                width: 100px;
                height: 100px;
            }

            .menu-content-enhanced {
                padding-left: 0;
                width: 100%;
            }

            .menu-price-enhanced {
                justify-content: center;
            }

            .stock-badge-enhanced {
                top: 10px;
                right: 10px;
            }

            .detail-btn {
                position: static;
                width: 100%;
                margin-top: 15px;
            }

            .nav-pills .nav-link {
                padding: 10px 15px;
            }

            .nav-pills .nav-link small {
                font-size: 0.7rem;
            }

            .nav-pills .nav-link h6 {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .menu-img-enhanced {
                width: 80px;
                height: 80px;
            }

            .menu-title-enhanced {
                font-size: 1rem;
            }

            .menu-description {
                font-size: 0.85rem;
            }

            .menu-price-enhanced {
                font-size: 1.1rem;
            }

            .stock-badge-enhanced {
                padding: 6px 12px;
                font-size: 0.75rem;
            }

            .enhanced-menu-item.out-of-stock::after {
                padding: 8px 30px;
                font-size: 1.2rem;
            }

            .empty-state {
                padding: 60px 15px;
            }

            .empty-state i {
                font-size: 4rem;
            }

            .empty-state h4 {
                font-size: 1.2rem;
            }

            .empty-state p {
                font-size: 0.95rem;
            }

            .nav-pills {
                flex-direction: column;
                gap: 10px;
            }

            .nav-pills .nav-link {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Menu</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="index.php" class="nav-item nav-link">Beranda</a>
                        <a href="about.html" class="nav-item nav-link">Tentang</a>
                        
                        <a href="menu.html" class="nav-item nav-link active">Menu</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Halaman</a>
                            <div class="dropdown-menu m-0">
                                <a href="pesan_menu.php" class="dropdown-item">Pemesanan</a>
                                <a href="team.html" class="dropdown-item">Team Kami</a>
                               
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Kontak</a>
                    </div>
                   
                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Menu Kami</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                            
                            <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Menu Start -->
        <?php
        include 'connection.php';

        // Ambil semua menu dari database
        $query_menu = "SELECT * FROM menu ORDER BY kategori_menu, nama_menu";
        $result_menu = mysqli_query($conn, $query_menu);

        if (!$result_menu) {
            die("SQL ERROR: " . mysqli_error($conn));
        }

        // Pisahkan kategori
        $menu_makanan = [];
        $menu_minuman = [];

        while ($row = mysqli_fetch_assoc($result_menu)) {
            $kategori = strtolower(trim($row['kategori_menu']));
            
            if ($kategori === 'makanan') {
                $menu_makanan[] = $row;
            } elseif ($kategori === 'minuman') {
                $menu_minuman[] = $row;
            }
        }
        ?>

        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Daftar Menu</h5>
                    <h1 class="mb-5">Menu Terpopuler Kami</h1>
                </div>
                
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-makanan">
                                <i class="fa fa-utensils fa-2x text-primary"></i>
                                <div class="ps-3">
                                    <small class="text-body">Lezat</small>
                                    <h6 class="mt-n1 mb-0">Makanan</h6>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-minuman">
                                <i class="fa fa-coffee fa-2x text-primary"></i>
                                <div class="ps-3">
                                    <small class="text-body">Segar</small>
                                    <h6 class="mt-n1 mb-0">Minuman</h6>
                                </div>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <!-- Tab Makanan -->
                        <div id="tab-makanan" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <?php if (count($menu_makanan) > 0): ?>
                                    <?php foreach ($menu_makanan as $index => $menu): 
                                        $isOutOfStock = $menu['stok_menu'] <= 0;
                                        $isLowStock = $menu['stok_menu'] > 0 && $menu['stok_menu'] <= 5;
                                    ?>
                                        <div class="col-lg-6 menu-item-container">
                                            <div class="enhanced-menu-item <?= $isOutOfStock ? 'out-of-stock' : '' ?>">
                                                <img class="menu-img-enhanced" 
                                                     src="uploads/<?= htmlspecialchars($menu['gambar']); ?>" 
                                                     alt="<?= htmlspecialchars($menu['nama_menu']); ?>"
                                                     onerror="this.src='img/menu-placeholder.jpg'">
                                                
                                                <div class="stock-badge-enhanced <?= $isOutOfStock ? 'out-of-stock' : ($isLowStock ? 'low-stock' : '') ?>">
                                                    <i class="fas fa-box"></i>
                                                    <?= $isOutOfStock ? 'Habis' : 'Stok: ' . $menu['stok_menu']; ?>
                                                </div>
                                                
                                                <div class="menu-content-enhanced">
                                                    <h5 class="menu-title-enhanced">
                                                        <i class="fas fa-utensils text-primary"></i>
                                                        <?= htmlspecialchars($menu['nama_menu']); ?>
                                                    </h5>
                                                    <p class="menu-description">
                                                        
                                                    </p>
                                                    <div class="menu-price-enhanced">
                                                        Rp <?= number_format($menu['harga'], 0, ',', '.'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <div class="empty-state">
                                            <i class="fas fa-utensils"></i>
                                            <h4>Belum Ada Menu Makanan</h4>
                                            <p>Menu makanan akan segera ditambahkan. Nantikan menu lezat kami!</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Tab Minuman -->
                        <div id="tab-minuman" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <?php if (count($menu_minuman) > 0): ?>
                                    <?php foreach ($menu_minuman as $index => $menu): 
                                        $isOutOfStock = $menu['stok_menu'] <= 0;
                                        $isLowStock = $menu['stok_menu'] > 0 && $menu['stok_menu'] <= 5;
                                    ?>
                                        <div class="col-lg-6 menu-item-container">
                                            <div class="enhanced-menu-item <?= $isOutOfStock ? 'out-of-stock' : '' ?>">
                                                <img class="menu-img-enhanced" 
                                                     src="uploads/<?= htmlspecialchars($menu['gambar']); ?>" 
                                                     alt="<?= htmlspecialchars($menu['nama_menu']); ?>"
                                                     onerror="this.src='img/menu-placeholder.jpg'">
                                                
                                                <div class="stock-badge-enhanced <?= $isOutOfStock ? 'out-of-stock' : ($isLowStock ? 'low-stock' : '') ?>">
                                                    <i class="fas fa-box"></i>
                                                    <?= $isOutOfStock ? 'Habis' : 'Stok: ' . $menu['stok_menu']; ?>
                                                </div>
                                                
                                                <div class="menu-content-enhanced">
                                                    <h5 class="menu-title-enhanced">
                                                        <i class="fas fa-glass-martini text-primary"></i>
                                                        <?= htmlspecialchars($menu['nama_menu']); ?>
                                                    </h5>
                                                    <p class="menu-description">
                                                        Minuman segar yang sempurna untuk menemani hidangan Anda
                                                    </p>
                                                    <div class="menu-price-enhanced">
                                                        Rp <?= number_format($menu['harga'], 0, ',', '.'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12">
                                        <div class="empty-state">
                                            <i class="fas fa-coffee"></i>
                                            <h4>Belum Ada Menu Minuman</h4>
                                            <p>Menu minuman akan segera ditambahkan. Nantikan minuman segar kami!</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu End -->
        

            <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Miayam Bu Suyatmi Section -->
                    <div class="col-lg-4 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Miayam Bu Suyatmi</h4>
                        <p class="mb-3">Mie ayam ikonik dengan cita rasa khas yang telah dikenal sejak lama di Nganjuk.</p>
                        <div class="d-flex flex-column">
                            <a class="text-light mb-2" href="about.html"><i class="fa fa-angle-right me-2"></i>Tentang Kami</a>
                            <a class="text-light mb-2" href="contact.php"><i class="fa fa-angle-right me-2"></i>Kontak</a>
                            
                        </div>
                    </div>
                    
                    <!-- Kontak Section -->
                    <div class="col-lg-4 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Kontak</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Dusun Pesu Kidul, Desa Girirejo, Kecamatan Bagor, Kabupaten Nganjuk</p>
                        <p class="mb-2"><i class="fab fa-whatsapp fa-lg alt me-3"></i><a href="https://wa.me/6285853484468">+62 858-5348-4468</a></p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i><a href="mailto:miesumi02@gmail.com">miesumi02@gmail.com</a></p>
                        
                    </div>
                    
                    <!-- Jam Buka Section -->
                    <div class="col-lg-4 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Jam Buka</h4>
                        <h5 class="text-light fw-normal">Setiap Hari</h5>
                        <p>14:30 - 22:00 WIB</p>
                            
                    </div>
                </div>
                
                <!-- Copyright Section -->
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <p class="mb-0">&copy; <span id="currentYear"></span> Miayam Bu Suyatmi. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize animations
            const menuItems = document.querySelectorAll('.menu-item-container');
            
            // Create intersection observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            // Observe all menu items
            menuItems.forEach(item => {
                observer.observe(item);
            });

            // Add hover effects
            const enhancedItems = document.querySelectorAll('.enhanced-menu-item');
            enhancedItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>