<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhân Viên | SOÁI PHONG</title>
    <link rel="shortcut icon" href="../assets/image/logo.ico"
        type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/account.css">
    <link rel="stylesheet"
        href="../assets/css/Custome/account_customet.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    echo '<img src="../assets/avatar/avatarmd.jpg" alt="Default Avatar">';
                }
                ?>
            </div>
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
        <br>
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
                <a href="order_history.php">
                    <i class="fas fa-boxes"></i>
                    <span>Lịch sử mua hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="account.php" class="active">
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
        <div class="account-content">
            <div class="account-section">
                <h2>Thông tin cá nhân</h2>

                <div id="notification" style="display:none; padding:10px; background:#4CAF50; color:white;">
                    Cập nhập thông tinh thành công!
                </div>

                <form id="infoForm" action="update_info.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <?php

                        $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Tên của bạn';
                        ?>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <?php

                        $email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : 'Email của bạn';
                        ?>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <?php

                        $phone = isset($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : 'Số điện thoại của bạn';
                        ?>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <div class="gender-options">
                            <label>
                            <input type="radio" name="gender" value="1" <?php echo (isset($_SESSION['user']['gender']) && $_SESSION['user']['gender'] == '1') ? 'checked' : ''; ?>>
                                <span>Nam</span>
                            </label>
                            <label>
                            <input type="radio" name="gender" value="0" <?php echo (isset($_SESSION['user']['gender']) && $_SESSION['user']['gender'] == '0') ? 'checked' : ''; ?>>
                                <span>Nữ</span>
                            </label>
                        </div>
                        <style>
                            .gender-options {
                                display: flex;
                                gap: 20px;
                                align-items: center;
                            }
                            .gender-options label {
                                display: flex;
                                align-items: center;
                                gap: 5px;
                                font-size: 16px;
                                cursor: pointer;
                            }
                            .gender-options input[type="radio"] {
                                accent-color:rgb(219, 0, 0);
                            }
                        </style>

                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <?php
                        $address = isset($_SESSION['user']['address']) ? $_SESSION['user']['address'] : 'Địa chỉ của bạn';
                        ?>
                        <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($address) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar:</label>
                        <?php
                        $avatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'Avatar của bản';
                        ?>
                        <input type="file" src="" alt="" name="avatar" id="avatar" value="<?php echo htmlspecialchars($avatar); ?>" accept="image/*">
                    </div>
                    <button type="submit" class="btn-primary" id="btnSuccess">Cập nhật thông
                        tin</button>
                </form>
            </div>

            <div class="account-section">
                <h2>Đổi mật khẩu</h2>
                <div id="notification" style="display:none; padding:10px; background:#4CAF50; color:white;">
                    Cập nhập Mật khẩu thành công!
                </div>
                <form id="passwordForm" action="change_password.php" method="POST">
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
</body>
<script>
    // Hiển thị/ẩn mật khẩu
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

        // Ẩn thông báo sau 3 giây
        setTimeout(() => {
            noti.style.display = 'none';
        }, 3000);
    });
</script>

</html>