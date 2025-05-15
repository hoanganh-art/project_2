<?php
session_start(); // Ensure the session is started
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài Khoản | SOÁI PHONG</title>
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
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
                <a href="manage_orders.php">
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
                <a href="account.php" class="active">
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
            <h1>Tài Khoản Nhân Viên</h1>
        </div>
        <!-- Stats Cards -->
        <div class="account-tabs">
            <div class="tab active">Thông tin cá nhân</div>
            <div id="notification" style="display:none; padding:10px; background:#4CAF50; color:white;">
                Cập nhập thông tinh thành công!
            </div>
        </div>
        <div class="account-card">
            <div class="account-header">
                <?php
                $avatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'https://randomuser.me/api/portraits/men/32.jpg';
                // Kiểm tra nếu avatar đã là URL đầy đủ
                $avatarSrc = (filter_var($avatar, FILTER_VALIDATE_URL)) ? $avatar : "../../assets/avatar/employees" . htmlspecialchars($avatar);
                ?>
                <img src="<?php echo $avatarSrc; ?>" alt="Avatar" class="account-avatar">
                <div class="account-title">
                    <?php
                    $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Tên của bạn';
                    $position = isset($_SESSION['user']['position']) ? $_SESSION['user']['position'] : 'Chức vụ của bạn';
                    $created_at = isset($_SESSION['user']['created_at']) ? $_SESSION['user']['created_at'] : 'Ngày tham gia';
                    ?>
                    <h2><?php echo htmlspecialchars($name); ?></h2>
                    <p><?php echo htmlspecialchars($position); ?> | Tham gia từ: <?php echo htmlspecialchars($created_at); ?></p>
                </div>
            </div>

            <form action="update_info.php" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <?php

                            $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Tên của bạn';
                            ?>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Email</label>
                            <?php
                            $email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : 'Email của bạn';
                            ?>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <?php
                            $phone = isset($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : 'Số điện thoại của bạn';
                            ?>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <?php
                            $birthdate = isset($_SESSION['user']['date_of_birth']) ? $_SESSION['user']['date_of_birth'] : 'Ngày sinh của bạn';
                            ?>
                            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($birthdate); ?>" required>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>Địa chỉ</label>
                    <?php

                    $address = isset($_SESSION['user']['address']) ? $_SESSION['user']['address'] : 'Địa chỉ của bạn';
                    ?>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
                </div>

                <div class="form-group">
                    <label>Avatar:</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*">
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <b>Chức vụ:</b>
                            <?php
                            $position = isset($_SESSION['user']['position']) ? $_SESSION['user']['position'] : 'Chức vụ của bạn';
                            ?>
                            <output><?php echo htmlspecialchars($position); ?></output>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <b>Trạng thái:</b>
                            <?php
                            $status = isset($_SESSION['user']['status']) ? $_SESSION['user']['status'] : 'Trạng thái chưa xác định';
                            $statusText = '';
                            switch ($status) {
                                case 'active':
                                    $statusText = 'Hoạt động';
                                    break;
                                case 'inactive':
                                    $statusText = 'Không hoạt động';
                                    break;
                                case 'suspended':
                                    $statusText = 'Bị đình chỉ';
                                    break;
                                default:
                                    $statusText = 'Trạng thái chưa xác định';
                                    break;
                            }
                            ?>
                            <output><?php echo htmlspecialchars($statusText); ?></output>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="btnSuccess">Lưu thay đổi</button>
                </div>
            </form>
            <div class="account-section">
                <h2>Đổi mật khẩu</h2>
                <div id="notification" style="display:none; padding:10px; background:#4CAF50; color:white;">
                    Cập nhập thông tinh thành công!
                </div>
                <div class="alert alert-success" id="pass-success"
                    style="display: none;">
                    Đổi mật khẩu thành công!
                </div>

                <div class="alert alert-danger" id="pass-error"
                    style="display: none;">
                    Mật khẩu hiện tại không đúng!
                </div>

                <form id="passwordForm" method="POST" action="change_password.php">
                    <div class="form-group">
                        <label for="current_password">Mật khẩu hiện
                            tại</label>
                        <input type="password" id="current_password"
                            name="current_password" required>
                        <span class="toggle-password"
                            onclick="togglePassword('current_password')">👁️</span>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Mật khẩu mới</label>
                        <input type="password" id="new_password"
                            name="new_password" required>
                        <span class="toggle-password"
                            onclick="togglePassword('new_password')">👁️</span>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu
                            mới</label>
                        <input type="password" id="confirm_password"
                            name="confirm_password" required>
                        <span class="toggle-password"
                            onclick="togglePassword('confirm_password')">👁️</span>
                    </div>

                    <button type="submit" class="btn-primary" id="btnSuccess">Đổi mật
                        khẩu</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling;

            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '👁️‍🗨️';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }

        document.getElementById('btnSuccess').addEventListener('click', function() {
            const noti = document.getElementById('notification');
            noti.style.display = 'block';


            setTimeout(() => {
                noti.style.display = 'none';
            }, 120000);
        });
    </script>
</body>

</html>