CREATE DATABASE cuahang;

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

SELECT id, name, status FROM product;
-- Cập nhật tất cả sản phẩm có status = 0 thành "active"
UPDATE product SET status = 'active' WHERE status = '0';

-- Hoặc cập nhật thành "inactive" nếu muốn
-- UPDATE product SET status = 'inactive' WHERE status = '0';

-- Bảng giỏ hàng
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL, --ID khách khàng 
    quantity INT NOT NULL DEFAULT 1,
    status VARCHAR(255) NOT NULL DEFAULT 'active', //trạng thái
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    FOREIGN KEY (product_id) REFERENCES product(id)
);