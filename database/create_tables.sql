-- Tạo database (giữ nguyên)
CREATE DATABASE cuahangs;

USE cuahangs;

-- Bảng khách hàng
CREATE TABLE `customer` (
    `id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `address` text NOT NULL,
    `avatar` varchar(255) DEFAULT NULL,
    `gender` tinyint(1) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Bảng nhân viên
CREATE TABLE `employees` (
    `id` int(11) NOT NULL,
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
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Bảng admin
CREATE TABLE `admin` (
    `id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `gender` tinyint(1) DEFAULT NULL,
    `address` text NOT NULL,
    `avatar` varchar(255) DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `status` varchar(50) NOT NULL DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

INSERT INTO
    admin (name, email, password, status)
VALUES
    (
        'Second Admin',
        'secondadmin@example.com',
        '$2y$10$LjeOEope0BsHsrEClUxTG.e3BkEJWzZffVKW0ySuMk4IJx8iaoEia',
        'active'
    );

SELECT
    *
FROM
    admin;

--Bảng sản phẩm
CREATE TABLE `product` (
    `id` int(11) NOT NULL,
    `name` varchar(400) NOT NULL,
    `code` varchar(200) NOT NULL,
    `price` float NOT NULL,
    `original_price` float NOT NULL,
    `category` varchar(255) NOT NULL,
    `subcategory` varchar(255) NOT NULL,
    `stock` float NOT NULL,
    `status` varchar(100) NOT NULL DEFAULT 'active',
    `description` text NOT NULL,
    `image` varchar(2555) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- 1. Sửa bảng contact:
CREATE TABLE `contact` (
    `id` int(11) NOT NULL,
    `name` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phon` varchar(255) DEFAULT NULL,
    `subject` mediumtext DEFAULT NULL,
    `message` longtext DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;



CREATE TABLE `contact_settings` (
    `id` int(11) NOT NULL,
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
    `updated_by` int(11) DEFAULT NULL COMMENT 'ID người cập nhật'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 2. Thêm bảng orders
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    employee_id INT,
    total_amount FLOAT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    shipping_address TEXT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    notes TEXT,
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- 3. Thêm bảng order_detail 
CREATE TABLE order_detail (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price FLOAT NOT NULL,
    color VARCHAR(50),
    size VARCHAR(50),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id)
);
