<?php
include('database.php'); // Kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Tránh SQL injection bằng cách sử dụng prepared statement
    $stmt = $conn->prepare("SELECT * FROM customers WHERE Cus_phone = ?");
    $stmt->bind_param("s", $phone); // 's' nghĩa là kiểu dữ liệu là string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Kiểm tra nếu có người dùng với số điện thoại đó
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Lấy thông tin người dùng
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $user['Password'])) {
            // Đăng nhập thành công, lưu thông tin người dùng vào session
            session_start();
            $_SESSION['Cus_id'] = $user['Cus_id']; // Lưu mã khách hàng
            $_SESSION['Cus_name'] = $user['Cus_name']; // Lưu tên khách hàng
            $_SESSION['Cus_phone'] = $user['Cus_phone']; // Lưu số điện thoại
            $_SESSION['Cus_add'] = $user['Cus_add']; // Lưu địa chỉ

            // Chuyển hướng đến trang chủ
            header("Location: index.php");
            exit();
        } else {
            // Mật khẩu không đúng
            echo "<p style='color: red;'>Mật khẩu không đúng.</p>";
        }
    } else {
        // Số điện thoại không tồn tại trong cơ sở dữ liệu
        echo "<p style='color: red;'>Số điện thoại không tồn tại.</p>";
    }
}
?>

<!-- Form đăng nhập -->
<div class="page-container">
    <nav class="top-container"></nav>
    <div class="main1-container ">
        <h2>ĐĂNG NHẬP</h2>
        <form method="post">
            <div class="form-group">
                <label for="phone">Điện thoại:<span style="color: red">*</span></label>
                <input type="tel" id="phone" name="phone" required />
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:<span style="color: red">*</span></label>
                <input type="password" id="password" name="password" required />
            </div>

            <a href="index.php?xem=dangky" class="right-link">Bạn chưa có tài khoản?</a>

            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>
    </div>
</div>
