<?php
session_start();
require_once('../includes/database.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: ../login/index.php');
    exit();
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if ($order_id <= 0) {
    echo "Không tìm thấy đơn hàng.";
    exit();
}

// Lấy thông tin đơn hàng
$sql = "SELECT o.*, oi.*, p.name AS product_name, p.image AS product_image
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN product p ON oi.product_id = p.id
        WHERE o.id = ? AND o.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $order_id, $_SESSION['user']['id']);
$stmt->execute();
$result = $stmt->get_result();
$order_items = $result->fetch_all(MYSQLI_ASSOC);

if (!$order_items) {
    echo "Không tìm thấy đơn hàng.";
    exit();
}

// Lấy thông tin chung đơn hàng
$order = $order_items[0];
function format_currency($number)
{
    return number_format($number, 0, ',', '.') . 'đ';
}
function format_date($datetime)
{
    return date('d/m/Y H:i', strtotime($datetime));
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #DH<?= htmlspecialchars($order_id) ?></title>
    <link rel="stylesheet" href="../assets/css/Custome/order_detail.css">
    <style>
        :root {
            --primary-color: #2d8cf0;
            --primary-hover: #1765ad;
            --text-dark: #2d3a4b;
            --text-medium: #444;
            --text-light: #666;
            --bg-light: #f6f7fb;
            --bg-white: #fff;
            --border-color: #e0e0e0;
            --table-header-bg: #e7eaf1;
            --table-row-even: #f3f5fa;
            --table-row-hover: #eaf3ff;
            --error-color: #e74c3c;
            --success-color: #27ae60;
            --border-radius: 8px;
            --box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f6f7fb;
            margin: 0;
            padding: 0;
            color: #2d3a4b;
            font-size: 16px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            -webkit-text-size-adjust: 100%;
        }

        h1 {
            color: #2d3a4b;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .order-detail-container {
            background: #fff;
            max-width: 800px;
            margin: 30px auto 0 auto;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 32px 40px 24px 40px;
        }

        .casa {
            margin-top: 16px;
            padding: 16px;
            background: rgb(161, 186, 250);
            border-radius: 8px;
        }

        .order-info p {
            margin: 8px 0;
            font-size: 16px;
            color: #444;
        }

        .product_view {
            margin-top: 16px;
            padding: 16px;
            background: rgb(161, 186, 250);
            border-radius: 8px;
        }

        h2 {
            margin-top: 32px;
            color: #2d3a4b;
            font-size: 22px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            background: #fafbfc;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px 10px;
            text-align: center;
        }

        th {
            background: #e7eaf1;
            color: #2d3a4b;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background: #f3f5fa;
        }

        tr:hover {
            background: #eaf3ff;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        .butons {
            text-align: center;
            margin-top: 24px;
            padding: 16px;
            background: rgb(161, 186, 250);
            border-radius: 8px;
        }

        h3 {
            text-align: right;
            color: #e74c3c;
            margin-top: 18px;
            margin-bottom: 0;
            font-size: 20px;
        }

        a {
            display: inline-block;
            margin-top: 24px;
            padding: 10px 24px;
            background: #2d8cf0;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }

        a:hover {
            background: #1765ad;
        }

        .order-status {
            font-weight: normal;
        }

        .order-status.status-pending {
            color: #f39c12;
            font-weight: bold;
        }

        .order-status.status-processing {
            color: #2980b9;
            font-weight: bold;
        }

        .order-status.status-shipping {
            color: #16a085;
            font-weight: bold;
        }

        .order-status.status-completed {
            color: #27ae60;
            font-weight: bold;
        }

        .order-status.status-cancelled {
            color: #e74c3c;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .order-detail-container {
                padding: 12px 4px;
            }

            table,
            th,
            td {
                font-size: 13px;
                padding: 6px 2px;
            }
        }
    </style>
</head>

<body>
    <?php
    // Chuyển đổi trạng thái sang tiếng Việt
    function get_status_vn($status)
    {
        switch ($status) {
            case 'pending':
                return 'Chờ xác nhận';
            case 'processing':
                return 'Đang xử lý';
            case 'shipped':
                return 'Đang giao ';
            case 'completed':
                return 'Hoàn thành';
            case 'cancelled':
                return 'Đã hủy';
            case 'delivered':
                return 'Đã giao hàng';
            default:
                return ucfirst($status);
        }
    }
    ?>
    <h1>Chi tiết đơn hàng #DH<?= htmlspecialchars($order_id) ?></h1>

    <div class="casa">
        <p><strong>Ngày đặt:</strong> <?= format_date($order['created_at']) ?></p>
        <p>
            <strong>Trạng thái:</strong>
            <span class="order-status <?= 'status-' . htmlspecialchars($order['status']) ?>">
                <?= htmlspecialchars(get_status_vn($order['status'])) ?>
            </span>
        </p>
        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['name']) ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
    </div>

    <div class="product_view">
        <h2>Sản phẩm</h2>
        <table border="1" cellpadding="5">
            <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Màu</th>
                <th>Size</th>
                <th>Thành tiền</th>
            </tr>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td>
                        <?php
                        $img = '';
                        if (!empty($item['order_item_image'])) {
                            $img = $item['order_item_image'];
                        } elseif (!empty($item['product_image'])) {
                            $img = $item['product_image'];
                        } else {
                            $img = '../assets/images/no-image.png';
                        }
                        ?>
                        <img src="<?= htmlspecialchars($img) ?>" width="60" alt="Ảnh sản phẩm">
                    </td>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= format_currency($item['price']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td><?= htmlspecialchars($item['color']) ?></td>
                    <td><?= htmlspecialchars($item['size']) ?></td>
                    <td><?= format_currency($item['price'] * $item['quantity']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="butons">
        <h3>Tổng cộng: <?= format_currency($order['total']) ?></h3>
        <a href="order_history.php">Quay lại lịch sử đơn hàng</a>
    </div>
</body>

</html>