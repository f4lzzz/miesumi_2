<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Restoran - Bootstrap Restaurant Template</title>
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
                    <h1 class="text-primary m-0"><i class="fa fa-envelope me-3"></i>Kontak</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="index.html" class="nav-item nav-link">Beranda</a>
                        <a href="about.html" class="nav-item nav-link">Tentang</a>
                        <a href="service.html" class="nav-item nav-link">Layanan</a>
                        <a href="menu.html" class="nav-item nav-link">Menu</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Halaman</a>
                            <div class="dropdown-menu m-0">
                                <a href="booking.html" class="dropdown-item">Pemesanan</a>
                                <a href="team.html" class="dropdown-item">Tim Kami</a>
                                <a href="testimonial.html" class="dropdown-item">Testimoni</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link active">Kontak</a>
                    </div>
                    <a href="" class="btn btn-primary py-2 px-4">Login</a>
                </div>
            </nav>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Hubungi Kami</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="#">Halaman</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Kontak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Contact Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Hubungi Kami</h5>
                    <h1 class="mb-5">Hubungi Kami Untuk Pertanyaan Apapun</h1>
                </div>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row gy-4">
                            <div class="col-md-4">
                                <h5 class="section-title ff-secondary fw-normal text-start text-primary">Pemesanan</h5>
                                <p><i class="fa fa-envelope-open text-primary me-2"></i>book@example.com</p>
                            </div>
                            <div class="col-md-4">
                                <h5 class="section-title ff-secondary fw-normal text-start text-primary">Umum</h5>
                                <p><i class="fa fa-envelope-open text-primary me-2"></i>info@example.com</p>
                            </div>
                            <div class="col-md-4">
                                <h5 class="section-title ff-secondary fw-normal text-start text-primary">Teknis</h5>
                                <p><i class="fa fa-envelope-open text-primary me-2"></i>tech@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                        <iframe class="position-relative rounded w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.6468371371393!2d111.8685705740287!3d-7.613352975261857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784bf0c17233d3%3A0x8bc1e51d5539cd1e!2sRumah%20Faul!5e0!3m2!1sid!2sus!4v1762873841775!5m2!1sid!2sus"
                            frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                    </div>
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                                      <form action="kirim_pesan.php" method="POST">
                                    
                                        <br>
        <div class="col-12">
            <div class="form-floating">
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                <label for="subject">Nama</label>
            </div>
        </div>
        <br>
        <div class="col-12">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a message here" id="message" name="message" style="height: 150px" required></textarea>
                <label for="message">Pesan</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary w-100 py-3" type="submit">Kirim</button>
        </div>
    </div>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Miayam Bu Suyatmi Section -->
                    <div class="col-lg-4 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Miayam Bu Suyatmi</h4>
                        <p class="mb-3">Mie ayam legendaris dengan cita rasa khas yang telah dikenal sejak lama di Nganjuk.</p>
                        <div class="d-flex flex-column">
                            <a class="text-light mb-2" href="about.html"><i class="fa fa-angle-right me-2"></i>Tentang Kami</a>
                            <a class="text-light mb-2" href="contact.html"><i class="fa fa-angle-right me-2"></i>Kontak</a>
                            <a class="text-light mb-2" href="booking.html"><i class="fa fa-angle-right me-2"></i>Reservasi</a>
                        </div>
                    </div>
                    
                    <!-- Kontak Section -->
                    <div class="col-lg-4 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Kontak</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Dusun Pesu Kidul, Desa Girirejo, Kecamatan Bagor, Kabupaten Nganjuk</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><a href="https://wa.me/6285853484468">+62 858-5348-4468</a></p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>mochammadfaul20@gmail.com</p>
                        
                    </div>
                    
                    <!-- Jam Buka Section -->
                    <div class="col-lg-4 col-md-6">
                        <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Jam Buka</h4>
                        <h5 class="text-light fw-normal">Senin - Minggu</h5>
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
</body>

</html>