<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
    <link rel="stylesheet" href="Style/reservasi.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about-us">About Us</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#reservasi">Pemesanan</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="reservasi">
            <h1>Reservasi</h1>
            <div class="reservasi-container">
                <!-- Reservasi Ruangan -->
                <div class="reservasi-box">
                    <h2>Reservasi Ruangan</h2>
                    <form action="checkout.php" method="POST">
                        <input type="hidden" name="tipe_reservasi" value="ruangan">
                        
                        <label for="nama-pemesan-ruangan">Nama Pemesan</label>
                        <input type="text" id="nama-pemesan-ruangan" name="nama_pemesan" placeholder="Nama Pemesan" required>
                        
                        <label for="ruangan">Ruangan</label>
                        <select id="ruangan" name="ruangan" required>
                            <option value="ruang1">Ruang 1</option>
                            <option value="ruang2">Ruang 2</option>
                            <option value="ruang3">Ruang 3</option>
                        </select>

                        <label for="tanggal-waktu-ruangan">Tanggal dan Waktu</label>
                        <input type="datetime-local" id="tanggal-waktu-ruangan" name="tanggal_waktu" required>

                        <label for="durasi">Durasi</label>
                        <input type="number" id="durasi" name="durasi" placeholder="Durasi (jam)" required>

                        <button type="submit">Reservasi</button>
                    </form>
                </div>

                <!-- Reservasi Meja -->
                <div class="reservasi-box">
                    <h2>Reservasi Meja</h2>
                    <form action="checkout_reservasi.php" method="POST">
                        <input type="hidden" name="tipe_reservasi" value="meja">
                        
                        <label for="nama-pemesan-meja">Nama Pemesan</label>
                        <input type="text" id="nama-pemesan-meja" name="nama_pemesan" placeholder="Nama Pemesan" required>
                        
                        <label for="jumlah-kursi">Jumlah Kursi</label>
                        <input type="number" id="jumlah-kursi" name="jumlah_kursi" placeholder="Jumlah Kursi" required>

                        <label for="tanggal-waktu-meja">Tanggal dan Waktu</label>
                        <input type="datetime-local" id="tanggal-waktu-meja" name="tanggal_waktu" required>

                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" placeholder="Catatan"></textarea>

                        <button type="submit">Reservasi</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>© 2024 CakePHP GROUP. Hak cipta dilindungi undang-undang.</p>
            <div class="contact">
                <p>Email: <a href="mailto:SpikoeResto@gmail.com">SpikoeResto@gmail.com</a></p>
                <p>Telp: <a href="tel:+6285256641111">+62 852-5664-1111</a></p>
            </div>
        </div>
    </footer>
</body>
</html>