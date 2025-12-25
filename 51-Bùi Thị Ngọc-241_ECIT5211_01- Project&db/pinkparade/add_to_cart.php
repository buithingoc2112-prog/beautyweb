<?php
session_start();
include('database.php');

// Kiểm tra nếu có thông tin sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $product_id = isset($data['product_id']) ? $data['product_id'] : '';

    if ($product_id && isset($_SESSION['Cus_id'])) {
        $cus_id = $_SESSION['Cus_id']; // Mã khách hàng từ session

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng của khách hàng
        $sql_check = "SELECT * FROM cart WHERE Cus_id = '$cus_id' AND Product_id = '$product_id'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            // Nếu có, cập nhật số lượng sản phẩm trong giỏ hàng
            $sql_update = "UPDATE cart SET Cart_quant = Cart_quant + 1 WHERE Cus_id = '$cus_id' AND Product_id = '$product_id'";
            $conn->query($sql_update);
            echo json_encode(['success' => true]);
        } else {
            // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
            $sql_insert = "INSERT INTO cart (Cus_id, Product_id, Cart_quant) VALUES ('$cus_id', '$product_id', 1)";
            $conn->query($sql_insert);
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
