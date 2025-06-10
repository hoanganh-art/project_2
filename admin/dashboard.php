<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}
require_once('../admin/header/admin-header.php');
?>
<?php
require_once('../includes/database.php');
$revenueData = [];
$sql = "SELECT DATE(created_at) as date, SUM(total) as revenue 
        FROM orders 
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
        GROUP BY DATE(created_at)
        ORDER BY date ASC";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $revenueData[] = [
        'date' => $row['date'],
        'revenue' => (int)$row['revenue']
    ];
}
?>
<?php
require_once('../includes/database.php');
$topProducts = [];
$sql = "SELECT p.subcategory AS name, SUM(oi.quantity) AS sold
        FROM order_items oi
        JOIN product p ON oi.product_id = p.id
        WHERE p.subcategory IN ('thun', 'Hoodie', 'jeans')
        GROUP BY p.subcategory
        ORDER BY sold DESC
        LIMIT 3";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $topProducts[] = [
        'name' => $row['name'],
        'sold' => (int)$row['sold']
    ];
}
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
                    <?php
                    // Kết nối CSDL
                    require_once('../includes/database.php'); // Đảm bảo file này trả về biến $conn

                    // Đếm tổng số đơn hàng
                    $totalOrders = 0;
                    $sql = "SELECT COUNT(*) AS total FROM `orders`";
                    $result = mysqli_query($conn, $sql);
                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $totalOrders = $row['total'];
                    }
                    ?>
                    <div class="stat-value"><?php echo number_format($totalOrders); ?></div>
                </div>

                <div class="stat-card total-revenue">
                    <div class="stat-title">Tổng doanh thu</div>
                    <?php
                    // Tính tổng doanh thu từ bảng orders (giả sử cột tổng tiền là 'total_amount')
                    $totalRevenue = 0;
                    $sql2 = "SELECT SUM(total) AS revenue FROM `orders`";
                    $result = mysqli_query($conn, $sql2);
                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $totalRevenue = $row['revenue'] ?? 0;
                    }
                    ?>
                    <div class="stat-value"><?php echo number_format($totalRevenue); ?>đ</div>
                </div>

                <div class="stat-card new-customers">
                    <div class="stat-title">Khách hàng đặt hàng</div>
                    <?php
                    // Đếm số lượng tài khoản khách hàng (giả sử bảng users, role là 'customer')
                    $totalCustomers = 0;
                    $sql = "SELECT COUNT(DISTINCT customer_id) AS total_customers FROM orders;";
                    $result = mysqli_query($conn, $sql);
                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $totalCustomers = $row['total_customers'];
                    }
                    ?>
                    <div class="stat-value"><?php echo number_format($totalCustomers); ?></div>

                </div>

                <div class="stat-card products">
                    <div class="stat-title">Sản phẩm bán được</div>
                    <?php
                    // Đếm tổng số sản phẩm đã bán (giả sử bảng order_items có cột quantity)
                    $totalProductsSold = 0;
                    $sql = "SELECT COUNT(*) AS total_products_sold FROM order_items WHERE product_id IS NOT NULL;";
                    $result = mysqli_query($conn, $sql);
                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $totalProductsSold = $row['total_products_sold'] ?? 0;
                    }
                    ?>
                    <div class="stat-value"><?php echo number_format($totalProductsSold); ?></div>
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
                        <?php
                        // Hàm hỗ trợ hiển thị trạng thái
                        function getStatusBadgeClass($status)
                        {
                            $classes = [
                                'pending' => 'bg-warning',
                                'processing' => 'bg-info',
                                'shipped' => 'bg-primary',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                'delivered' => 'bg-secondary'
                            ];
                            return $classes[$status] ?? 'bg-secondary';
                        }

                        function getStatusText($status)
                        {
                            $texts = [
                                'pending' => 'Chờ xác nhận',
                                'processing' => 'Đang xử lý',
                                'shipped' => 'Đang giao',
                                'completed' => 'Hoàn thành',
                                'cancelled' => 'Đã hủy',
                                'delivered' => 'Đã giao hàng'
                            ];
                            return $texts[$status] ?? $status;
                        }
                        ?>
                        <?php
                        // Lấy 5 đơn hàng gần đây nhất
                        $recentOrders = [];
                        $sql = "SELECT o.id AS order_id, o.customer_id, o.name AS customer_name, o.address, o.phone, o.payment_method, o.notes, o.total, o.created_at, o.status
                                FROM orders o
                                ORDER BY o.id DESC
                                LIMIT 5";
                        $result = mysqli_query($conn, $sql);
                        $recentOrders = [];
                        while ($row = mysqli_fetch_assoc($result)) {
                            $recentOrders[] = [
                                'id' => $row['order_id'],
                                'customer_name' => $row['customer_name'],
                                'created_at' => date('d/m/Y', strtotime($row['created_at'])),
                                'total' => number_format($row['total'], 0, ',', '.') . 'đ',
                                'status' => $row['status']
                            ];
                        }
                        foreach ($recentOrders as $order) {
                            echo "<tr>
                                    <td>#DH{$order['id']}</td>
                                    <td>{$order['customer_name']}</td>
                                    <td>{$order['created_at']}</td>
                                    <td>{$order['total']}</td>
                                    <td><span class='order-status status-{$order['status']}'>" . getStatusText($order['status']) . "</span></td>
                                    <td><a href='#' style='color: #FF0000;'>Xem</a></td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="manege_oder.php" class="view-all">Xem tất cả đơn hàng →</a>
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


        //tạo bản đồ doanh thu và sản phẩm bán trong 7 ngay gần đây
        /**
         * Dữ liệu mẫu doanh thu 7 ngày gần đây (có thể lấy từ PHP truyền qua JS nếu cần)
         * Ở đây giả lập số liệu.
         */
        const revenueData = <?php echo json_encode($revenueData); ?>;

        // Vẽ biểu đồ đơn giản bằng canvas
        const chartDiv = document.getElementById('revenue-chart');
        const canvas = document.createElement('canvas');
        canvas.width = chartDiv.offsetWidth;
        canvas.height = chartDiv.offsetHeight;
        chartDiv.innerHTML = '';
        chartDiv.appendChild(canvas);

        const ctx = canvas.getContext('2d');

        // Tính toán max doanh thu để scale
        const maxRevenue = Math.max(...revenueData.map(d => d.revenue));
        const padding = 40;
        const chartHeight = canvas.height - padding * 2;
        const chartWidth = canvas.width - padding * 2;
        const barWidth = chartWidth / revenueData.length * 0.6;
        const barGap = chartWidth / revenueData.length * 0.4;

        // Vẽ trục Y
        ctx.beginPath();
        ctx.moveTo(padding, padding);
        ctx.lineTo(padding, canvas.height - padding);
        ctx.strokeStyle = '#888';
        ctx.stroke();

        // Vẽ trục X
        ctx.beginPath();
        ctx.moveTo(padding, canvas.height - padding);
        ctx.lineTo(canvas.width - padding, canvas.height - padding);
        ctx.stroke();

        // Vẽ các cột doanh thu
        revenueData.forEach((item, i) => {
            const x = padding + i * (barWidth + barGap) + barGap / 2;
            const barHeight = (item.revenue / maxRevenue) * chartHeight;
            const y = canvas.height - padding - barHeight;

            // Vẽ cột
            ctx.fillStyle = '#4e73df';
            ctx.fillRect(x, y, barWidth, barHeight);

            // Vẽ giá trị doanh thu trên đầu cột
            ctx.fillStyle = '#222';
            ctx.font = '12px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(item.revenue.toLocaleString('vi-VN'), x + barWidth / 2, y - 5);

            // Vẽ ngày bên dưới cột
            ctx.fillStyle = '#555';
            ctx.font = '11px Arial';
            ctx.fillText(item.date.slice(5), x + barWidth / 2, canvas.height - padding + 15);
        });

        //loại sản phẩm bán chạy

        const productsData = <?php echo json_encode($topProducts); ?>;

        const productsChartDiv = document.getElementById('products-chart');
        const productsCanvas = document.createElement('canvas');
        productsCanvas.width = productsChartDiv.offsetWidth;
        productsCanvas.height = productsChartDiv.offsetHeight;
        productsChartDiv.innerHTML = '';
        productsChartDiv.appendChild(productsCanvas);
        const productsCtx = productsCanvas.getContext('2d');
        const productsMax = Math.max(...productsData.map(d => d.sold));
        const productsPadding = 40;
        const productsChartHeight = productsCanvas.height - productsPadding * 2;
        const productsChartWidth = productsCanvas.width - productsPadding * 2;
        const productsBarWidth = productsChartWidth / productsData.length * 0.6;
        const productsBarGap = productsChartWidth / productsData.length * 0.4;
        // Vẽ trục Y
        productsCtx.beginPath();
        productsCtx.moveTo(productsPadding, productsPadding);
        productsCtx.lineTo(productsPadding, productsCanvas.height - productsPadding);
        productsCtx.strokeStyle = '#888';
        productsCtx.stroke();
        // Vẽ trục X
        productsCtx.beginPath();
        productsCtx.moveTo(productsPadding, productsCanvas.height - productsPadding);
        productsCtx.lineTo(productsCanvas.width - productsPadding, productsCanvas.height - productsPadding);
        productsCtx.stroke();
        // Vẽ các cột sản phẩm
        productsData.forEach((item, i) => {
            const x = productsPadding + i * (productsBarWidth + productsBarGap) + productsBarGap / 2;
            const barHeight = (item.sold / productsMax) * productsChartHeight;
            const y = productsCanvas.height - productsPadding - barHeight;

            // Vẽ cột
            productsCtx.fillStyle = '#1cc88a';
            productsCtx.fillRect(x, y, productsBarWidth, barHeight);

            // Vẽ số lượng bán trên đầu cột
            productsCtx.fillStyle = '#222';
            productsCtx.font = '12px Arial';
            productsCtx.textAlign = 'center';
            productsCtx.fillText(item.sold.toLocaleString('vi-VN'), x + productsBarWidth / 2, y - 5);

            // Vẽ tên sản phẩm bên dưới cột
            productsCtx.fillStyle = '#555';
            productsCtx.font = '11px Arial';
            productsCtx.fillText(item.name, x + productsBarWidth / 2, productsCanvas.height - productsPadding + 15);
        });
    </script>
</body>

</html>
<?php
require_once('../admin/footer/admin-footer.php');
?>