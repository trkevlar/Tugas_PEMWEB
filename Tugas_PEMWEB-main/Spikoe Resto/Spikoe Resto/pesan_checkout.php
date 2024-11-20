<?php
session_start();
require_once 'db_pemesanan.php';

// Check jika berhasil
if (!isset($_SESSION['success_message'])) {
    // check jika gagal
    session_destroy();
    header("Location: index.php");
    exit(); 
}

$success_message = $_SESSION['success_message'] = "Pesanan sedang diproses.";
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="style/checkout_pesan.css">
</head>
<body>
    <div class="background">
        <div class="container">
            <?php if (isset($success_message)): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <h1>Konfirmasi Pesanan</h1>
            <div class="order-details">
                <div class="customer-details">
                    <h2>Detail Pelanggan</h2>
                    <p><strong>Nama Kasir:</strong></p>
                    <p><strong>Tanggal:</strong> <?php echo date('d F Y H:i'); ?></p>
                    <p><strong>Nama Pelanggan:</strong> <?php echo isset($_SESSION['nama_pelanggan']) ? htmlspecialchars($_SESSION['nama_pelanggan']) : ; ?></p>
                    <p><strong>Nomor Pesanan:</strong> 001</p>
                </div>
                <div class="order-summary">
                    <h2>Detail Pemesanan</h2>
                    <?php if (isset($_SESSION['order_items'])): ?>
                        <?php foreach ($_SESSION['order_items'] as $item): ?>
                            <p><?php echo htmlspecialchars($item['name']); ?> 1x Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                        <?php endforeach; ?>
                        <p><strong>Total:</strong> Rp<?php echo number_format($_SESSION['total_amount'], 0, ',', '.'); ?></p>
                    <?php else: ?>
                        <p><strong>Total:</strong></p>
                    <?php endif; ?>
                </div>
                <div class="buttons">
                    <button class="btn btn-order" onclick="window.location.href='index.php'">Selesai</button>
                    <button class="btn btn-cancel" onclick="window.location.href='pesan.php'">Kembali</button>
                </div>
            </div>
        </div>
        <footer>
            <p>© 2024 CakePHP GROUP. Hak cipta dilindungi undang-undang.</p>
            <p>Contact Us: spikoeresto@gmail.com | +62852-5664-1111</p>
        </footer>
    </div>
</body>
</html>