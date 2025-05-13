CREATE DATABASE cuahang;
DROP DATABASE cuahang;
USE cuahang;

-- Bảng khách hàng
CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    avatar VARCHAR(255),
    gender TINYINT(1),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * from customer;
DROP TABLE customer;
ALTER TABLE customer ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'active';

-- Bảng nhân viên
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
    role ENUM('staff') NOT NULL DEFAULT 'staff',
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * from employees;

-- Bảng admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'active'
);
-- Thêm tài khoản admin với password được hash
SELECT * FROM admin;

-- Sản phẩm 
CREATE TABLE product(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(400) NOT NULL,  /*Tên sản phẩm */
    code VARCHAR(200) NOT NULL UNIQUE, /* Mã Sản phẩm */
    price FLOAT NOT NULL, /*Giá bán*/
    original_price FLOAT NOT NULL, /*Giá gốc */
    category VARCHAR(255) NOT NULL, /*Danh mục*/
    subcategory VARCHAR(255) NOT NULL, /*loại sản phẩm*/
    stock FLOAT NOT NULL, /*Số lượng sản phẩm */
    status VARCHAR(100) NOT NULL DEFAULT 'active', /*Trạng thái */
    description TEXT NOT NULL, /* Mô tả */
    image VARCHAR(2555) /*Ảnh minh họa */
);
SELECT * FROM product;
DROP TABLE product;
-- Thêm dữ liệu vào bảng product
INSERT INTO product (name, code, price, original_price, category, subcategory, stock, status, description, image)
VALUES
('Laptop Dell XPS 13', 'LAP001', 1500.00, 1400.00, 'Electronics', 'Laptops', 50, 'active', 'High-performance laptop with sleek design.', 'dell_xps_13.jpg'),
('iPhone 14 Pro', 'IPH001', 1200.00, 1100.00, 'Electronics', 'Smartphones', 100, 'active', 'Latest Apple smartphone with advanced features.', 'iphone_14_pro.jpg'),
('Samsung Galaxy S22', 'SAM001', 1000.00, 950.00, 'Electronics', 'Smartphones', 80, 'active', 'Flagship Samsung smartphone with powerful performance.', 'galaxy_s22.jpg'),
('Sony WH-1000XM5', 'SON001', 400.00, 350.00, 'Electronics', 'Headphones', 200, 'active', 'Noise-canceling over-ear headphones.', 'sony_wh_1000xm5.jpg'),
('Apple Watch Series 8', 'APP001', 500.00, 450.00, 'Electronics', 'Wearables', 150, 'active', 'Smartwatch with health tracking features.', 'apple_watch_series_8.jpg');

-- Thêm tài khoản admin mới với password được hash
INSERT INTO admin (name, email, password, status)
VALUES
('Second Admin', 'secondadmin@example.com','$2y$10$LjeOEope0BsHsrEClUxTG.e3BkEJWzZffVKW0ySuMk4IJx8iaoEia', 'active');
SELECT * FROM admin;
SELECT id, name, status FROM product;
-- Cập nhật tất cả sản phẩm có status = 0 thành "active"
UPDATE product SET status = 'active' WHERE status = '0';

-- Hoặc cập nhật thành "inactive" nếu muốn
-- UPDATE product SET status = 'inactive' WHERE status = '0';

-- Bảng giỏ hàng
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    product_id INT,
    quantity INT,
    color VARCHAR(50),
    size VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    FOREIGN KEY (product_id) REFERENCES product(id)
);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT * FROM contact_settings;
UPDATE contact_settings
SET 
    address = '123 Main Street, Hanoi, Vietnam',
    phone_1 = '0123456789',
    phone_2 = '0987654321',
    email_1 = 'contact@cuahang.com',
    email_2 = 'support@cuahang.com',
    map_url = 'https://maps.google.com/example',
    facebook_url = 'https://facebook.com/cuahang',
    instagram_url = 'https://instagram.com/cuahang',
    youtube_url = 'https://youtube.com/cuahang',
    tiktok_url = 'https://tiktok.com/@cuahang',
    updated_by = 1
WHERE id = 1;

-- Thêm dữ liệu ngẫu nhiên vào bảng customer
INSERT INTO customer (name, email, password, phone, address, avatar, gender)
VALUES
('Nguyen Van A', 'nguyenvana@example.com', '$2y$10$abc123', '0123456789', '123 Main Street, Hanoi', 'avatar1.jpg', 1),
('Tran Thi B', 'tranthib@example.com', '$2y$10$def456', '0987654321', '456 Second Street, Ho Chi Minh City', 'avatar2.jpg', 0),
('Le Van C', 'levanc@example.com', '$2y$10$ghi789', '0912345678', '789 Third Street, Da Nang', 'avatar3.jpg', 1);

-- Thêm dữ liệu ngẫu nhiên vào bảng employees
INSERT INTO employees (name, email, phone, date_of_birth, address, password, position, avatar)
VALUES
('Pham Van D', 'phamvand@example.com', '0901234567', '1990-01-01', '123 Fourth Street, Hue', '$2y$10$jkl012', 'Manager', 'avatar4.jpg'),
('Hoang Thi E', 'hoangthie@example.com', '0934567890', '1995-05-05', '456 Fifth Street, Can Tho', '$2y$10$mno345', 'Sales', 'avatar5.jpg');

-- Thêm dữ liệu ngẫu nhiên vào bảng cart
INSERT INTO cart (customer_id, product_id, quantity, color, size)
VALUES
(1, 1, 2, 'Black', 'M'),
(2, 3, 1, 'White', 'L'),
(3, 5, 3, 'Blue', 'S');

-- Thêm dữ liệu ngẫu nhiên vào bảng contact_settings
INSERT INTO contact_settings (address, phone_1, phone_2, email_1, email_2, map_url, facebook_url, instagram_url, youtube_url, tiktok_url, updated_by)
VALUES
('789 Sixth Street, Hai Phong', '0911111111', '0922222222', 'info@cuahang.vn', 'support@cuahang.vn', 'https://maps.google.com/example2', 'https://facebook.com/cuahang2', 'https://instagram.com/cuahang2', 'https://youtube.com/cuahang2', 'https://tiktok.com/@cuahang2', 2);

-- Bảng đơn hàng    
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    total_price FLOAT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);  