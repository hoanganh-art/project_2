-- Tạo database (giữ nguyên)
CREATE DATABASE cuahangs;
USE cuahangs;

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
-- Bảng admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone varchar(20),
    gender tinyint(1),
    address TEXT,
    avatar varchar(255),
    password VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * from admin;


-- 1. Sửa bảng contact:
CREATE TABLE contact (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL, 
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,       
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    status VARCHAR(50) DEFAULT 'unread'  
);

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

-- 4. Thêm ràng buộc khóa ngoại cho contact_settings
ALTER TABLE contact_settings
ADD CONSTRAINT fk_updated_by
FOREIGN KEY (updated_by) REFERENCES admin(id);

-- 5. Cải thiện bảng product (thêm các trường quan trọng)
ALTER TABLE product
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN created_by INT,
ADD COLUMN weight FLOAT,
ADD COLUMN brand VARCHAR(100),
ADD CONSTRAINT fk_created_by FOREIGN KEY (created_by) REFERENCES admin(id);

-- 6. Thêm bảng categories để quản lý danh mục tốt hơn
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    parent_id INT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id)
);

ALTER TABLE product
MODIFY COLUMN category INT,
MODIFY COLUMN subcategory INT,
ADD CONSTRAINT fk_product_category FOREIGN KEY (category) REFERENCES categories(id),
ADD CONSTRAINT fk_product_subcategory FOREIGN KEY (subcategory) REFERENCES categories(id);