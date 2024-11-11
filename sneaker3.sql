-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 10, 2024 lúc 11:44 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sneaker`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '$2y$10$9fRyVlzUzVQNDPj.gFx2oOXr24lHZdbrIx03Lzkv0Fzoq/pEDhI5u', '2024-11-10 13:41:55', '2024-11-10 13:41:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_order`
--

CREATE TABLE `admin_order` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `shipping_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `action` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banner`
--

INSERT INTO `banner` (`banner_id`, `image_url`, `order`, `action`, `created_at`, `updated_at`) VALUES
(1, 'nike-banner.jpg', 3, 1, '2024-11-04 02:13:18', '2024-11-04 13:17:22'),
(2, 'adidas-banner.jpg', 2, 1, '2024-11-04 02:13:59', '2024-11-04 13:17:30'),
(3, 'converse-banner.jpg', 1, 1, '2024-11-04 02:13:59', '2024-11-04 13:17:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`brand_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ADIDAS', '2024-10-21 10:03:18', '2024-10-21 10:03:18'),
(2, 'NIKE', '2024-10-21 10:03:18', '2024-10-21 10:03:18'),
(3, 'VANS', '2024-10-21 12:02:15', '2024-10-21 12:02:15'),
(5, 'CONVERSE', '2024-10-21 10:04:34', '2024-10-21 10:04:34'),
(4, 'FILA', '2024-10-21 12:02:36', '2024-10-21 12:02:36'),
(6, 'MLB', '2024-10-21 10:49:27', '2024-10-21 10:49:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 10, '2024-11-10 14:55:09', '2024-11-10 14:55:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `color`
--

CREATE TABLE `color` (
  `color_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `color`
--

INSERT INTO `color` (`color_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'red', '2024-11-06 23:05:31', '2024-11-06 23:05:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` int(11) NOT NULL,
  `status` enum('pending','completed','canceled') NOT NULL,
  `shipping_address` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 7, '2024-11-06 23:04:38', 123000000, 'completed', 'abc', '2024-11-06 23:04:38', '2024-11-06 23:04:38'),
(2, 7, '2024-11-06 23:11:16', 123000000, 'completed', 'abc', '2024-11-06 23:11:16', '2024-11-06 23:11:16'),
(3, 7, '2024-11-06 23:11:53', 123000000, 'completed', 'abc', '2024-11-06 23:11:53', '2024-11-06 23:11:53'),
(4, 7, '2024-11-06 23:11:53', 123000000, 'completed', 'abc', '2024-11-06 23:11:53', '2024-11-06 23:11:53'),
(5, 10, '2024-11-10 09:03:09', 1158000000, 'pending', '40 ho chi minh', '2024-11-10 15:03:09', '2024-11-10 15:03:09'),
(6, 10, '2024-11-10 09:16:55', 345000000, 'pending', '', '2024-11-10 15:16:55', '2024-11-10 15:16:55'),
(7, 10, '2024-11-10 09:24:48', 123000000, 'pending', '30 van kiep', '2024-11-10 15:24:48', '2024-11-10 15:24:48'),
(8, 10, '2024-11-10 10:17:28', 0, 'pending', '', '2024-11-10 16:17:28', '2024-11-10 16:17:28'),
(9, 10, '2024-11-10 10:40:37', 345000000, 'pending', '40 ho chi minh', '2024-11-10 16:40:37', '2024-11-10 16:40:37'),
(10, 10, '2024-11-10 10:48:34', 567000000, 'pending', '100 suc manh', '2024-11-10 16:48:34', '2024-11-10 16:48:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `size_id`, `color_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 123000000, '2024-11-06 23:05:16', '2024-11-06 23:05:16'),
(2, 2, 2, 1, 1, 1, 123000000, '2024-11-06 23:13:03', '2024-11-06 23:13:03'),
(3, 3, 3, 1, 1, 1, 123000000, '2024-11-06 23:13:03', '2024-11-06 23:13:03'),
(4, 4, 4, 1, 1, 1, 123000000, '2024-11-06 23:13:27', '2024-11-06 23:13:27'),
(5, 5, 2, 1, 1, 2, 123000000, '2024-11-10 15:03:09', '2024-11-10 15:03:09'),
(6, 5, 3, 1, 1, 1, 567000000, '2024-11-10 15:03:09', '2024-11-10 15:03:09'),
(7, 5, 1, 1, 1, 1, 345000000, '2024-11-10 15:03:09', '2024-11-10 15:03:09'),
(8, 6, 1, 1, 1, 1, 345000000, '2024-11-10 15:16:55', '2024-11-10 15:16:55'),
(9, 7, 2, 1, 1, 1, 123000000, '2024-11-10 15:24:48', '2024-11-10 15:24:48'),
(10, 9, 1, 1, 1, 1, 345000000, '2024-11-10 16:40:37', '2024-11-10 16:40:37'),
(11, 10, 3, 1, 1, 1, 567000000, '2024-11-10 16:48:34', '2024-11-10 16:48:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` enum('credit_card','paypal','bank_transfer') NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `name`, `brand_id`, `description`, `price`, `type`, `created_at`, `updated_at`) VALUES
(2, 'giày adidas', 1, 'abc', 123000000, 'Ultraboost', '2024-10-21 10:08:26', '2024-11-06 20:16:30'),
(1, 'giày nike', 2, 'abc', 345000000, 'Air Force 1', '2024-10-21 10:07:12', '2024-11-06 20:17:22'),
(3, 'giày vans', 3, 'abc', 567000000, 'Old Skool', '2024-10-21 10:09:06', '2024-11-06 20:17:56'),
(4, 'giày FILA', 4, 'abc', 789000000, 'abc', '2024-11-06 23:14:49', '2024-11-06 23:14:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_color`
--

CREATE TABLE `product_color` (
  `product_color_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_color`
--

INSERT INTO `product_color` (`product_color_id`, `product_id`, `color_id`, `created_at`, `updated_at`) VALUES
(2, 1, 1, '2024-11-10 15:04:20', '2024-11-10 15:04:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_image`
--

CREATE TABLE `product_image` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_main` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_image`
--

INSERT INTO `product_image` (`image_id`, `product_id`, `image_url`, `is_main`, `created_at`, `updated_at`) VALUES
(1, 2, 'product1.png', 1, '2024-10-22 02:58:08', '2024-11-10 14:43:15'),
(3, 3, 'product2.png', 1, '2024-10-22 08:12:53', '2024-11-10 14:41:53'),
(2, 1, 'product3.png', 1, '2024-11-04 13:48:36', '2024-11-10 14:53:12'),
(4, 4, 'product4.png', 1, '2024-11-06 23:15:47', '2024-11-06 23:15:47'),
(7, 1, '../admin/uploads/product2.png', 0, '2024-11-10 15:04:20', '2024-11-10 15:04:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_size`
--

CREATE TABLE `product_size` (
  `product_size_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_size`
--

INSERT INTO `product_size` (`product_size_id`, `product_id`, `size_id`, `created_at`, `updated_at`) VALUES
(2, 1, 1, '2024-11-10 15:04:20', '2024-11-10 15:04:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `review_date` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `size_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`size_id`, `value`, `created_at`, `updated_at`) VALUES
(1, '44', '2024-11-06 23:05:49', '2024-11-06 23:05:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `phone`, `address`, `username`, `password`, `created_at`, `updated_at`) VALUES
(9, 'Vương Việt Thắng', 'admin@gmail.com', '0797839603', '145/23/1 đường Lê Thị Hoa, phường Bình Chiểu, Tp Thủ Đức', 'a', '$2y$10$/zl6a8Wq8p94PuQ8F73euOrzI/Q3eL0RCcETw2C7GZe0MFxDSRo7m', '2024-10-20 22:28:46', '2024-10-20 23:40:51'),
(8, 'admin', 'admin@gmail.com', '0797839603', '145/23/1 đường Lê Thị Hoa, phường Bình Chiểu, Tp Thủ Đức', '123', '$2y$10$9VyRuyAabMqcW2A91U/WC.giNlkuiQ71IOAg7uN3tWhE9EDj4qgy.', '2024-10-19 08:07:45', '2024-10-19 08:07:45'),
(7, 'admin', 'admin@gmail.com', '0797839603', '145/23/1 đường Lê Thị Hoa, phường Bình Chiểu, Tp Thủ Đức', 'admin', '$2y$10$c9BVZTFThADhfr27NshRF.Bew.Z42M0GUaQiWoYEsvF8aHyr20VMa', '2024-10-19 01:30:42', '2024-10-19 01:30:42'),
(10, 'khoa', 'khoa@gmail.com', '0903145032', 'abc', 'khoa', '$2y$10$F2xOOr14YZXNrzPJhksEz.4POrzPVE33tugfo.Kj/1Am5DsYP2cPG', '2024-11-10 14:06:27', '2024-11-10 14:06:27');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `admin_order`
--
ALTER TABLE `admin_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`color_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `brand_id` (`brand_id`) USING BTREE;

--
-- Chỉ mục cho bảng `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`product_color_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`product_size_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `admin_order`
--
ALTER TABLE `admin_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `color`
--
ALTER TABLE `color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `product_color`
--
ALTER TABLE `product_color`
  MODIFY `product_color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `product_image`
--
ALTER TABLE `product_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `product_size`
--
ALTER TABLE `product_size`
  MODIFY `product_size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
