
-- Thêm dữ liệu mẫu cho bảng orders-- Thêm đơn hàng mới
INSERT INTO orders (customer_id, name, address, phone, payment_method, notes, total, status)
VALUES (1, 'Nguyen Van A', '123 Đường ABC, Quận 1', '0909123456', 'COD', 'Giao giờ hành chính', 500000, 'pending');

-- Lấy id vừa thêm (giả sử là 5)
-- Thêm sản phẩm cho đơn hàng id = 5
INSERT INTO order_items (order_id, product_name, price, quantity, color, size, image, product_id)
VALUES (5, 'Áo Thun Nam', 250000, 2, 'Trắng', 'L', NULL, 1);


DELETE FROM order_items;
DELETE FROM orders;
ALTER TABLE orders AUTO_INCREMENT = 1;
ALTER TABLE order_items AUTO_INCREMENT = 1;