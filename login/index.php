<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - SOÁI PHONG</title>
    <link rel="stylesheet" href="../assets/css/login/style.css">
    <style>
        
    </style>
</head>
<body>
    <?php require_once("../includes/header.php");?>
    <div class="login-container">
        <h1 class="login-title">ĐĂNG NHẬP</h1>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="error-message">
                <?php 
                    if($_GET['error'] == 'invalid') {
                        echo "Email hoặc mật khẩu không đúng!";
                    } elseif($_GET['error'] == 'empty') {
                        echo "Vui lòng điền đầy đủ thông tin!";
                    }
                ?>
            </div>
        <?php endif; ?>
        
        <form action="suly.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn">ĐĂNG NHẬP</button>
        </form>
        
        <div class="register-link">
            Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
        </div>
    </div>
    <?php require_once("../includes/footer.php");?>
</body>
</html>