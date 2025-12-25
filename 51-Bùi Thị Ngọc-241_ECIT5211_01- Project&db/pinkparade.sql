-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 05, 2025 lúc 04:27 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `pinkparade`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `Cart_id` int(11) NOT NULL,
  `Cus_id` int(11) DEFAULT NULL,
  `Product_id` varchar(10) DEFAULT NULL,
  `Cart_quant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `Cus_id` int(11) NOT NULL,
  `Cus_name` varchar(40) NOT NULL,
  `Cus_phone` char(13) NOT NULL,
  `Cus_add` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`Cus_id`, `Cus_name`, `Cus_phone`, `Cus_add`, `Password`) VALUES
(1, 'Bùi Thị A', '0123456789', '', '$2y$10$bM6mmSEYQm7hHPt/yafHleZRrefPuwVdYPYJ2aJiRLDndvO7w6re2'),
(2, 'Bùi Thị B', '0123456781', '', '$2y$10$dPIjyKpIOK6mpvlS7.MTvOX2pZfDVkNM0RP3jTuS6d4ZHC0sVLH7G');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `Order_id` varchar(10) NOT NULL,
  `Cus_id` varchar(10) DEFAULT NULL,
  `Order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`Order_id`, `Cus_id`, `Order_date`) VALUES
('ORD6779A02', '1', '2025-01-04'),
('ORD6779A12', '1', '2025-01-04'),
('ORD6779A1E', '1', '2025-01-04'),
('ORD6779A29', '1', '2025-01-04'),
('ORD6779A32', '1', '2025-01-04'),
('ORD6779A36', '1', '2025-01-04'),
('ORD6779A3F', '1', '2025-01-04'),
('ORD6779A62', '1', '2025-01-04'),
('ORD6779A87', '1', '2025-01-04'),
('ORD6779A92', '1', '2025-01-04'),
('ORD6779AA2', '1', '2025-01-04'),
('ORD6779AAC', '1', '2025-01-04'),
('ORD6779ABA', '1', '2025-01-04'),
('ORD6779AC8', '1', '2025-01-04'),
('ORD6779E5A', '1', '2025-01-05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `Product_id` varchar(6) NOT NULL,
  `Product_name` varchar(255) NOT NULL,
  `Category` enum('Sản phẩm dưỡng','Sản phẩm chống nắng','Sản phẩm làm sạch') NOT NULL,
  `Product_quant` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`Product_id`, `Product_name`, `Category`, `Product_quant`, `Price`, `Description`, `Image`) VALUES
