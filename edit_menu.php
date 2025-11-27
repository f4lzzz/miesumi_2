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

    .alert-warning {
        background: linear-gradient(135deg, var(--warning) 0%, #f57c00 100%);
        color: white;
    }

    .info-box {
        background: #f8f9fa;
        border-left: 4px solid var(--info);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 0.5rem;
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

    .btn:active {
        transform: scale(0.98);
    }

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
          <input type="number" name="stok_menu" class="form-control" value="<?= htmlspecialchars($data['stok_menu']); ?>" required min="0" id="stokMenuInput">
          <input type="hidden" name="stok_menu_lama" value="<?= htmlspecialchars($data['stok_menu']); ?>">
          <small class="text-muted">Stok saat ini: <strong><?= htmlspecialchars($data['stok_menu']); ?></strong></small>
        </div>

        <!-- DROPDOWN STOK BAHAN BAKU -->
        <div class="mb-3 form-field">
          <label class="form-label">
            <i class="fas fa-box"></i>
            Stok Bahan Baku
          </label>
          <select name="id_stok" class="form-control form-select" required id="stokBahanSelect">
            <option value="">-- Pilih Stok Bahan Baku --</option>
            <?php
            $stok = mysqli_query($conn, "SELECT * FROM stok_bahan_baku");
            while ($row = mysqli_fetch_assoc($stok)) {
                $selected = ($row['id_stok'] == $data['id_stok']) ? 'selected' : '';
                echo "<option value='".$row['id_stok']."' data-jumlah='".$row['jumlah']."' $selected>".$row['nama_bahan']." (Stok: ".$row['jumlah'].")</option>";
            }
            ?>
          </select>
          <input type="hidden" name="id_stok_lama" value="<?= htmlspecialchars($data['id_stok']); ?>">
          <small class="text-muted" id="stokInfo"></small>
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
          $stok_menu_baru = intval($_POST['stok_menu']);
          $stok_menu_lama = intval($_POST['stok_menu_lama']);
          $id_stok_baru = intval($_POST['id_stok']);
          $id_stok_lama = intval($_POST['id_stok_lama']);
          $gambar_lama = $_POST['gambar_lama'];

          // Hitung selisih stok
          $selisih_stok = $stok_menu_baru - $stok_menu_lama;

          // CEK APAKAH BAHAN BAKU DIGANTI
          $ganti_bahan = ($id_stok_baru != $id_stok_lama);

          // Validasi stok bahan baku
          $cek_stok = mysqli_query($conn, "SELECT jumlah, nama_bahan FROM stok_bahan_baku WHERE id_stok = $id_stok_baru");
          $data_stok = mysqli_fetch_assoc($cek_stok);

          // Jika ganti bahan baku, perlu stok penuh untuk menu baru
          if ($ganti_bahan) {
              if ($data_stok['jumlah'] < $stok_menu_baru) {
                  echo "<div class='alert alert-warning mt-3' id='alertMsg'>
                          <i class='fas fa-exclamation-triangle'></i> 
                          Stok bahan baku <strong>".$data_stok['nama_bahan']."</strong> tidak cukup! 
                          (Tersedia: ".$data_stok['jumlah'].", Dibutuhkan: $stok_menu_baru)
                        </div>";
                  echo "<script>setTimeout(() => { document.getElementById('alertMsg').classList.add('show'); }, 100);</script>";
                  exit;
              }
          } else {
              // Jika tidak ganti bahan, cek apakah ada penambahan stok
              if ($selisih_stok > 0) {
                  if ($data_stok['jumlah'] < $selisih_stok) {
                      echo "<div class='alert alert-warning mt-3' id='alertMsg'>
                              <i class='fas fa-exclamation-triangle'></i> 
                              Stok bahan baku <strong>".$data_stok['nama_bahan']."</strong> tidak cukup untuk menambah stok menu! 
                              (Tersedia: ".$data_stok['jumlah'].", Dibutuhkan: $selisih_stok)
                            </div>";
                      echo "<script>setTimeout(() => { document.getElementById('alertMsg').classList.add('show'); }, 100);</script>";
                      exit;
                  }
              }
          }

          // UPLOAD FOTO
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

          // MULAI TRANSACTION
          mysqli_begin_transaction($conn);

          try {
              // 1. UPDATE MENU
              $update = "UPDATE menu SET 
                            nama_menu='$nama_menu', 
                            harga='$harga', 
                            kategori_menu='$kategori', 
                            stok_menu='$stok_menu_baru',
                            gambar='$nama_file_baru',
                            id_stok='$id_stok_baru'
                         WHERE id_menu='$id'";

              if (!mysqli_query($conn, $update)) {
                  throw new Exception("Gagal update menu: " . mysqli_error($conn));
              }

              // 2. UPDATE STOK BAHAN BAKU
              if ($ganti_bahan) {
                  // Kembalikan stok bahan lama
                  $query_kembalikan = "UPDATE stok_bahan_baku 
                                      SET jumlah = jumlah + $stok_menu_lama 
                                      WHERE id_stok = $id_stok_lama";
                  
                  if (!mysqli_query($conn, $query_kembalikan)) {
                      throw new Exception("Gagal mengembalikan stok lama: " . mysqli_error($conn));
                  }

                  // Kurangi stok bahan baru
                  $query_kurangi = "UPDATE stok_bahan_baku 
                                   SET jumlah = jumlah - $stok_menu_baru 
                                   WHERE id_stok = $id_stok_baru";
                  
                  if (!mysqli_query($conn, $query_kurangi)) {
                      throw new Exception("Gagal mengurangi stok baru: " . mysqli_error($conn));
                  }

                  $pesan_stok = "Bahan baku diganti. Stok lama dikembalikan, stok baru berkurang $stok_menu_baru";
              } else {
                  // Jika bahan tidak diganti, update berdasarkan selisih
                  if ($selisih_stok != 0) {
                      $query_update_stok = "UPDATE stok_bahan_baku 
                                           SET jumlah = jumlah - ($selisih_stok) 
                                           WHERE id_stok = $id_stok_baru";
                      
                      if (!mysqli_query($conn, $query_update_stok)) {
                          throw new Exception("Gagal update stok: " . mysqli_error($conn));
                      }

                      if ($selisih_stok > 0) {
                          $pesan_stok = "Stok menu bertambah $selisih_stok, stok bahan baku <strong>".$data_stok['nama_bahan']."</strong> berkurang $selisih_stok";
                      } else {
                          $pesan_stok = "Stok menu berkurang ".abs($selisih_stok).", stok bahan baku <strong>".$data_stok['nama_bahan']."</strong> bertambah ".abs($selisih_stok);
                      }
                  } else {
                      $pesan_stok = "Stok menu tidak berubah";
                  }
              }

              // COMMIT TRANSACTION
              mysqli_commit($conn);

              echo "<div class='alert alert-success mt-3' id='alertMsg'>
                      <i class='fas fa-check-circle'></i> 
                      Menu berhasil diperbarui! $pesan_stok
                    </div>";
              echo "<script>
                setTimeout(() => { 
                  document.getElementById('alertMsg').classList.add('show');
                }, 100);
                setTimeout(() => { 
                  window.location.href = 'admin_dashboard.php'; 
                }, 3000);
              </script>";

          } catch (Exception $e) {
              // ROLLBACK JIKA GAGAL
              mysqli_rollback($conn);
              echo "<div class='alert alert-danger mt-3' id='alertMsg'>
                      <i class='fas fa-times-circle'></i> 
                      Gagal: " . $e->getMessage() . "
                    </div>";
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
    setTimeout(() => {
      document.getElementById('mainCard').classList.add('show');
    }, 100);

    const formFields = document.querySelectorAll('.form-field');
    formFields.forEach((field, index) => {
      setTimeout(() => {
        field.classList.add('show');
      }, 300 + (index * 100));
    });

    const imageWrapper = document.getElementById('imageWrapper');
    if (imageWrapper) {
      setTimeout(() => {
        imageWrapper.classList.add('show');
      }, 800);
    }
  });

  // VALIDASI REAL-TIME STOK
  const stokMenuInput = document.getElementById('stokMenuInput');
  const stokBahanSelect = document.getElementById('stokBahanSelect');
  const stokInfo = document.getElementById('stokInfo');
  const stokMenuLama = <?= $data['stok_menu']; ?>;
  const idStokLama = <?= $data['id_stok']; ?>;

  function validateStok() {
      const stokMenuBaru = parseInt(stokMenuInput.value) || 0;
      const selectedOption = stokBahanSelect.selectedOptions[0];
      
      if (!selectedOption || !selectedOption.value) {
          stokInfo.innerHTML = '';
          return;
      }

      const idStokBaru = parseInt(selectedOption.value);
      const stokBahan = parseInt(selectedOption.getAttribute('data-jumlah')) || 0;
      const selisihStok = stokMenuBaru - stokMenuLama;
      const gantiBahan = (idStokBaru != idStokLama);

      if (gantiBahan) {
          // Jika ganti bahan, perlu cek stok penuh
          if (stokMenuBaru > stokBahan) {
              stokInfo.innerHTML = '<span style="color: red;">⚠️ Stok tidak cukup! (Tersedia: ' + stokBahan + ', Dibutuhkan: ' + stokMenuBaru + ')</span>';
          } else {
              stokInfo.innerHTML = '<span style="color: orange;">ℹ️ Bahan baku akan diganti. Stok lama akan dikembalikan. Sisa stok bahan baru: ' + (stokBahan - stokMenuBaru) + '</span>';
          }
      } else {
          // Jika tidak ganti bahan
          if (selisihStok > 0) {
              if (selisihStok > stokBahan) {
                  stokInfo.innerHTML = '<span style="color: red;">⚠️ Stok tidak cukup untuk menambah! (Tersedia: ' + stokBahan + ', Dibutuhkan: ' + selisihStok + ')</span>';
              } else {
                  stokInfo.innerHTML = '<span style="color: green;">✓ Stok menu akan bertambah ' + selisihStok + '. Sisa stok bahan: ' + (stokBahan - selisihStok) + '</span>';
              }
          } else if (selisihStok < 0) {
              stokInfo.innerHTML = '<span style="color: blue;">ℹ️ Stok menu akan berkurang ' + Math.abs(selisihStok) + '. Stok bahan akan bertambah ' + Math.abs(selisihStok) + '</span>';
          } else {
              stokInfo.innerHTML = '<span style="color: gray;">ℹ️ Tidak ada perubahan stok</span>';
          }
      }
  }

  stokMenuInput.addEventListener('input', validateStok);
  stokBahanSelect.addEventListener('change', validateStok);

  // Panggil validasi saat load
  validateStok();
</script>
</body>
</html>