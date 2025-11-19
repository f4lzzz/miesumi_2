<?php
include 'connection.php';

// ✅ Cek apakah ID ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data menu berdasarkan id
    $result = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id'");
    $data = mysqli_fetch_assoc($result);

    // Jika data tidak ditemukan
    if (!$data) {
        echo "<div class='alert alert-danger text-center mt-3'>Data menu tidak ditemukan.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger text-center mt-3'>ID menu tidak tersedia di URL.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Menu | Mie Ayam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        background: linear-gradient(135deg, var(--light) 0%, #fff 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        padding: 20px 0;
    }

    .container {
        max-width: 800px;
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
        opacity: 0;
        transform: translateY(30px);
    }

    .card.show {
        animation: slideUp 0.6s ease forwards;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control, .form-select {
        border: 2px solid var(--gray-light);
        border-radius: 8px;
        padding: 0.75rem;
        transition: var(--transition);
        font-size: 1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(254, 161, 22, 0.25);
    }

    .form-control:hover, .form-select:hover {
        border-color: var(--primary);
    }

    .mb-3 {
        opacity: 0;
        transform: translateX(-20px);
    }

    .mb-3.show {
        animation: slideInLeft 0.5s ease forwards;
    }

    @keyframes slideInLeft {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .current-image-wrapper {
        position: relative;
        display: inline-block;
        opacity: 0;
        transform: scale(0.8);
    }

    .current-image-wrapper.show {
        animation: zoomIn 0.5s ease forwards;
    }

    @keyframes zoomIn {
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .current-image-wrapper img {
        border: 3px solid var(--primary);
        transition: var(--transition);
    }

    .current-image-wrapper img:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(254, 161, 22, 0.3);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(254, 161, 22, 0.4);
    }

    .btn-outline-secondary {
        border: 2px solid var(--secondary);
        color: var(--secondary);
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: var(--secondary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(15, 23, 43, 0.3);
    }

    .alert {
        border: none;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transform: translateX(20px);
    }

    .alert.show {
        animation: slideInRight 0.5s ease forwards;
    }

    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .alert-success {
        background: linear-gradient(135deg, var(--accent) 0%, #45a049 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #d32f2f 100%);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-header h4 {
            font-size: 1.25rem;
        }

        .btn {
            padding: 0.65rem 1.25rem;
            font-size: 0.95rem;
        }

        .current-image-wrapper img {
            max-width: 100%;
            height: auto;
        }
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .card-header h4 {
            font-size: 1.1rem;
            flex-direction: column;
            text-align: center;
        }

        .btn-warning, .btn-outline-secondary {
            width: 100%;
            margin-bottom: 10px;
        }

        .form-control, .form-select {
            font-size: 0.95rem;
        }
    }

    /* Loading Animation */
    .btn:active {
        transform: scale(0.98);
    }

    /* Input File Style */
    input[type="file"] {
        cursor: pointer;
    }

    input[type="file"]::file-selector-button {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        margin-right: 10px;
    }

    input[type="file"]::file-selector-button:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="card shadow-lg border-0" id="mainCard">
    <div class="card-header">
      <h4>
        <i class="fas fa-edit"></i>
        Edit Menu: <?= htmlspecialchars($data['nama_menu']); ?>
      </h4>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3 form-field">
          <label class="form-label">
            <i class="fas fa-utensils"></i>
            Nama Menu
          </label>
          <input type="text" name="nama_menu" class="form-control" value="<?= htmlspecialchars($data['nama_menu']); ?>" required>
        </div>

        <div class="mb-3 form-field">
          <label class="form-label">
            <i class="fas fa-money-bill-wave"></i>
            Harga (Rp)
          </label>
          <input type="number" step="0.01" name="harga" class="form-control" value="<?= htmlspecialchars($data['harga']); ?>" required>
        </div>

        <div class="mb-3 form-field">
          <label class="form-label">
            <i class="fas fa-list"></i>
            Kategori
          </label>
          <select name="kategori" class="form-control form-select" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Makanan" <?= ($data['kategori_menu'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
            <option value="Minuman" <?= ($data['kategori_menu'] == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
          </select>
        </div>

        <div class="mb-3 form-field">
          <label class="form-label">
            <i class="fas fa-boxes"></i>
            Stok Menu
          </label>
          <input type="number" name="stok_menu" class="form-control" value="<?= htmlspecialchars($data['stok_menu']); ?>" required>
        </div>

        <div class="mb-3 form-field">
          <label class="form-label">
            <i class="fas fa-image"></i>
            Foto Menu Saat Ini
          </label><br>
          <?php if (!empty($data['gambar'])): ?>
            <div class="current-image-wrapper" id="imageWrapper">
              <img src="uploads/<?= htmlspecialchars($data['gambar']); ?>" alt="Foto Menu" width="120" class="rounded shadow-sm mb-2">
            </div>
          <?php else: ?>
            <p class="text-muted"><i class="fas fa-exclamation-circle"></i> Belum ada foto.</p>
          <?php endif; ?>
        </div>

        <div class="mb-3 form-field">
          <label class="form-label">
            <i class="fas fa-camera"></i>
            Ubah Foto Menu (opsional)
          </label>
          <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar']); ?>">

        <button type="submit" name="update" class="btn btn-warning w-100">
          <i class="fas fa-save"></i>
          Perbarui Menu
        </button>
      </form>

      <div class="mt-3 text-center">
        <a href="admin_dashboard.php" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left"></i>
          Kembali ke Daftar Menu
        </a>
      </div>

      <?php
      if (isset($_POST['update'])) {
          $nama_menu = mysqli_real_escape_string($conn, $_POST['nama_menu']);
          $harga = mysqli_real_escape_string($conn, $_POST['harga']);
          $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
          $stok_menu = mysqli_real_escape_string($conn, $_POST['stok_menu']);
          $gambar_lama = $_POST['gambar_lama'];

          $gambar = $_FILES['gambar']['name'];
          $tmp_name = $_FILES['gambar']['tmp_name'];

          $target_dir = "uploads/";
          if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

          if (!empty($gambar)) {
              $nama_file_baru = time() . "_" . basename($gambar);
              $target_file = $target_dir . $nama_file_baru;

              if (move_uploaded_file($tmp_name, $target_file)) {
                  if (!empty($gambar_lama) && file_exists($target_dir . $gambar_lama)) {
                      unlink($target_dir . $gambar_lama);
                  }
              }
          } else {
              $nama_file_baru = $gambar_lama;
          }

          // ✅ Gunakan kolom kategori_menu yang benar
          $update = "UPDATE menu SET 
                        nama_menu='$nama_menu', 
                        harga='$harga', 
                        kategori_menu='$kategori', 
                        stok_menu='$stok_menu',
                        gambar='$nama_file_baru'
                     WHERE id_menu='$id'";

          if (mysqli_query($conn, $update)) {
              echo "<div class='alert alert-success mt-3' id='alertMsg'><i class='fas fa-check-circle'></i> Data berhasil diperbarui!</div>";
              echo "<script>
                setTimeout(() => { 
                  document.getElementById('alertMsg').classList.add('show');
                }, 100);
                setTimeout(() => { 
                  window.location.href = 'admin_dashboard.php'; 
                }, 2000);
              </script>";
          } else {
              echo "<div class='alert alert-danger mt-3' id='alertMsg'><i class='fas fa-times-circle'></i> Gagal: " . mysqli_error($conn) . "</div>";
              echo "<script>
                setTimeout(() => { 
                  document.getElementById('alertMsg').classList.add('show');
                }, 100);
              </script>";
          }
      }
      ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Animasi saat halaman dimuat
  document.addEventListener('DOMContentLoaded', function() {
    // Animasi card utama
    setTimeout(() => {
      document.getElementById('mainCard').classList.add('show');
    }, 100);

    // Animasi form fields secara berurutan
    const formFields = document.querySelectorAll('.form-field');
    formFields.forEach((field, index) => {
      setTimeout(() => {
        field.classList.add('show');
      }, 300 + (index * 100));
    });

    // Animasi gambar jika ada
    const imageWrapper = document.getElementById('imageWrapper');
    if (imageWrapper) {
      setTimeout(() => {
        imageWrapper.classList.add('show');
      }, 800);
    }
  });
</script>
</body>
</html>