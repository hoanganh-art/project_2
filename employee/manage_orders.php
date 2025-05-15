<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng | SOÁI PHONG</title>
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/employee/manage_orders.css">
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar (giống dashboard) -->
    <div class="sidebar">
        <div class="logo">
            <h2>SOÁI<span> PHONG</span></h2>
            <p style="color: var(--gray); font-size: 12px;">Nhân viên cửa hàng</p>
        </div>

        <nav class="nav-menu">
            <div class="nav-item">
                <a href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tổng quan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="manage_orders.php" class="active">
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
                if (!isset($_SESSION['user'])) {
                    header('Location: ../login/index.php');
                    exit();
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
            <h1>Quản Lý Đơn Hàng</h1>
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

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Từ ngày</label>
                    <input type="date">
                </div>
                <div class="filter-group">
                    <label>Đến ngày</label>
                    <input type="date">
                </div>
                <div class="filter-group">
                    <label>Trạng thái</label>
                    <select>
                        <option value="">Tất cả</option>
                        <option value="pending">Chờ xác nhận</option>
                        <option value="processing">Đang xử lý</option>
                        <option value="shipped">Đang giao</option>
                        <option value="completed">Hoàn thành</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Tìm kiếm</label>
                    <input type="text" placeholder="Mã đơn, tên khách...">
                </div>
            </div>
            <div class="filter-actions">
                <button class="btn btn-primary">
                    <i class="fas fa-filter"></i> Lọc
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-sync-alt"></i> Làm mới
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </button>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>PTTT</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#SW20230015</td>
                            <td>Trần Văn B</td>
                            <td>15/05/2023</td>
                            <td>1.850.000đ</td>
                            <td>COD</td>
                            <td><span class="status pending">Chờ xác nhận</span></td>
                            <td>
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn process"><i class="fas fa-check"></i></button>
                                <button class="action-btn cancel"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SW20230014</td>
                            <td>Lê Thị C</td>
                            <td>14/05/2023</td>
                            <td>2.450.000đ</td>
                            <td>Chuyển khoản</td>
                            <td><span class="status processing">Đang xử lý</span></td>
                            <td>
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn complete"><i class="fas fa-truck"></i></button>
                                <button class="action-btn cancel"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SW20230013</td>
                            <td>Phạm Văn D</td>
                            <td>14/05/2023</td>
                            <td>3.200.000đ</td>
                            <td>Ví điện tử</td>
                            <td><span class="status shipped">Đang giao</span></td>
                            <td>
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                <button class="action-btn complete"><i class="fas fa-check-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SW20230012</td>
                            <td>Nguyễn Thị E</td>
                            <td>13/05/2023</td>
                            <td>1.250.000đ</td>
                            <td>COD</td>
                            <td><span class="status completed">Hoàn thành</span></td>
                            <td>
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SW20230011</td>
                            <td>Hoàng Văn F</td>
                            <td>12/05/2023</td>
                            <td>1.890.000đ</td>
                            <td>Chuyển khoản</td>
                            <td><span class="status cancelled">Đã hủy</span></td>
                            <td>
                                <button class="action-btn view"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="page-item"><i class="fas fa-angle-left"></i></div>
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</body>

</html>