<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng | SOÁI PHONG</title>
    <link rel="shortcut icon" href="../assets/image/logo.ico"
        type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/account.css">
    <link rel="stylesheet" href="../assets/css/Custome/cart.css">
    <link rel="stylesheet"
        href="../assets/css/Custome/account_customet.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>SOÁI<span> PHONG</span></h2>
        </div>
        <div class="usear">
            <div class="avata">
                <?php
                if (isset($_SESSION['user']['avatar']) && !empty($_SESSION['user']['avatar'])) {
                    echo '<img src="' . htmlspecialchars($_SESSION['user']['avatar']) . '" alt="Avatar">';
                } else {
                    echo '<img src="../assets/avatar/default-avatar.png" alt="Default Avatar">';
                }
                ?> </div>
            <div class="users">
                <?php
                if (isset($_SESSION['user']['name'])) {
                    echo '<h3>' . htmlspecialchars($_SESSION['user']['name']) . '</h3>';
                } else {
                    echo '<h3>Khách</h3>';
                }
                ?>
            </div>
        </div>
        <nav class="nav-menu">
            <div class="nav-item">
                <a href="../index.php">
                    <i class="fas fa-home"></i>
                    <span>Trang chủ</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="cart1.php" class="active">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Giỏ hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="order_history.php">
                    <i class="fas fa-boxes"></i>
                    <span>Lịch sử mua hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="account_customet.php">
                    <i class="fas fa-user-cog"></i>
                    <span>Tài khoản</span>
                </a>
            </div>
            <div class="nav-item" style="margin-top: 6px;">
                <?php
                if (isset($_SESSION['user'])) {
                    // Hiển thị nút đăng xuất
                    echo '<a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>';
                } else {
                    // Hiển thị nút đăng nhập
                    echo '<a href="../login/index.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>';
                }
                ?>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="cart-items">
            <h2 class="cart-title">GIỎ HÀNG CỦA BẠN</h2>

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Product 1 -->
                    <tr>
                        <td data-label="Sản phẩm">
                            <div class="product-cell">
                                <img src="../assets/image/ao/hoodie.png" alt="Áo Hoodie" class="product-image">
                                <div class="product-info">
                                    <h4>Áo Hoodie Streetwear Limited Edition</h4>
                                    <p>Màu: Đen | Size: M</p>
                                </div>
                            </div>
                        </td>
                        <td data-label="Giá">450.000đ</td>
                        <td data-label="Số lượng">
                            <div class="quantity-selector">
                                <button class="quantity-btn">-</button>
                                <input type="number" value="1" min="1" class="quantity-input">
                                <button class="quantity-btn">+</button>
                            </div>
                        </td>
                        <td data-label="Tổng">450.000đ</td>
                        <td>
                            <button class="remove-btn" title="Xóa sản phẩm">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Product 2 -->
                    <tr>
                        <td data-label="Sản phẩm">
                            <div class="product-cell">
                                <img src="../assets/image/quan/quan_jeans.png" alt="Quần Jeans" class="product-image">
                                <div class="product-info">
                                    <h4>Quần Jeans Rách Phong Cách Streetwear</h4>
                                    <p>Màu: Xanh | Size: L</p>
                                </div>
                            </div>
                        </td>
                        <td data-label="Giá">620.000đ</td>
                        <td data-label="Số lượng">
                            <div class="quantity-selector">
                                <button class="quantity-btn">-</button>
                                <input type="number" value="1" min="1" class="quantity-input">
                                <button class="quantity-btn">+</button>
                            </div>
                        </td>
                        <td data-label="Tổng">620.000đ</td>
                        <td>
                            <button class="remove-btn" title="Xóa sản phẩm">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Product 3 -->
                    <tr>
                        <td data-label="Sản phẩm">
                            <div class="product-cell">
                                <img src="../assets/image//mu/mon.png" alt="Nón Snapback" class="product-image">
                                <div class="product-info">
                                    <h4>Nón Snapback Logo Streetwear</h4>
                                    <p>Màu: Đen</p>
                                </div>
                            </div>
                        </td>
                        <td data-label="Giá">280.000đ</td>
                        <td data-label="Số lượng">
                            <div class="quantity-selector">
                                <button class="quantity-btn">-</button>
                                <input type="number" value="1" min="1" class="quantity-input">
                                <button class="quantity-btn">+</button>
                            </div>
                        </td>
                        <td data-label="Tổng">280.000đ</td>
                        <td>
                            <button class="remove-btn" title="Xóa sản phẩm">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="continue-shopping">
                <a href="#">
                    <i class="fas fa-arrow-left"></i>
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>

        <div class="cart-summary">
            <h2 class="summary-title">TÓM TẮT ĐƠN HÀNG</h2>

            <div class="summary-row">
                <span>Tạm tính:</span>
                <span>1.350.000đ</span>
            </div>

            <div class="summary-row">
                <span>Giảm giá:</span>
                <span>-50.000đ</span>
            </div>

            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <span>30.000đ</span>
            </div>

            <div class="summary-row summary-total">
                <span>Tổng cộng:</span>
                <span>1.330.000đ</span>
            </div>

            <button class="btn btn-primary">TIẾN HÀNH THANH TOÁN</button>
            <button class="btn btn-secondary">CẬP NHẬT GIỎ HÀNG</button>

            <div style="margin-top: 20px; font-size: 14px; color: #666; text-align: center;">
                <p>Miễn phí vận chuyển cho đơn hàng từ 500.000đ</p>
            </div>
        </div>
    </div>
</body>
<script>
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value);

            if (this.textContent === '+' || this.innerHTML.includes('+')) {
                input.value = value + 1;
            } else {
                if (value > 1) {
                    input.value = value - 1;
                }
            }

            // Update cart totals here (would need more JS logic)
        });
    });

    // Remove product from cart
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                // Update cart totals here

                // If no more items, show empty cart
                if (document.querySelectorAll('.cart-table tbody tr').length === 0) {
                    document.querySelector('.cart-items').style.display = 'none';
                    document.querySelector('.cart-summary').style.display = 'none';
                    document.querySelector('.empty-cart').style.display = 'block';
                }
            }, 300);
        });
    });

    // Update cart button
    document.querySelector('.btn-secondary').addEventListener('click', function() {
        alert('Giỏ hàng đã được cập nhật!');
        // Here you would normally send the updated quantities to your backend
    });
</script>

</html>