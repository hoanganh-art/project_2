<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}
require_once('../admin/header/admin-header.php');
?>
<?php
include('../includes/database.php');
// Truy vấn danh sách nhân viên từ cơ sở dữ liệu
$sql = "SELECT * FROM customer";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result(); // Lấy kết quả truy vấn
$customer = $result->fetch_all(MYSQLI_ASSOC); // Gán kết quả vào biến 
// Tạo biến hiển thị email
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/admin/manege_customer.css">
    <title>Quản lý nhân viên - Admin Clothing Store</title>
</head>

<body>
    <div class="admin-container">
        <?php require_once('../admin/sidebar/admin_sidebar.php'); ?>

        <div class="admin-content">
            <div class="page-header">
                <h1 class="page-title">Quản lý khách hàng</h1>
                <button class="btn-export">
                    <span>📁</span> Xuất Excel
                </button>
            </div>

            <div class="customer-actions">
                <input type="text" class="search-box" placeholder="Tìm kiếm khách hàng...">
                <div class="filter-group">
                    <label for="status-filter">Trạng thái:</label>
                    <select id="status-filter">
                        <option value="all">Tất cả</option>
                        <option value="active">Đang hoạt động</option>
                        <option value="inactive">Ngừng hoạt động</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="sort-by">Sắp xếp:</label>
                    <select id="sort-by">
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                        <option value="name-asc">Tên A-Z</option>
                        <option value="name-desc">Tên Z-A</option>
                    </select>
                </div>
            </div>

            <table class="customers-table">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Ngày đăng ký</th>
                        <th>Tổng đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customer as $customer): ?>
                        <?php
                        $statusClass = $customer['status'] == 'active' ? 'status-active' : 'status-inactive';
                        $statusText = $customer['status'] == 'active' ? 'Hoạt động' : 'Ngừng hoạt động';
                        ?>
                        <tr data-email="<?php echo htmlspecialchars($customer['email']); ?>"
                            data-avatar="<?php echo htmlspecialchars($customer['avatar'] ?: '../../assets/avatar/default-avatar.png'); ?>"
                            data-gender="<?php echo htmlspecialchars($customer['gender']) ? ($customer['gender'] == 1 ? 'Nam' : 'Nữ') : 'Không xác định'; ?>">
                            <td><?php echo htmlspecialchars($customer['name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                            <td><?php echo htmlspecialchars($customer['address']); ?></td>
                            <td><?php echo htmlspecialchars($customer['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                            <td><?php echo htmlspecialchars($statusText); ?></td>
                            <td>
                                <button class="action-btn btn-view">Xem</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <button class="pagination-btn">←</button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">→</button>
            </div>
        </div>
    </div>

    <!-- Modal Xem chi tiết khách hàng -->
    <div class="modal" id="customerModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thông tin khách hàng</h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="customer-details">
                    <img alt="Avatar" class="customer-avatar-large">
                    <div class="customer-main-info">
                        <div class="customer-name-large">Nguyễn Thị A</div>
                        <div class="customer-join-date">Thành viên từ: 15/08/2023</div>
                        <div class="customer-stats">
                            <div class="stat-item">
                                <div class="stat-value">12</div>
                                <div class="stat-label">Đơn hàng</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">8,450,000đ</div>
                                <div class="stat-label">Tổng chi tiêu</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">4.8 ★</div>
                                <div class="stat-label">Đánh giá</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">nguyenthi.a@example.com</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Số điện thoại:</div>
                    <div class="detail-value">0912345678</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Địa chỉ:</div>
                    <div class="detail-value">123 Đường ABC, Phường 1, Quận 1, TP.Hồ Chí Minh</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Ngày sinh:</div>
                    <div class="detail-value">15/05/1990</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Giới tính:</div>
                    <div class="detail-value"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Trạng thái:</div>
                    <div class="detail-value"><span class="customer-status status-active">Hoạt động</span></div>
                </div>

                <h3 style="margin: 20px 0 10px; color: #2D3436;">Đơn hàng gần đây</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f8f8;">
                            <th style="padding: 10px; text-align: left;">Mã đơn</th>
                            <th style="padding: 10px; text-align: left;">Ngày đặt</th>
                            <th style="padding: 10px; text-align: left;">Tổng tiền</th>
                            <th style="padding: 10px; text-align: left;">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">#DH20231001</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">10/10/2023</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">1,250,000đ</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Đã giao</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">#DH20230915</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">15/09/2023</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">2,450,000đ</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Đã giao</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">#DH20230820</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">20/08/2023</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">850,000đ</td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Đã giao</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="action-btn btn-delete" id="closeDetailBtn">Đóng</button>
            </div>
        </div>
    </div>
    <script>
        // Xử lý modal khách hàng
        const customerModal = document.getElementById('customerModal');
        const closeBtn = document.getElementById('closeModal');
        const closeDetailBtn = document.getElementById('closeDetailBtn');

        // Mở modal xem chi tiết
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const customerRow = this.closest('tr');
                const customerName = customerRow.querySelector('td:nth-child(1)').textContent;
                const customerPhone = customerRow.querySelector('td:nth-child(2)').textContent;
                const customerAddress = customerRow.querySelector('td:nth-child(3)').textContent;
                const customerJoinDate = customerRow.querySelector('td:nth-child(4)').textContent;
                const customerOrders = customerRow.querySelector('td:nth-child(5)').textContent;
                const customerStatus = customerRow.querySelector('td:nth-child(6)').textContent;
                const customerEmail = customerRow.getAttribute('data-email');
                const customerAvatar = customerRow.getAttribute('data-avatar');
                const customerGender = customerRow.getAttribute('data-gender');

                // Cập nhật thông tin vào modal
                document.querySelector('.customer-avatar-large').src = customerAvatar || '../../assets/avatar/default-avatar.png';
                document.querySelector('.customer-name-large').textContent = customerName;
                document.querySelector('.customer-join-date').textContent = `Thành viên từ: ${customerJoinDate}`;
                document.querySelector('.detail-row:nth-child(2) .detail-value').textContent = customerEmail || 'Không có email';
                document.querySelector('.detail-row:nth-child(3) .detail-value').textContent = customerPhone;
                document.querySelector('.detail-row:nth-child(4) .detail-value').textContent = customerAddress;
                document.querySelector('.detail-row:nth-child(6) .detail-value').textContent = customerGender || 'Không xác định'; // Hiển thị giới tính
                document.querySelector('.stat-item:nth-child(1) .stat-value').textContent = customerOrders;
                document.querySelector('.detail-row:nth-child(7) .detail-value .customer-status').textContent = customerStatus;
                document.querySelector('.detail-row:nth-child(7) .detail-value .customer-status').className = `customer-status ${customerStatus === 'Hoạt động' ? 'status-active' : 'status-inactive'}`;

                // Hiển thị modal
                customerModal.style.display = 'flex';
            });
        });

        // Đóng modal
        closeBtn.addEventListener('click', () => {
            customerModal.style.display = 'none';
        });

        closeDetailBtn.addEventListener('click', () => {
            customerModal.style.display = 'none';
        });

        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === customerModal) {
                customerModal.style.display = 'none';
            }
        });

        // Xử lý khóa/mở khóa tài khoản
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const customerName = this.closest('tr').querySelector('.customer-name').textContent;
                const isLocked = this.textContent === 'Khóa';

                if (confirm(`Bạn có chắc muốn ${isLocked ? 'khóa' : 'mở khóa'} tài khoản của ${customerName}?`)) {
                    const statusCell = this.closest('tr').querySelector('.customer-status');
                    if (isLocked) {
                        statusCell.textContent = 'Đã khóa';
                        statusCell.className = 'customer-status status-inactive';
                        this.textContent = 'Mở khóa';
                        this.style.backgroundColor = '#2ecc71';
                        alert(`Đã khóa tài khoản ${customerName}`);
                    } else {
                        statusCell.textContent = 'Hoạt động';
                        statusCell.className = 'customer-status status-active';
                        this.textContent = 'Khóa';
                        this.style.backgroundColor = '#e74c3c';
                        alert(`Đã mở khóa tài khoản ${customerName}`);
                    }
                }
            });
        });

        // Xử lý tìm kiếm khách hàng
        const searchBox = document.querySelector('.search-box');
        searchBox.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.customers-table tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('.customer-name').textContent.toLowerCase();
                const email = row.querySelector('.customer-email').textContent.toLowerCase();
                const phone = row.cells[1].textContent.toLowerCase();

                if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Xử lý lọc theo trạng thái
        const statusFilter = document.getElementById('status-filter');
        statusFilter.addEventListener('change', (e) => {
            const status = e.target.value;
            const rows = document.querySelectorAll('.customers-table tbody tr');

            rows.forEach(row => {
                const rowStatus = row.querySelector('.customer-status').classList.contains('status-active') ? 'active' : 'inactive';

                if (status === 'all' || status === rowStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Xử lý sắp xếp
        const sortBy = document.getElementById('sort-by');
        sortBy.addEventListener('change', (e) => {
            alert(`Đã chọn sắp xếp theo: ${e.target.value}`);
            // Trong thực tế sẽ có code sắp xếp dữ liệu
        });
    </script>
</body>

</html>
<?php require_once('../admin/footer/admin-footer.php'); ?>