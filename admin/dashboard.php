<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}
require_once('../admin/header/admin-header.php');
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang tổng quan - Admin Clothing Store</title>
    <link rel="stylesheet" href="../assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>


    <div class="admin-container">
        <?php require_once('../admin/sidebar/admin_sidebar.php'); ?>

        <div class="admin-content">
            <h1 class="page-title">
                <span>Tổng quan hệ thống</span>
                <span id="current-date"></span>
            </h1>

            <div class="stats-cards">
                <div class="stat-card total-orders">
                    <div class="stat-title">Tổng đơn hàng</div>
                    <div class="stat-value">1,248</div>
                    <div class="stat-change">+12% so với tháng trước</div>
                </div>

                <div class="stat-card total-revenue">
                    <div class="stat-title">Tổng doanh thu</div>
                    <div class="stat-value">325,450,000đ</div>
                    <div class="stat-change">+8.5% so với tháng trước</div>
                </div>

                <div class="stat-card new-customers">
                    <div class="stat-title">Khách hàng mới</div>
                    <div class="stat-value">84</div>
                    <div class="stat-change">+5.2% so với tháng trước</div>
                </div>

                <div class="stat-card products">
                    <div class="stat-title">Sản phẩm</div>
                    <div class="stat-value">156</div>
                    <div class="stat-change negative">-3% so với tháng trước</div>
                </div>
            </div>

            <div class="charts-row">
                <div class="chart-container">
                    <h3 class="chart-title">Doanh thu 7 ngày gần đây</h3>
                    <div id="revenue-chart" style="height: 300px;">
                        <!-- Biểu đồ sẽ được chèn bằng JavaScript -->
                        <img src="https://via.placeholder.com/800x300?text=Biểu+đồ+doanh+thu" alt="Biểu đồ doanh thu" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                    </div>
                </div>

                <div class="chart-container">
                    <h3 class="chart-title">Loại sản phẩm bán chạy</h3>
                    <div id="products-chart" style="height: 300px;">
                        <!-- Biểu đồ sẽ được chèn bằng JavaScript -->
                        <img src="https://via.placeholder.com/400x300?text=Biểu+đồ+sản+phẩm" alt="Biểu đồ sản phẩm" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                    </div>
                </div>
            </div>

            <div class="recent-orders">
                <h3 class="chart-title">Đơn hàng gần đây</h3>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#DH20230098</td>
                            <td>Nguyễn Thị B</td>
                            <td>15/10/2023</td>
                            <td>1,250,000đ</td>
                            <td><span class="order-status status-completed">Đã giao</span></td>
                            <td><a href="#" style="color: #FF0000;">Xem</a></td>
                        </tr>
                        <tr>
                            <td>#DH20230097</td>
                            <td>Trần Văn C</td>
                            <td>15/10/2023</td>
                            <td>2,450,000đ</td>
                            <td><span class="order-status status-processing">Đang giao</span></td>
                            <td><a href="#" style="color: #FF0000;">Xem</a></td>
                        </tr>
                        <tr>
                            <td>#DH20230096</td>
                            <td>Lê Thị D</td>
                            <td>14/10/2023</td>
                            <td>850,000đ</td>
                            <td><span class="order-status status-pending">Chờ xử lý</span></td>
                            <td><a href="#" style="color: #FF0000;">Xem</a></td>
                        </tr>
                        <tr>
                            <td>#DH20230095</td>
                            <td>Phạm Văn E</td>
                            <td>14/10/2023</td>
                            <td>1,750,000đ</td>
                            <td><span class="order-status status-completed">Đã giao</span></td>
                            <td><a href="#" style="color: #FF0000;">Xem</a></td>
                        </tr>
                        <tr>
                            <td>#DH20230094</td>
                            <td>Hoàng Thị F</td>
                            <td>13/10/2023</td>
                            <td>3,200,000đ</td>
                            <td><span class="order-status status-cancelled">Đã hủy</span></td>
                            <td><a href="#" style="color: #FF0000;">Xem</a></td>
                        </tr>
                    </tbody>
                </table>
                <a href="#" class="view-all">Xem tất cả đơn hàng →</a>
            </div>
        </div>
    </div>

    <script>
        // Hiển thị ngày hiện tại
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('current-date').textContent = now.toLocaleDateString('vi-VN', options);

        // Giả lập dữ liệu biểu đồ (trong thực tế sẽ dùng Chart.js hoặc thư viện khác)
        console.log('Khởi tạo biểu đồ...');

        // Xử lý responsive cho sidebar
        function handleSidebar() {
            const sidebar = document.querySelector('.admin-sidebar');
            if (window.innerWidth < 768) {
                sidebar.style.display = 'none';
                // Thêm nút toggle sidebar cho mobile
            } else {
                sidebar.style.display = 'block';
            }
        }

        window.addEventListener('resize', handleSidebar);
        handleSidebar();
    </script>
</body>

</html>
<?php
require_once('../admin/footer/admin-footer.php');
?>