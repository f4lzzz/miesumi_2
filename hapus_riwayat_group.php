<?php
session_start(); // Mulai session untuk menyimpan state

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['nama_pemesan']) && isset($_POST['waktu'])) {
        $nama_pemesan = $_POST['nama_pemesan'];
        $waktu = $_POST['waktu'];
        
        // Hapus berdasarkan nama pemesan dan waktu
        $stmt = $conn->prepare("DELETE FROM riwayat_pemesanan WHERE nama_pemesan = ? AND waktu = ?");
        if($stmt) {
            $stmt->bind_param("ss", $nama_pemesan, $waktu);
            
            if ($stmt->execute()) {
                // Set session untuk pesan sukses
                $_SESSION['delete_message'] = 'success';
                // Redirect ke halaman riwayat
                header('Location: index.php?page=riwayat');
                exit();
            }
        }
    }
}

// Jika gagal atau bukan POST
header('Location: index.php?page=riwayat');
exit();
?>