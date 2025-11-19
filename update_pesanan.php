<?php
include 'connection.php';

if (isset($_POST['nama_pemesan']) && isset($_POST['aksi'])) {
    $nama_pemesan = $_POST['nama_pemesan'];
    $aksi = $_POST['aksi'];

    // Tentukan status baru
    $status_baru = ($aksi == 'selesai') ? 'selesai' : 'batal';

    // Update status pesanan di detail_pesanan
    $conn->query("UPDATE detail_pesanan SET status_pesanan = '$status_baru' WHERE nama_pemesan = '$nama_pemesan'");

    // Ambil semua menu yang dipesan oleh pembeli ini
    $result = $conn->query("
        SELECT m.nama_menu, d.jumlah, d.subtotal
        FROM detail_pesanan d
        JOIN menu m ON d.id_menu = m.id_menu
        WHERE d.nama_pemesan = '$nama_pemesan'
    ");

    $daftar_menu = [];
    $total_jumlah = 0;
    $total_subtotal = 0;

    while ($row = $result->fetch_assoc()) {
        $daftar_menu[] = $row['nama_menu'] . ' (' . $row['jumlah'] . 'x)';
        $total_jumlah += $row['jumlah'];
        $total_subtotal += $row['subtotal'];
    }

    // Gabungkan semua nama menu jadi satu string
    $rincian_menu = implode(', ', $daftar_menu);

    // Masukkan ke riwayat_pemesanan
    $conn->query("
        INSERT INTO riwayat_pemesanan (nama_pemesan, rincian_menu, jumlah, subtotal, status_pesanan, waktu)
        VALUES ('$nama_pemesan', '$rincian_menu', '$total_jumlah', '$total_subtotal', '$status_baru', NOW())
    ");

    // Hapus pesanan dari detail_pesanan (stok otomatis diatur oleh trigger)
    $conn->query("DELETE FROM detail_pesanan WHERE nama_pemesan = '$nama_pemesan'");

    header("Location: admin_dashboard.php?page=pesanan");
    exit;
}
?>
