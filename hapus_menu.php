<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file gambar dari tabel menu
    $getMenu = $conn->query("SELECT gambar FROM menu WHERE id_menu = '$id'");
    $menu = $getMenu->fetch_assoc();

    $foto = $menu['gambar'];

    // Cek apakah menu masih digunakan di pesanan aktif
    $cek = $conn->query("SELECT COUNT(*) AS total FROM detail_pesanan WHERE id_menu = '$id'");
    $data = $cek->fetch_assoc();

    if ($data['total'] > 0) {
        echo "<script>
                alert('Gagal menghapus! Menu ini masih digunakan dalam pesanan aktif.');
                window.location='menu.php';
              </script>";
        exit;
    }

    // Hapus file foto 
    if (!empty($foto)) {
        $path = "uploads/" . $foto;

        if (file_exists($path)) {
            unlink($path); // hapus file
        }
    }

    // Hapus menu dari database
    if ($conn->query("DELETE FROM menu WHERE id_menu = '$id'")) {
        echo "<script>
                alert('Menu dan fotonya berhasil dihapus!');
                window.location='admin_dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus menu!');
                window.location='menu.php';
              </script>";
    }
}
?>
