<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'spikoe_resto';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$username = $conn->real_escape_string('adminspikoeresto');
$password = $conn->real_escape_string(password_hash('1q2w3e4r5t', PASSWORD_DEFAULT));
$email = $conn->real_escape_string('adminspikoeresto@gmail.com');
$no_telepon = $conn->real_escape_string('081255259452');
$role = $conn->real_escape_string('admin');

$sql = "INSERT INTO pengguna (username, password, email, no_telepon, role) 
        VALUES ('$username', '$password', '$email', '$no_telepon', '$role')
        ON DUPLICATE KEY UPDATE 
        password='$password', email='$email', no_telepon='$no_telepon', role='$role'";
?>