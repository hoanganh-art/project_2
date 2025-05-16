-- Tạo database (giữ nguyên)
CREATE DATABASE cuahang;
USE cuahang;

-- 1. Sửa bảng contact: sửa 'phon' thành 'phone'
CREATE TABLE contact (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,  -- Đã sửa từ 'phon'
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,       -- Đổi từ VARCHAR(25555555) sang TEXT
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Thêm trường này
    status VARCHAR(50) DEFAULT 'unread'  -- Thêm trạng thái
);

-- 2. Thêm bảng orders còn thiếu
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

-- 3. Sửa bảng order_detail để đảm bảo tham chiếu đúng
CREATE TABLE order_detail (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price FLOAT NOT NULL,
    color VARCHAR(50),           -- Thêm thông tin màu sắc
    size VARCHAR(50),            -- Thêm thông tin kích thước
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

-- Sau đó cập nhật bảng product để sử dụng khóa ngoại
ALTER TABLE product
MODIFY COLUMN category INT,
MODIFY COLUMN subcategory INT,
ADD CONSTRAINT fk_product_category FOREIGN KEY (category) REFERENCES categories(id),
ADD CONSTRAINT fk_product_subcategory FOREIGN KEY (subcategory) REFERENCES categories(id);