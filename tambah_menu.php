<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Menu | Mie Ayam</title>
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
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        background: linear-gradient(135deg, var(--light) 0%, #fff 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh; padding: 20px 0;
    }
    @keyframes fadeInUp { from {opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }
    @keyframes fadeInDown { from {opacity:0; transform:translateY(-30px);} to {opacity:1; transform:translateY(0);} }
    @keyframes scaleIn { from {opacity:0; transform:scale(0.9);} to {opacity:1; transform:scale(1);} }
    .container { animation: fadeInUp 0.6s ease-out; }
    .card { border:none; border-radius:var(--border-radius); box-shadow:var(--box-shadow); overflow:hidden; animation:scaleIn 0.5s ease-out; }
    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding:25px; position:relative; overflow:hidden;
    }
    .card-header::before {
        content:''; position:absolute; top:-50%; right:-50%; width:200%; height:200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation:pulse 3s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100%{transform:scale(1);opacity:0.5;} 50%{transform:scale(1.1);opacity:0.8;} }
    .card-header h4 { position:relative; z-index:1; font-weight:700; display:flex; align-items:center; gap:10px; animation:fadeInDown 0.8s ease-out; }
    .card-body { padding:40px; background:white; }
    .form-group { animation:fadeInUp 0.6s ease-out backwards; margin-bottom:25px; }
    .form-group:nth-child(1) { animation-delay: .1s; } .form-group:nth-child(2) { animation-delay: .2s; }
    .form-group:nth-child(3) { animation-delay: .3s; } .form-group:nth-child(4) { animation-delay: .4s; }
    .form-group:nth-child(5) { animation-delay: .5s; }
    .form-label { font-weight:600; color:var(--dark); margin-bottom:10px; display:flex; align-items:center; gap:8px; }
    .form-label i { color:var(--primary); font-size:18px; }
    .form-control, .form-select {
        border:2px solid var(--gray-light); border-radius:var(--border-radius);
        padding:12px 15px; transition:var(--transition); font-size:15px;
    }
    .form-control:focus, .form-select:focus {
        border-color:var(--primary); box-shadow:0 0 0 0.2rem rgba(254,161,22,0.25); transform:translateY(-2px);
    }
    .btn { padding:14px 30px; border-radius:var(--border-radius); font-weight:600; text-transform:uppercase;
        letter-spacing:0.5px; transition:var(--transition); border:none; position:relative; overflow:hidden; }
    .btn-primary-custom {
        background:linear-gradient(135deg,var(--primary)0%,var(--primary-dark)100%); color:white;
        animation:fadeInUp .8s ease-out backwards; animation-delay:.6s;
    }
    .btn-primary-custom:hover { transform:translateY(-3px); box-shadow:0 6px 20px rgba(254,161,22,0.4); }
    .alert-success {
        background:linear-gradient(135deg,var(--accent)0%,#45a049 100%); color:white;
    }
    .alert-danger {
        background:linear-gradient(135deg,var(--danger)0%,#d32f2f 100%); color:white;
    }
    .alert-warning {
        background:linear-gradient(135deg,var(--warning)0%,#f57c00 100%); color:white;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="card shadow-lg">
    <div class="card-header">
      <h4 class="mb-0 text-white">
        <i class="fas fa-plus-circle"></i>
        Tambah Menu Baru
      </h4>
    </div>

    <div class="card-body">
      <form method="POST" enctype="multipart/form-data" id="menuForm">

        <div class="form-group">
          <label class="form-label"><i class="fas fa-utensils"></i> Nama Menu</label>
          <input type="text" name="nama_menu" class="form-control" required>
        </div>

        <div class="form-group">
          <label class="form-label"><i class="fas fa-money-bill-wave"></i> Harga (Rp)</label>
          <input type="number" step="0.01" name="harga" class="form-control" required>
        </div>

        <div class="form-group">
          <label class="form-label"><i class="fas fa-list"></i> Kategori</label>
          <select name="kategori" class="form-control form-select" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Makanan">Makanan</option>
            <option value="Minuman">Minuman</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label"><i class="fas fa-boxes"></i> Stok Menu</label>
          <input type="number" name="stok_menu" class="form-control" required min="1" id="stokMenuInput">
          <small class="text-muted">Jumlah stok bahan baku akan berkurang sesuai input ini</small>
        </div>

        <!-- DROPDOWN STOK BAHAN BAKU -->
        <div class="form-group">
          <label class="form-label"><i class="fas fa-box"></i> Stok Bahan Baku</label>
          <select name="id_stok" class="form-control form-select" required id="stokBahanSelect">
            <option value="">-- Pilih Stok Bahan Baku --</option>
            <?php
            $stok = mysqli_query($conn, "SELECT * FROM stok_bahan_baku");
            while ($row = mysqli_fetch_assoc($stok)) {
                echo "<option value='".$row['id_stok']."' data-jumlah='".$row['jumlah']."'>".$row['nama_bahan']." (Stok: ".$row['jumlah'].")</option>";
            }
            ?>
          </select>
          <small class="text-muted" id="stokInfo"></small>
        </div>

        <div class="form-group">
          <label class="form-label"><i class="fas fa-image"></i> Foto Menu</label>
          <input type="file" name="gambar" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-primary-custom w-100">
          <i class="fas fa-save"></i> Simpan Menu
        </button>
      </form>

      <div class="mt-4 text-center">
        <a href="admin_dashboard.php" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>

      <?php
      if (isset($_POST['submit'])) {

          $nama_menu = mysqli_real_escape_string($conn, $_POST['nama_menu']);
          $harga = mysqli_real_escape_string($conn, $_POST['harga']);
          $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
          $stok_menu = intval($_POST['stok_menu']);
          $id_stok = intval($_POST['id_stok']);

          // CEK STOK BAHAN BAKU DULU
          $cek_stok = mysqli_query($conn, "SELECT jumlah, nama_bahan FROM stok_bahan_baku WHERE id_stok = $id_stok");
          $data_stok = mysqli_fetch_assoc($cek_stok);
          
          if ($data_stok['jumlah'] < $stok_menu) {
              echo "<div class='alert alert-warning mt-4'>
                      <i class='fas fa-exclamation-triangle'></i> 
                      Stok bahan baku <strong>".$data_stok['nama_bahan']."</strong> tidak cukup! 
                      (Tersedia: ".$data_stok['jumlah'].", Dibutuhkan: $stok_menu)
                    </div>";
          } else {

              // UPLOAD FOTO
              $gambar = $_FILES['gambar']['name'];
              $tmp = $_FILES['gambar']['tmp_name'];
              $folder = "uploads/";

              if (!is_dir($folder)) mkdir($folder);

              if ($gambar != "") {
                  $nama_file = time() . "_" . $gambar;
                  move_uploaded_file($tmp, $folder.$nama_file);
              } else {
                  $nama_file = null;
              }

              // MULAI TRANSACTION
              mysqli_begin_transaction($conn);

              try {
                  // 1. INSERT MENU
                  $query_menu = "INSERT INTO menu (nama_menu, harga, kategori_menu, stok_menu, gambar, id_stok)
                                VALUES ('$nama_menu', '$harga', '$kategori', '$stok_menu', '$nama_file', '$id_stok')";
                  
                  if (!mysqli_query($conn, $query_menu)) {
                      throw new Exception("Gagal insert menu: " . mysqli_error($conn));
                  }

                  // 2. UPDATE STOK BAHAN BAKU (KURANGI)
                  $query_update_stok = "UPDATE stok_bahan_baku 
                                       SET jumlah = jumlah - $stok_menu 
                                       WHERE id_stok = $id_stok";
                  
                  if (!mysqli_query($conn, $query_update_stok)) {
                      throw new Exception("Gagal update stok: " . mysqli_error($conn));
                  }

                  // COMMIT TRANSACTION
                  mysqli_commit($conn);

                  echo "<div class='alert alert-success mt-4'>
                          <i class='fas fa-check-circle'></i> 
                          Menu berhasil ditambahkan! Stok bahan baku <strong>".$data_stok['nama_bahan']."</strong> berkurang $stok_menu 
                          (Sisa: ".($data_stok['jumlah'] - $stok_menu).")
                        </div>";
                  
                  // REFRESH HALAMAN SETELAH 2 DETIK
                  echo "<script>setTimeout(function(){ window.location.href = 'tambah_menu.php'; }, 2000);</script>";

              } catch (Exception $e) {
                  // ROLLBACK JIKA GAGAL
                  mysqli_rollback($conn);
                  echo "<div class='alert alert-danger mt-4'>
                          <i class='fas fa-times-circle'></i> 
                          Gagal: " . $e->getMessage() . "
                        </div>";
              }
          }
      }
      ?>

    </div>
  </div>
</div>

<script>
// VALIDASI REAL-TIME STOK
document.getElementById('stokMenuInput').addEventListener('input', function() {
    const stokMenu = parseInt(this.value) || 0;
    const selectedOption = document.getElementById('stokBahanSelect').selectedOptions[0];
    const stokBahan = parseInt(selectedOption.getAttribute('data-jumlah')) || 0;
    const infoBox = document.getElementById('stokInfo');
    
    if (stokMenu > 0 && stokBahan > 0) {
        if (stokMenu > stokBahan) {
            infoBox.innerHTML = '<span style="color: red;">⚠️ Stok tidak cukup! (Tersedia: ' + stokBahan + ')</span>';
        } else {
            infoBox.innerHTML = '<span style="color: green;">✓ Stok cukup. Sisa setelah input: ' + (stokBahan - stokMenu) + '</span>';
        }
    }
});

document.getElementById('stokBahanSelect').addEventListener('change', function() {
    document.getElementById('stokMenuInput').dispatchEvent(new Event('input'));
});
</script>

</body>
</html>