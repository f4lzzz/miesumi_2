<?php
// Konfigurasi koneksi ke database
$host     = "localhost";     // Nama host (biasanya localhost)
$username = "root";          // Username MySQL kamu
$password = "";              // Password MySQL (kosong jika default di XAMPP)
$database = "test_constraint";      // Nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Mengecek koneksi
if (!$conn) {
    die("❌ Koneksi ke database gagal: " . mysqli_connect_error());
} else {
    // (Opsional) tampilkan pesan koneksi berhasil untuk debug
    // echo "✅ Koneksi berhasil!";
}
?>
