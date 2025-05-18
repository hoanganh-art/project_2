-- Tạo database (giữ nguyên)
CREATE DATABASE IF NOT EXISTS cuahang;
USE cuahang;

-- Bảng khách hàng (đã cải tiến)
CREATE TABLE `customer` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `address` text NOT NULL,
    `avatar` varchar(255) DEFAULT NULL,
    `gender` tinyint(1) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `status` varchar(50) NOT NULL DEFAULT 'active',
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    INDEX `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Bảng nhân viên (đã cải tiến)
CREATE TABLE `employees` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `date_of_birth` date NOT NULL,
    `address` text NOT NULL,
    `password` varchar(255) NOT NULL,
    `position` varchar(50) NOT NULL,
    `status` varchar(50) NOT NULL DEFAULT 'active',
    `role` enum('staff') NOT NULL DEFAULT 'staff',
    `avatar` varchar(255) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    INDEX `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Bảng admin (đã cải tiến)
CREATE TABLE `admin` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `gender` tinyint(1) DEFAULT NULL,
    `address` text NOT NULL,
    `avatar` varchar(255) DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `status` varchar(50) NOT NULL DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Bảng sản phẩm (đã cải tiến)
CREATE TABLE `product` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(400) NOT NULL,
    `code` varchar(200) NOT NULL,
    `price` float NOT NULL,
    `original_price` float NOT NULL,
    `category` varchar(255) NOT NULL,
    `subcategory` varchar(255) NOT NULL,
    `stock` float NOT NULL,
    `status` varchar(100) NOT NULL DEFAULT 'active',
    `description` text NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`),
    INDEX `category` (`category`),
    INDEX `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Bảng orders (đã cải tiến)
CREATE TABLE `orders` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `customer_id` int(11) NOT NULL,
    `employee_id` int(11) DEFAULT NULL,
    `total_amount` float NOT NULL,
    `payment_method` varchar(50) NOT NULL,
    `shipping_address` text NOT NULL,
    `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
    `status` varchar(50) NOT NULL DEFAULT 'pending',
    `notes` text DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`customer_id`) 
        REFERENCES `customer` (`id`)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY (`employee_id`) 
        REFERENCES `employees` (`id`)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    INDEX `customer_id` (`customer_id`),
    INDEX `status` (`status`),
    INDEX `order_date` (`order_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Bảng order_detail (đã cải tiến)
CREATE TABLE `order_detail` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `order_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `quantity` int(11) NOT NULL,
    `price` float NOT NULL,
    `color` varchar(50) DEFAULT NULL,
    `size` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`order_id`) 
        REFERENCES `orders` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`product_id`) 
        REFERENCES `product` (`id`)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    INDEX `order_id` (`order_id`),
    INDEX `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Bảng cart (đã cải tiến)
CREATE TABLE `cart` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `customer_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `color` varchar(50) NOT NULL,
    `size` varchar(50) NOT NULL,
    `quantity` int(11) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
     `status` varchar(50) NOT NULL DEFAULT 'active',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`customer_id`) 
        REFERENCES `customer` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (`product_id`) 
        REFERENCES `product` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    UNIQUE KEY `unique_cart_item` (`customer_id`, `product_id`, `color`, `size`),
    INDEX `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Các bảng khác giữ nguyên như cũ
CREATE TABLE `contact` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `subject` mediumtext DEFAULT NULL,
    `message` longtext DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `contact_settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `address` varchar(255) NOT NULL COMMENT 'Địa chỉ cửa hàng',
    `phone_1` varchar(20) NOT NULL COMMENT 'Số điện thoại chính',
    `phone_2` varchar(20) DEFAULT NULL COMMENT 'Số điện thoại phụ',
    `email_1` varchar(100) NOT NULL COMMENT 'Email chính',
    `email_2` varchar(100) DEFAULT NULL COMMENT 'Email phụ',
    `map_url` text DEFAULT NULL COMMENT 'URL Google Maps',
    `facebook_url` varchar(255) DEFAULT NULL COMMENT 'Link Facebook',
    `instagram_url` varchar(255) DEFAULT NULL COMMENT 'Link Instagram',
    `youtube_url` varchar(255) DEFAULT NULL COMMENT 'Link YouTube',
    `tiktok_url` varchar(255) DEFAULT NULL COMMENT 'Link TikTok',
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật',
    `updated_by` int(11) DEFAULT NULL COMMENT 'ID người cập nhật',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu admin mẫu
INSERT INTO `admin` (`name`, `email`, `password`, `status`) VALUES
    ('Second Admin', 'secondadmin@example.com', '$2y$10$LjeOEope0BsHsrEClUxTG.e3BkEJWzZffVKW0ySuMk4IJx8iaoEia', 'active');