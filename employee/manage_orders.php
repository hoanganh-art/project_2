<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Khởi động session nếu chưa được khởi động
}
if (!isset($_SESSION['user'])) {
    header('Location: ../login/index.php');
    exit();
}
?>

<?php
require_once('../includes/database.php');

$sql = "SELECT o.id AS order_id, o.customer_id, o.name AS customer_name, o.address, o.phone, o.payment_method, o.notes, o.total, o.created_at, o.status,
        oi.id AS order_item_id, oi.product_id, p.name AS product_name, p.code AS product_code, p.price AS product_price, p.original_price, 
        p.category, p.subcategory, p.stock, p.status AS product_status, p.description, p.image AS product_image, 
        oi.price AS order_item_price, oi.quantity, oi.color, oi.size, oi.image AS order_item_image
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN product p ON oi.product_id = p.id
        ORDER BY o.id DESC, oi.id ASC;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);



?>

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

    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 900px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #333;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #777;
        }

        .close-btn:hover {
            color: #333;
        }

        .order-info {
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            width: 120px;
            color: #555;
        }

        .info-value {
            flex: 1;
        }

        .order-items-table {
            margin: 20px 0;
            overflow-x: auto;
        }

        .order-items-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-items-table th,
        .order-items-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .order-items-table th {
            background-color: #f5f5f5;
        }

        .order-total {
            text-align: right;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .total-row {
            display: inline-flex;
            align-items: center;
        }

        .total-label {
            font-weight: 600;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .total-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }
    </style>
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
                    <select name="status">
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
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($order['order_item_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></td>
                                <td><?php echo number_format($order['total'], 0, ',', '.') . 'đ'; ?></td>
                                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                                <td>
                                    <?php
                                    $status = $order['status'];
                                    if ($status == 'pending') {
                                        echo '<span class="badge badge-warning">Chờ xác nhận</span>';
                                    } elseif ($status == 'processing') {
                                        echo '<span class="badge badge-info">Đang xử lý</span>';
                                    } elseif ($status == 'shipped') {
                                        echo '<span class="badge badge-primary">Đang giao</span>';
                                    } elseif ($status == 'completed') {
                                        echo '<span class="badge badge-success">Hoàn thành</span>';
                                    } elseif ($status == 'cancelled') {
                                        echo '<span class="badge badge-danger">Đã hủy</span>';
                                    }

                                    ?>
                                </td>
                                <td>
                                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                    <?php if ($status == 'pending'): ?>
                                        <button class="action-btn process" data-order-id="<?php echo $order['order_id']; ?>"><i class="fas fa-check"></i></button>
                                        <button class="action-btn cancel" data-order-id="<?php echo $order['order_id']; ?>"><i class="fas fa-times"></i></button>
                                    <?php elseif ($status == 'processing'): ?>
                                        <button class="action-btn ship" data-order-id="<?php echo $order['order_id']; ?>"><i class="fas fa-truck"></i></button>
                                        <button class="action-btn cancel" data-order-id="<?php echo $order['order_id']; ?>"><i class="fas fa-times"></i></button>
                                    <?php elseif ($status == 'shipped'): ?>
                                        <button class="action-btn complete" data-order-id="<?php echo $order['order_id']; ?>"><i class="fas fa-check-circle"></i></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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

            <!-- Modal chi tiết đơn hàng -->
            <div class="modal" id="orderDetailModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Chi tiết đơn hàng #<span id="modalOrderId"></span></h2>
                        <button class="close-btn">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="order-info">
                            <div class="info-row">
                                <span class="info-label">Khách hàng:</span>
                                <span class="info-value" id="customerName"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Địa chỉ:</span>
                                <span class="info-value" id="customerAddress"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">SĐT:</span>
                                <span class="info-value" id="customerPhone"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ngày đặt:</span>
                                <span class="info-value" id="orderDate"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">PTTT:</span>
                                <span class="info-value" id="paymentMethod"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ghi chú:</span>
                                <span class="info-value" id="orderNotes"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Trạng thái:</span>
                                <span class="info-value" id="orderStatus"></span>
                            </div>
                        </div>

                        <h3>Sản phẩm</h3>
                        <div class="order-items-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>Mã SP</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Màu/Size</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="orderItemsList">
                                    <!-- Nội dung sản phẩm sẽ được thêm bằng JS -->
                                </tbody>
                            </table>
                        </div>

                        <div class="order-total">
                            <div class="total-row">
                                <span class="total-label">Tổng cộng:</span>
                                <span class="total-value" id="orderTotal"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>



    </div>


    <style>
        /* Modal styles */
        .order-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            width: 80%;
            max-width: 900px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #777;
        }

        .modal-body {
            padding: 20px;
        }

        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .order-info-item {
            margin-bottom: 10px;
        }

        .order-info-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .order-info-value {
            color: #333;
        }

        .order-items {
            margin-top: 20px;
        }

        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-items th,
        .order-items td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .order-items th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
        }

        .btn-close {
            padding: 8px 16px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>

    <!-- Order Detail Modal -->
    <div class="order-modal" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Chi tiết đơn hàng #<span id="modalOrderId"></span></h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="order-info">
                    <div>
                        <div class="order-info-item">
                            <div class="order-info-label">Khách hàng</div>
                            <div class="order-info-value" id="modalCustomerName"></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Địa chỉ</div>
                            <div class="order-info-value" id="modalAddress"></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Số điện thoại</div>
                            <div class="order-info-value" id="modalPhone"></div>
                        </div>
                    </div>
                    <div>
                        <div class="order-info-item">
                            <div class="order-info-label">Ngày đặt hàng</div>
                            <div class="order-info-value" id="modalOrderDate"></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Phương thức thanh toán</div>
                            <div class="order-info-value" id="modalPaymentMethod"></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Trạng thái</div>
                            <div class="order-info-value" id="modalStatus"></div>
                        </div>
                    </div>
                </div>
                <div class="order-info-item">
                    <div class="order-info-label">Ghi chú</div>
                    <div class="order-info-value" id="modalNotes"></div>
                </div>

                <div class="order-items">
                    <h4>Sản phẩm</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Mã SP</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Màu sắc</th>
                                <th>Kích thước</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody id="modalOrderItems">
                            <!-- Items will be inserted here by JavaScript -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" style="text-align: right; font-weight: 600;">Tổng cộng:</td>
                                <td id="modalOrderTotal" style="font-weight: 600;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-close">Đóng</button>
            </div>
        </div>
    </div>
    <script>
        //xử lý sự kiện cho các nút
        const viewButtons = document.querySelectorAll('.action-btn.view');
        const processButtons = document.querySelectorAll('.action-btn.process');
        const completeButtons = document.querySelectorAll('.action-btn.complete');
        const cancelButtons = document.querySelectorAll('.action-btn.cancel');
        const orderItems = document.querySelectorAll('.order-item');
        const orderDetails = document.querySelectorAll('.order-details');
        const closeButtons = document.querySelectorAll('.close-btn');

        viewButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                orderItems[index].style.display = 'block';
            });
        });
        processButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Xử lý logic cho nút "Xử lý"
                alert('Đơn hàng đã được xử lý!');
            });
        });
        completeButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Xử lý logic cho nút "Hoàn thành"
                alert('Đơn hàng đã được hoàn thành!');
            });
        });
        // Xử lý nút hủy đơn hàng
        cancelButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation(); // Ngăn sự kiện lan truyền
                const orderId = button.getAttribute('data-order-id');
                if (confirm('Bạn có chắc chắn muốn hủy đơn hàng #' + orderId + ' không?')) {
                    fetch('update_order_status.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `order_id=${orderId}&status=cancelled`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Đã hủy đơn hàng #' + orderId + ' thành công!');
                                location.reload();
                            } else {
                                alert('Có lỗi xảy ra khi hủy đơn hàng!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Lỗi kết nối máy chủ!');
                        });
                }
            });
        });

        // Xử lý các nút khác (xử lý, hoàn thành...)
        processButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const orderId = button.getAttribute('data-order-id');
                // Gửi request để chuyển sang trạng thái processing
                updateOrderStatus(orderId, 'processing');
            });
        });

        completeButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const orderId = button.getAttribute('data-order-id');
                // Gửi request để chuyển sang trạng thái completed
                updateOrderStatus(orderId, 'completed');
            });
        });

        // Hàm chung để cập nhật trạng thái đơn hàng
        function updateOrderStatus(orderId, newStatus) {
            fetch('update_order_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `order_id=${orderId}&status=${newStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Đã cập nhật trạng thái đơn hàng #${orderId} thành ${getStatusName(newStatus)}!`);
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật trạng thái đơn hàng!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Lỗi kết nối máy chủ!');
                });
        }

        // Hàm chuyển đổi status code thành tên trạng thái
        function getStatusName(status) {
            const statusMap = {
                'pending': 'Chờ xác nhận',
                'processing': 'Đang xử lý',
                'shipped': 'Đang giao',
                'completed': 'Hoàn thành',
                'cancelled': 'Đã hủy'
            };
            return statusMap[status] || status;
        }
        closeButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                orderItems[index].style.display = 'none';
            });
        });


        // Xử lý lọc theo ngày
        document.querySelector('.filter-section input[type="date"]').addEventListener('change', function() {
            const selectedDate = this.value;
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const orderDate = row.cells[2].textContent;
                if (orderDate.includes(selectedDate)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        // Xử lý lọc theo trạng thái
        document.querySelector('.filter-section select[name="status"]').addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const statusBadge = row.querySelector('td:nth-child(6) .badge');
                if (!statusBadge) return;

                const rowStatus = statusBadge.className.includes('badge-warning') ? 'pending' :
                    statusBadge.className.includes('badge-info') ? 'processing' :
                    statusBadge.className.includes('badge-primary') ? 'shipped' :
                    statusBadge.className.includes('badge-success') ? 'completed' :
                    statusBadge.className.includes('badge-danger') ? 'cancelled' : '';

                if (selectedStatus === '' || rowStatus === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        //Xử lý tìm kiếm theo mã đơn hàng
        document.querySelector('.filter-section input[type="text"]').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const orderId = row.cells[0].textContent.toLowerCase();
                if (orderId.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        // Xử lý lọc theo tên khách hàng
        document.querySelector('.filter-section input[type="text"]').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const customerName = row.cells[1].textContent.toLowerCase();
                if (customerName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        // Xử lý làm mới
        document.querySelector('.filter-actions .btn-secondary').addEventListener('click', function() {
            document.querySelector('.filter-section input[type="date"]').value = '';
            document.querySelector('.filter-section select').value = '';
            document.querySelector('.filter-section input[type="text"]').value = '';
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        });


        // Xử lý sự kiện cho nút "Xem chi tiết"
        // Lấy dữ liệu đơn hàng từ PHP sang JS
        const ordersData = <?php echo json_encode($orders); ?>;

        // Lấy modal và các thành phần trong modal
        const orderModal = document.getElementById('orderModal');
        const closeModalBtn = document.querySelector('.close-modal');
        const closeFooterBtn = document.querySelector('.btn-close');
        const modalOrderId = document.querySelectorAll('#modalOrderId');
        const modalCustomerName = document.getElementById('modalCustomerName');
        const modalAddress = document.getElementById('modalAddress');
        const modalPhone = document.getElementById('modalPhone');
        const modalOrderDate = document.getElementById('modalOrderDate');
        const modalPaymentMethod = document.getElementById('modalPaymentMethod');
        const modalStatus = document.getElementById('modalStatus');
        const modalNotes = document.getElementById('modalNotes');
        const modalOrderItems = document.getElementById('modalOrderItems');
        const modalOrderTotal = document.getElementById('modalOrderTotal');

        // Gộp các order_items theo order_id
        function groupOrdersById(orders) {
            const grouped = {};
            orders.forEach(item => {
            if (!grouped[item.order_id]) {
                grouped[item.order_id] = {
                ...item,
                items: []
                };
            }
            grouped[item.order_id].items.push(item);
            });
            return grouped;
        }
        const groupedOrders = groupOrdersById(ordersData);

        // Gán sự kiện cho nút "Xem chi tiết"
        document.querySelectorAll('.action-btn.view').forEach((btn, idx) => {
            btn.addEventListener('click', function () {
            // Lấy order_id từ hàng hiện tại
            const row = btn.closest('tr');
            const orderIdCell = row.cells[0].textContent.replace('#', '').trim();
            let orderId = null;
            // Tìm order_id thực sự (vì cell[0] là order_item_id, cần lấy order_id)
            if (ordersData[idx]) {
                orderId = ordersData[idx].order_id;
            } else {
                // fallback: lấy order_id từ data-order-id nếu có
                orderId = btn.getAttribute('data-order-id');
            }
            if (!orderId) return;

            const order = groupedOrders[orderId];
            if (!order) return;

            // Hiển thị thông tin đơn hàng
            modalOrderId.forEach(el => el.textContent = orderId);
            modalCustomerName.textContent = order.customer_name || '';
            modalAddress.textContent = order.address || '';
            modalPhone.textContent = order.phone || '';
            modalOrderDate.textContent = order.created_at ? (new Date(order.created_at)).toLocaleDateString('vi-VN') : '';
            modalPaymentMethod.textContent = order.payment_method || '';
            modalStatus.textContent = getStatusName(order.status);
            modalNotes.textContent = order.notes || '';

            // Hiển thị danh sách sản phẩm
            modalOrderItems.innerHTML = '';
            let total = 0;
            order.items.forEach(item => {
                const itemTotal = (item.order_item_price || 0) * (item.quantity || 0);
                total += itemTotal;
                modalOrderItems.innerHTML += `
                <tr>
                    <td><img src="${item.order_item_image || item.product_image || ''}" class="product-image" alt=""></td>
                    <td>${item.product_name || ''}</td>
                    <td>${item.product_code || ''}</td>
                    <td>${Number(item.order_item_price || 0).toLocaleString('vi-VN')}đ</td>
                    <td>${item.quantity || ''}</td>
                    <td>${item.color || ''}</td>
                    <td>${item.size || ''}</td>
                    <td>${itemTotal.toLocaleString('vi-VN')}đ</td>
                </tr>
                `;
            });
            modalOrderTotal.textContent = total.toLocaleString('vi-VN') + 'đ';

            // Hiển thị modal
            orderModal.style.display = 'flex';
            });
        });

        // Đóng modal khi bấm nút đóng
        [closeModalBtn, closeFooterBtn].forEach(btn => {
            btn.addEventListener('click', function () {
            orderModal.style.display = 'none';
            });
        });

        // Đóng modal khi click ra ngoài nội dung modal
        orderModal.addEventListener('click', function (e) {
            if (e.target === orderModal) {
            orderModal.style.display = 'none';
            }
        });
    </script>
</body>

</html>