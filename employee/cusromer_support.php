<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỗ Trợ Khách Hàng | SOÁI PHONG</title>
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/cusromer_support.css">
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <h2>SOÁI<span> PHONG</span></h2>
            <p style="color: var(--gray); font-size: 12px;">Nhân viên hỗ
                trợ</p>
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
                <a href="cusromer_support.php" class="active">
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
            <h1>Hỗ Trợ Khách Hàng</h1>
            <div class="user-profile">
            <?php
                $avatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'https://randomuser.me/api/portraits/men/32.jpg';
                // Kiểm tra nếu avatar đã là URL đầy đủ
                $avatarSrc = (filter_var($avatar, FILTER_VALIDATE_URL)) ? $avatar : "../assets/avatar/" . htmlspecialchars($avatar);
                ?>
                <img src="<?php echo $avatarSrc; ?>" alt="Avatar" class="account-avatar">
                <?php
                $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Tên của bạn';
                ?>
                <span>Nhân viên: <?php echo htmlspecialchars($name); ?></span>
            </div>
        </div>

        <!-- Support Dashboard -->
        <div class="support-dashboard">
            <div class="support-card">
                <h3>Yêu cầu mới</h3>
                <p>8</p>
            </div>
            <div class="support-card">
                <h3>Đang chờ phản hồi</h3>
                <p>12</p>
            </div>
            <div class="support-card">
                <h3>Đã giải quyết hôm nay</h3>
                <p>5</p>
            </div>
        </div>

        <!-- Ticket List -->
        <div class="ticket-card">
            <div class="ticket-header">
                <div class="ticket-info">
                    <div class="ticket-avatar">TV</div>
                    <div class="ticket-meta">
                        <h3>Trần Văn B - #SW20230015</h3>
                        <p>Vấn đề: Đổi trả sản phẩm</p>
                    </div>
                </div>
                <span class="ticket-status status-new">Mới</span>
            </div>

            <div class="ticket-content">
                <p><strong>Nội dung:</strong></p>
                <p>Xin chào, tôi đã nhận được áo hoodie đặt hàng nhưng bị
                    lỗi đường may. Tôi muốn đổi sang sản phẩm khác hoặc hoàn
                    tiền. Đơn hàng của tôi là #SW20230015.</p>
            </div>

            <div class="ticket-actions">
                <span class="ticket-date">Gửi lúc: 15/05/2023 14:30</span>
                <button class="btn btn-primary">Phản hồi</button>
            </div>
        </div>

        <div class="ticket-card">
            <div class="ticket-header">
                <div class="ticket-info">
                    <div class="ticket-avatar">LC</div>
                    <div class="ticket-meta">
                        <h3>Lê Thị C - #SW20230014</h3>
                        <p>Vấn đề: Theo dõi đơn hàng</p>
                    </div>
                </div>
                <span class="ticket-status status-pending">Đang xử lý</span>
            </div>

            <div class="ticket-content">
                <p><strong>Nội dung:</strong></p>
                <p>Tôi đã đặt hàng từ 3 ngày trước nhưng chưa thấy cập nhật
                    tình trạng vận chuyển. Shop có thể kiểm tra giúp đơn
                    hàng #SW20230014 được không?</p>

                <p
                    style="margin-top: 15px; padding: 10px; background-color: #F8F9FA; border-radius: 4px;">
                    <strong>Phản hồi của bạn:</strong> (15/05/2023
                    10:15)<br>
                    Chào chị, đơn hàng đã được đóng gói và sẽ được bên vận
                    chuyển lấy hàng trong ngày hôm nay ạ.
                </p>
            </div>

            <div class="ticket-actions">
                <span class="ticket-date">Cập nhật lần cuối: 15/05/2023
                    10:15</span>
                <button class="btn btn-primary">Tiếp tục phản hồi</button>
            </div>
        </div>

        <div class="ticket-card">
            <div class="ticket-header">
                <div class="ticket-info">
                    <div class="ticket-avatar">ND</div>
                    <div class="ticket-meta">
                        <h3>Nguyễn Văn D - #SW20230010</h3>
                        <p>Vấn đề: Hỏi về size đồ</p>
                    </div>
                </div>
                <span class="ticket-status status-resolved">Đã giải
                    quyết</span>
            </div>

            <div class="ticket-content">
                <p><strong>Nội dung:</strong></p>
                <p>Tôi cao 1m75, nặng 68kg thì nên mua size nào với áo
                    hoodie của shop?</p>

                <p
                    style="margin-top: 15px; padding: 10px; background-color: #F8F9FA; border-radius: 4px;">
                    <strong>Phản hồi của bạn:</strong> (14/05/2023
                    16:45)<br>
                    Chào anh, với chiều cao và cân nặng của anh thì nên chọn
                    size L là vừa đẹp ạ. Size này sẽ ôm vừa người nhưng
                    không quá chật.
                </p>

                <p
                    style="margin-top: 10px; padding: 10px; background-color: #E8F4FD; border-radius: 4px;">
                    <strong>Khách hàng:</strong> (14/05/2023 17:30)<br>
                    Cảm ơn shop đã tư vấn, tôi sẽ đặt size L.
                </p>
            </div>

            <div class="ticket-actions">
                <span class="ticket-date">Đóng lúc: 14/05/2023 17:45</span>
                <button class="btn btn-secondary">Mở lại</button>
            </div>
        </div>

        <!-- Response Form (hidden by default, shows when clicking "Phản hồi") -->
        <div class="response-form" style="display: none;">
            <h2>Phản hồi yêu cầu #12345</h2>
            <div class="form-group">
                <label>Nội dung phản hồi</label>
                <textarea
                    placeholder="Nhập nội dung phản hồi cho khách hàng..."></textarea>
            </div>
            <div class="form-actions">
                <button class="btn btn-secondary">Hủy</button>
                <button class="btn btn-primary">Gửi phản hồi</button>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript to show/hide response form
        document.querySelectorAll('.btn-primary').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelector('.response-form').style.display = 'block';
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            });
        });

        document.querySelector('.btn-secondary').addEventListener('click', function() {
            document.querySelector('.response-form').style.display = 'none';
        });
    </script>
</body>

</html>