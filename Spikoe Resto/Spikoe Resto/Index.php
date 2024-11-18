<?php
session_start();
require_once 'db.php';

// Fungsi untuk mengecek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi untuk mengarahkan ke halaman login dengan pesan
function redirectToLogin($message) {
    $_SESSION['login_required_message'] = $message;
    header("Location: login.php");
    exit();
}

// Handle permintaan pemesanan dan lihat selengkapnya
if (isset($_GET['action'])) {
    if (!isLoggedIn()) {
        switch ($_GET['action']) {
            case 'delivery':
                redirectToLogin("Silakan login terlebih dahulu untuk melakukan pemesanan delivery.");
                break;
            case 'reservasi':
                redirectToLogin("Silakan login terlebih dahulu untuk melakukan reservasi.");
                break;
            case 'lihat_menu':
                redirectToLogin("Silakan login terlebih dahulu untuk melihat menu lengkap dan melakukan pembelian.");
                break;
            case 'pesan':
                redirectToLogin("Silakan login terlebih dahulu untuk melakukan pemesanan.");
                break;
            default:
                header("Location: index.php");
                exit();
        }
    } else {
        switch ($_GET['action']) {
            case 'delivery':
            case 'lihat_menu':
            case 'pesan':
                header("Location: pesan.php");
                exit();
            case 'reservasi':
                header("Location: reservasi.php");
                exit();
            default:
                header("Location: index.php");
                exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Beranda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style/Index.css">
</head>
<body>
    <header>
        <div class="wrapper">
            <nav class="navbar">
                <div class="logo">
                    <a href="Index.php"><img src="Style/Assets/Logo.png" alt="logo"></a>
                </div>
                <ul class="nav-menu">
                    <div class="hover-wane">
                        <li class="navbar-list"><a href="#beranda">Home</a></li>
                    </div>
                    <div class="hover-wane">
                        <li class="navbar-list"><a href="#about-us">About Us</a></li>
                    </div>
                    <div class="hover-wane">
                        <li class="navbar-list"><a href="#menu">Menu</a></li>
                    </div>
                    <div class="hover-wane">
                        <li class="navbar-list"><a href="#pemesanan">Pemesanan</a></li>
                    </div>
                </ul>
                <ul class="nav-right">
                    <?php if (isLoggedIn()): ?>
                        <div class="hover-wane">
                            <li class="navbar-list"><a href="logout.php" class="button">Logout</a></li>
                        </div>
                    <?php else: ?>
                        <div class="hover-wane">
                            <li class="navbar-list"><a href="regis.php" class="nav-button">Daftar</a></li>
                        </div>
                        <div class="hover-wane">
                            <li class="navbar-list"><a href="login.php" class="button">Login</a></li>
                        </div>
                    <?php endif; ?>
                </ul>
            </nav>
<!-- end navbar -->   
<div class="beranda" id="beranda">
    <div class="left">
        <h1>Pesan kemewahan bawa pulang kenikmatan</h1>
        <br><br>
        <div class="hover-wane">
            <a href="<?php echo isLoggedIn() ? 'pesan.php' : 'login.php'; ?>" class="button">Pesan disini</a>
        </div>
    </div> 
    <div class="right">
        <img src="Style/Assets/main.png" alt="Tampilan makanan" width="400px" height="400px">
    </div>
</div>
    </header>
<!-- end hero section -->
    <div class="wrapper">
        <section class="about-us" id="about-us">
            <h1>Review by Customer</h1>
            <div class="review-container">
                <div class="image-section">
                    <div class="reviwer">
                        <img src="Style/Assets/user3.png" alt="User">
                    </div>
                    <div class="review-box">
                        <div class="review-user">
                            <a class="name-user">Ucup</a>
                            <p>"Pelayanan bintang lima"</p><br>
                        </div>
                    </div>
                </div>
                <div class="image-section">
                    <div class="reviwer">
                        <img src="Style/Assets/user1.png" alt="User">
                    </div>
                    <div class="review-box">
                        <div class="review-user">
                            <a class="name-user">Kevin</a>
                            <p>"Websitenya sangat <br>membantu saya"</p>
                        </div>
                    </div>
                </div>
                <div class="image-section">
                    <div class="reviwer">
                        <img src="Style/Assets/user2.png" alt="User">
                    </div>
                    <div class="review-box">
                        <div class="review-user">
                            <a class="name-user">Sarah</a>
                            <p>"Pengantarannya cepat"</p><br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="wrapper">
        <section class="Menu" id="menu">
            <h1 class="title">Menu</h1>
            <div class="menu-container">
                <div class="image-section">
                    <div class="hover-swall">
                        <div class="menu-box">
                            <div class="food">
                                <img src="Style/Assets/menu1.png" alt="Menu">
                            </div>
                            <div class="info">
                                <a class="menu">Provencal Roast Chicken</a>
                                <a class="range">Rp.240.000,00</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-section">
                    <div class="hover-swall">
                        <div class="menu-box">
                            <div class="food">
                                <img src="Style/Assets/menu2.png" alt="Menu">
                            </div>
                            <div class="info">
                                <a class="menu">Virgin Green Mojito</a>
                                <a class="range">Rp.40.000,00</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-section">
                    <div class="hover-swall">
                        <div class="menu-box">
                            <div class="food">
                                <img src="Style/Assets/menu3.png" alt="Menu">
                            </div>
                            <div class="info">
                                <a class="menu">Tuna Tomato Sauce</a>
                                <a class="range">Rp.140.000,00</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-section">
                    <div class="hover-swall">
                        <div class="menu-box">
                            <div class="food">
                                <img src="Style/Assets/menu4.png" alt="Menu">
                            </div>
                            <div class="info">
                                <a class="menu">Lobster Garlic Sauce</a>
                                <a class="range">Rp.400.000,00</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hover-wane">
                <a href="<?php echo isLoggedIn() ? 'pesan.php' : '?action=lihat_menu'; ?>" class="button">Lihat Selengkapnya</a>
            </div>
        </section>
    </div>        
<!--end middle section-->
<div class="wrapper">
        <section class="pemesanan" id="pemesanan">
            <h1 class="title">Pemesanan</h1>
            <div class="pemesanan-container">
                <div class="hover-wane">
                    <div class="pemesanan-box">
                        <div class="button-img">
                            <a href="<?php echo isLoggedIn() ? 'pesan.php' : '?action=delivery'; ?>">
                                <img src="Style/Assets/delivery.png" alt="Delivery" width="70px" height="70px">
                                <p>Delivery</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="hover-wane">
                    <div class="pemesanan-box">
                        <div class="button-img">
                            <a href="<?php echo isLoggedIn() ? 'reservasi.php' : '?action=reservasi'; ?>">
                                <img src="Style/Assets/reservasi.png" alt="Reservasi" width="80px" height="80px">
                                <p>Reservasi</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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