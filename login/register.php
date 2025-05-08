
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Clothing Store</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .register-container {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #FF0000;
            border-radius: 10px;
            box-shadow: 0 0 20px #FF0000;
            padding: 30px;
            width: 400px;
            margin: 80px auto;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .register-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(0, 255, 255, 0.1),
                rgba(255, 0, 0, 0.1),
                rgba(255, 244, 79, 0.1)
            );
            transform: rotate(45deg);
            z-index: -1;
        }
        
        .register-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #00FFFF;
            text-shadow: 0 0 10px #FFF44F;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #FFFFFF;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #2D3436;
            border-radius: 5px;
            background: rgba(45, 52, 54, 0.7);
            color: white;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            border-color: #FFF44F;
            box-shadow: 0 0 10px #FFF44F;
            outline: none;
            background: rgba(45, 52, 54, 0.9);
        }
        
        .register-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #00FFFF, #FFF44F);
            border: none;
            border-radius: 5px;
            color: #000000;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .register-btn:hover {
            background: linear-gradient(to right, #FFF44F, #00FFFF);
            box-shadow: 0 0 15px #00FFFF;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #CCCCCC;
        }
        
        .login-link a {
            color: #FF0000;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .login-link a:hover {
            color: #FFF44F;
            text-shadow: 0 0 5px #00FFFF;
        }
        
        .error-message {
            color: #FF0000;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .success-message {
            color: #00FFFF;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="register-container">
        <h1 class="register-title">ĐĂNG KÝ TÀI KHOẢN</h1>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="error-message">
                <?php 
                    if($_GET['error'] == 'email_exists') {
                        echo "Email đã được sử dụng!";
                    } elseif($_GET['error'] == 'empty') {
                        echo "Vui lòng điền đầy đủ thông tin!";
                    } elseif($_GET['error'] == 'password_mismatch') {
                        echo "Mật khẩu không khớp!";
                    }
                ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['success']) && $_GET['success'] == '1'): ?>
            <div class="success-message">
                Đăng ký thành công! Vui lòng đăng nhập.
            </div>
        <?php endif; ?>
        
        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Nhập lại mật khẩu</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" name="address" required>
            </div>
            
            <button type="submit" class="register-btn">ĐĂNG KÝ</button>
        </form>
        
        <div class="login-link">
            Đã có tài khoản? <a href="index.php">Đăng nhập ngay</a>
        </div>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>