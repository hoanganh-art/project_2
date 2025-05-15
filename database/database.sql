-- Active: 1746948069875@@127.0.0.1@3306@cuahang
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


DROP TABLE contact_settings;
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
('Le Van C', 'levanc@example.com', '$2y$10$ghi789', '0912345678', '789 Third Street, Da Nang', 'avatar3.jpg', 1),
('Pham Thi D', 'phamthid@example.com', '$2y$10$jkl012', '0908765432', '321 Fourth Street, Hai Phong', 'avatar4.jpg', 0),
('Bui Van E', 'buivane@example.com', '$2y$10$mno345', '0976543210', '654 Fifth Street, Can Tho', 'avatar5.jpg', 1),
('Do Thi F', 'dothif@example.com', '$2y$10$pqr678', '0932123456', '987 Sixth Street, Nha Trang', 'avatar6.jpg', 0),
('Nguyen Van G', 'nguyenvang@example.com', '$2y$10$stu901', '0911223344', '111 Seventh Street, Vinh', 'avatar7.jpg', 1),
('Tran Thi H', 'tranthih@example.com', '$2y$10$vwx234', '0922334455', '222 Eighth Street, Quang Ninh', 'avatar8.jpg', 0),
('Le Van I', 'levani@example.com', '$2y$10$yzb567', '0933445566', '333 Ninth Street, Lao Cai', 'avatar9.jpg', 1),
('Pham Thi J', 'phamthij@example.com', '$2y$10$cde890', '0944556677', '444 Tenth Street, Thanh Hoa', 'avatar10.jpg', 0),
('Hoang Van K', 'hoangvank@example.com', '$2y$10$fgh123', '0955667788', '555 Eleventh Street, Bac Ninh', 'avatar11.jpg', 1),
('Vu Thi L', 'vuthil@example.com', '$2y$10$ijk456', '0966778899', '666 Twelfth Street, Nam Dinh', 'avatar12.jpg', 0),
('Nguyen Van M', 'nguyenvanm@example.com', '$2y$10$lmn789', '0977889900', '777 Thirteenth Street, Ha Tinh', 'avatar13.jpg', 1),
('Tran Thi N', 'tranthin@example.com', '$2y$10$pqr012', '0988990011', '888 Fourteenth Street, Quang Binh', 'avatar14.jpg', 0),
('Le Van O', 'levano@example.com', '$2y$10$stu345', '0999001122', '999 Fifteenth Street, Quang Tri', 'avatar15.jpg', 1),
('Pham Thi P', 'phamthip@example.com', '$2y$10$vwx678', '0900112233', '101 Sixteenth Street, Hue', 'avatar16.jpg', 0),
('Hoang Van Q', 'hoangvanq@example.com', '$2y$10$yzb901', '0911223345', '102 Seventeenth Street, Da Lat', 'avatar17.jpg', 1),
('Vu Thi R', 'vuthir@example.com', '$2y$10$cde234', '0922334456', '103 Eighteenth Street, Vung Tau', 'avatar18.jpg', 0),
('Nguyen Van S', 'nguyenvans@example.com', '$2y$10$fgh567', '0933445567', '104 Nineteenth Street, Phan Thiet', 'avatar19.jpg', 1),
('Tran Thi T', 'tranthit@example.com', '$2y$10$ijk890', '0944556678', '105 Twentieth Street, Bien Hoa', 'avatar20.jpg', 0),
('Le Van U', 'levanu@example.com', '$2y$10$lmn123', '0955667789', '106 Twenty-first Street, Long An', 'avatar21.jpg', 1),
('Pham Thi V', 'phamthiv@example.com', '$2y$10$pqr456', '0966778890', '107 Twenty-second Street, Tay Ninh', 'avatar22.jpg', 0),
('Hoang Van W', 'hoangvanw@example.com', '$2y$10$stu789', '0977889901', '108 Twenty-third Street, Soc Trang', 'avatar23.jpg', 1),
('Vu Thi X', 'vuthix@example.com', '$2y$10$vwx012', '0988990012', '109 Twenty-fourth Street, Bac Lieu', 'avatar24.jpg', 0),
('Nguyen Van Y', 'nguyenvany@example.com', '$2y$10$yzb345', '0999001123', '110 Twenty-fifth Street, Ca Mau', 'avatar25.jpg', 1),
('Tran Thi Z', 'tranthiz@example.com', '$2y$10$cde678', '0900112234', '111 Twenty-sixth Street, Kien Giang', 'avatar26.jpg', 0),
('Le Van AA', 'levanaa@example.com', '$2y$10$fgh901', '0911223346', '112 Twenty-seventh Street, An Giang', 'avatar27.jpg', 1),
('Pham Thi BB', 'phamthibb@example.com', '$2y$10$ijk234', '0922334457', '113 Twenty-eighth Street, Dong Thap', 'avatar28.jpg', 0),
('Hoang Van CC', 'hoangvancc@example.com', '$2y$10$lmn567', '0933445568', '114 Twenty-ninth Street, Ben Tre', 'avatar29.jpg', 1),
('Vu Thi DD', 'vuthidd@example.com', '$2y$10$pqr890', '0944556679', '115 Thirtieth Street, Tien Giang', 'avatar30.jpg', 0),
('Nguyen Van EE', 'nguyenvanee@example.com', '$2y$10$stu123', '0955667790', '116 Thirty-first Street, Tra Vinh', 'avatar31.jpg', 1),
('Tran Thi FF', 'tranthiff@example.com', '$2y$10$vwx456', '0966778891', '117 Thirty-second Street, Vinh Long', 'avatar32.jpg', 0),
('Le Van GG', 'levangg@example.com', '$2y$10$yzb789', '0977889902', '118 Thirty-third Street, Hau Giang', 'avatar33.jpg', 1),
('Pham Thi HH', 'phamthihh@example.com', '$2y$10$cde012', '0988990013', '119 Thirty-fourth Street, Can Tho', 'avatar34.jpg', 0),
('Hoang Van II', 'hoangvanii@example.com', '$2y$10$fgh345', '0999001124', '120 Thirty-fifth Street, Soc Trang', 'avatar35.jpg', 1),
('Vu Thi JJ', 'vuthijj@example.com', '$2y$10$ijk678', '0900112235', '121 Thirty-sixth Street, Bac Lieu', 'avatar36.jpg', 0),
('Nguyen Van KK', 'nguyenvankk@example.com', '$2y$10$lmn901', '0911223347', '122 Thirty-seventh Street, Ca Mau', 'avatar37.jpg', 1),
('Tran Thi LL', 'tranthill@example.com', '$2y$10$pqr234', '0922334458', '123 Thirty-eighth Street, Kien Giang', 'avatar38.jpg', 0),
('Le Van MM', 'levanmm@example.com', '$2y$10$stu567', '0933445569', '124 Thirty-ninth Street, An Giang', 'avatar39.jpg', 1),
('Pham Thi NN', 'phamthinn@example.com', '$2y$10$vwx890', '0944556680', '125 Fortieth Street, Dong Thap', 'avatar40.jpg', 0),
('Hoang Van OO', 'hoangvanoo@example.com', '$2y$10$yzb123', '0955667791', '126 Forty-first Street, Ben Tre', 'avatar41.jpg', 1),
('Vu Thi PP', 'vuthipp@example.com', '$2y$10$cde456', '0966778892', '127 Forty-second Street, Tien Giang', 'avatar42.jpg', 0),
('Nguyen Van QQ', 'nguyenvanqq@example.com', '$2y$10$fgh789', '0977889903', '128 Forty-third Street, Tra Vinh', 'avatar43.jpg', 1),
('Tran Thi RR', 'tranthirr@example.com', '$2y$10$ijk012', '0988990014', '129 Forty-fourth Street, Vinh Long', 'avatar44.jpg', 0),
('Le Van SS', 'levanss@example.com', '$2y$10$lmn345', '0999001125', '130 Forty-fifth Street, Hau Giang', 'avatar45.jpg', 1),
('Pham Thi TT', 'phamthitt@example.com', '$2y$10$pqr678', '0900112236', '131 Forty-sixth Street, Can Tho', 'avatar46.jpg', 0),
('Hoang Van UU', 'hoangvanuu@example.com', '$2y$10$stu901', '0911223348', '132 Forty-seventh Street, Soc Trang', 'avatar47.jpg', 1),
('Vu Thi VV', 'vuthivv@example.com', '$2y$10$vwx234', '0922334459', '133 Forty-eighth Street, Bac Lieu', 'avatar48.jpg', 0),
('Nguyen Van WW', 'nguyenvanww@example.com', '$2y$10$yzb567', '0933445570', '134 Forty-ninth Street, Ca Mau', 'avatar49.jpg', 1),
('Tran Thi XX', 'tranthixx@example.com', '$2y$10$cde890', '0944556681', '135 Fiftieth Street, Kien Giang', 'avatar50.jpg', 0);
-- Thêm dữ liệu ngẫu nhiên vào bảng employees
INSERT INTO employees (name, email, phone, date_of_birth, address, password, position, avatar)
VALUES
('Pham Van D', 'phamvand@example.com', '0901234567', '1990-01-01', '123 Fourth Street, Hue', '$2y$10$jkl012', 'Manager', 'avatar4.jpg'),
('Hoang Thi E', 'hoangthie@example.com', '0934567890', '1995-05-05', '456 Fifth Street, Can Tho', '$2y$10$mno345', 'Sales', 'avatar5.jpg'),
('Nguyen Van F', 'nguyenvanf@example.com', '0912345678', '1988-03-12', '789 Sixth Street, Da Nang', '$2y$10$pqr678', 'Accountant', 'avatar6.jpg'),
('Tran Thi G', 'tranthig@example.com', '0923456789', '1992-07-21', '321 Seventh Street, Nha Trang', '$2y$10$stu901', 'Sales', 'avatar7.jpg'),
('Le Van H', 'levanh@example.com', '0934567891', '1985-11-30', '654 Eighth Street, Vinh', '$2y$10$vwx234', 'Manager', 'avatar8.jpg'),
('Pham Thi I', 'phamthii@example.com', '0945678912', '1993-09-15', '987 Ninth Street, Quang Ninh', '$2y$10$yzb567', 'Accountant', 'avatar9.jpg'),
('Hoang Van J', 'hoangvanj@example.com', '0956789123', '1989-12-25', '111 Tenth Street, Lao Cai', '$2y$10$cde890', 'Sales', 'avatar10.jpg'),
('Vu Thi K', 'vuthik@example.com', '0967891234', '1991-06-18', '222 Eleventh Street, Thanh Hoa', '$2y$10$fgh123', 'Manager', 'avatar11.jpg'),
('Nguyen Van L', 'nguyenvanl@example.com', '0978912345', '1987-04-09', '333 Twelfth Street, Bac Ninh', '$2y$10$ijk456', 'Sales', 'avatar12.jpg'),
('Tran Thi M', 'tranthim@example.com', '0989123456', '1994-08-22', '444 Thirteenth Street, Nam Dinh', '$2y$10$lmn789', 'Accountant', 'avatar13.jpg'),
('Le Van N', 'levann@example.com', '0991234567', '1996-02-14', '555 Fourteenth Street, Ha Tinh', '$2y$10$pqr012', 'Sales', 'avatar14.jpg'),
('Pham Thi O', 'phamthio@example.com', '0902345678', '1986-10-05', '666 Fifteenth Street, Quang Binh', '$2y$10$stu345', 'Manager', 'avatar15.jpg'),
('Hoang Van P', 'hoangvanp@example.com', '0913456789', '1990-03-17', '777 Sixteenth Street, Quang Tri', '$2y$10$vwx678', 'Sales', 'avatar16.jpg'),
('Vu Thi Q', 'vuthiq@example.com', '0924567890', '1992-12-29', '888 Seventeenth Street, Hue', '$2y$10$yzb901', 'Accountant', 'avatar17.jpg'),
('Nguyen Van R', 'nguyenvanr@example.com', '0935678901', '1988-07-11', '999 Eighteenth Street, Da Lat', '$2y$10$cde234', 'Sales', 'avatar18.jpg'),
('Tran Thi S', 'tranthis@example.com', '0946789012', '1993-05-23', '101 Ninth Street, Vung Tau', '$2y$10$fgh567', 'Manager', 'avatar19.jpg'),
('Le Van T', 'levant@example.com', '0957890123', '1989-09-03', '102 Twentieth Street, Phan Thiet', '$2y$10$ijk890', 'Sales', 'avatar20.jpg'),
('Pham Thi U', 'phamthiu@example.com', '0968901234', '1991-01-27', '103 Twenty-first Street, Bien Hoa', '$2y$10$lmn123', 'Accountant', 'avatar21.jpg'),
('Hoang Van V', 'hoangvanv@example.com', '0979012345', '1987-06-16', '104 Twenty-second Street, Long An', '$2y$10$pqr456', 'Sales', 'avatar22.jpg'),
('Vu Thi W', 'vuthiw@example.com', '0980123456', '1994-11-08', '105 Twenty-third Street, Tay Ninh', '$2y$10$stu789', 'Manager', 'avatar23.jpg');

