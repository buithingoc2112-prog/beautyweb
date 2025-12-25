<?php
// Kết nối cơ sở dữ liệu
include('database.php');

// Lấy id sản phẩm từ URL và kiểm tra hợp lệ
$product_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

// Truy vấn lấy thông tin sản phẩm
$query = $conn->prepare("SELECT * FROM products WHERE Product_id = ?");
$query->bind_param("s", $product_id); // Sử dụng "s" vì Product_id có thể là chuỗi
$query->execute();
$result = $query->get_result();
$product = $result->fetch_assoc();

if ($product) {
    // Hiển thị thông tin sản phẩm
    echo '<section class="product-detail-section">';

    echo '<h1 class="product-name">' . htmlspecialchars($product['Product_name']) . '</h1>';

    echo '<div class="product-image-wrapper">';
    echo '<img class="product-image" src="' . htmlspecialchars($product['Image']) . '" alt="' . htmlspecialchars($product['Product_name']) . '" />';
    echo '</div>';

    echo '<p class="product-description">' . nl2br(htmlspecialchars($product['Description'])) . '</p>';

    echo '<p class="product-price">Price: ' . number_format($product['Price'], 0, ',', '.') . ' $</p>';

    echo '<p class="product-quantity">Quantity Available: ' . htmlspecialchars($product['Product_quant']) . '</p>';
    
    // Sửa lỗi biến $row -> $product
    echo '<a href="index.php?add_to_cart=' . $product['Product_id'] . '" class="add-to-cart" onclick="addToCart(\'' . $product['Product_id'] . '\'); return false;">Thêm vào giỏ hàng</a>';

    echo '</section>';
} else {
    echo '<p class="error-message">Sản phẩm không tồn tại.</p>';
}
?>

<script>
// Thêm sản phẩm vào giỏ hàng qua AJAX
function addToCart(productId) {
    fetch('./modules/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        }
    })
    .catch((error) => {
        console.error('Lỗi:', error);
        alert('Không thể thêm sản phẩm vào giỏ hàng.');
    });
}
</script>
