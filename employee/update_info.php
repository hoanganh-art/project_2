<?php
session_start();
require_once("../includes/database.php"); // Kết nối đến cơ sở dữ liệu

// Kiểm tra trạng thái đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: ../login/index.php');
    exit();
}

// Kiểm tra phương thức POST
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Yêu cầu không hợp lệ!");
}

// Lấy dữ liệu từ form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$date_of_birth = $_POST['date_of_birth'] ?? '';
$address = $_POST['address'] ?? '';
$avatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : '';



if (!isset($_SESSION['user']['id'])) {
    echo "Bạn cần đăng nhập để cập nhật thông tin!";
    exit();
}
$userId = $_SESSION['user']['id'];

$avatar = $_SESSION['user']['avatar'] ?? ''; // Avatar mặc định

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../assets/avatar/employees/';
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];

    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

      // Kiểm tra định dạng file

      if (in_array($fileExtension, $allowedExtensions)) {
        // Đặt tên file mới để tránh trùng lặp
        $newFileName = uniqid('avatar_employess', true) . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
            chmod($uploadDir, 0755);
        }

        // Di chuyển file vào thư mục đích
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $avatar = $destPath;
        } else {
            echo "Lỗi khi lưu file.";
            exit();
        }
    } else {
        echo "Định dạng file không hợp lệ!";
        exit();
    }
}

// Cập nhật thông tin người dùng

 $sql = "UPDATE employees 
           SET name = ?, email = ?, phone = ?, date_of_birth = ?, address = ?, avatar = ?
WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssssi', $name, $email, $phone, $date_of_birth, $address, $avatar, $userId);


if ($stmt->execute()) {
        // Cập nhật session với thông tin mới
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['date_of_birth'] = $date_of_birth;
        $_SESSION['user']['address'] = $address;
        $_SESSION['user']['avatar'] = $avatar;
        // Chuyển hướng hoặc hiển thị thông báo thành công
        header('Location: account.php?success=1');
        exit();
//     
}
} else {
    echo "Cập nhật thông tin thất bại!";
    exit();
}

