<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - SOÁI PHONG</title>
    <link rel="stylesheet" href="../assets/css/login/style.css">
    <style>
        .alert.alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.08);
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px);}
            to { opacity: 1; transform: translateY(0);}
        }
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
    
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'locked' && isset($_GET['message'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['message']) . '</div>';
        }
        ?>
        
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

    <script>
        // Ẩn thông báo lỗi sau 5 giây nếu có class 'alert-danger'
        const alertDanger = document.querySelector('.alert.alert-danger');
        if (alertDanger) {
            setTimeout(() => {
            alertDanger.style.display = 'none';
            }, 5000);
        }

        // Đoạn cũ vẫn giữ nếu muốn ẩn error-message khi có từ 'bị khóa'
        const errorMessage = document.querySelector('.error-message');
        if (errorMessage && errorMessage.textContent.includes('bị khóa')) {
            setTimeout(() => {
            errorMessage.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>