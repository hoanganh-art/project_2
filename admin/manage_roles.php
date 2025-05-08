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
    <title>Phân quyền - Admin Clothing Store</title>
    <link rel="stylesheet" href="../assets/css/admin/manage_roles.css">
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
                <li><a href="manage_employees.php"><i>👨‍💼</i> Nhân viên</a></li>
                <li><a href="manage_roles.php" class="active"><i>🔐</i> Phân quyền</a></li>
                <li><a href="#"><i>⚙️</i> Cài đặt</a></li>
                <li>
                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start(); // Khởi động session nếu chưa được khởi động
                    }
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
                <h1 class="page-title">Quản lý phân quyền</h1>
                <button class="btn-add" id="addRoleBtn">
                    <span>+</span> Thêm vai trò
                </button>
            </div>
            
            <div class="role-management">
                <div class="role-list">
                    <h3>Danh sách vai trò</h3>
                    <div class="role-item active">Quản trị viên</div>
                    <div class="role-item">Quản lý bán hàng</div>
                    <div class="role-item">Nhân viên bán hàng</div>
                    <div class="role-item">Quản lý kho</div>
                    <div class="role-item">Nhân viên giao hàng</div>
                </div>
                
                <div class="role-details">
                    <div class="role-header">
                        <div class="role-name">Quản trị viên</div>
                        <button class="btn-save">Lưu thay đổi</button>
                    </div>
                    
                    <div class="permission-categories">
                        <div class="permission-category">
                            <h4>Quản lý hệ thống</h4>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-system" checked disabled>
                                <label for="perm-system">Truy cập trang quản trị</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-settings" checked>
                                <label for="perm-settings">Cấu hình hệ thống</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-roles" checked>
                                <label for="perm-roles">Quản lý phân quyền</label>
                            </div>
                        </div>
                        
                        <div class="permission-category">
                            <h4>Quản lý sản phẩm</h4>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-product-view" checked>
                                <label for="perm-product-view">Xem sản phẩm</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-product-add" checked>
                                <label for="perm-product-add">Thêm sản phẩm</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-product-edit" checked>
                                <label for="perm-product-edit">Sửa sản phẩm</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-product-delete" checked>
                                <label for="perm-product-delete">Xóa sản phẩm</label>
                            </div>
                        </div>
                        
                        <div class="permission-category">
                            <h4>Quản lý đơn hàng</h4>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-order-view" checked>
                                <label for="perm-order-view">Xem đơn hàng</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-order-edit" checked>
                                <label for="perm-order-edit">Sửa đơn hàng</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-order-cancel" checked>
                                <label for="perm-order-cancel">Hủy đơn hàng</label>
                            </div>
                        </div>
                        
                        <div class="permission-category">
                            <h4>Quản lý khách hàng</h4>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-customer-view" checked>
                                <label for="perm-customer-view">Xem khách hàng</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-customer-edit" checked>
                                <label for="perm-customer-edit">Sửa thông tin</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-customer-delete" checked>
                                <label for="perm-customer-delete">Xóa khách hàng</label>
                            </div>
                        </div>
                        
                        <div class="permission-category">
                            <h4>Quản lý nhân viên</h4>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-employee-view" checked>
                                <label for="perm-employee-view">Xem nhân viên</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-employee-add" checked>
                                <label for="perm-employee-add">Thêm nhân viên</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-employee-edit" checked>
                                <label for="perm-employee-edit">Sửa nhân viên</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-employee-delete" checked>
                                <label for="perm-employee-delete">Xóa nhân viên</label>
                            </div>
                        </div>
                        
                        <div class="permission-category">
                            <h4>Báo cáo & thống kê</h4>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-report-view" checked>
                                <label for="perm-report-view">Xem báo cáo</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm-report-export" checked>
                                <label for="perm-report-export">Xuất báo cáo</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="user-assignment">
                        <h3>Nhân viên thuộc vai trò này</h3>
                        <div class="user-list">
                            <div class="user-card">
                                <img src="https://via.placeholder.com/40" alt="Avatar" class="user-avatar">
                                <div class="user-info">
                                    <div class="user-name">Nguyễn Văn Admin</div>
                                    <div class="user-email">admin@example.com</div>
                                </div>
                                <button class="btn-assign">Gỡ bỏ</button>
                            </div>
                            <div class="user-card">
                                <img src="https://via.placeholder.com/40" alt="Avatar" class="user-avatar">
                                <div class="user-info">
                                    <div class="user-name">Trần Thị Quản lý</div>
                                    <div class="user-email">manager@example.com</div>
                                </div>
                                <button class="btn-assign">Gỡ bỏ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Thêm vai trò mới -->
    <div class="modal" id="roleModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm vai trò mới</h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    <div class="form-group">
                        <label for="role-name">Tên vai trò</label>
                        <input type="text" id="role-name" name="role-name" required placeholder="Ví dụ: Quản lý kho">
                    </div>
                    <div class="form-group">
                        <label for="role-desc">Mô tả</label>
                        <input type="text" id="role-desc" name="role-desc" placeholder="Mô tả chức năng của vai trò">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="action-btn btn-delete" id="cancelBtn">Hủy</button>
                <button class="action-btn btn-view" id="saveBtn">Thêm vai trò</button>
            </div>
        </div>
    </div>
    <script>
        // Xử lý modal vai trò
        const roleModal = document.getElementById('roleModal');
        const addBtn = document.getElementById('addRoleBtn');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        
        // Mở modal thêm vai trò
        addBtn.addEventListener('click', () => {
            roleModal.style.display = 'flex';
        });
        
        // Đóng modal
        closeBtn.addEventListener('click', () => {
            roleModal.style.display = 'none';
        });
        
        cancelBtn.addEventListener('click', () => {
            roleModal.style.display = 'none';
        });
        
        // Lưu vai trò mới
        saveBtn.addEventListener('click', () => {
            const roleName = document.getElementById('role-name').value;
            if (roleName) {
                alert(`Đã thêm vai trò mới: ${roleName}`);
                roleModal.style.display = 'none';
                document.getElementById('roleForm').reset();
                
                // Giả lập thêm vai trò vào danh sách
                const roleList = document.querySelector('.role-list');
                const newRole = document.createElement('div');
                newRole.className = 'role-item';
                newRole.textContent = roleName;
                roleList.appendChild(newRole);
            }
        });
        
        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === roleModal) {
                roleModal.style.display = 'none';
            }
        });
        
        // Xử lý chọn vai trò
        document.querySelectorAll('.role-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.role-item').forEach(i => {
                    i.classList.remove('active');
                });
                this.classList.add('active');
                
                // Giả lập load quyền của vai trò được chọn
                document.querySelector('.role-name').textContent = this.textContent;
                
                // Hiển thị thông báo
                console.log(`Đã chọn vai trò: ${this.textContent}`);
            });
        });
        
        // Xử lý gỡ bỏ nhân viên khỏi vai trò
        document.querySelectorAll('.btn-assign').forEach(btn => {
            btn.addEventListener('click', function() {
                const userName = this.closest('.user-card').querySelector('.user-name').textContent;
                if (confirm(`Bạn có chắc muốn gỡ bỏ ${userName} khỏi vai trò này?`)) {
                    this.closest('.user-card').remove();
                    alert(`Đã gỡ bỏ ${userName} khỏi vai trò`);
                }
            });
        });
    </script>
</body>
</html>
<?php require_once('../admin/footer/admin-footer.php');?>