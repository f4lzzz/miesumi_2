<?php
include 'connection.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];
    $level    = $_POST['level_akses'];

    // Cek apakah username sudah ada di tabel admin
    $check = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "❌ Username sudah digunakan!";
    } elseif ($password !== $confirm) {
        $error = "⚠ Password dan konfirmasi tidak cocok!";
    } else {
        // Enkripsi password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Simpan data ke tabel admin
        $query = mysqli_query($conn, "INSERT INTO admin (username, password, level_akses) 
                                      VALUES ('$username', '$hashed', '$level')");

        if ($query) {
            $success = "✅ Akun berhasil dibuat! Silakan login.";
        } else {
            $error = "❌ Gagal membuat akun: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Akun Admin</title>
  <link href="css/register.css" rel="stylesheet">
</head>
<body>

<div class="isi">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow border-0">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="mb-0">Daftar Akun Admin</h4>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="confirm" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Level Akses</label>
              <select name="level_akses" class="form-select" required>
                <option value="">-- Pilih Level Akses --</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
              </select>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
            <br>
            <br>
            <a href="login.php" class="btn btn-primary w-100">Login</a>
            <br>
            <br>
            <a href="index.html" class="btn btn-primary w-100">Kembali</a>
          </form>
          <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-3"><?= $error; ?></div>
          <?php elseif (isset($success)): ?>
            <div class="alert alert-success mt-3"><?= $success; ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>