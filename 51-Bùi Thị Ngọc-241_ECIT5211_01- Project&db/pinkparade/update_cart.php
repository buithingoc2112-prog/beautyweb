<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $cart_id = $data['cart_id'];
    $new_quantity = $data['quantity'];
    $cus_id = $_SESSION['Cus_id'];

    if (!isset($cus_id)) {
        echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
        exit;
    }

    // Cập nhật số lượng sản phẩm
    $sql = "UPDATE cart SET Cart_quant = ? WHERE Cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_quantity, $cart_id);

    if ($stmt->execute()) {
        // Tính lại tổng tiền
        $total = 0;
        $sql = "SELECT c.Cart_quant, p.Price 
                FROM cart c 
                JOIN products p ON c.Product_id = p.Product_id 
                WHERE c.Cus_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cus_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $total += $row['Price'] * $row['Cart_quant'];
        }

        // Trả về tổng tiền mới
        echo json_encode(['success' => true, 'total' => number_format($total, 1)]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không thể cập nhật sản phẩm.']);
    }
}
?>
