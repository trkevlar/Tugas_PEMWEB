<?php
session_start();
require_once 'db.php';

// Fungsi validasi nomor telepon
function validatePhoneNumber($phone) {
    $cleanedPhone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($cleanedPhone) < 10) {
        return false;
    }
    return $cleanedPhone;
}

// Proses form jika di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $inputPhone = $_POST['no_telepon'];

    // Validasi nomor telepon
    $validatedPhone = validatePhoneNumber($inputPhone);

    if ($validatedPhone === false) {
        $error = "Nomor telepon tidak valid. Harap masukkan minimal 10 digit angka.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Persiapkan query SQL
        $sql = "INSERT INTO pengguna (username, password, email, no_telepon) 
                VALUES ('$username', '$hashedPassword', '$email', '$validatedPhone')";

        // Eksekusi query
        if (mysqli_query($conn, $sql)) {
            // Pendaftaran berhasil
            $_SESSION['success_message'] = "Pendaftaran berhasil! Silakan login.";
            header("Location: login.php");
            exit();
        } else {
            // Gagal menyimpan data
            $error = "Terjadi kesalahan saat mendaftar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italianno&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style/LoginRegis.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="left">
                <h1>Spokei Resto</h1><br>
                <p>Spikoe resto merupakan platform berbasis website yang menyediakan layanan FnB, di mana Anda bisa memesan makanan.</p>
            </div> 
            <div class="right">
                <div class="form-header">
                    <a href="Index.php" class="back-button">
                        <img src="Style/Assets/kembali.png" alt="Kembali" class="back-icon">
                    </a>
                    <h1>Daftar</h1>
                </div>
                <?php 
                if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                } elseif (isset($_SESSION['success_message'])) {
                    echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
                    unset($_SESSION['success_message']);
                }
                ?>
                <form action="regis.php" method="POST">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <input type="text" id="no_telepon" name="no_telepon" placeholder="No Telepon" required>
                    <button type="submit" name="daftar">Daftar</button>
                </form>
                <p>Sudah punya akun?<a href="login.php"> Masuk disini</a></p>
            </div>
        </div>
    </div>
</body>
</html>