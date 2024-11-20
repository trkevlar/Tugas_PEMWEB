<?php 
session_start(); 
require_once 'db_pemesanan.php';


// Proses form jika di-submit
 if ($_SERVER["REQUEST_METHOD"] == "POST") 
 {
  $nama_pelanggan = isset($_POST['nama_pelanggan']) ? $_POST['nama_pelanggan'] : '';
  $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
  $metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : '';
  
  if ($nama_pelanggan && $alamat) {
      try {
          $stmt = $conn->prepare("INSERT INTO pemesanan (nama_pelanggan, alamat, metode_pembayaran) VALUES (?, ?, ?)");
          $stmt->bind_param("sss", $nama_pelanggan, $alamat, $metode_pembayaran);
          
          if ($stmt->execute()) {
              $_SESSION['success_message'] = "Pemesanan berhasil dikonfirmasi.";
              header("Location: pesan_checkout.php");
              exit();
          } else {
              $error = "Terjadi kesalahan saat pemesanan: " . $stmt->error;
          }
          $stmt->close();
      } catch (Exception $e) {
          $error = "Terjadi kesalahan: " . $e->getMessage();
      }
  } else {
      $error = "Nama pelanggan dan alamat harus diisi.";
  }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan - SpikeResto</title>
    <link rel="stylesheet" href="style/pesan.css">
</head>
<body>
    <div class="container">
        <header class="navbar">
            <div class="logo">SpikeResto</div>
            <nav>
                <a href="index.php">Home</a>
                <a href="about.php">About Us</a>
                <a href="menu.php">Menu</a>
                <a href="pesan.php" class="active">Pemesanan</a>
            </nav>
            <div class="profile-icon">
                <img src="user1.png" alt="Profile Icon">
            </div>
        </header>

        <main class="main-content">
            <section class="order-section">
                <h1>Pesan</h1>
                
                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="customer-details">
                        <label for="nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" 
                               placeholder="Nama Pelanggan" required>
                        
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" 
                               placeholder="Alamat" required>
                        
                        <label for="metode_pembayaran">Metode Pembayaran</label>
                        <select id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="Cash">Cash</option>
                            <option value="Debit">Debit</option>
                            <option value="e-Wallet">e-Wallet</option>
                        </select>
                    </div>

                    <div class="order-summary">
                        <h2>Pesanan</h2>
                        <div id="order-items">
                        </div>
                        <div class="total">
                            <span>Total</span>
                            <span id="total-amount">Rp</span>
                        </div>
                        <button type="submit">Lanjut</button>
                    </div>
                </form>
            </section>

            <section class="menu-section">
                <input type="text" placeholder="Masukan nama makanan" class="search-bar">
                <div class="menu-grid">
                    <div class="menu-item">
                        <img src="style/Assets/menu1.png" alt="Provencal Roast Chicken">
                        <p>Provencal Roast Chicken</p>
                        <span>Rp40.000,00</span>
                        <button type="button" onclick="addToOrder('Provencal Roast Chicken', 40000)">Pesan</button>
                    </div>
                    <div class="menu-item">
                        <img src="style/Assets/menu2.png" alt="Virgin Green Mojito">
                        <p>Virgin Green Mojito</p>
                        <span>Rp40.000,00</span>
                        <button type="button" onclick="addToOrder('Virgin Green Mojito', 40000)">Pesan</button>
                    </div>
                    <div class="menu-item">
                        <img src="style/Assets/menu3.png" alt="Tuna Tomato Sauce">
                        <p>Tuna Tomato Sauce</p>
                        <span>Rp140.000,00</span>
                        <button type="button" onclick="addToOrder('Tuna Tomato Sauce', 140000)">Pesan</button>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="contact-info">
                <p>&copy; 2024 CakePHP GROUP. Hak cipta dilindungi undang-undang.</p>
                <p>Email: SpikeResto@gmail.com</p>
                <p>Phone: +62852-5664-1111</p>
            </div>
        </footer>
    </div>

    <script>
    let orderItems = [];
    let totalAmount = 0;

    function addToOrder(itemName, price) {
        orderItems.push({ name: itemName, price: price });
        totalAmount += price;
        updateOrderSummary();
    }

    function updateOrderSummary() {
        const orderItemsDiv = document.getElementById('order-items');
        const totalAmountSpan = document.getElementById('total-amount');
        
        orderItemsDiv.innerHTML = '';
        orderItems.forEach(item => {
            const p = document.createElement('p');
            p.textContent = `${item.name} 1x Rp${item.price.toLocaleString()}`;
            orderItemsDiv.appendChild(p);
        });
        
        totalAmountSpan.textContent = `Rp${totalAmount.toLocaleString()}`;
    }
    </script>
</body>
</html>