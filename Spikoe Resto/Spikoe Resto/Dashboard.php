<?php
session_start();
require_once 'db.php';

// Cek apakah user sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fungsi untuk mendapatkan total booking hari ini
function getTotalBookingToday($conn) {
    $today = date("Y-m-d");
    $query = "SELECT COUNT(*) as total FROM reservasi WHERE DATE(tanggal_reservasi) = '$today'";
    $result = $conn->query($query);
    return $result->fetch_assoc()['total'];
}

// Fungsi untuk mendapatkan total pesanan hari ini (termasuk delivery)
function getTotalOrdersToday($conn) {
    $today = date("Y-m-d");
    $query = "SELECT COUNT(*) as total FROM pesanan WHERE DATE(dibuat_pada) = '$today'";
    $result = $conn->query($query);
    return $result->fetch_assoc()['total'];
}

// Fungsi untuk mendapatkan pendapatan hari ini
function getTotalRevenueToday($conn) {
    $today = date("Y-m-d");
    $query = "SELECT SUM(total_harga) as total FROM pesanan WHERE DATE(dibuat_pada) = '$today'";
    $result = $conn->query($query);
    return $result->fetch_assoc()['total'] ?? 0;
}

// Fungsi untuk mendapatkan pesanan terbaru
function getLatestOrders($conn, $limit = 5) {
    $query = "SELECT * FROM pesanan ORDER BY dibuat_pada DESC LIMIT $limit";
    return $conn->query($query);
}

// Fungsi untuk mendapatkan booking mendatang
function getUpcomingBookings($conn, $limit = 5) {
    $today = date("Y-m-d");
    $query = "SELECT * FROM reservasi WHERE tanggal_reservasi >= '$today' ORDER BY tanggal_reservasi ASC LIMIT $limit";
    return $conn->query($query);
}

// Mendapatkan data untuk dashboard
$totalBookingToday = getTotalBookingToday($conn);
$totalOrdersToday = getTotalOrdersToday($conn);
$totalRevenueToday = getTotalRevenueToday($conn);
$latestOrders = getLatestOrders($conn);
$upcomingBookings = getUpcomingBookings($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style/Dashboard.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="Style/Assets/Logo.png" alt="logo">
        </div>
        <ul class="nav-sections">
            <li>
                <img src="Style/Assets/Dashboard.png" alt="Dashboard">
                <a href="Dashboard.php">Dashboard</a>
            </li>
            <li>
                <img src="Style/Assets/Manajemen-pengguna.png" alt="Manajemen_pengguna">
                <a href="Manajemen_pengguna.php">Manajemen Pengguna</a>
            </li>
            <li>
                <img src="Style/Assets/Manajemen-menu.png" alt="Manajemen_menu">
                <a href="Manajemen_menu.php">Manajemen Menu</a>
            </li>
            <li>
                <img src="Style/Assets/Manajemen-reservasi.png" alt="Manajemen_reservasi">
                <a href="Manajemen_reservasi.php">Manajemen Reservasi</a>
            </li>
            <li>
                <img src="Style/Assets/Pesanan-delivery.png" alt="Pesanan-delivery">
                <a href="Pesanan_delivery.php">Pesanan Delivery</a>
            </li>
            <li>
                <img src="Style/Assets/Pembayaran.png" alt="Pembayaran">
                <a href="Pembayaran.php">Pembayaran</a>
            </li>
            <li>
                <img src="Style/Assets/Laporan-keuangan.png" alt="Laporan-keuangan">
                <a href="Laporan_keuangan.php">Laporan Keuangan</a>
            </li>
            <li>
                <img src="Style/Assets/Pengaturan.png" alt="Pengaturan">
                <a href="Pengaturan.php">Pengaturan</a>
            </li>
            <li>
                <img src="Style/Assets/Manajemen-konten.png" alt="Manajemen_konten">
                <a href="Manajemen_konten.php">Manajemen Konten</a>
            </li>
            <li>
                <img src="Style/Assets/Logout.png" alt="Logout">
                <a href="Logout.php">Logout</a>
            </li>
        </ul>
    </div>
    <div class="content">
        <div class="title">Dashboard Admin</div>
        <div class="table-container">
            <table class="total">
                <thead>
                    <tr>
                        <th colspan="2">Total Booking Hari ini</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h5>19</h5><p>Meja</p>
                        </td>
                        <td>
                            <h5>7</h5><p>Ruangan</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="total">
                <thead>
                    <tr>
                        <th>Total Delivery Hari ini</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h5>149</h5>
                            <p>Pemesanan</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="total">
                <thead>
                    <tr>
                        <th>Pendapatan Hari ini</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h5>43.799.200,00</h5>
                            <p>Rupiah</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4">Pesanan Terbaru</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Costomer</td>
                    <td>Jumlah</td>
                    <td>Total</td>
                    <td>Status</td>
                </tr>
                <tr>
                    <td>Budi Siregar</td>
                    <td>1</td>
                    <td>Rp 300.000</td>
                    <td>Dalam Perjalanan</td>
                </tr>
                <tr>
                    <td>Bogerbojinov</td>
                    <td>2</td>
                    <td>Rp 400.000</td>
                    <td>Bersiap</td>
                </tr>
                <tr>
                    <td>Asep Karbu</td>
                    <td>3</td>
                    <td>Rp 500.000</td>
                    <td>Terkirim</td>
                </tr>
                <tr>
                    <td>Andi Spakbor</td>
                    <td>4</td>
                    <td>Rp 600.000</td>
                    <td>Bersiap</td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4">Booking Mendatang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td>Waktu</td>
                    <td>Tamu</td>
                    <td>Status</td>
                </tr>
                <tr>
                    <td>Adi Kopling</td>
                    <td>12.00</td>
                    <td>4 orang</td>
                    <td>Diterima</td>
                </tr>
                <tr>
                    <td>Rama Radiator</td>
                    <td>11.00</td>
                    <td>5 orang</td>
                    <td>Sedang Diproses</td>
                </tr>
            </tbody>
        </table>
    </div>
    <footer>
        <div class="wrapper">
            <div class="links-container">
                <div class="copywrite">
                    <img src="Style/Assets/Logo.png" alt="logo">
                    <p>© 2024 CakePHP GROUP. Hak cipta dilindungi undang-undang.</p>
                </div> 
                <div class="links">
                    <h3>
                        Contact Us
                    </h3>
                    <ul>
                        <li>
                            <img src="Style/Assets/email.png" alt="email-">
                            <a href="#">SpikoeResto@gmail.com</a>
                        </li>
                        <li>
                            <img src="Style/Assets/contact.png" alt="contact">
                            <a href="#">(+62) 852-5664-1111</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
