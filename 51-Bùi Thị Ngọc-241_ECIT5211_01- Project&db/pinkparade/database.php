<?php
$host = 'localhost'; // Máy chủ MySQL
$username = 'root';  // Tên đăng nhập MySQL
$password = '';      // Mật khẩu
$database = 'pinkparade'; // Tên cơ sở dữ liệu

$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die('Kết nối cơ sở dữ liệu thất bại: ' . $conn->connect_error);
}
?>
