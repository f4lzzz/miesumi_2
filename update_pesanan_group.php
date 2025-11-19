<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemesan = $_POST['nama_pemesan'];
    $aksi = $_POST['aksi']; // 'selesai' atau 'batal'

    // Ambil semua item pesanan dari detail_pesanan
    $result = $conn->query("SELECT * FROM detail_pesanan WHERE nama_pemesan='$nama_pemesan'");

    while ($row = $result->fetch_assoc()) {
        $id_menu = $row['id_menu'];
        $jumlah = $row['jumlah'];
        $subtotal = $row['subtotal'];

        // Ambil nama menu
        $menu = $conn->query("SELECT nama_menu FROM menu WHERE id_menu='$id_menu'")->fetch_assoc();
        $nama_menu = $menu['nama_menu'];

        // Simpan ke riwayat_pemesanan
        $conn->query("
            INSERT INTO riwayat_pemesanan (nama_pemesan, rincian_menu, jumlah, subtotal, status_pesanan, id_menu)
            VALUES ('$nama_pemesan', '$nama_menu', '$jumlah', '$subtotal', '$aksi', '$id_menu')
        ");

        // Jika batal, kembalikan stok
        if ($aksi == 'batal') {
            $conn->query("UPDATE menu SET stok_menu = stok_menu + $jumlah WHERE id_menu='$id_menu'");
        }
    }

    // Hapus dari detail_pesanan setelah dipindah
    $conn->query("DELETE FROM detail_pesanan WHERE nama_pemesan='$nama_pemesan'");

    header("Location: admin_dashboard.php?page=pesanan");
    exit;
}
?>
