<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemesan = $_POST['nama_pemesan'];
    $group_waktu = $_POST['group_waktu'];
    
    // Tentukan batas waktu grup (10 menit sebelum/sesudah)
    $time_before = date('Y-m-d H:i:s', strtotime($group_waktu . ' -10 minutes'));
    $time_after = date('Y-m-d H:i:s', strtotime($group_waktu . ' +10 minutes'));
    
    // Hapus semua riwayat dalam rentang waktu 10 menit
    $delete_result = $conn->query("
        DELETE FROM riwayat_pemesanan 
        WHERE nama_pemesan = '$nama_pemesan' 
        AND waktu BETWEEN '$time_before' AND '$time_after'
        AND status_pesanan IN ('selesai', 'batal')
    ");
    
    if ($delete_result) {
        header("Location: admin_dashboard.php?page=riwayat&success=deleted");
    } else {
        header("Location: admin_dashboard.php?page=riwayat&error=delete_failed");
    }
    exit;
} else {
    header("Location: admin_dashboard.php?page=riwayat&error=invalid_request");
    exit;
}
?>