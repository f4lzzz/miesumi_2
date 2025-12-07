<?php
include 'connection.php';
// Tambahkan di awal file update_pesanan_group.php, setelah include
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debugging info
if (isset($_POST)) {
    error_log("POST Data: " . print_r($_POST, true));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemesan = $_POST['nama_pemesan'];
    $group_waktu = $_POST['group_waktu']; // waktu acuan untuk grup
    $aksi = $_POST['aksi']; // 'selesai' atau 'batal'
    
    // Tentukan batas waktu grup (10 menit sebelum/sesudah)
    $time_before = date('Y-m-d H:i:s', strtotime($group_waktu . ' -10 minutes'));
    $time_after = date('Y-m-d H:i:s', strtotime($group_waktu . ' +10 minutes'));
    
    // Ambil semua item pesanan dalam rentang waktu 10 menit
    $result = $conn->query("
        SELECT d.*, m.nama_menu, m.stok_menu 
        FROM detail_pesanan d 
        JOIN menu m ON d.id_menu = m.id_menu 
        WHERE d.nama_pemesan = '$nama_pemesan' 
        AND d.waktu BETWEEN '$time_before' AND '$time_after'
        AND d.status_pesanan = 'pending'
    ");

    if ($result->num_rows > 0) {
        // Proses setiap item dalam grup
        while ($row = $result->fetch_assoc()) {
            $id_detail = $row['id_detail'];
            $id_menu = $row['id_menu'];
            $jumlah = $row['jumlah'];
            $subtotal = $row['subtotal'];
            $nama_menu = $row['nama_menu'];
            $waktu_pesan = $row['waktu'];
            $stok_sekarang = $row['stok_menu'];
            
            // 1. Simpan ke riwayat_pemesanan (per item)
            $conn->query("
                INSERT INTO riwayat_pemesanan 
                (nama_pemesan, rincian_menu, jumlah, subtotal, status_pesanan, waktu, id_menu)
                VALUES 
                ('$nama_pemesan', '$nama_menu', '$jumlah', '$subtotal', '$aksi', '$waktu_pesan', '$id_menu')
            ");
            
            // 2. Update stok berdasarkan aksi
            if ($aksi == 'selesai') {
                // Kurangi stok jika selesai
                if ($stok_sekarang >= $jumlah) {
                    $conn->query("UPDATE menu SET stok_menu = stok_menu - $jumlah WHERE id_menu = '$id_menu'");
                }
            } elseif ($aksi == 'batal') {
                // Tambah stok jika batal
                $conn->query("UPDATE menu SET stok_menu = stok_menu + $jumlah WHERE id_menu = '$id_menu'");
            }
            
            // 3. Hapus dari detail_pesanan
            $conn->query("DELETE FROM detail_pesanan WHERE id_detail = '$id_detail'");
        }
        
        // Redirect dengan pesan sukses
        $redirect_msg = $aksi == 'selesai' ? 'completed' : 'cancelled';
        header("Location: admin_dashboard.php?page=pesanan&success=$redirect_msg");
        exit;
    } else {
        // Tidak ada data ditemukan
        header("Location: admin_dashboard.php?page=pesanan&error=no_data");
        exit;
    }
    
} else {
    header("Location: admin_dashboard.php?page=pesanan&error=invalid_request");
    exit;
}
?>