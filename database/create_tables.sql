
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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Bảng orders (đã cải tiến)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    name VARCHAR(255),
    address TEXT,
    phone VARCHAR(20),
    payment_method VARCHAR(50),
    notes TEXT,
    total INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL DEFAULT 'pending'
);

-- Bảng order_detail (đã cải tiến)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_name VARCHAR(255),
    price INT,
    quantity INT,
    color VARCHAR(50),
    size VARCHAR(50),
    image VARCHAR(255),
    product_id INT,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE
    SET
        NULL ON UPDATE CASCADE
);

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
    FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY `unique_cart_item` (`customer_id`, `product_id`, `color`, `size`),
    INDEX `customer_id` (`customer_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Thêm dữ liệu admin mẫu
INSERT INTO
    `admin` (`name`, `email`, `password`, `status`)
VALUES
    (
        'Second Admin',
        'secondadmin@example.com',
        '$2y$10$LjeOEope0BsHsrEClUxTG.e3BkEJWzZffVKW0ySuMk4IJx8iaoEia',
        'active'
    );

-- Truy vấn tất cả đơn hàng cùng các sản phẩm trong từng đơn

SELECT
    o.id AS order_id,
    o.customer_id,
    o.name AS customer_name,
    o.address,
    o.phone,
    o.payment_method,
    o.notes,
    o.status,
    o.total,
    o.created_at,
    oi.id AS order_item_id,
    oi.product_id,
    p.name AS product_name,
    p.code AS product_code,
    p.price AS product_price,
    p.original_price,
    p.category,
    p.subcategory,
    p.stock,
    p.status AS product_status,
    p.description,
    p.image AS product_image,
    oi.price AS order_item_price,
    oi.quantity,
    oi.color,
    oi.size,
    oi.image AS order_item_image
FROM
    orders o
    LEFT JOIN order_items oi ON o.id = oi.order_id
    LEFT JOIN product p ON oi.product_id = p.id
ORDER BY
    o.id DESC,
    oi.id ASC;



ALTER TABLE orders
ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'pending';


UPDATE orders SET status = 'delivered';


SELECT * FROM orders;
SELECT * FROM order_items;

-- truy vẫn hai bảng orders và order_items

SELECT
    o.*,
    oi.*,
    oi.id AS order_item_id
FROM
    orders o
JOIN
    order_items oi ON o.id = oi.order_id;




ALTER TABLE orders
ADD CONSTRAINT fk_orders_customer
FOREIGN KEY (customer_id) REFERENCES customer(id)
ON DELETE SET NULL
ON UPDATE CASCADE;

-- Cập nhật trạng thái status ở orders ngẫu nhiên
UPDATE orders
SET status = (CASE FLOOR(RAND() * 3)
    WHEN 0 THEN 'pending'
    WHEN 1 THEN 'delivered'
    ELSE 'completed'
END);
UPDATE orders SET status  = 'completed';


-- Thêm dữ liệu mẫu cho bảng orders và order_items 