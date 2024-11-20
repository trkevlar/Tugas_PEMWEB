<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'spikoe_resto';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}


function insertOrder($nama_pelanggan, $alamat, $metode_pembayaran) {
    global $conn;
    

    $sql = "INSERT INTO pesanan (nama_pelanggan, alamat, metode_pembayaran) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            nama_pelanggan = ?, alamat = ?, metode_pembayaran = ?";
            
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {

        $stmt->bind_param("ssdsssds", 
            $nama_pelanggan, $alamat,  $metode_pembayaran,
            $nama_pelanggan, $alamat,  $metode_pembayaran
        );
        
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    return false;
}

function sanitizeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}
?>