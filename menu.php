<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Menu | Mie Ayam</title>
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">




<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-success">🍜 Daftar Menu Mie Ayam</h2>
    <a href="tambah_menu.php" class="btn btn-success">+ Tambah Menu Baru</a>
  </div>

  <div class="row">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM menu ORDER BY id_menu DESC");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='col-md-4 mb-4'>
              <div class='card shadow-sm border-0 h-100'>
                <div class='card-body'>
                  <h5 class='card-title text-success'>" . htmlspecialchars($row['nama_menu']) . "</h5>
                  <p class='card-text mb-1'><strong>Harga:</strong> Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
                  <p class='card-text mb-1'><strong>Kategori:</strong> " . htmlspecialchars($row['kategori_menu']) . "</p>
                  <p class='card-text mb-3'><strong>Stok:</strong> " . htmlspecialchars($row['stok_menu']) . "</p>
                  <a href='edit_menu.php?id=" . $row['id_menu'] . "' class='btn btn-warning btn-sm'>Edit</a>
                  <a href='hapus_menu.php?id=" . $row['id_menu'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus menu ini?\")'>Hapus</a>
                </div>
              </div>
            </div>
            ";
        }
    } else {
        echo "<p class='text-muted text-center'>Belum ada menu yang tersedia.</p>";
    }
    ?>
  </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
