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

// Nhóm các mục đơn hàng theo order_id
$grouped_orders = [];
foreach ($orders as $order) {
    $order_id = $order['order_id'];
    if (!isset($grouped_orders[$order_id])) {
        $grouped_orders[$order_id] = [
            'order_info' => [
                'order_id' => $order['order_id'],
                'customer_name' => $order['customer_name'],
                'address' => $order['address'],
                'phone' => $order['phone'],
                'payment_method' => $order['payment_method'],
                'notes' => $order['notes'],
                'total' => $order['total'],
                'created_at' => $order['created_at'],
                'status' => $order['status']
            ],
            'items' => []
        ];
    }
    $grouped_orders[$order_id]['items'][] = [
        'product_name' => $order['product_name'],
        'product_code' => $order['product_code'],
        'price' => $order['order_item_price'],
        'quantity' => $order['quantity'],
        'color' => $order['color'],
        'size' => $order['size'],
        'subtotal' => $order['order_item_price'] * $order['quantity']
    ];
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin Clothing Store</title>
    <link rel="stylesheet" href="../../assets/css/admin/manege_customer.css">
    <link rel="stylesheet" href="../../assets/css/admin/order_management.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="admin-container">
        <?php require_once('../admin/sidebar/admin_sidebar.php'); ?>

        <div class="admin-content">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-shopping-bag me-2"></i>Quản lý đơn hàng</h1>
                <button class="btn btn-export">
                    <i class="fas fa-file-excel me-2"></i>Xuất Excel
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control search-box" placeholder="Tìm kiếm đơn hàng...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="status-filter">
                                <option value="all">Tất cả trạng thái</option>
                                <option value="pending">Chờ xác nhận</option>
                                <option value="processing">Đang xử lý</option>
                                <option value="shipped">Đang giao</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="sort-by">
                                <option value="newest">Mới nhất</option>
                                <option value="oldest">Cũ nhất</option>
                                <option value="total_asc">Tổng tiền (Tăng dần)</option>
                                <option value="total_desc">Tổng tiền (Giảm dần)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Số điện thoại</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>PTTT</th>
                                    <th class="text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($grouped_orders as $order_id => $order): ?>
                                    <tr data-order-id="<?= $order_id ?>" data-status="<?= $order['order_info']['status'] ?>">
                                        <td>#<?= str_pad($order_id, 6, '0', STR_PAD_LEFT) ?></td>
                                        <td><?= htmlspecialchars($order['order_info']['customer_name']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($order['order_info']['created_at'])) ?></td>
                                        <td><?= htmlspecialchars($order['order_info']['phone']) ?></td>
                                        <td><?= number_format($order['order_info']['total'], 0, ',', '.') ?>đ</td>
                                        <td>
                                            <span class="badge <?= getStatusBadgeClass($order['order_info']['status']) ?>">
                                                <?= getStatusText($order['order_info']['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($order['order_info']['payment_method']) ?></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary btn-view"
                                                data-bs-toggle="modal"
                                                data-bs-target="#orderDetailModal"
                                                data-order-id="<?= $order_id ?>">
                                                <i class="fas fa-eye"></i> Xem
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#" data-action="process"><i class="fas fa-check-circle me-2"></i>Xác nhận</a></li>
                                                    <li><a class="dropdown-item" href="#" data-action="ship"><i class="fas fa-truck me-2"></i>Giao hàng</a></li>
                                                    <li><a class="dropdown-item" href="#" data-action="complete"><i class="fas fa-check-double me-2"></i>Hoàn thành</a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item text-danger" href="#" data-action="cancel"><i class="fas fa-times-circle me-2"></i>Hủy đơn</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Trước</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết đơn hàng -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng #<span id="modalOrderId"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold"><i class="fas fa-user me-2"></i>Thông tin khách hàng</h6>
                            <div class="ps-4">
                                <p class="mb-1"><strong>Tên:</strong> <span id="customerName"></span></p>
                                <p class="mb-1"><strong>Địa chỉ:</strong> <span id="customerAddress"></span></p>
                                <p class="mb-1"><strong>SĐT:</strong> <span id="customerPhone"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Thông tin đơn hàng</h6>
                            <div class="ps-4">
                                <p class="mb-1"><strong>Ngày đặt:</strong> <span id="orderDate"></span></p>
                                <p class="mb-1"><strong>PTTT:</strong> <span id="paymentMethod"></span></p>
                                <p class="mb-1"><strong>Trạng thái:</strong> <span id="orderStatus" class="badge"></span></p>
                                <p class="mb-1"><strong>Ghi chú:</strong> <span id="orderNotes"></span></p>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold"><i class="fas fa-boxes me-2"></i>Sản phẩm đã đặt</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th>Mã SP</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-center">SL</th>
                                    <th>Màu/Size</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody id="orderItemsList">
                                <!-- Nội dung sản phẩm sẽ được thêm bằng JS -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-end fw-bold" id="orderTotal"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnPrintOrder"><i class="fas fa-print me-2"></i>In đơn hàng</button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dữ liệu đơn hàng từ PHP
        const ordersData = <?= json_encode($grouped_orders) ?>;

        // Xử lý hiển thị modal chi tiết đơn hàng
        const orderDetailModal = document.getElementById('orderDetailModal');
        orderDetailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const orderId = button.getAttribute('data-order-id');
            const order = ordersData[orderId];
            if (!order) return;

            // Hiển thị thông tin cơ bản
            document.getElementById('modalOrderId').textContent = orderId.padStart(6, '0');
            document.getElementById('customerName').textContent = order.order_info.customer_name || 'N/A';
            document.getElementById('customerAddress').textContent = order.order_info.address || 'N/A';
            document.getElementById('customerPhone').textContent = order.order_info.phone || 'N/A';
            document.getElementById('orderDate').textContent = new Date(order.order_info.created_at).toLocaleString('vi-VN');
            document.getElementById('paymentMethod').textContent = order.order_info.payment_method || 'N/A';

            // Hiển thị trạng thái
            const statusBadge = document.getElementById('orderStatus');
            statusBadge.textContent = getStatusText(order.order_info.status);
            statusBadge.className = 'badge ' + getStatusBadgeClass(order.order_info.status);

            // Hiển thị ghi chú
            document.getElementById('orderNotes').textContent = order.order_info.notes || 'Không có ghi chú';

            // Hiển thị danh sách sản phẩm
            const itemsList = document.getElementById('orderItemsList');
            itemsList.innerHTML = '';

            let total = 0;
            order.items.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.product_name || 'N/A'}</td>
                    <td>${item.product_code || 'N/A'}</td>
                    <td class="text-end">${Number(item.price).toLocaleString('vi-VN')}đ</td>
                    <td class="text-center">${item.quantity}</td>
                    <td>${item.color || 'N/A'}/${item.size || 'N/A'}</td>
                    <td class="text-end">${subtotal.toLocaleString('vi-VN')}đ</td>
                `;
                itemsList.appendChild(row);
            });

            // Hiển thị tổng tiền
            document.getElementById('orderTotal').textContent = total.toLocaleString('vi-VN') + 'đ';
        });

        // Hàm hỗ trợ hiển thị trạng thái (tương tự PHP)
        function getStatusBadgeClass(status) {
            const classes = {
                'pending': 'bg-warning',
                'processing': 'bg-info',
                'shipped': 'bg-primary',
                'completed': 'bg-success',
                'cancelled': 'bg-danger',
                'delivered': 'bg-secondary'
            };
            return classes[status] || 'bg-secondary';
        }

        function getStatusText(status) {
            const texts = {
                'pending': 'Chờ xác nhận',
                'processing': 'Đang xử lý',
                'shipped': 'Đang giao',
                'completed': 'Hoàn thành',
                'cancelled': 'Đã hủy',
                'delivered': 'Đã giao hàng'
            };
            return texts[status] || status;
        }

        // Xử lý tìm kiếm đơn hàng
        document.querySelector('.search-box').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const orderId = row.cells[0].textContent.toLowerCase();
                const customerName = row.cells[1].textContent.toLowerCase();
                const phone = row.cells[3].textContent.toLowerCase();

                if (orderId.includes(searchTerm) ||
                    customerName.includes(searchTerm) ||
                    phone.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        //Xử lý đóng modal khi click ra ngoài
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('orderDetailModal');
            if (modal && !modal.contains(event.target) && !event.target.closest('.btn-view')) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            }
        });
        // Xử lý đóng modal khi nhấn ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('orderDetailModal');
                if (modal) {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                }
            }
        });
        // Xử lý đống modal khi click vào nút đóng
        document.querySelector('.btn-close').addEventListener('click', function() {
            const modal = document.getElementById('orderDetailModal');
            if (modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            }
        });
        // Xử lý đong modal khi click vào nút "x"
        document.querySelector('.btn-close-white').addEventListener('click', function() {
            const modal = document.getElementById('orderDetailModal');
            if (modal) {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            }
        });
        // Xử lý lọc theo trạng thái
        document.getElementById('status-filter').addEventListener('change', function(e) {
            const status = e.target.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Xử lý sắp xếp
        document.getElementById('sort-by').addEventListener('change', function(e) {
            const sortType = e.target.value;
            // Thực hiện sắp xếp dữ liệu theo lựa chọn
            console.log('Sắp xếp theo:', sortType);
            // Trong thực tế, bạn cần gửi yêu cầu đến server hoặc sắp xếp dữ liệu client-side
        });

        // Xử lý nút in đơn hàng
        document.getElementById('btnPrintOrder').addEventListener('click', function() {
            window.print();
        });

        // Xử lý các hành động trên đơn hàng (xác nhận, giao hàng, hủy...)
        document.querySelectorAll('[data-action]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');
                const orderId = this.closest('tr').getAttribute('data-order-id');

                if (confirm(`Bạn có chắc muốn ${getActionText(action)} đơn hàng #${orderId}?`)) {
                    // Gửi AJAX request đến server để cập nhật trạng thái
                    const statusMap = {
                        'process': 'processing',
                        'ship': 'shipped',
                        'complete': 'completed',
                        'cancel': 'cancelled'
                    };
                    const newStatus = statusMap[action];
                    if (!newStatus) return;

                    fetch('update_status.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `order_id=${orderId}&status=${newStatus}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateOrderStatus(orderId, action); // Cập nhật giao diện nếu thành công
                        } else {
                            alert('Cập nhật trạng thái thất bại!');
                        }
                    })
                    .catch(() => alert('Có lỗi khi kết nối server!'));
                }
            });
        });

        function getActionText(action) {
            const actions = {
                'process': 'xác nhận',
                'ship': 'giao hàng',
                'complete': 'hoàn thành',
                'cancel': 'hủy'
            };
            return actions[action] || action;
        }

        function updateOrderStatus(orderId, action) {
            const statusMap = {
                'process': 'processing',
                'ship': 'shipped',
                'complete': 'completed',
                'cancel': 'cancelled'
            };

            const newStatus = statusMap[action];
            if (!newStatus) return;

            // Cập nhật trong ordersData
            if (ordersData[orderId]) {
                ordersData[orderId].order_info.status = newStatus;
            }

            // Cập nhật giao diện
            const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
            if (row) {
                row.setAttribute('data-status', newStatus);
                const badge = row.querySelector('.badge');
                if (badge) {
                    badge.textContent = getStatusText(newStatus);
                    badge.className = 'badge ' + getStatusBadgeClass(newStatus);
                }
            }
        }

        //Xuất file Excel
        document.querySelector('.btn-export').addEventListener('click', function() {
            window.location.href = 'export_orders_excel.php';
        });
        // Xử lý phân trang 
        const rowsPerPage = 5;
        let currentPage = 1;

        function showPage(page) {
            const rows = document.querySelectorAll('tbody tr');
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            // Ẩn tất cả các dòng
            rows.forEach(row => row.style.display = 'none');

            // Hiển thị các dòng cho trang hiện tại
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            rows.forEach((row, idx) => {
            if (idx >= start && idx < end) {
                row.style.display = '';
            }
            });

            // Cập nhật phân trang
            updatePagination(page, totalPages);
        }

        function updatePagination(page, totalPages) {
            const pagination = document.querySelector('.pagination');
            if (!pagination) return;
            pagination.innerHTML = '';

            // Nút trước
            const prev = document.createElement('li');
            prev.className = 'page-item' + (page === 1 ? ' disabled' : '');
            prev.innerHTML = `<a class="page-link" href="#">Trước</a>`;
            prev.addEventListener('click', function(e) {
            e.preventDefault();
            if (page > 1) showPage(page - 1);
            });
            pagination.appendChild(prev);

            // Các nút số trang
            for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = 'page-item' + (i === page ? ' active' : '');
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', function(e) {
                e.preventDefault();
                showPage(i);
            });
            pagination.appendChild(li);
            }

            // Nút sau
            const next = document.createElement('li');
            next.className = 'page-item' + (page === totalPages ? ' disabled' : '');
            next.innerHTML = `<a class="page-link" href="#">Sau</a>`;
            next.addEventListener('click', function(e) {
            e.preventDefault();
            if (page < totalPages) showPage(page + 1);
            });
            pagination.appendChild(next);
        }

        // Khởi tạo phân trang khi trang tải xong
        document.addEventListener('DOMContentLoaded', function() {
            showPage(1);
        });

        // Khi tìm kiếm, lọc trạng thái hoặc sắp xếp, reset về trang 1
        document.querySelector('.search-box').addEventListener('input', function() {
            showPage(1);
        });
        document.getElementById('status-filter').addEventListener('change', function() {
            showPage(1);
        });
        document.getElementById('sort-by').addEventListener('change', function() {
            showPage(1);
        });

        // Bộ lọc mới nhất, cũ nhất, tổng tiền tăng dần, giảm dần
        // Sắp xếp lại các dòng trong bảng theo lựa chọn sort-by
        function sortTable(sortType) {
            const tbody = document.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
            rows.sort((a, b) => {
            let valA, valB;
            switch (sortType) {
                case 'newest':
                valA = parseInt(a.getAttribute('data-order-id'));
                valB = parseInt(b.getAttribute('data-order-id'));
                return valB - valA;
                case 'oldest':
                valA = parseInt(a.getAttribute('data-order-id'));
                valB = parseInt(b.getAttribute('data-order-id'));
                return valA - valB;
                case 'total_asc':
                valA = parseInt(a.cells[4].textContent.replace(/\D/g, ''));
                valB = parseInt(b.cells[4].textContent.replace(/\D/g, ''));
                return valA - valB;
                case 'total_desc':
                valA = parseInt(a.cells[4].textContent.replace(/\D/g, ''));
                valB = parseInt(b.cells[4].textContent.replace(/\D/g, ''));
                return valB - valA;
                default:
                return 0;
            }
            });
            // Xóa các dòng cũ và thêm lại theo thứ tự mới
            rows.forEach(row => tbody.appendChild(row));
        }

        document.getElementById('sort-by').addEventListener('change', function(e) {
            const sortType = e.target.value;
            sortTable(sortType);
            showPage(1);
        });

        // Sắp xếp mặc định khi load trang (mới nhất)
        document.addEventListener('DOMContentLoaded', function() {
            sortTable(document.getElementById('sort-by').value);
        });
        
    </script>
</body>

</html>

<?php require_once('../admin/footer/admin-footer.php'); ?>