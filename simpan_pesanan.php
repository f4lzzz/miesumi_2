<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['nama_pemesan']) || !isset($input['items'])) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

$nama_pemesan = mysqli_real_escape_string($conn, $input['nama_pemesan']);
$items = $input['items'];
$total = 0;

foreach ($items as $item) {
    $id_menu = (int)$item['id_menu'];
    $jumlah = (int)$item['jumlah'];

    // Ambil data menu
    $menu_q = mysqli_query($conn, "SELECT nama_menu, harga, stok FROM menu WHERE id_menu = $id_menu");
    $menu = mysqli_fetch_assoc($menu_q);

    if (!$menu) {
        echo json_encode(['status' => 'error', 'message' => "Menu ID $id_menu tidak ditemukan"]);
        exit;
    }

    if ($menu['stok'] < $jumlah) {
        echo json_encode(['status' => 'error', 'message' => "Stok menu '{$menu['nama_menu']}' tidak mencukupi"]);
        exit;
    }

    $subtotal = $menu['harga'] * $jumlah;
    $total += $subtotal;

    // Simpan ke tabel detail_pesanan
    mysqli_query($conn, "
        INSERT INTO detail_pesanan (id_menu, nama_pemesan, jumlah, subtotal, status_pesanan)
        VALUES ($id_menu, '$nama_pemesan', $jumlah, $subtotal, 'pending')
    ");

    // Kurangi stok menu
    mysqli_query($conn, "UPDATE menu SET stok = stok - $jumlah WHERE id_menu = $id_menu");
}

echo json_encode([
    'status' => 'success',
    'message' => 'Pesanan berhasil disimpan',
    'total_harga' => $total
]);
?>
