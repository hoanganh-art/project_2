📦male-fashion-store
├── 📂assets
│   ├── 📂css                   # File CSS ✅
│   ├── 📂js                    # File JavaScript ✅
│   └── 📂images                # Hình ảnh 
│
├── 📂admin                     # Khu vực quản trị
│   ├── 📜dashboard.php         # Trang tổng quan ✅
│   ├── 📂products
│   │   └── 📜edit.php          # Sửa sản phẩm ❌
│   │   ├── 📜add.php           # Thêm sản phẩm ❌
│   │   └── 📜edit.php          # Sửa sản phẩm ❌
│   ├── 📂orders
│   │   ├── 📜list.php          # Quản lý đơn hàng ❌
│   │   └── 📜detail.php        # Chi tiết đơn hàng ✅
│   ├── 📂staff
│   │   ├── 📜list.php                   # Quản lý nhân viên ✅
│   │            ├── 📜 delete.php       # Xóa nhân viên
│   │            └── 📜add.php           # Thêm nhân viên ✅
│   │
│   ├── 📂customers
│   │   ├── 📜list.php                   # Quản lý tài khoản khách hàng ✅
│   │             └── 📜 lock.php        # Khóa tài khoản khách hàng
│   └── 📜logout.php                     # Đăng xuất ✅
│
│
├── 📂includes                  # File chung
│   ├── 📜config.php            # Kết nối database ✅ 
│   ├── 📜header.php            # Header chung ✅
│   └── 📜footer.php            # Footer chung ✅
│
├── 📂user                      # Khu vực khách hàng
│   ├── 📜login.php             # Đăng nhập ✅
│   ├── 📜register.php          # Đăng ký  ✅
│   ├── 📜profile.php           # Hồ sơ cá nhân ✅
│   └── 📜order_history.php     # Lịch sử mua hàng ✅
│
├── 📂class                     # Các class PHP
│   ├── 📜Database.php          # Class kết nối DB ✅
│   ├── 📜Product.php           # Class sản phẩm  ❌
│   ├── 📜Order.php             # Class đơn hàng ❌
│   └── 📜User.php              # Class người dùng ✅
│
├── 📂templates                 # Giao diện người dùng
│   ├── 📜home.php              # Trang chủ ✅
│   ├── 📜product_list.php      # Danh sách sản phẩm ❌
│   ├── 📜product_detail.php    # Chi tiết sản phẩm ✅
│   ├── 📜cart.php              # Giỏ hàng ✅
│   ├── 📜checkout.php          # Thanh toán ✅
│   └── 📜review.php            # Đánh giá ❌
│
├── 📜index.php                 # Trang chủx ✅
├── 📜search.php                # Tìm kiếm sản phẩm ❌ 
└── 📜.htaccess                 # Cấu hình URL ❌