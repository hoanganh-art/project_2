<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('database.php');

// Khởi tạo biến để lưu số lượng sản phẩm
$cart_count = 0;

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user']['id'])) {
    $customer_id = $_SESSION['user']['id'];
    
    // Truy vấn chỉ đếm sản phẩm của khách hàng hiện tại
    $sql = "SELECT COUNT(*) AS total_cart_items FROM cart WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $row = $result->fetch_assoc()) {
        $cart_count = $row['total_cart_items'];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng quần áo Soái Phong</title>
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header class="header">
        <div class="logo">SOÁI<span> PHONG</span></div>

        <nav class="nav-menu">
            <a href="../index.php">Trang chủ</a>
            <a href="../products/product.php">Sản phẩm</a>
            <a href="#">Tin tức</a>
            <a href="../products/contact.php">Liên hệ</a>
        </nav>

        <div class="header-right">
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm...">
                <button>🔍</button>
            </div>

            <div class="cart-icon">
                🛒
                <span class="cart-count">
                    <?php echo htmlspecialchars($cart_count); ?>
                </span>
            </div>

            <div class="user-icon">
                <i class="fas fa-user-cog"></i>
            </div>
        </div>
    </header>
    <script>
        document.querySelector('.user-icon').addEventListener('click', function() {
            window.location.href = '../customer/account_customet.php';
        });

        document.querySelector('.cart-icon').addEventListener('click', function() {
            window.location.href = '../customer/cart1.php';
        });


        //Xử lý tìm kiếm theo tên sản phẩm
        document.querySelector('.search-box button').addEventListener('click', function() {
            const query = document.querySelector('.search-box input').value.trim();
            if (query) {
                window.location.href = '../products/product.php?search=' + encodeURIComponent(query);
            }
        });

        document.querySelector('.search-box input').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    window.location.href = '../products/product.php?search=' + encodeURIComponent(query);
                }
            }
        });
    </script>
</body>
</html>