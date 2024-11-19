<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM pengguna WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Arahkan pengguna berdasarkan peran
            if ($user['role'] == 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "Username tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <h1>Login</h1>
                </div>
                <?php 
                if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                }
                ?>
                <form action="login.php" method="POST">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Login</button>
                </form>
                <p>Belum punya akun? <a href="regis.php">Daftar disini</a></p>
            </div>
        </div>
    </div>
</body>
</html>