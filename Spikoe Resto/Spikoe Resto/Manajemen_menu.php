<?php
session_start();
require_once 'db.php';

// Periksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fungsi untuk mendapatkan semua menu
function getAllMenus($conn) {
    $query = "SELECT * FROM menu ORDER BY id ASC";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk menambah atau mengupdate menu
function saveMenu($conn, $nama_item, $deskripsi, $harga, $id = null) {
    $nama_item = $conn->real_escape_string($nama_item);
    $deskripsi = $conn->real_escape_string($deskripsi);
    $harga = floatval($harga);

    if ($id) {
        $id = intval($id);
        $query = "UPDATE menu SET nama_item = '$nama_item', deskripsi = '$deskripsi', harga = $harga WHERE id = $id";
    } else {
        // Cek apakah nama_item sudah ada
        $check_query = "SELECT id FROM menu WHERE nama_item = '$nama_item'";
        $result = $conn->query($check_query);
        if ($result->num_rows > 0) {
            // Nama menu sudah ada
            return 'duplicate';
        }
        $query = "INSERT INTO menu (nama_item, deskripsi, harga) VALUES ('$nama_item', '$deskripsi', $harga)";
    }
    
    $result = $conn->query($query);
    if (!$result) {
        error_log("SQL Error: " . $conn->error);
        return false;
    }
    return true;
}

// Fungsi untuk mencari menu
function searchMenus($conn, $keyword) {
    $keyword = $conn->real_escape_string($keyword);
    $query = "SELECT * FROM menu WHERE nama_item LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%' ORDER BY id ASC";
    $result = $conn->query($query);
    if (!$result) {
        error_log("SQL Error in searchMenus: " . $conn->error);
        return [];
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// mengambil data dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'save') {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $result = saveMenu($conn, $_POST['nama_item'], $_POST['deskripsi'], $_POST['harga'], $id);
        if ($result === true) {
            $_SESSION['success_message'] = "Menu berhasil disimpan.";
        } elseif ($result === 'duplicate') {
            $_SESSION['error_message'] = "Gagal menyimpan menu. Nama menu sudah ada.";
        } else {
            $_SESSION['error_message'] = "Gagal menyimpan menu.";
        }
    }
    header("Location: manajemen_menu.php");
    exit();
}

// Ambil semua menu untuk ditampilkan
$menus = getAllMenus($conn);

// Handle pencarian
if (isset($_GET['search'])) {
    $menus = searchMenus($conn, $_GET['search']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style/Manajemen-menu.css">
    <title>Manajemen Menu</title>
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
                <img src="Style/Assets/Manajemen-pengguna.png" alt="Dashboard">
                <a href="Manajemen_pengguna.php">Manajemen Pengguna</a>
            </li>
            <li class="underline">
                <img src="Style/Assets/Manajemen-menu.png" alt="Manajemen-menu">
                <a href="Manajemen_menu.php">Manajemen Menu</a>
            </li>
            <li>
                <img src="Style/Assets/Manajemen-reservasi.png" alt="Manajemen-reservasi">
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
                <img src="Style/Assets/Manajemen-konten.png" alt="Manajemen-konten">
                <a href="Manajemen-konten.php">Manajemen Konten</a>
            </li>
            <li>
                <img src="Style/Assets/Logout.png" alt="Logout">
                <a href="Logout.php">Logout</a>
            </li>
        </ul>
    </div>
    <div class="content">
        <div class="wrapper">
            <div class="title">Manajemen Menu</div>
        </div>
        <div class="wrapper">
            <form action="manajemen_menu.php" method="GET" class="search">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Cari menu..." class="search-input" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-button">
                        <img src="Style/Assets/search.png" alt="Cari" class="search-icon">
                    </button>
                </div>
            </form>
        </div>
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<div class='wrapper'><p style='color: green;'>" . $_SESSION['success_message'] . "</p></div>";
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo "<div class='wrapper'><p style='color: red;'>" . $_SESSION['error_message'] . "</p></div>";
            unset($_SESSION['error_message']);
        }
        ?>
        <form action="manajemen_menu.php" method="POST">
            <input type="hidden" name="action" value="save">
            <div class="wrapper">
                Nama Menu
                <div class="edit">
                    <div class="edit-container">
                        <input type="text" name="nama_item" placeholder="Masukkan Nama Menu" class="edit-input" required>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                Deskripsi
                <div class="edit">
                    <div class="edit-container">
                        <input type="text" name="deskripsi" placeholder="Tuliskan Deskripsi Menu" class="edit-input" required>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                Harga
                <div class="edit">
                    <div class="edit-container">
                        <input type="number" name="harga" placeholder="Masukkan Harga Menu" class="edit-input" step="0.01" required>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                <div class="button-save">
                    <a href="#">Simpan</a>
                </div>
            </div>
        </form>

        <div class="wrapper">
            <h2>Daftar Menu</h2>
            <?php if (empty($menus)): ?>
                <p>Tidak ada menu yang ditemukan.</p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($menu['nama_item']); ?></td>
                            <td><?php echo htmlspecialchars($menu['deskripsi']); ?></td>
                            <td>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="edit_menu.php?id=<?php echo $menu['id']; ?>">Edit</a>
                                <a href="delete_menu.php?id=<?php echo $menu['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
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
