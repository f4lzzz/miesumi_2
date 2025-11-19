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

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
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

    .container {
        animation: fadeInUp 0.6s ease-out;
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        animation: scaleIn 0.5s ease-out;
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 25px;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .card-header h4 {
        position: relative;
        z-index: 1;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: fadeInDown 0.8s ease-out;
    }

    .card-body {
        padding: 40px;
        background: white;
    }

    .form-group {
        animation: fadeInUp 0.6s ease-out backwards;
        margin-bottom: 25px;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }
    .form-group:nth-child(5) { animation-delay: 0.5s; }

    .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label i {
        color: var(--primary);
        font-size: 18px;
    }

    .form-control, .form-select {
        border: 2px solid var(--gray-light);
        border-radius: var(--border-radius);
        padding: 12px 15px;
        transition: var(--transition);
        font-size: 15px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(254, 161, 22, 0.25);
        transform: translateY(-2px);
    }

    .form-control:hover, .form-select:hover {
        border-color: var(--primary);
    }

    .btn {
        padding: 14px 30px;
        border-radius: var(--border-radius);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        animation: fadeInUp 0.8s ease-out backwards;
        animation-delay: 0.6s;
    }

    .btn-primary-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(254, 161, 22, 0.4);
    }

    .btn-outline-secondary {
        border: 2px solid var(--gray);
        color: var(--gray);
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: var(--gray);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .back-link {
        animation: fadeInUp 0.8s ease-out backwards;
        animation-delay: 0.7s;
    }

    .alert {
        border-radius: var(--border-radius);
        border: none;
        padding: 15px 20px;
        animation: fadeInDown 0.5s ease-out;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, var(--accent) 0%, #45a049 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #d32f2f 100%);
        color: white;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 40px 20px;
        border: 3px dashed var(--gray-light);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
        background: var(--light);
    }

    .file-input-label:hover {
        border-color: var(--primary);
        background: white;
    }

    .file-input-label i {
        font-size: 40px;
        color: var(--primary);
    }

    .file-name {
        margin-top: 10px;
        font-size: 14px;
        color: var(--gray);
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 25px;
        }
        
        .btn {
            padding: 12px 25px;
        }
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
          <label class="form-label">
            <i class="fas fa-utensils"></i>
            Nama Menu
          </label>
          <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Mie Ayam Special" required>
        </div>
        
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-money-bill-wave"></i>
            Harga (Rp)
          </label>
          <input type="number" step="0.01" name="harga" class="form-control" placeholder="Contoh: 15000" required>
        </div>
        
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-list"></i>
            Kategori
          </label>
          <select name="kategori" class="form-control form-select" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Makanan">Makanan</option>
            <option value="Minuman">Minuman</option>
          </select>
        </div>
        
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-boxes"></i>
            Stok Menu
          </label>
          <input type="number" name="stok_menu" class="form-control" placeholder="Contoh: 50" required>
        </div>
        
        <div class="form-group">
          <label class="form-label">
            <i class="fas fa-image"></i>
            Foto Menu
          </label>
          <div class="file-input-wrapper">
            <input type="file" name="gambar" id="fileInput" accept="image/*" onchange="updateFileName(this)">
            <label for="fileInput" class="file-input-label">
              <div class="text-center">
                <i class="fas fa-cloud-upload-alt"></i>
                <div class="mt-2">
                  <strong>Klik untuk upload foto</strong>
                  <div class="text-muted small">atau drag & drop file di sini</div>
                </div>
              </div>
            </label>
          </div>
          <div id="fileName" class="file-name"></div>
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary-custom w-100">
          <i class="fas fa-save"></i> Simpan Menu
        </button>
      </form>
      
      <div class="mt-4 text-center back-link">
        <a href="admin_dashboard.php" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left"></i> Kembali ke Daftar Menu
        </a>
      </div>
      
      <?php
      if (isset($_POST['submit'])) {
          $nama_menu = $_POST['nama_menu'];
          $harga = $_POST['harga'];
          $kategori = $_POST['kategori'];
          $stok_menu = $_POST['stok_menu'];
          
          // Upload foto
          $gambar = $_FILES['gambar']['name'];
          $tmp_name = $_FILES['gambar']['tmp_name'];
          $target_dir = "uploads/";
          
          // buat folder uploads kalau belum ada
          if (!is_dir($target_dir)) {
              mkdir($target_dir, 0777, true);
          }
          
          if ($gambar != "") {
              $nama_file_baru = time() . "_" . basename($gambar);
              $target_file = $target_dir . $nama_file_baru;
              move_uploaded_file($tmp_name, $target_file);
          } else {
              $nama_file_baru = null;
          }
          
          $query = "INSERT INTO menu (nama_menu, harga, kategori_menu, stok_menu, gambar)
                    VALUES ('$nama_menu', '$harga', '$kategori', '$stok_menu', '$nama_file_baru')";
          
          if (mysqli_query($conn, $query)) {
              echo "<div class='alert alert-success mt-4'>
                      <i class='fas fa-check-circle'></i>
                      Menu berhasil ditambahkan!
                    </div>";
          } else {
              echo "<div class='alert alert-danger mt-4'>
                      <i class='fas fa-times-circle'></i>
                      Gagal: " . mysqli_error($conn) . "
                    </div>";
          }
      }
      ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateFileName(input) {
    const fileNameDiv = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        fileNameDiv.innerHTML = '<i class="fas fa-file-image"></i> ' + input.files[0].name;
    } else {
        fileNameDiv.innerHTML = '';
    }
}

// Add ripple effect to buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        let ripple = document.createElement('span');
        ripple.classList.add('ripple');
        this.appendChild(ripple);
        
        let x = e.clientX - e.target.offsetLeft;
        let y = e.clientY - e.target.offsetTop;
        
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});
</script>
</body>
</html>