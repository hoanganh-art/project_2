<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}
include('../includes/database.php');
// Truy vấn danh sách nhân viên từ cơ sở dữ liệu
$sql = "SELECT * FROM employees";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result(); // Lấy kết quả truy vấn
$employees = $result->fetch_all(MYSQLI_ASSOC); // Gán kết quả vào biến $employees
?>
<?php require_once('../admin/header/admin-header.php'); ?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên - Admin Clothing Store</title>
    <link rel="stylesheet" href="../assets/css/admin/manage_employees.css">
</head>

<body>
    <div class="admin-container">
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <div class="admin-name"><?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['name']) : 'Admin'; ?></div>
                <div class="admin-role">Quản trị viên</div>
            </div>

            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i>📊</i> Tổng quan</a></li>
                <li><a href="#"><i>📦</i> Đơn hàng</a></li>
                <li><a href="manage_products.php"><i>👕</i> Sản phẩm</a></li>
                <li><a href="manege_customer.php"><i>👥</i> Khách hàng</a></li>
                <li><a href="manage_employees.php" class="active"><i>👨‍💼</i> Nhân viên</a></li>
                <li><a href="manage_roles.php"><i>🔐</i> Phân quyền</a></li>
                <li><a href="#"><i>⚙️</i> Cài đặt</a></li>
                <li>
                    <?php
                    if (isset($_SESSION['user'])) {
                        // Hiển thị nút đăng xuất
                        echo '<a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>';
                    } else {
                        // Hiển thị nút đăng nhập
                        echo '<a href="../login/index.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>

        <div class="admin-content">
            <div class="page-header">
                <h1 class="page-title">Quản lý nhân viên</h1>
                <button class="btn-add" id="addEmployeeBtn">
                    <span>+</span> Thêm nhân viên
                </button>
            </div>

            <div class="employee-actions">
                <input type="text" class="search-box" placeholder="Tìm kiếm nhân viên...">
                <div class="filter-group">
                    <label for="status-filter">Trạng thái:</label>
                    <select id="status-filter">
                        <option value="all">Tất cả</option>
                        <option value="active">Đang hoạt động</option>
                        <option value="inactive">Ngừng hoạt động</option>
                    </select>
                </div>
            </div>

            <table class="employees-table">
                <thead>
                    <tr>
                        <th>Nhân viên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vị trí</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                        <?php
                        $statusClass = $employee['status'] == 'active' ? 'status-active' : 'status-inactive';
                        $statusText = $employee['status'] == 'active' ? 'Đang làm' : 'Đã Nghỉ làm';

                        $positionMap = [
                            'Manager' => 'Quản lý',
                            'Sales Staff' => 'Nhân viên bán hàng',
                            'Warehouse Staff' => 'Nhân viên kho',
                            'Delivery Staff' => 'Nhân viên giao hàng',
                            'Customer Service' => 'Nhân viên CSKH'
                        ];
                        $positionInVietnamese = isset($positionMap[$employee['position']]) ? $positionMap[$employee['position']] : $employee['position'];
                        ?>
                        <tr data-id="<?php echo $employee['id']; ?>"
                            data-posion="<?php echo htmlspecialchars($employee['position']); ?>"
                            data-address="<?php echo htmlspecialchars($employee['address']); ?>"
                            data-birthday="<?php echo htmlspecialchars($employee['date_of_birth']); ?>"
                            data-avatar="<?php echo htmlspecialchars($employee['avatar'] ? '../assets/avatar/' . $employee['avatar'] : '../assets/avatar/default-avatar.png'); ?>">
                            <td><?php echo htmlspecialchars($employee['name']); ?></td>
                            <td><?php echo htmlspecialchars($employee['email']); ?></td>
                            <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                            <td><?php echo $positionInVietnamese; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($employee['created_at'])); ?></td>
                            <td><span class="employee-status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                            <td>
                                <button class="action-btn btn-view">Xem</button>
                                <button class="action-btn btn-edit" id="">Sửa</button>
                                <a href="delete_employees.php?id=<?php echo $employee['id']; ?>" class="action-btn btn-delete">Xóa</a>
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

    <!-- Modal Thêm nhân viên -->
    <div class="modal" id="employeeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm nhân viên mới</h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="employeeForm" action="addemployees.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Vị trí</label>
                            <select id="position" name="position" required>
                                <option value="">Chọn vị trí</option>
                                <option value="Quản lý">Quản lý</option>
                                <option value="Nhân Viên bán hàng">Nhân viên bán hàng</option>
                                <option value="Nhân viên kho">Nhân viên kho</option>
                                <option value="Nhân viên giao hàng">Nhân viên giao hàng</option>
                                <option value="Nhân viên CSKH">Nhân viên CSKH</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_of_birth">Ngày sinh:</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" id="address" name="address">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="action-btn btn-delete" id="cancelBtn">Hủy</button>
                        <button type="submit" class="action-btn btn-view">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Chỉnh sửa thông tin nhân viên -->
    <div class="modal" id="editEmployeeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Chỉnh sửa nhân viên</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm" action="update_employee.php" method="POST">
                    <input type="hidden" id="edit-id" name="id">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-name">Họ và tên</label>
                            <input type="text" id="edit-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" id="edit-email" name="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-phone">Số điện thoại</label>
                            <input type="tel" id="edit-phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-position">Vị trí</label>
                            <select id="edit-position" name="position" required>
                                <option value="">Chọn vị trí</option>
                                <option value="Manager">Quản lý</option>
                                <option value="Sales Staff">Nhân viên bán hàng</option>
                                <option value="Warehouse Staff">Nhân viên kho</option>
                                <option value="Delivery Staff">Nhân viên giao hàng</option>
                                <option value="Customer Service">Nhân viên CSKH</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-date_of_birth">Ngày sinh:</label>
                            <input type="date" id="edit-date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-status">Trạng thái</label>
                            <select id="edit-status" name="status" required>
                                <option value="active">Đang làm</option>
                                <option value="inactive">Đã nghỉ làm</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit-address">Địa chỉ</label>
                        <input type="text" id="edit-address" name="address">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="action-btn btn-delete" id="cancelEditBtn">Hủy</button>
                        <button type="submit" class="action-btn btn-view">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Xem thông tin nhân viên -->
    <div class="modal" id="employeeDetailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thông tin nhân viên</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="employee-details">
                    <img alt="Avatar" class="employee-avatar-large">
                    <div class="employee-main-info">
                        <div class="employee-name-large"></div>
                        <div class="employee-position"></div>
                        <div class="employee-stats">
                            <div class="stat-item">
                                <div class="stat-value">0</div>
                                <div class="stat-label">Đơn hàng đã bán</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">5.0 ★</div>
                                <div class="stat-label">Đánh giá</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-email"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Số điện thoại:</div>
                    <div class="detail-tell" id="detail-phone"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Địa chỉ:</div>
                    <div class="detail-address"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Ngày sinh:</div>
                    <div class="detail-birthday"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Ngày tạo:</div>
                    <div class="detail-created"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Trạng thái:</div>
                    <div class="detail-status"><span class="employee-status"></span></div>
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
                            <td colspan="4" style="padding: 10px; text-align: center;">Không có dữ liệu</td>
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
        // Xử lý modal xem chi tiết nhân viên
        const employeeDetailModal = document.getElementById('employeeDetailModal');
        const closeDetailBtn = document.getElementById('closeDetailBtn');
        const closeBtns = document.querySelectorAll('.modal-close');

        // Mở modal xem chi tiết
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const employeeRow = this.closest('tr');
                //lấy dữ liệu
                const Avatar = (employeeRow.getAttribute('data-avatar').startsWith('../') ?
                    employeeRow.getAttribute('data-avatar') :
                    '../assets/avatar/employees/' + employeeRow.getAttribute('data-avatar')); // Ảnh đại diện
                const employeeName = employeeRow.querySelector('td:nth-child(1)').textContent; // Tên nhân viên
                const employeeEmail = employeeRow.querySelector('td:nth-child(2)').textContent; // Email
                const employeeTell = employeeRow.querySelector('td:nth-child(3)').textContent; // Số điện thoại
                const employeeAddress = employeeRow.getAttribute('data-address'); // Địa chỉ
                const employeeBirthday = employeeRow.getAttribute('data-birthday'); // Ngày sinh
                const created = employeeRow.querySelector('td:nth-child(5)').textContent; // Ngày tạo
                const status = employeeRow.querySelector('td:nth-child(6)').textContent; // Trạng thái
                // Hiển thị 
                document.querySelector('.employee-avatar-large').src = Avatar; //Hiển thị ảnh avatars
                document.querySelector('.employee-name-large').textContent = employeeName; //Hiển thị tên
                document.querySelector('.detail-email').textContent = employeeEmail; //Hiển thị email
                document.querySelector('.detail-tell').textContent = employeeTell; //Hiển thị số điện thoại
                document.querySelector('.detail-address').textContent = employeeAddress; // Hiển thị địa chỉ
                document.querySelector('.detail-birthday').textContent = employeeBirthday; // Hiển thị ngày sinh
                document.querySelector('.detail-created').textContent = created; // Hiển thị ngày tạo
                document.querySelector('.detail-status .employee-status').textContent = status; // Hiển thị trạng thái

                employeeDetailModal.style.display = 'flex';
            });
        });
        // Đóng modal
        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                employeeDetailModal.style.display = 'none';
            });
        });

        closeDetailBtn.addEventListener('click', () => {
            employeeDetailModal.style.display = 'none';
        });

        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === employeeDetailModal) {
                employeeDetailModal.style.display = 'none';
            }
        });


        // Xử lý modal thêm nhân viên
        const modal = document.getElementById('employeeModal');
        const addBtn = document.getElementById('addEmployeeBtn');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');

        addBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
        // Xử lý modal chỉnh sửa nhân viên
        const editModal = document.getElementById('editEmployeeModal');
        const editCloseBtn = editModal.querySelector('.modal-close');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        

        // Ánh xạ giá trị tiếng Việt sang tiếng Anh
        const positionMap = {
            'Quản lý': 'Manager',
            'Nhân viên bán hàng': 'Sales Staff',
            'Nhân viên kho': 'Warehouse Staff',
            'Nhân viên giao hàng': 'Delivery Staff',
            'Nhân viên CSKH': 'Customer Service'
        };

        // Mở modal chỉnh sửa khi click nút Sửa
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const employeeRow = this.closest('tr');

                // Lấy dữ liệu từ hàng
                const employeeId = employeeRow.getAttribute('data-id');
                const employeeName = employeeRow.querySelector('td:nth-child(1)').textContent;
                const employeeEmail = employeeRow.querySelector('td:nth-child(2)').textContent;
                const employeePhone = employeeRow.querySelector('td:nth-child(3)').textContent;
                const employeePosition = employeeRow.querySelector('td:nth-child(4)').textContent.trim();
                const employeeBirthday = employeeRow.getAttribute('data-birthday');
                const employeeAddress = employeeRow.getAttribute('data-address');
                const employeeStatus = employeeRow.querySelector('.employee-status').textContent === 'Đang làm' ? 'active' : 'inactive';

                // Điền dữ liệu vào form chỉnh sửa
                document.getElementById('edit-id').value = employeeId;
                document.getElementById('edit-name').value = employeeName;
                document.getElementById('edit-email').value = employeeEmail;
                document.getElementById('edit-phone').value = employeePhone;
                document.getElementById('edit-position').value = positionMap[employeePosition] || ''; // Ánh xạ giá trị
                document.getElementById('edit-date_of_birth').value = employeeBirthday;
                document.getElementById('edit-address').value = employeeAddress;
                document.getElementById('edit-status').value = employeeStatus;

                // Hiển thị modal
                editModal.style.display = 'flex';
            });
        });


        // Đóng modal chỉnh sửa
        editCloseBtn.addEventListener('click', () => {
            editModal.style.display = 'none';
        });

        cancelEditBtn.addEventListener('click', () => {
            editModal.style.display = 'none';
        });

        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === editModal) {
                editModal.style.display = 'none';
            }
        });

        // Xử lý tìm kiếm nhân viên
        const searchBox = document.querySelector('.search-box');
        searchBox.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.employees-table tbody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const phone = row.cells[2].textContent.toLowerCase();

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
            const rows = document.querySelectorAll('.employees-table tbody tr');

            rows.forEach(row => {
                const rowStatus = row.querySelector('.employee-status').classList.contains(
                    'status-active') ? 'active' : 'inactive';

                if (status === 'all' || status === rowStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
<?php require_once('../admin/footer/admin-footer.php'); ?>