<?php require_once('../admin/header/admin-header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản Admin</title>
    <link rel="stylesheet" href="../../assets/css/admin/manage_employees.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/admin/account/account_admin.css">
</head>
<body>
    <div class="admin-container">
        <?php require_once('../admin/sidebar/admin_sidebar.php'); ?>
        <div class="main-content">
            <div class="account-content">
                <div class="account-section">
                    <h2><i class="fas fa-user-cog"></i> Thông tin Admin</h2>

                    <div id="info-notification" class="alert alert-success" style="display:none;">
                        <i class="fas fa-check-circle"></i>
                        <span>Cập nhật thông tin thành công!</span>
                    </div>

                    <form id="infoForm" action="update_info.php" method="POST" enctype="multipart/form-data">
                        <div class="user-avatar">
                            <div class="avatar-preview">
                                <?php if(isset($_SESSION['user']['avatar']) && !empty($_SESSION['user']['avatar'])): ?>
                                    <img src="<?php echo htmlspecialchars($_SESSION['user']['avatar']); ?>" alt="Avatar">
                                <?php else: ?>
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="avatar-upload">
                                <label for="avatar">
                                    <i class="fas fa-camera"></i>
                                    <span>Thay đổi avatar</span>
                                </label>
                                <input type="file" name="avatar" id="avatar" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <?php
                            $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';
                            ?>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <?php
                            $email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';
                            ?>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <?php
                            $phone = isset($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : '';
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
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <?php
                            $address = isset($_SESSION['user']['address']) ? $_SESSION['user']['address'] : '';
                            ?>
                            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($address) ?>" required>
                        </div>
                        
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Cập nhật thông tin
                        </button>
                    </form>
                </div>

                <div class="account-section">
                    <h2><i class="fas fa-key"></i> Đổi mật khẩu</h2>
                    <div id="password-notification" class="alert alert-success" style="display:none;">
                        <i class="fas fa-check-circle"></i>
                        <span>Cập nhật mật khẩu thành công!</span>
                    </div>
                    <form id="passwordForm" action="change_password.php" method="POST">
                        <div class="form-group">
                            <label for="current_password">Mật khẩu hiện tại</label>
                            <input type="password" id="current_password" name="current_password" required>
                            <span class="toggle-password" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Mật khẩu mới</label>
                            <input type="password" id="new_password" name="new_password" required>
                            <span class="toggle-password" onclick="togglePassword('new_password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Xác nhận mật khẩu mới</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                            <span class="toggle-password" onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <button type="submit" class="btn-primary">
                            <i class="fas fa-key"></i>
                            Đổi mật khẩu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hiển thị/ẩn mật khẩu
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Hiển thị preview khi chọn ảnh avatar
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = document.querySelector('.avatar-preview');
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview">`;
                }
                
                reader.readAsDataURL(file);
            }
        });

        // Xử lý hiển thị thông báo sau khi submit form
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('update') && urlParams.get('update') === 'success') {
                const noti = document.getElementById('info-notification');
                noti.style.display = 'flex';
                setTimeout(() => {
                    noti.style.display = 'none';
                }, 3000);
            }
            
            if (urlParams.has('password') && urlParams.get('password') === 'success') {
                const noti = document.getElementById('password-notification');
                noti.style.display = 'flex';
                setTimeout(() => {
                    noti.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>