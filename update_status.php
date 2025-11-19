<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_detail = $_POST['id_detail'];
    $aksi = $_POST['aksi'];

    if ($aksi === 'selesai') {
        // Ubah status jadi selesai, lalu hapus agar trigger berjalan
        mysqli_query($conn, "UPDATE detail_pesanan SET status_pesanan='selesai' WHERE id_detail='$id_detail'");
        mysqli_query($conn, "DELETE FROM detail_pesanan WHERE id_detail='$id_detail'");
        header("Location: admin_dashboard.php?msg=selesai");
    } elseif ($aksi === 'batal') {
        // Ubah status jadi batal, lalu hapus agar trigger berjalan
        mysqli_query($conn, "UPDATE detail_pesanan SET status_pesanan='batal' WHERE id_detail='$id_detail'");
        mysqli_query($conn, "DELETE FROM detail_pesanan WHERE id_detail='$id_detail'");
        header("Location: admin_dashboard.php?msg=batal");
    } else {
        header("Location: admin_dashboard.php?msg=error");
    }
    exit;
}
?>
