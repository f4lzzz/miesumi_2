<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($conn->query("DELETE FROM riwayat_pemesanan WHERE id_riwayat = '$id'")) {
        echo "<script>
                alert('Riwayat pesanan berhasil dihapus!');
                window.location='admin_dashboard.php?page=riwayat';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus riwayat pesanan!');
                window.location='admin_dashboard.php?page=riwayat';
              </script>";
    }
}
?>
