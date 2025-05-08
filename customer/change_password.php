<?php
session_start();
require_once("../includes/database.php"); // Kết nối đến cơ sở dữ liệu

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if(isset($_SESSION['user']['id'])){
        $userId = $_SESSION['user']['id'];

        // Kiểm tra mật khẩu cũ
        $sql = "SELECT password FROM customers WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        if(password_verify($password, $hashed_password)){
            if($new_password === $confirm_password){
                // Cập nhật mật khẩu mới
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE customers SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $new_hashed_password, $userId);

                header('Location: account_customet.php?success=1');

                if($stmt->execute()){
                    header('Location: account_customet.php?success=1');
                    echo "Cập nhật mật khẩu thành công!";
                } else {
                    header('Location: account_customet.php?success=1');
                    echo "Cập nhật mật khẩu thất bại!";
                }
            } else {
                header('Location: account_customet.php?success=1');
                echo "Mật khẩu xác nhận không khớp!";
            }
        } else {
            header('Location: account_customet.php?success=1');
            echo "Mật khẩu cũ không đúng!";
        }
    } else {
        header('Location: account_customet.php?success=1');
        echo "Bạn cần đăng nhập để thay đổi mật khẩu!";
    }
}
?>