-- Thêm sản phẩm quần áo vào bảng product
INSERT INTO product (name, code, price, original_price, category, subcategory, stock, status, description, image)
VALUES
('Áo Thun Nam Basic', 'CLO001', 200.00, 150.00, 'Clothing', 'T-Shirt', 120, 'active', 'Áo thun nam chất liệu cotton thoáng mát.', 'ao_thun_nam_basic.jpg'),
('Áo Sơ Mi Nữ Công Sở', 'CLO002', 350.00, 300.00, 'Clothing', 'Shirt', 80, 'active', 'Áo sơ mi nữ kiểu dáng thanh lịch, phù hợp công sở.', 'ao_so_mi_nu_cong_so.jpg'),
('Quần Jean Nam Skinny', 'CLO003', 400.00, 350.00, 'Clothing', 'Jeans', 60, 'active', 'Quần jean nam skinny co giãn, trẻ trung.', 'quan_jean_nam_skinny.jpg'),
('Váy Đầm Dạ Hội', 'CLO004', 900.00, 800.00, 'Clothing', 'Dress', 30, 'active', 'Váy đầm dạ hội sang trọng, phù hợp dự tiệc.', 'vay_dam_da_hoi.jpg'),
('Áo Khoác Bomber Nam', 'CLO005', 600.00, 500.00, 'Clothing', 'Jacket', 45, 'active', 'Áo khoác bomber nam cá tính, giữ ấm tốt.', 'ao_khoac_bomber_nam.jpg'),
('Quần Short Nữ Thể Thao', 'CLO006', 180.00, 140.00, 'Clothing', 'Shorts', 100, 'active', 'Quần short nữ thể thao năng động.', 'quan_short_nu_the_thao.jpg'),
('Áo Hoodie Unisex', 'CLO007', 350.00, 300.00, 'Clothing', 'Hoodie', 70, 'active', 'Áo hoodie unisex trẻ trung, cá tính.', 'ao_hoodie_unisex.jpg'),
('Chân Váy Xếp Ly', 'CLO008', 250.00, 200.00, 'Clothing', 'Skirt', 55, 'active', 'Chân váy xếp ly nữ tính, dễ phối đồ.', 'chan_vay_xep_ly.jpg'),
('Áo Polo Nam', 'CLO009', 270.00, 220.00, 'Clothing', 'Polo', 90, 'active', 'Áo polo nam lịch sự, phù hợp đi làm.', 'ao_polo_nam.jpg'),
('Quần Tây Nữ Công Sở', 'CLO010', 320.00, 270.00, 'Clothing', 'Trousers', 65, 'active', 'Quần tây nữ công sở thanh lịch.', 'quan_tay_nu_cong_so.jpg'),
('Áo Khoác Gió Nữ', 'CLO011', 400.00, 350.00, 'Clothing', 'Jacket', 50, 'active', 'Áo khoác gió nữ nhẹ, chống nước.', 'ao_khoac_gio_nu.jpg'),
('Váy Maxi Hoa Nhí', 'CLO012', 420.00, 370.00, 'Clothing', 'Dress', 40, 'active', 'Váy maxi hoa nhí dịu dàng, nữ tính.', 'vay_maxi_hoa_nhi.jpg'),
('Áo Thun Trơn Unisex', 'CLO013', 160.00, 120.00, 'Clothing', 'T-Shirt', 110, 'active', 'Áo thun trơn unisex nhiều màu sắc.', 'ao_thun_tron_unisex.jpg'),
('Quần Jogger Nam', 'CLO014', 300.00, 250.00, 'Clothing', 'Jogger', 75, 'active', 'Quần jogger nam thể thao, co giãn tốt.', 'quan_jogger_nam.jpg'),
('Áo Len Nữ Dệt Kim', 'CLO015', 380.00, 330.00, 'Clothing', 'Sweater', 60, 'active', 'Áo len nữ dệt kim ấm áp, thời trang.', 'ao_len_nu_det_kim.jpg'),
('Áo Khoác Dạ Nam', 'CLO016', 800.00, 700.00, 'Clothing', 'Coat', 35, 'active', 'Áo khoác dạ nam sang trọng, giữ ấm tốt.', 'ao_khoac_da_nam.jpg'),
('Quần Legging Nữ', 'CLO017', 220.00, 180.00, 'Clothing', 'Leggings', 95, 'active', 'Quần legging nữ co giãn, thoải mái.', 'quan_legging_nu.jpg'),
('Áo Sơ Mi Nam Caro', 'CLO018', 320.00, 270.00, 'Clothing', 'Shirt', 85, 'active', 'Áo sơ mi nam caro trẻ trung, năng động.', 'ao_so_mi_nam_caro.jpg'),
('Váy Công Sở Nữ', 'CLO019', 350.00, 300.00, 'Clothing', 'Dress', 50, 'active', 'Váy công sở nữ thanh lịch, hiện đại.', 'vay_cong_so_nu.jpg'),
('Áo Khoác Jean Nữ', 'CLO020', 500.00, 450.00, 'Clothing', 'Jacket', 40, 'active', 'Áo khoác jean nữ cá tính, dễ phối đồ.', 'ao_khoac_jean_nu.jpg');



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


select *FROM admin;
SELECT * FROM employees;
SELECT * FROM customer;
SELECT * from contact_settings;