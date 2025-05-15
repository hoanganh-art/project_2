CREATE DATABASE cuahang;

USE cuahang;

-- Khách hàng
CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    avatar VARCHAR(255),
    gender TINYINT(1),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL DEFAULT 'active'
);

-- Nhân viên
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE NOT NULL,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    position VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'active',
    role ENUM('staff', 'manager') NOT NULL DEFAULT 'staff',
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    gender TINYINT(1),
    address TEXT NOT NULL,
    avatar VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT
    *
FROM
    admin;

-- Cập nhật thông tin admin
UPDATE
    admin
SET
    name = 'Updated Name',
    email = 'updated_email@example.com',
    phone = '123456789',
    gender = 1,
    address = 'Updated Address',
    avatar = 'updated_avatar.jpg',
    password = 'new_password',
    status = 'inactive'
WHERE
    id = 1;

-- Sản phẩm
CREATE TABLE product (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(400) NOT NULL,
    /*Tên sản phẩm */
    code VARCHAR(200) NOT NULL UNIQUE,
    /* Mã Sản phẩm */
    price FLOAT NOT NULL,
    /*Giá bán*/
    original_price FLOAT NOT NULL,
    /*Giá gốc */
    category VARCHAR(255) NOT NULL,
    /*Danh mục*/
    subcategory VARCHAR(255) NOT NULL,
    /*loại sản phẩm*/
    stock FLOAT NOT NULL,
    /*Số lượng sản phẩm */
    status VARCHAR(100) NOT NULL DEFAULT 'active',
    /*Trạng thái */
    description TEXT NOT NULL,
    /* Mô tả */
    image VARCHAR(2555)
    /*Ảnh minh họa */
);

-- Giỏ hàng
-- Giỏ hàng
CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'active',
    color VARCHAR(255) NOT NULL,
    size VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer (id),
    FOREIGN KEY (product_id) REFERENCES product (id)
);

-- Đơn hàng
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    employee_id INT NULL,
    total_amount FLOAT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    payment_method VARCHAR(50),
    shipping_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer (id),
    FOREIGN KEY (employee_id) REFERENCES employees (id)
);

-- Chi tiết đơn hàng
CREATE TABLE order_detail (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price FLOAT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders (id),
    FOREIGN KEY (product_id) REFERENCES product (id)
);

-- Bảng cài đặt liên hệ
CREATE TABLE contact_settings (
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