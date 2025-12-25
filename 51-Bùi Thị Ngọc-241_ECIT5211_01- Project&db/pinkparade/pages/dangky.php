<?php
// Kết nối cơ sở dữ liệu
include('database.php');

// Xử lý khi form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST['Name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Kiểm tra xem mật khẩu và xác nhận mật khẩu có khớp không
    if ($password !== $confirmPassword) {
        echo "<p style='color: red;'>Mật khẩu và xác nhận mật khẩu không khớp.</p>";
    } else {
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Tránh SQL injection bằng cách sử dụng prepared statement
        $stmt = $conn->prepare("INSERT INTO customers (Cus_name, Cus_phone, Password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $hashedPassword);

        // Kiểm tra nếu đã tồn tại số điện thoại
        $checkStmt = $conn->prepare("SELECT * FROM customers WHERE Cus_phone = ?");
        $checkStmt->bind_param("s", $phone);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            echo "<p style='color: red;'>Số điện thoại đã tồn tại.</p>";
        } else {
            // Lưu thông tin người dùng mới vào cơ sở dữ liệu
            if ($stmt->execute()) {
                // Thông báo thành công và chuyển hướng tới trang đăng nhập
                echo "<p style='color: green;'>Đăng ký thành công! Đang chuyển hướng đến trang đăng nhập...</p>";
                header("Location: index.php?xem=dangnhap"); // Điều hướng đến trang đăng nhập
                exit(); // Dừng script sau khi điều hướng
            } else {
                echo "<p style='color: red;'>Lỗi khi đăng ký: " . $stmt->error . "</p>";
            }
        }
    }
}
?>

<link rel="stylesheet" href="CSS/style.css?v=1.0" />
<div class="page-container">
    <nav class="top-container">
    </nav>
    <div class="main1-container ">
        <h2>ĐĂNG KÝ</h2>

        <form method="POST" action="index.php?xem=dangky">
            <div class="form-group">
                <label for="Name">Họ và tên:<span style="color: red">*</span></label>
                <input type="text" id="Name" name="Name" required />
            </div>
            <div class="form-group">
                <label for="phone">Điện thoại:<span style="color: red">*</span></label>
                <input type="tel" id="phone" name="phone" required />
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:<span style="color: red">*</span></label>
                <input type="password" id="password" name="password" required />
            </div>
            <div class="form-group">
                <label for="confirmPassword">Xác nhận mật khẩu:<span style="color: red">*</span></label>
                <input type="password" id="confirmPassword" name="confirmPassword" required />
            </div>
            <button type="submit" class="btn-login">Đăng ký</button>
        </form>
    </div>
</div>
