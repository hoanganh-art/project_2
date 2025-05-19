-- Bảng orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    name VARCHAR(255),
    address TEXT,
    phone VARCHAR(20),
    payment_method VARCHAR(50),
    notes TEXT,
    total INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
USER cuahang;
DROP TABLE orders;
-- Bảng order_items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_name VARCHAR(255),
    price INT,
    quantity INT,
    color VARCHAR(50),
    size VARCHAR(50),
    image VARCHAR(255)
);