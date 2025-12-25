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
$cus_id = $_SESSION['Cus_id'];

// Kiểm tra xem form đã được gửi hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin thanh toán từ form
    $cus_name = $_POST['cus_name'];
    $cus_phone = $_POST['cus_phone'];
    $cus_add = $_POST['cus_add'];

    // Truy vấn danh sách sản phẩm trong giỏ hàng
    $sql_cart = "
        SELECT 
            c.Cart_id, c.Cart_quant, p.Product_name, p.Price, p.Image
        FROM cart c
        INNER JOIN products p ON c.Product_id = p.Product_id
        WHERE c.Cus_id = '$cus_id'";
    $result_cart = $conn->query($sql_cart);

    // Kiểm tra nếu giỏ hàng có sản phẩm
    if ($result_cart->num_rows > 0) {
        // Bắt đầu giao dịch
        mysqli_begin_transaction($conn);

        try {
            // Tạo mã đơn hàng mới
            $order_id = 'ORD' . strtoupper(uniqid()); // Tạo mã đơn hàng
            $order_date = date('Y-m-d');
            $sql_order = "INSERT INTO orders (Order_id, Cus_id, Order_date)
                          VALUES ('$order_id', '$cus_id', '$order_date')";
            if (!mysqli_query($conn, $sql_order)) {
                throw new Exception("Không thể tạo đơn hàng.");
            }

            // Thêm sản phẩm vào bảng order_items
            while ($row = mysqli_fetch_assoc($result_cart)) {
                $cart_id = $row['Cart_id'];
                $product_name = $row['Product_name'];
                $price = $row['Price'];
                $cart_quant = $row['Cart_quant'];
                $subtotal = $price * $cart_quant;

                // Thêm sản phẩm vào bảng order_items
                $sql_order_items = "INSERT INTO order_items (Order_id, Product_name, Quantity, Price, Subtotal)
                                    VALUES ('$order_id', '$product_name', '$cart_quant', '$price', '$subtotal')";
                if (!mysqli_query($conn, $sql_order_items)) {
                    throw new Exception("Không thể thêm sản phẩm vào đơn hàng.");
                }

                // Xóa sản phẩm khỏi giỏ hàng sau khi thanh toán
                $sql_delete_cart = "DELETE FROM cart WHERE Cart_id = '$cart_id'";
                if (!mysqli_query($conn, $sql_delete_cart)) {
                    throw new Exception("Không thể xóa sản phẩm khỏi giỏ hàng.");
                }
            }

            // Commit giao dịch
            mysqli_commit($conn);

            // Thông báo thanh toán thành công trên trang hiện tại
            echo "<div class='success-message'>";
            echo "<p>Thanh toán thành công! Mã đơn hàng của bạn là: " . $order_id . "</p>";
            echo "<p>Chúng tôi sẽ xử lý đơn hàng và gửi đến bạn trong thời gian sớm nhất.</p>";
            echo "</div>";

            // Có thể thêm thông tin đơn hàng chi tiết nếu cần
            echo "<h3>Thông tin đơn hàng</h3>";
            echo "<table border='1'>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>";

            // Hiển thị chi tiết đơn hàng
            $result_cart->data_seek(0); // Đặt lại con trỏ kết quả để lấy lại dữ liệu giỏ hàng
            $total = 0;
            while ($row = mysqli_fetch_assoc($result_cart)) {
                $subtotal = $row['Cart_quant'] * $row['Price'];
                $total += $subtotal;
                echo "<tr>
                        <td>" . $row['Product_name'] . "</td>
                        <td>" . $row['Cart_quant'] . "</td>
                        <td>" . number_format($row['Price'], 2) . " $</td>
                        <td>" . number_format($subtotal, 2) . " $</td>
                      </tr>";
            }

            echo "<tfoot>
                    <tr>
                        <td colspan='3'>Tổng cộng:</td>
                        <td>" . number_format($total, 2) . " $</td>
                    </tr>
                  </tfoot>";
            echo "</table>";

        } catch (Exception $e) {
            // Rollback giao dịch nếu có lỗi
            mysqli_rollback($conn);
            echo "Có lỗi xảy ra: " . $e->getMessage();
        }
    } else {
        echo "Giỏ hàng trống, không thể thanh toán.";
    }
} else {
    echo "Không có dữ liệu từ form thanh toán.";
}
?>
