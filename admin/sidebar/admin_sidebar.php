<link rel="stylesheet" href="../assets/css/admin/manage_employees.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="admin-sidebar">
    <div class="sidebar-header">
        <div class="admin-name"><?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['name']) : 'Admin'; ?></div>
        <div class="admin-role">Quản trị viên</div>
    </div>

    <ul class="sidebar-menu">
        <?php
        // Lấy URL hiện tại
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>
        <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>"><i>📊</i> Tổng quan</a></li>
        <li><a href="../admin/manege_oder.php" class="<?php echo $current_page == 'manege_oder.php' ? 'active' : ''; ?>"><i>📦</i> Đơn hàng</a></li>
        <li><a href="../admin/manage_products.php" class="<?php echo $current_page == 'manage_products.php' ? 'active' : ''; ?>"><i>👕</i> Sản phẩm</a></li>
        <li><a href="../admin/manege_customer.php" class="<?php echo $current_page == 'manege_customer.php' ? 'active' : ''; ?>"><i>👥</i> Khách hàng</a></li>
        <li><a href="../admin/manage_employees.php" class="<?php echo $current_page == 'manage_employees.php' ? 'active' : ''; ?>"><i>👨‍💼</i> Nhân viên</a></li>
        <li><a href="../admin/cusromer_support.php" class="<?php echo $current_page == 'cusromer_support.php' ? 'active' : ''; ?>"><i class="fa-solid fa-comment"></i> Hỗ Trợ khách hàng</a></li>
        <li><a href="../admin/acount_admin.php" class="<?php echo $current_page == 'acount_admin.php' ? 'active' : ''; ?>"><i class="fa-solid fa-user"></i>Thông Tin tài Khoản</a></li>
        <li><a href="../admin/admin_setting.php" class="<?php echo $current_page == 'admin_setting.php' ? 'active' : ''; ?>"><i>⚙️</i> Cài đặt</a></li>
        <li>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>';
            } else {
                echo '<a href="../login/index.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>';
            }
            ?>
        </li>
    </ul>
</div>

<style>
    .sidebar-menu li a.active {
        background-color: red;
        color: white;
    }
</style>