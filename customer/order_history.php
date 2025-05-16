<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Mua Hàng | SOÁI PHONG</title>
    <link rel="shortcut icon" href="../assets/image/logo.ico"
        type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/account.css">
    <link rel="stylesheet" href="../assets/css/Custome/order_history.css">
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
                <a href="cart1.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Giỏ hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="order_history.php" class="active">
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
        <h1 class="page-title">Lịch sử mua hàng</h1>

        <div class="order-filter">
            <div class="filter-group">
                <label for="time-filter">Thời gian:</label>
                <select id="time-filter">
                    <option value="all">Tất cả</option>
                    <option value="30days">30 ngày gần đây</option>
                    <option value="3months">3 tháng gần đây</option>
                    <option value="2023">Năm 2023</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="status-filter">Trạng thái:</label>
                <select id="status-filter">
                    <option value="all">Tất cả</option>
                    <option value="delivered">Đã giao</option>
                    <option value="processing">Đang xử lý</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>

            <input type="text" class="search-boxs"
                placeholder="Tìm kiếm đơn hàng...">
        </div>

        <div class="order-list">
            <!-- Đơn hàng 1 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Đơn hàng #DH20230001</span>
                        <span class="order-date"> - 15/10/2023</span>
                    </div>
                    <span class="order-status status-delivered">Đã giao
                        hàng</span>
                </div>

                <div class="order-details">
                    <div class="order-products">
                        <div class="product-item">
                            <img src="../assets/image/ao/hoodie.png"
                                alt="Áo thun" class="product-image">
                            <div class="product-info">
                                <div class="product-name">Áo thun nam trắng
                                    cổ tròn</div>
                                <div class="product-price">250,000đ</div>
                                <div class="product-quantity">Số lượng:
                                    1</div>
                            </div>
                        </div>

                        <div class="product-item">
                            <img src="../assets/image/quan/quan_jeans.png"
                                alt="Quần jeans" class="product-image">
                            <div class="product-info">
                                <div class="product-name">Quần jeans nam đen
                                    slim fit</div>
                                <div class="product-price">450,000đ</div>
                                <div class="product-quantity">Số lượng:
                                    1</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="summary-row">
                            <span class="summary-label">Tạm tính:</span>
                            <span class="summary-value">700,000đ</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Phí vận
                                chuyển:</span>
                            <span class="summary-value">30,000đ</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Giảm giá:</span>
                            <span class="summary-value">-50,000đ</span>
                        </div>
                        <div class="summary-row total-row">
                            <span class="summary-label">Tổng cộng:</span>
                            <span class="summary-value">680,000đ</span>
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <button class="action-btn reorder-btn">Mua lại</button>
                    <button class="action-btn review-btn">Đánh giá</button>
                    <button class="action-btn view-detail-btn">Xem chi
                        tiết</button>
                </div>
            </div>

            <!-- Đơn hàng 2 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Đơn hàng #DH20230002</span>
                        <span class="order-date"> - 05/10/2023</span>
                    </div>
                    <span class="order-status status-processing">Đang giao
                        hàng</span>
                </div>

                <div class="order-details">
                    <div class="order-products">
                        <div class="product-item">
                            <img src="https://via.placeholder.com/80"
                                alt="Áo khoác" class="product-image">
                            <div class="product-info">
                                <div class="product-name">Áo khoác nam dù
                                    đen</div>
                                <div class="product-price">550,000đ</div>
                                <div class="product-quantity">Số lượng:
                                    1</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="summary-row">
                            <span class="summary-label">Tạm tính:</span>
                            <span class="summary-value">550,000đ</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Phí vận
                                chuyển:</span>
                            <span class="summary-value">30,000đ</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Giảm giá:</span>
                            <span class="summary-value">-0đ</span>
                        </div>
                        <div class="summary-row total-row">
                            <span class="summary-label">Tổng cộng:</span>
                            <span class="summary-value">580,000đ</span>
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <button class="action-btn view-detail-btn">Theo dõi đơn
                        hàng</button>
                </div>
            </div>

            <!-- Đơn hàng 3 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Đơn hàng #DH20230003</span>
                        <span class="order-date"> - 20/09/2023</span>
                    </div>
                    <span class="order-status status-cancelled">Đã
                        hủy</span>
                </div>

                <div class="order-details">
                    <div class="order-products">
                        <div class="product-item">
                            <img src="https://via.placeholder.com/80"
                                alt="Váy" class="product-image">
                            <div class="product-info">
                                <div class="product-name">Váy liền nữ đen
                                    dáng dài</div>
                                <div class="product-price">380,000đ</div>
                                <div class="product-quantity">Số lượng:
                                    1</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="summary-row">
                            <span class="summary-label">Tạm tính:</span>
                            <span class="summary-value">380,000đ</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Phí vận
                                chuyển:</span>
                            <span class="summary-value">30,000đ</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Giảm giá:</span>
                            <span class="summary-value">-0đ</span>
                        </div>
                        <div class="summary-row total-row">
                            <span class="summary-label">Tổng cộng:</span>
                            <span class="summary-value">410,000đ</span>
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <button class="action-btn reorder-btn">Mua lại</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Hiển thị/ẩn mật khẩu
    document.getElementById('status-filter').addEventListener('change', function() {
        const status = this.value;
        const orders = document.querySelectorAll('.order-card');

        orders.forEach(order => {
            const orderStatus = order.querySelector('.order-status').classList;
            const shouldShow = status === 'all' ||
                (status === 'delivered' && orderStatus.contains('status-delivered')) ||
                (status === 'processing' && orderStatus.contains('status-processing')) ||
                (status === 'cancelled' && orderStatus.contains('status-cancelled'));

            order.style.display = shouldShow ? 'block' : 'none';
        });
    });

    // Tìm kiếm đơn hàng
    document.querySelector('.search-box').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const orders = document.querySelectorAll('.order-card');

        orders.forEach(order => {
            const orderId = order.querySelector('.order-id').textContent.toLowerCase();
            const orderVisible = orderId.includes(searchTerm);
            order.style.display = orderVisible ? 'block' : 'none';
        });
    });

    // Xử lý nút mua lại
    document.querySelectorAll('.reorder-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Các sản phẩm từ đơn hàng này đã được thêm vào giỏ hàng!');
        });
    });

    // Xử lý nút đánh giá
    document.querySelectorAll('.review-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Chuyển hướng đến trang đánh giá sản phẩm...');
        });
    });

    // Xử lý nút xem chi tiết
    document.querySelectorAll('.view-detail-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Chuyển hướng đến trang chi tiết đơn hàng...');
        });
    });
</script>

</html>