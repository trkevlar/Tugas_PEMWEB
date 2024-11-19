<?php
session_start();
require_once 'db.php';

// Cek apakah user sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fungsi untuk mendapatkan log aktivitas pengguna
function getActivityLog($conn, $limit = 10) {
    $query = "SELECT * FROM log_aktivitas ORDER BY waktu_aktivitas DESC LIMIT $limit";
    return $conn->query($query);
}

// Fungsi untuk mendapatkan semua pengguna
function getAllUsers($conn) {
    $query = "SELECT id, username, role FROM pengguna ORDER BY id ASC";
    return $conn->query($query);
}

// Fungsi untuk mencari pengguna
function searchUsers($conn, $searchTerm) {
    $searchTerm = $conn->real_escape_string($searchTerm);
    $query = "SELECT id, username, role FROM pengguna WHERE id LIKE '%$searchTerm%' OR username LIKE '%$searchTerm%'";
    return $conn->query($query);
}

// Handle pencarian
$searchResult = null;
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $searchResult = searchUsers($conn, $searchTerm);
}

// Mendapatkan log aktivitas dan pengguna
$activityLog = getActivityLog($conn);
$users = $searchResult ? $searchResult : getAllUsers($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style/Manajemen_pengguna.css">
    <title>Manajemen Pengguna</title>
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
            <li class="underline">
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
        <div class="title">Manajemen Pengguna</div>
        <table class="table1">
            <thead>
                <tr>
                    <th>Riwayat aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($activityLog->num_rows > 0) {
                    while ($log = $activityLog->fetch_assoc()) {
                        echo "<tr><td>" . htmlspecialchars($log['deskripsi']) . " - " . htmlspecialchars($log['waktu_aktivitas']) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td>Tidak ada aktivitas tercatat</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="search">
            <form action="Manajemen_pengguna.php" method="GET">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Masukan ID atau Nama" class="search-input" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-button">
                        <img src="Style/Assets/search.png" alt="Cari" class="search-icon">
                    </button>
                </div>
            </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4">Kelola Pengguna</th>
                </tr>
            </thead>
            <tbody>
                <tr class="title-sec">
                    <td>ID</td>
                    <td>Nama</td>
                    <td>Status</td>
                    <td>Aksi</td>
                </tr>
                <?php
                if ($users->num_rows > 0) {
                    while ($user = $users->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                        echo "<td><a href='edit_user.php?id=" . $user['id'] . "'>Edit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada pengguna ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="pagination">
            <div class="pagination-box">
                                <button class="page-btn"><img src="Style/Assets/back.png" alt="before"></button>
                                <button class="page-btn">1</button>
                                <button class="page-btn">2</button>
                                <button class="page-btn">3</button>
                                <button class="page-btn"><img src="Style/Assets/continue.png" alt="after"></button>
                            </div>
                        </div>
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
                </html>