('P001', '[MEDICUBE] Collagen Jelly Cream 110ml', 'Sản phẩm dưỡng', 100, 25.00, 'A transparent collagen jelly cream that provides anti-aging benefits to enhance facial contours, promote firmness, and achieve a polished and glowing complexion. Immediately after application, the skin restores its natural inner radiance with tightened, radiant, volumized \"Korean Glass Glow\" effect.', 'images/a1.jpg'),
('P002', '[Beauty Of Joseon] Relief Sun : Rice + Probiotics 50ml', 'Sản phẩm chống nắng', 100, 14.00, 'Relief Sun is an organic sunscreen that applies gently on the skin and by also including skin calming ingredients, it allows sensitive skin types to use it with ease as well.', 'images/a2.jpg'),
('P003', '[Dr.G] R.E.D Blemish Clear Soothing Cream 70ml', 'Sản phẩm dưỡng', 100, 24.00, 'Powerful soothing and hydrating cream. Relaxing and calming for sensitized skin.', 'images/a3.jpg'),
('P004', '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml', 'Sản phẩm làm sạch', 100, 10.00, 'The cleansing foam contains Houttuynia Cordata Powder to remove dead skin and waste in pores.', 'images/a4.jpg'),
('P005', '[Banila co X My Melody] Clean it Zero Cleansing Balm Original 125ml', 'Sản phẩm làm sạch', 90, 21.00, '[My Melody Edition] Clean it Zero Cleansing Balm Original 125ml for All Skin Types (Normal to Combination).', 'images/a5.jpg'),
('P006', '[d\'Alba] White Truffle First Spray Serum 100ml (Vegan)', 'Sản phẩm dưỡng', 90, 24.00, 'Experience the upgraded 2024 formula of the Clean It Zero Cleansing Balm Original, now vegan and more powerful than ever!', 'images/a6.jpg'),
('P007', '[d\'Alba] Mild Skin Balancing Vegan Cleanser 200ml', 'Sản phẩm làm sạch', 90, 26.00, 'Mild pH (4.7~6.7) cleanser: Formulated close to the natural skin\'s pH (5.5~6.5) to balance skin pH for a hydrated and non-tightening finish after cleansing.', 'images/a7.jpg'),
('P008', '[FULLY] Green Tomato Basic Pore Cleansing with Toner Bundle', 'Sản phẩm dưỡng', 90, 35.00, 'Enriched with 49% green tomato extract, Fully Clay Mask Cleanser offers excessive sebum control and gentle exfoliation.', 'images/a8.jpg'),
('P009', '[Beauty of Joseon] Matte Sun Stick : Mugwort + Camelia', 'Sản phẩm chống nắng', 100, 13.00, 'Key ingredients: Artemisia Capillaris. Mugwort has been an important ingredient throughout the history of oriental medicine.', 'images/a9.jpg'),
('P010', '[d\'Alba] Waterfull Essence Sun Cream 50ml (Vegan)', 'Sản phẩm chống nắng', 100, 24.00, 'A chemical sunscreen with a broad spectrum SPF50+ PA++++ that protects the skin from UV rays.', 'images/a10.jpg'),
('P011', '[celimax] Pore+Dark Spot Brightening Care Sunscreen 50ml', 'Sản phẩm chống nắng', 100, 15.00, 'Benefits: A chemical sunscreen with a broad spectrum SPF50+ PA++++ that protects the skin from UV rays.', 'images/a11.jpg'),
('P012', '[HYAAH] Mild But Deep Cleansing Water 300m', 'Sản phẩm làm sạch', 100, 23.00, 'With HYAAH’s unique multi-micellar method, it quickly removes only impurities and makeup, while leaving moisture to prevent skin from drying out easily.', 'images/a12.jpg');


--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `Order_item_id` int(11) NOT NULL,
  `Order_id` varchar(10) NOT NULL,
  `Product_id` varchar(6) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Subtotal` decimal(20,2) GENERATED ALWAYS AS (`Quantity` * `Price`) STORED,
  `Product_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`Order_item_id`, `Order_id`, `Product_id`, `Quantity`, `Price`, `Product_name`) VALUES
(1, 'ORD6779A02', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(2, 'ORD6779A12', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(3, 'ORD6779A12', '', 1, 21.00, '[Banila co X My Melody] Clean it Zero Cleansing Balm Original 125ml'),
(4, 'ORD6779A1E', '', 1, 21.00, '[Banila co X My Melody] Clean it Zero Cleansing Balm Original 125ml'),
(5, 'ORD6779A29', '', 1, 21.00, '[Banila co X My Melody] Clean it Zero Cleansing Balm Original 125ml'),
(6, 'ORD6779A32', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(7, 'ORD6779A36', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(8, 'ORD6779A3F', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(9, 'ORD6779A62', '', 1, 21.00, '[Banila co X My Melody] Clean it Zero Cleansing Balm Original 125ml'),
(10, 'ORD6779A87', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(11, 'ORD6779A92', '', 1, 21.00, '[Banila co X My Melody] Clean it Zero Cleansing Balm Original 125ml'),
(12, 'ORD6779AA2', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(13, 'ORD6779AAC', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(14, 'ORD6779ABA', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(15, 'ORD6779AC8', '', 1, 10.00, '[Anua] Heartleaf Quercetinol Pore Deep Cleansing Foam 150ml'),
(16, 'ORD6779E5A', '', 2, 21.00, '[Banila co X My Melody] Clean it Zero Cleansing Balm Original 125ml');

-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Cart_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Cus_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `Cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `Cus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
