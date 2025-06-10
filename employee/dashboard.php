<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Khởi động session nếu chưa được khởi động
}
if (!isset($_SESSION['user'])) {
    header('Location: ../login/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhân Viên | SOÁI PHONG</title>
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>SOÁI<span> PHONG</span></h2>
            <p style="color: var(--gray); font-size: 12px;">Nhân viên cửa hàng</p>
        </div>

        <nav class="nav-menu">
            <div class="nav-item">
                <a href="dashboard.php" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tổng quan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="manage_orders.php">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="inventory.php">
                    <i class="fas fa-boxes"></i>
                    <span>Kho hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="cusromer_support.php">
                    <i class="fas fa-headset"></i>
                    <span>Hỗ trợ khách hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="sales_report.php">
                    <i class="fas fa-chart-line"></i>
                    <span>Báo cáo bán hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="account.php">
                    <i class="fas fa-user-cog"></i>
                    <span>Tài khoản</span>
                </a>
            </div>
            <div class="nav-item" style="margin-top: 30px;">
                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Khởi động session nếu chưa được khởi động
                }
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
        <div class="header">
            <h1>Xin chào, Nhân viên!</h1>
            <div class="user-profile">
            <?php
                $avatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'https://randomuser.me/api/portraits/men/32.jpg';
                // Kiểm tra nếu avatar đã là URL đầy đủ
                ?>
                <img src="<?php echo $avatar; ?>" alt="Avatar" class="account-avatar">
                <?php
                $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Tên của bạn';
                ?>
                <span>Nhân viên: <?php echo htmlspecialchars($name); ?></span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Đơn hàng hôm nay</h3>
                <p>24</p>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="stat-card">
                <h3>Doanh thu hôm nay</h3>
                <p>12.450.000đ</p>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            <div class="stat-card">
                <h3>Sản phẩm sắp hết</h3>
                <p>5</p>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
            </div>
            <div class="stat-card">
                <h3>Yêu cầu hỗ trợ</h3>
                <p>3</p>
                <div class="icon">
                    <i class="fas fa-question-circle"></i>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h2>Đơn hàng gần đây</h2>
                <a href="#">Xem tất cả</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#SW20230001</td>
                        <td>Trần Văn B</td>
                        <td>10/05/2023</td>
                        <td>1.250.000đ</td>
                        <td><span class="status completed">Hoàn thành</span></td>
                        <td><a href="#" style="color: var(--red);">Chi tiết</a></td>
                    </tr>
                    <tr>
                        <td>#SW20230002</td>
                        <td>Lê Thị C</td>
                        <td>10/05/2023</td>
                        <td>2.450.000đ</td>
                        <td><span class="status processing">Đang xử lý</span></td>
                        <td><a href="#" style="color: var(--red);">Chi tiết</a></td>
                    </tr>
                    <tr>
                        <td>#SW20230003</td>
                        <td>Phạm Văn D</td>
                        <td>09/05/2023</td>
                        <td>1.890.000đ</td>
                        <td><span class="status pending">Chờ xác nhận</span></td>
                        <td><a href="#" style="color: var(--red);">Chi tiết</a></td>
                    </tr>
                    <tr>
                        <td>#SW20230004</td>
                        <td>Nguyễn Thị E</td>
                        <td>09/05/2023</td>
                        <td>3.200.000đ</td>
                        <td><span class="status processing">Đang giao</span></td>
                        <td><a href="#" style="color: var(--red);">Chi tiết</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Low Stock Products -->
        <div class="card">
            <div class="card-header">
                <h2>Sản phẩm sắp hết hàng</h2>
                <a href="#">Xem tất cả</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Mã SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Số lượng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#SWP001</td>
                        <td>Áo Hoodie Streetwear</td>
                        <td>Áo</td>
                        <td>2</td>
                        <td><a href="#" style="color: var(--red);">Nhập hàng</a></td>
                    </tr>
                    <tr>
                        <td>#SWP005</td>
                        <td>Quần Jeans Rách</td>
                        <td>Quần</td>
                        <td>3</td>
                        <td><a href="#" style="color: var(--red);">Nhập hàng</a></td>
                    </tr>
                    <tr>
                        <td>#SWP012</td>
                        <td>Nón Snapback</td>
                        <td>Phụ kiện</td>
                        <td>1</td>
                        <td><a href="#" style="color: var(--red);">Nhập hàng</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>