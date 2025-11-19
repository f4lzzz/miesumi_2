<?php
session_start();
include 'connection.php';

if (isset($_POST['login'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Ambil data admin dari database
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        // Verifikasi password
        if (password_verify($password, $data['password'])) {

            // Simpan ke session
            $_SESSION['login'] = true;
            $_SESSION['id_admin'] = $data['id_admin'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['level_akses'] = $data['level_akses'];

            // Redirect ke menu utama
            header("Location: admin_dashboard.php");
            exit;

        } else {
            $error = "❌ Password salah!";
        }
    } else {
        $error = "⚠️ Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin</title>
<link href="css/login.css" rel="stylesheet">
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="Username" class="input-box" placeholder="Username" required>
        <input type="password" name="Password" class="input-box" placeholder="Password" required>
        <button type="submit" name="login" class="btn-login">Login</button>
    </form>

<?php if (isset($error)): ?>
    <div style="color: red; text-align:center; margin-top:10px;">
        <?= $error; ?>
    </div>
<?php endif; ?>

<div class="footer-text">
    <a href="index.php">Kembali ke Halaman Utama</a>
</div>

</div>

</body>
</html>
