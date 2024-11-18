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
        <a href="#">Home</a>
        <a href="#">About Us</a>
        <a href="#">Menu</a>
        <a href="#" class="active">Pemesanan</a>
      </nav>
      <div class="profile-icon">
        <img src="user1.png" alt="Profile Icon">
      </div>
    </header>

    <main class="main-content">
      <section class="order-section">
        <h1>Pesan</h1>
        <div class="customer-details">
          <label for="customer-name">Nama Pelanggan</label>
          <input type="text" id="customer-name" placeholder="Nama Pelanggan">
          
          <label for="address">Alamat</label>
          <input type="text" id="address" placeholder="Alamat">
          
          <label for="payment-method">Metode Pembayaran</label>
          <select id="payment-method">
            <option>Cash</option>
            <option>Debit</option>
            <option>e-Wallet</option>
          </select>
        </div>

        <div class="order-summary">
          <h2>Pesanan</h2>
          <p>Ayam Goreng 1x Rp15.000</p>
          <p>Ayam Goreng 1x Rp15.000</p>
          <div class="total">
            <span>Total</span>
            <span>Rp30.000</span>
          </div>
          <button>Lanjut</button>
        </div>
      </section>

      <section class="menu-section">
        <input type="text" placeholder="Masukan nama makanan" class="search-bar">
        <div class="menu-grid">
          <div class="menu-item">
            <img src="style/Assets/menu1.png" alt="Provencal Roast Chicken">
            <p>Provencal Roast Chicken</p>
            <span>Rp40.000,00</span>
            <button>Pesan</button>
          </div>
          <div class="menu-item">
            <img src="style/Assets/menu2.png" alt="Virgin Green Mojito">
            <p>Virgin Green Mojito</p>
            <span>Rp40.000,00</span>
            <button>Pesan</button>
          </div>
          <div class="menu-item">
            <img src="style/Assets/menu3.png" alt="Tuna Tomato Sauce">
            <p>Tuna Tomato Sauce</p>
            <span>Rp140.000,00</span>
            <button>Pesan</button>
          </div>
          <!-- Add more menu items as needed -->
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
</body>
</html>
