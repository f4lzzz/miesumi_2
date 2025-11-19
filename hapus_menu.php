<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek dulu apakah menu masih digunakan di pesanan aktif
    $cek = $conn->query("SELECT COUNT(*) AS total FROM detail_pesanan WHERE id_menu = '$id'");
    $data = $cek->fetch_assoc();

    if ($data['total'] > 0) {
        echo "<script>
                alert('Gagal menghapus! Menu ini masih digunakan dalam pesanan aktif.');
                window.location='menu.php';
              </script>";
        exit;
    }

    // Hapus menu
    if ($conn->query("DELETE FROM menu WHERE id_menu = '$id'")) {
        echo "<script>
                alert('Menu berhasil dihapus!');
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
