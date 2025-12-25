<section class="my-20 flex flex-col items-center justify-center w-full">
    <div class="w-full max-w-[1154px]">
        <?php
        session_start();
        include 'database.php'; // Kết nối cơ sở dữ liệu

        // Kiểm tra người dùng đã đăng nhập
        if (isset($_SESSION['Cus_name']) && isset($_SESSION['Cus_id'])) {
            $user_name = $_SESSION['Cus_name']; // Lấy tên khách hàng từ session
            echo '<div class="welcome-container flex justify-between items-center mb-5">';
            echo '<p class="text-lg font-bold">Xin chào, ' . htmlspecialchars($user_name) . '!</p>';
            echo '<form action="dangxuat.php" method="POST">';
            echo '<button type="submit" class="logout-btn bg-red-500 text-white py-2 px-4 rounded">Đăng xuất</button>';
            echo '</form>';
            echo '</div>';
        } else {
            echo '<p class="text-lg font-bold text-red-500">Bạn chưa đăng nhập. <a href="index.php?xem=dangnhap" class="text-blue-500 underline">Đăng nhập ngay!</a></p>';
            exit;
        }

        // Lấy mã khách hàng từ session
        $cus_id = $_SESSION['Cus_id'];

        // Lấy thông tin giỏ hàng từ cơ sở dữ liệu
        $sql = "SELECT c.Cart_id, c.Cart_quant, p.Product_name, p.Price, p.Image
                FROM cart c
                JOIN products p ON c.Product_id = p.Product_id
                WHERE c.Cus_id = '$cus_id'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $total = 0;
            echo '<div class="cart-container">'; // Bắt đầu container giỏ hàng
            while ($row = mysqli_fetch_assoc($result)) {
                $cart_id = $row['Cart_id'];
                $product_name = $row['Product_name'];
                $price = $row['Price'];
                $image = $row['Image'];
                $cart_quant = $row['Cart_quant'];

                echo '<div class="cart-item">';
                echo '<img class="product-image1" src="' . $image . '" alt="' . $product_name . '" />';
                echo '<div class="product-info">';
                echo '<p><strong>' . $product_name . '</strong></p>';
                echo '<p><strong>Giá: </strong>' . number_format($price, 1) . ' $</p>';

                // Hiển thị form để tăng giảm số lượng
                echo '<div class="quantity-controls">';
                echo '<button class="quantity-btn" data-action="decrease" data-cart-id="' . $cart_id . '">-</button>';
                echo '<span class="cart-quantity" data-cart-id="' . $cart_id . '">' . $cart_quant . '</span>';
                echo '<button class="quantity-btn" data-action="increase" data-cart-id="' . $cart_id . '">+</button>';
                echo '</div>';

                // Thêm nút xóa
                echo '<button class="remove-btn" data-cart-id="' . $cart_id . '">Xóa</button>';

                $subtotal = $price * $cart_quant;
                $total += $subtotal;
                echo '</div>'; // Kết thúc product-info
                echo '</div>'; // Kết thúc cart-item
            }
            echo '</div>'; // Kết thúc container giỏ hàng

            // Hiển thị tổng tiền và nút đặt hàng
            echo '<div class="cart-summary">';
            echo '<strong id="total-price">Tổng tiền: ' . number_format($total, 1) . ' $</strong>';
            echo '<form action="index.php?xem=thanhtoan" method="POST">
            <button type="submit" id="order-button">Đặt hàng</button></form>';
            echo '</div>';
        } else {
            echo 'Giỏ hàng của bạn trống.';
        }
        ?>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const orderButton = document.querySelector('#order-button');
    if (orderButton) {
        orderButton.addEventListener('click', function (event) {
            // Loại bỏ preventDefault để gửi form khi nhấn nút
            this.closest('form').submit(); // Gửi form đi
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Xử lý tăng giảm số lượng
    const quantityButtons = document.querySelectorAll('.quantity-btn');
    const totalPriceElement = document.querySelector('#total-price');

    quantityButtons.forEach(button => {
        button.addEventListener('click', function () {
            const action = this.getAttribute('data-action');
            const cartId = this.getAttribute('data-cart-id');
            const quantitySpan = document.querySelector(`.cart-quantity[data-cart-id="${cartId}"]`);
            let currentQuantity = parseInt(quantitySpan.textContent);

            // Tăng hoặc giảm số lượng
            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity--;
            }

            // Gửi yêu cầu AJAX để cập nhật số lượng và tổng tiền
            fetch('/update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ cart_id: cartId, quantity: currentQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng và tổng tiền
                    quantitySpan.textContent = currentQuantity;
                    if (totalPriceElement) {
                        totalPriceElement.textContent = 'Tổng tiền: ' + data.total + ' $';
                    }
                } else {
                    alert('Không thể cập nhật sản phẩm: ' + (data.message || 'Lỗi không xác định.'));
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Có lỗi xảy ra khi cập nhật giỏ hàng.');
            });
        });
    });

    // Xử lý xóa sản phẩm
    const removeButtons = document.querySelectorAll('.remove-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const cartId = this.getAttribute('data-cart-id');

            // Gửi yêu cầu AJAX để xóa sản phẩm
            fetch('remove_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ cart_id: cartId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Xóa sản phẩm khỏi giao diện
                    this.closest('.cart-item').remove();
                    if (totalPriceElement) {
                        totalPriceElement.textContent = 'Tổng tiền: ' + data.total + ' $';
                    }
                } else {
                    alert('Không thể xóa sản phẩm.');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Có lỗi xảy ra khi xóa sản phẩm.');
            });
        });
    });
});
</script>

