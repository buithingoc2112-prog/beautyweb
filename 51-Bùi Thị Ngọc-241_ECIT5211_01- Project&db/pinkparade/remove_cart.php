<?php
session_start();
include 'database.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $cart_id = $data['cart_id'];

    // Xóa sản phẩm khỏi giỏ hàng
    $sql = "DELETE FROM cart WHERE Cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);

    if ($stmt->execute()) {
        // Tính lại tổng tiền cho giỏ hàng
        $total = 0;
        $sql = "SELECT c.Cart_quant, p.Price FROM cart c JOIN products p ON c.Product_id = p.Product_id WHERE c.Cus_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['Cus_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $total += $row['Price'] * $row['Cart_quant'];
        }

        // Trả về kết quả
        echo json_encode(['success' => true, 'total' => number_format($total, 1)]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm']);
    }
}
?>
