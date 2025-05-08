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
                <span class="cart-count">3</span>
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
    </script>
</body>

</html>