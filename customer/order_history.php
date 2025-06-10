<?php
session_start();
?>

<?php
require_once('../includes/database.php');


// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header('Location: ../login/index.php');
    exit();
}
// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user']['id'];
// Kiểm tra xem người dùng có quyền truy cập vào trang này không
if ($_SESSION['user']['role'] !== 'customer') {
    // Nếu không có quyền, chuyển hướng đến trang chính
    header('Location: ../index.php');
    exit();
}
// truy vấn dữ liệu đơn hàng từ cơ sở dữ liệu 

$sql = "SELECT o.id AS order_id, o.customer_id, o.name AS customer_name, o.address, o.phone, o.payment_method, o.notes, o.total, o.created_at, o.status,
        oi.id AS order_item_id, oi.product_id, p.name AS product_name, p.code AS product_code, p.price AS product_price, p.original_price, 
        p.category, p.subcategory, p.stock, p.status AS product_status, p.description, p.image AS product_image, 
        oi.price AS order_item_price, oi.quantity, oi.color, oi.size, oi.image AS order_item_image
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN product p ON oi.product_id = p.id
        WHERE o.customer_id = ?
        ORDER BY o.id DESC, oi.id ASC;";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

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
    <style>
        #view {
            text-decoration: none;
        }

        .status-completed {
            color: #fff;
            background: #28a745;
            /* xanh lá cây */
            border-radius: 4px;
            padding: 2px 10px;
            font-weight: bold;
        }
        a{
            text-decoration: none;
        }
    </style>
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
                    <option value="pending">Chờ xác nhận</option>
                    <option value="shipped">Đang giao hàng</option>
                    <option value="completed">Hoàn tất</option>
                    <option value="delivered">Đã giao</option>
                    <option value="processing">Đang xử lý</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>

            <input type="text" class="search-boxs"
                placeholder="Tìm kiếm đơn hàng...">
        </div>

        <div class="order-list">

            <?php
            // Gom các sản phẩm theo từng đơn hàng
            $orderGroups = [];
            foreach ($orders as $row) {
                $oid = $row['order_id'];
                if (!isset($orderGroups[$oid])) {
                    $orderGroups[$oid] = [
                        'order_id' => $oid,
                        'customer_name' => $row['customer_name'],
                        'address' => $row['address'],
                        'phone' => $row['phone'],
                        'payment_method' => $row['payment_method'],
                        'notes' => $row['notes'],
                        'total' => $row['total'],
                        'created_at' => $row['created_at'],
                        'status' => $row['status'],
                        'items' => []
                    ];
                }
                if ($row['order_item_id']) {
                    $orderGroups[$oid]['items'][] = [
                        'product_name' => $row['product_name'],
                        'product_code' => $row['product_code'],
                        'product_price' => $row['order_item_price'],
                        'quantity' => $row['quantity'],
                        'color' => $row['color'],
                        'size' => $row['size'],
                        'image' => $row['order_item_image'] ?: $row['product_image']
                    ];
                }
            }

            // Hàm định dạng tiền tệ
            function format_currency($number)
            {
                return number_format($number, 0, ',', '.') . 'đ';
            }

            // Hàm định dạng ngày
            function format_date($datetime)
            {
                return date('d/m/Y', strtotime($datetime));
            }

            // Hàm chuyển trạng thái sang tiếng Việt và class
            function get_status_label($status)
            {
                switch ($status) {
                    case 'pending':
                        return ['Chờ xác nhận', 'status-pending'];
                    case 'delivered':
                        return ['Đã giao hàng', 'status-delivered'];
                    case 'processing':
                        return ['Đang sử lý', 'status-processing'];
                    case 'shipped':
                        return ['Đang giao hàng', 'status-shipping'];
                    case 'completed':
                        return ['Hoàn tất', 'status-completed'];
                    case 'cancelled':
                        return ['Đã hủy', 'status-cancelled'];


                    default:
                        return [$status, ''];
                }
            }

            // Hiển thị từng đơn hàng
            foreach ($orderGroups as $order) {
                list($statusText, $statusClass) = get_status_label($order['status']);
                echo '<div class="order-card">';
                echo '<div class="order-header">';
                echo '<div>';
                echo '<span class="order-id">Đơn hàng #DH' . htmlspecialchars($order['order_id']) . '</span>';
                echo '<span class="order-date"> - ' . format_date($order['created_at']) . '</span>';
                echo '</div>';
                echo '<span class="order-status ' . $statusClass . '">' . $statusText . '</span>';
                echo '</div>';

                echo '<div class="order-details">';
                echo '<div class="order-products">';
                foreach ($order['items'] as $item) {
                    echo '<div class="product-item">';
                    $img = $item['image'] ? htmlspecialchars($item['image']) : '../assets/image/no-image.png';
                    echo '<img src="' . $img . '" alt="' . htmlspecialchars($item['product_name']) . '" class="product-image">';
                    echo '<div class="product-info">';
                    echo '<div class="product-name">' . htmlspecialchars($item['product_name']) . '</div>';
                    echo '<div class="product-price">' . format_currency($item['product_price']) . '</div>';
                    echo '<div class="product-quantity">Số lượng: ' . htmlspecialchars($item['quantity']) . '</div>';
                    if ($item['color']) echo '<div class="product-color">Màu: ' . htmlspecialchars($item['color']) . '</div>';
                    if ($item['size']) echo '<div class="product-size">Size: ' . htmlspecialchars($item['size']) . '</div>';
                    echo '</div></div>';
                }
                echo '</div>';

                // Tạm tính là tổng giá sản phẩm
                $subtotal = 0;
                foreach ($order['items'] as $item) {
                    $subtotal += $item['product_price'] * $item['quantity'];
                }
                // Giả sử phí vận chuyển và giảm giá là 0 (có thể sửa lại nếu có cột riêng)
                $shipping = 0;
                $discount = 0;
                echo '<div class="order-summary">';
                echo '<div class="summary-row"><span class="summary-label">Tạm tính:</span><span class="summary-value">' . format_currency($subtotal) . '</span></div>';
                echo '<div class="summary-row"><span class="summary-label">Phí vận chuyển:</span><span class="summary-value">' . format_currency($shipping) . '</span></div>';
                echo '<div class="summary-row"><span class="summary-label">Giảm giá:</span><span class="summary-value">-' . format_currency($discount) . '</span></div>';
                echo '<div class="summary-row total-row"><span class="summary-label">Tổng cộng:</span><span class="summary-value">' . format_currency($order['total']) . '</span></div>';
                echo '</div>'; // order-summary
                echo '</div>'; // order-details

                // Nút thao tác
                echo '<div class="order-actions">';
                if ($order['status'] === 'completed') {
                    echo '<a href="reorder.php?order_id=' . htmlspecialchars($order['order_id']) . '" class="action-btn reorder-btn" style="text-d">Mua lại</a>';
                    echo '<button class="action-btn review-btn">Đánh giá</button>';
                    echo '<a href="order_detail.php?order_id=' . htmlspecialchars($order['order_id']) . '" class="action-btn view-detail-btn" id = "view">Xem chi tiết</a>';
                } elseif ($order['status'] === 'processing') {
                    echo '<a href="order_detail.php?order_id=' . htmlspecialchars($order['order_id']) . '" class="action-btn view-detail-btn">Theo dõi đơn hàng</a>';
                } elseif ($order['status'] === 'cancelled') {
                    echo '<a href="reorder.php?order_id=' . htmlspecialchars($order['order_id']) . '" class="action-btn reorder-btn">Mua lại</a>';
                }
                echo '</div>'; // order-actions

                echo '</div>'; // order-card
            }
            ?>
        </div>
    </div>
    <script>
        // Xử lý tìm kiếm theo trạng thái, thời gian và ô tìm kiếm
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('status-filter');
            const timeFilter = document.getElementById('time-filter');
            const searchBox = document.querySelector('.search-boxs');
            const orderCards = document.querySelectorAll('.order-card');

            function filterOrders() {
                const status = statusFilter.value;
                const time = timeFilter.value;
                const search = searchBox.value.trim().toLowerCase();

                orderCards.forEach(card => {
                    let show = true;

                    // Lọc theo trạng thái
                    if (status !== 'all') {
                        const statusSpan = card.querySelector('.order-status');
                        if (!statusSpan || !statusSpan.classList.contains('status-' + status)) {
                            show = false;
                        }
                    }

                    // Lọc theo thời gian
                    if (show && time !== 'all') {
                        const dateSpan = card.querySelector('.order-date');
                        if (dateSpan) {
                            const dateText = dateSpan.textContent.replace(/[^0-9\/]/g, '').trim();
                            const [day, month, year] = dateText.split('/').map(Number);
                            const orderDate = new Date(year, month - 1, day);
                            const now = new Date();

                            if (time === '30days') {
                                const diff = (now - orderDate) / (1000 * 60 * 60 * 24);
                                if (diff > 30) show = false;
                            } else if (time === '3months') {
                                const diff = (now - orderDate) / (1000 * 60 * 60 * 24);
                                if (diff > 90) show = false;
                            } else if (time === '2023') {
                                if (orderDate.getFullYear() !== 2023) show = false;
                            }
                        }
                    }

                    // Lọc theo ô tìm kiếm (tìm theo mã đơn hàng hoặc tên sản phẩm)
                    if (show && search) {
                        const orderId = card.querySelector('.order-id')?.textContent.toLowerCase() || '';
                        const productNames = Array.from(card.querySelectorAll('.product-name')).map(e => e.textContent.toLowerCase()).join(' ');
                        if (!orderId.includes(search) && !productNames.includes(search)) {
                            show = false;
                        }
                    }

                    card.style.display = show ? '' : 'none';
                });
            }

            statusFilter.addEventListener('change', filterOrders);
            timeFilter.addEventListener('change', filterOrders);
            searchBox.addEventListener('input', filterOrders);
        });
    </script>
</body>

</html>