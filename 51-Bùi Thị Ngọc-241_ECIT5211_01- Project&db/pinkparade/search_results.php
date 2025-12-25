<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/style.css?v=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3.0/dist/tailwind.min.css" rel="stylesheet"/>
    <title>Pink Paradise</title>
</head>
<?php
include('header.php'); 
?>

<!-- Thanh tìm kiếm -->
<div class="search-bar">
    <form action="search_results.php" method="GET">
        <input type="text" class="search-input" name="query" placeholder="Nhập từ khóa tìm kiếm..." />
        <button type="submit" class="search-button">
            Tìm kiếm
        </button>
    </form>
</div>
<section class="my-20 flex flex-col items-center justify-center w-full">
    <div class="w-full max-w-[1154px]">
<?php
// Kiểm tra nếu có từ khóa tìm kiếm
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    
    // Kết nối cơ sở dữ liệu
    include('database.php');

    // Truy vấn tìm kiếm sản phẩm theo từ khóa
    $sql = "SELECT * FROM products WHERE Product_name LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        echo '<h2>Kết quả tìm kiếm cho: "' . htmlspecialchars($query) . '"</h2>';
        echo '<div class="product-grid">';
        
        // Hiển thị danh sách sản phẩm tìm thấy
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="product-card">
                        <a href="index.php?xem=chitiet&id=' . $row['Product_id'] . '">
                            <div class="image-container">
                                <img class="product-image" src="' . $row['Image'] . '" alt="' . $row['Product_name'] . '" />
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">' . $row['Product_name'] . '</h3>
                                <div class="price-cart">
                                    <p class="price">' . number_format($row['Price'], 0, ',', '.') . '$ </p>
                                    <button class="add-to-cart">
                                        <img class="cart-icon" src="./images/cart.png" alt="Add to cart" />
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>';
        }
        echo '</div>'; // Kết thúc phần hiển thị sản phẩm
    } else {
        echo '<p>Không có sản phẩm nào phù hợp với từ khóa "' . htmlspecialchars($query) . '"</p>';
    }
} else {
    echo '<p>Vui lòng nhập từ khóa tìm kiếm.</p>';
}
?>
</section>
<?php
include('footer.php'); 
?>
