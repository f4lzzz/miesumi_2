<?php
include 'connection.php';

// Ambil data menu dari database
$result = mysqli_query($conn, "SELECT * FROM menu");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Mie Ayam Bu Suyatmi</title>
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
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        /* Custom styles for menu slider */
        .menu-slider-section {
            padding: 50px 0;
            background: #f8f9fa;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        .menu-slider-title {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .menu-slider-title h2 {
            color: #FEA116;
            font-weight: 800;
            font-size: 2.5rem;
            position: relative;
            display: inline-block;
        }
        
        .menu-slider-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #FEA116 0%, #FFB74D 100%);
            border-radius: 2px;
        }
        
        .swiper {
            width: 100%;
            padding: 40px 10px;
        }
        
        .menu-card-slider {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            transition: all 0.4s ease;
            height: 100%;
        }
        
        .menu-card-slider:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        
        .menu-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 250px;
        }
        
        .menu-img-slider {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .menu-card-slider:hover .menu-img-slider {
            transform: scale(1.1);
        }
        
        .stock-badge-slider {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(25, 135, 84, 0.95);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .stock-badge-slider.low-stock {
            background: rgba(255, 193, 7, 0.95);
            color: #0F172B;
        }
        
        .stock-badge-slider.out-of-stock {
            background: rgba(220, 53, 69, 0.95);
        }
        
        .menu-card-body {
            padding: 25px;
            text-align: center;
        }
        
        .menu-card-title {
            font-weight: 700;
            font-size: 1.4rem;
            color: #0F172B;
            margin-bottom: 12px;
        }
        
        .menu-price {
            color: #4CAF50;
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        .menu-order-btn {
            background: linear-gradient(135deg, #FEA116 0%, #e55c00 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        
        .menu-order-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 102, 0, 0.4);
            color: white;
        }
        
        /* Swiper Navigation Buttons */
        .swiper-button-next, .swiper-button-prev {
            background: linear-gradient(135deg, #FEA116 0%, #e55c00 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 0 8px 25px rgba(255, 102, 0, 0.4);
            transition: all 0.3s ease;
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
        
        /* Swiper Pagination */
        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #e9ecef;
            opacity: 1;
        }
        
        .swiper-pagination-bullet-active {
            background: #FEA116;
        }
        
        .out-of-stock-overlay {
            position: relative;
        }
        
        .out-of-stock-overlay::after {
            content: 'HABIS';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            background: #dc3545;
            color: white;
            padding: 15px 50px;
            font-size: 1.8rem;
            font-weight: 900;
            z-index: 10;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .menu-card-slider.out-of-stock {
            opacity: 0.7;
        }
        
        @media (max-width: 768px) {
            .menu-slider-title h2 {
                font-size: 2rem;
            }
            
            .menu-img-wrapper {
                height: 200px;
            }
            
            .swiper-button-next, .swiper-button-prev {
                width: 40px;
                height: 40px;
            }
            
            .swiper-button-next:after, .swiper-button-prev:after {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 576px) {
            .swiper-button-next, .swiper-button-prev {
                display: none;
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
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Mie Sumi</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="index.php" class="nav-item nav-link active">Beranda</a>
                        <a href="about.html" class="nav-item nav-link">Tentang</a>
                        
                        <a href="menu_index.php" class="nav-item nav-link">Menu</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Halaman</a>
                            <div class="dropdown-menu m-0">
                                <a href="booking.html" class="dropdown-item">Pemesanan</a>
                                <a href="team.html" class="dropdown-item">Tim Kami</a>
                                <a href="testimonial.html" class="dropdown-item">Testimoni</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Kontak</a>
                    </div>
                    <a href="login.php" class="btn btn-primary py-2 px-4">LOGIN</a>
                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft">Nikmati<br>Mie Ayam kami</h1>
                            <p class="text-white animated slideInLeft mb-4 pb-2">Nikmati Mi Ayam khas Nganjuk dengan rasa istimewa, kenyal di setiap suapan, dan kuah sedap yang memanjakan lidah</p>
                            <a href="pesan_menu.php" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Pilih Menu</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <img class="img-fluid" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->



        

        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="img/about-1.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s" src="img/about-2.jpg" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s" src="img/about-3.png">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s" src="img/about-4.png">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Kenali Kami</h5>
                        <h1 class="mb-4">Selamat Datang</h1>
                        <p class="mb-4">Mie Ayam Bu Suyatmi telah hadir sejak 2013 dengan cita rasa khas, porsi melimpah, dan harga bersahabat. Berlokasi di Girirejo, Bagor, Nganjuk, kami menyajikan mie ayam dengan topping yang royal dan pelayanan penuh kehangatan. Kami terus berkomitmen untuk berkembang dan menjadi pilihan utama pecinta mie ayam di mana pun berada.
</p>
                        <p class="mb-4"></p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">12</h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Tahun Pengalaman</p>
                                        <h6 class="text-uppercase mb-0">Membuat Mie</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">3</h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Menu Khas</p>
                                        <h6 class="text-uppercase mb-0">Mie Ayam</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-primary py-3 px-5 mt-2" href="pesan_menu.php">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Menu Start -->
        <div class="container-xxl menu-slider-section">
            <div class="container">
                <div class="menu-slider-title">
                    <h2><i class="fa fa-utensils"></i> Menu Spesial Kami</h2>
                </div>
                
                <!-- Swiper Slider -->
                <div class="swiper menuSwiper">
                    <div class="swiper-wrapper">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $isOutOfStock = $row['stok_menu'] <= 0;
                                $isLowStock = $row['stok_menu'] > 0 && $row['stok_menu'] <= 5;
                        ?>
                            <div class="swiper-slide">
                                <div class="menu-card-slider <?= $isOutOfStock ? 'out-of-stock' : '' ?>">
                                    <div class="menu-img-wrapper <?= $isOutOfStock ? 'out-of-stock-overlay' : '' ?>">
                                        <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" class="menu-img-slider" alt="<?= htmlspecialchars($row['nama_menu']); ?>">
                                        <div class="stock-badge-slider <?= $isOutOfStock ? 'out-of-stock' : ($isLowStock ? 'low-stock' : '') ?>">
                                            <i class="fas fa-box"></i> Stok: <?= $row['stok_menu']; ?>
                                        </div>
                                    </div>
                                    <div class="menu-card-body">
                                        <h5 class="menu-card-title"><?= htmlspecialchars($row['nama_menu']); ?></h5>
                                        <p class="menu-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                        <a href="pesan_menu.php" class="menu-order-btn">
                                            <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<div class="swiper-slide"><p class="text-center">Belum ada menu tersedia</p></div>';
                        }
                        ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <!-- Menu End -->


       

        <!-- Team Start -->
        <!-- Team End -->
        

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
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
    <script>
        // Initialize Menu Swiper
        var menuSwiper = new Swiper(".menuSwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
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
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1400: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
    </script>
</body>

</html>