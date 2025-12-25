<?php
session_start();
session_destroy(); // Xóa toàn bộ session
header('Location: index.php?xem=dangnhao'); // Chuyển hướng về trang đăng nhập
exit;
?>
