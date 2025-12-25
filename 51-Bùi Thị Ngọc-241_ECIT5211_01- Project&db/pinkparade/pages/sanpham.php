<?php
include 'database.php'; // Kết nối cơ sở dữ liệu

// Lấy danh sách sản phẩm từ bảng
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Lấy danh sách sản phẩm và hiển thị
?>

<section class="my-20 flex flex-col items-center justify-center w-full">
    <div class="w-full max-w-[1154px]">
        <?php
            // Danh sách các danh mục
            $categories = ['Sản phẩm làm sạch', 'Sản phẩm dưỡng', 'Sản phẩm chống nắng'];

            // Lặp qua từng danh mục
            foreach ($categories as $category) {
                echo '<h3 class="title">' . $category . '</h3>'; // Hiển thị tên danh mục

                // Lọc sản phẩm theo danh mục
                $category_result = mysqli_query($conn, "SELECT * FROM products WHERE Category = '$category'");
                echo '<div class="product-grid">';

                // Hiển thị sản phẩm trong mỗi danh mục
                while ($row = mysqli_fetch_assoc($category_result)) {
                    echo '
                    <div class="product-card">
                        <a href="index.php?xem=chitiet&id=' . $row['Product_id'] . '">
                            <div class="image-container">
                                <img class="product-image" src="' . $row['Image'] . '" alt="' . $row['Product_name'] . '" />
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">' . $row['Product_name'] . '</h3>
                                <div class="price-cart">
                                    <p class="price">' . number_format($row['Price'], 0, ',', '.') . ' $</p>
                                </div>
                            </div>
                        </a>
                    </div>';
                }
                echo '</div>'; // Kết thúc phần hiển thị sản phẩm
            }
        ?>
    </div>
</section>
