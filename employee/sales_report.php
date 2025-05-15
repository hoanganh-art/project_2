<?php session_start();?>
<?php
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
    <title>Báo Cáo Doanh Số | SOÁI PHONG</title>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/sales_report.css">
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <style>

    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>SOÁI<span> PHONG</span></h2>
            <p style="color: var(--gray); font-size: 12px;">Báo cáo doanh số</p>
        </div>

        <nav class="nav-menu">
            <div class="nav-item">
                <a href="dashboard.php">
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
                <a href="sales_report.php" class="active">
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
            <h1>Báo Cáo Doanh Số Bán Hàng</h1>
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

        <!-- Report Filters -->
        <div class="report-filters">
            <div class="filter-group">
                <label>Thời gian</label>
                <select>
                    <option value="today">Hôm nay</option>
                    <option value="week">Tuần này</option>
                    <option value="month" selected>Tháng này</option>
                    <option value="quarter">Quý này</option>
                    <option value="year">Năm nay</option>
                    <option value="custom">Tùy chọn</option>
                </select>
            </div>

            <div class="filter-group" id="custom-date-range" style="display: none;">
                <label>Khoảng thời gian</label>
                <div style="display: flex; gap: 10px;">
                    <input type="date" style="flex: 1;">
                    <span style="display: flex; align-items: center;">đến</span>
                    <input type="date" style="flex: 1;">
                </div>
            </div>

            <div class="filter-group">
                <label>Danh mục</label>
                <select>
                    <option value="">Tất cả</option>
                    <option value="ao">Áo</option>
                    <option value="quan">Quần</option>
                    <option value="phukien">Phụ kiện</option>
                </select>
            </div>

            <div class="filter-actions">
                <button class="btn btn-secondary">
                    <i class="fas fa-sync-alt"></i> Làm mới
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-filter"></i> Áp dụng
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <h3>Tổng doanh thu</h3>
                <p>85.450.000đ</p>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> 12% so với tháng trước
                </div>
            </div>
            <div class="summary-card">
                <h3>Tổng đơn hàng</h3>
                <p>142</p>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> 8% so với tháng trước
                </div>
            </div>
            <div class="summary-card">
                <h3>Giá trị đơn trung bình</h3>
                <p>601.760đ</p>
                <div class="change positive">
                    <i class="fas fa-arrow-up"></i> 4% so với tháng trước
                </div>
            </div>
            <div class="summary-card">
                <h3>Sản phẩm bán ra</h3>
                <p>287</p>
                <div class="change negative">
                    <i class="fas fa-arrow-down"></i> 5% so với tháng trước
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <h2>Doanh thu theo ngày</h2>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h2>Doanh thu theo danh mục</h2>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products Table -->
        <div class="top-products">
            <h2>Top 10 sản phẩm bán chạy</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Đã bán</th>
                            <th>Doanh thu</th>
                            <th>Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="product-info">
                                    <img src="https://via.placeholder.com/40" alt="Áo Hoodie" class="product-image">
                                    <span>Áo Hoodie Streetwear</span>
                                </div>
                            </td>
                            <td>Áo</td>
                            <td>45</td>
                            <td>20.250.000đ</td>
                            <td>23.7%</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="product-info">
                                    <img src="https://via.placeholder.com/40" alt="Quần Jeans" class="product-image">
                                    <span>Quần Jeans Rách</span>
                                </div>
                            </td>
                            <td>Quần</td>
                            <td>32</td>
                            <td>19.840.000đ</td>
                            <td>23.2%</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <div class="product-info">
                                    <img src="https://via.placeholder.com/40" alt="Áo Thun" class="product-image">
                                    <span>Áo Thun Oversize</span>
                                </div>
                            </td>
                            <td>Áo</td>
                            <td>38</td>
                            <td>12.160.000đ</td>
                            <td>14.2%</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>
                                <div class="product-info">
                                    <img src="https://via.placeholder.com/40" alt="Nón Snapback" class="product-image">
                                    <span>Nón Snapback</span>
                                </div>
                            </td>
                            <td>Phụ kiện</td>
                            <td>28</td>
                            <td>7.840.000đ</td>
                            <td>9.2%</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>
                                <div class="product-info">
                                    <img src="https://via.placeholder.com/40" alt="Túi Đeo" class="product-image">
                                    <span>Túi Đeo Chéo</span>
                                </div>
                            </td>
                            <td>Phụ kiện</td>
                            <td>25</td>
                            <td>9.500.000đ</td>
                            <td>11.1%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Toggle custom date range
        document.querySelector('select').addEventListener('change', function() {
            const customDateRange = document.getElementById('custom-date-range');
            if (this.value === 'custom') {
                customDateRange.style.display = 'block';
            } else {
                customDateRange.style.display = 'none';
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['1', '5', '10', '15', '20', '25', '30'],
                datasets: [{
                    label: 'Doanh thu (triệu đồng)',
                    data: [1.3, 2.8, 1.5, 3.2, 2.5, 3.8, 4.2],
                    backgroundColor: 'rgba(255, 0, 0, 0.1)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Áo', 'Quần', 'Phụ kiện'],
                datasets: [{
                    data: [45, 30, 25],
                    backgroundColor: [
                        'rgba(255, 0, 0, 0.7)',
                        'rgba(0, 0, 0, 0.7)',
                        'rgba(255, 244, 79, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 0, 0, 1)',
                        'rgba(0, 0, 0, 1)',
                        'rgba(255, 244, 79, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    </script>
</body>

</html>