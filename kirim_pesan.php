<?php
include 'connection.php'; // pastikan file ini sudah ada dan berisi koneksi $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil data dari form
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // cek apakah form terisi
    if (!empty($subject) && !empty($message)) {
        // query simpan ke tabel ulasan
        $query = "INSERT INTO ulasan (nama_pengguna, pesan) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $subject, $message);

        if ($stmt->execute()) {
            echo "
                <script>
                    alert('Terima kasih, pesan Anda telah dikirim!');
                    window.location.href = 'contact.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Terjadi kesalahan saat mengirim pesan.');
                    window.location.href = 'contact.php';
                </script>
            ";
        }

        $stmt->close();
    } else {
        echo "
            <script>
                alert('Harap isi semua kolom sebelum mengirim.');
                window.location.href = 'contact.php';
            </script>
        ";
    }
}

$conn->close();
?>
