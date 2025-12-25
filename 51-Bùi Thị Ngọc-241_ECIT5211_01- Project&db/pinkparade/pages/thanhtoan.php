<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pinkparade";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin khách hàng từ session
session_start();
if (!isset($_SESSION['Cus_id'])) {
    // Nếu chưa đăng nhập, chuyển về trang đăng nhập
    header("Location: index.php?xem=dangnhap");
    exit();
}

$cus_id = $_SESSION['Cus_id'];

// Truy vấn thông tin khách hàng
$sql_customer = "SELECT Cus_name, Cus_phone, Cus_add FROM customers WHERE Cus_id = '$cus_id'";
$result_customer = $conn->query($sql_customer);
$customer = $result_customer->fetch_assoc();

// Truy vấn danh sách sản phẩm trong giỏ hàng
$sql_cart = "
    SELECT 
        c.Cart_id, c.Cart_quant, p.Product_name, p.Price, p.Image
    FROM cart c
    INNER JOIN products p ON c.Product_id = p.Product_id
    WHERE c.Cus_id = '$cus_id'";
$result_cart = $conn->query($sql_cart);
?>

<div class="checkout-container">
    <?php if (mysqli_num_rows($result_cart) > 0): ?>
        <form action="process_checkout.php" method="POST">
            <div class="title">Thông tin nhận hàng</div>
            <div class="form-group">
                <label for="cus_name">Tên Khách Hàng:</label>
                <input type="text" id="cus_name" name="cus_name" value="<?php echo $customer['Cus_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cus_phone">Số Điện Thoại:</label>
                <input type="text" id="cus_phone" name="cus_phone" value="<?php echo $customer['Cus_phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cus_add">Địa Chỉ:</label>
                <textarea id="cus_add" name="cus_add" required><?php echo $customer['Cus_add']; ?></textarea>
            </div>

            <!-- Product List -->
            <div class="title1">Danh Sách Sản Phẩm</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Đơn Giá</th>
                        <th>Thành Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    while ($row = $result_cart->fetch_assoc()) {
                        $subtotal = $row['Cart_quant'] * $row['Price'];
                        $total += $subtotal;
                        echo "<tr>";
                        echo "<td>" . $row['Product_name'] . "</td>";
                        echo "<td>" . $row['Cart_quant'] . "</td>";
                        echo "<td>" . number_format($row['Price'], 2) . " $</td>";
                        echo "<td>" . number_format($subtotal, 2) . " $</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="total">Tổng Tiền:</td>
                        <td><?php echo number_format($total, 2); ?> $</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Xác Nhận Thanh Toán</button>
        </form>
    <?php else: ?>
        <p>Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm để tiếp tục thanh toán.</p>
    <?php endif; ?>
</div>
