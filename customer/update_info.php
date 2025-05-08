<?php
session_start();
require_once("../includes/database.php"); // Kết nối đến cơ sở dữ liệu

// Kiểm tra phương thức POST
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Phương thức không được phép!";
    exit();
}

// Lấy dữ liệu từ form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
// Lấy giá trị của gender
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;

// Kiểm tra giá trị hợp lệ của gender
if ($gender !== '1' && $gender !== '0') {
    echo "Giá trị giới tính không hợp lệ!";
    exit();
}

// Kiểm tra session người dùng
if (!isset($_SESSION['user']['id'])) {
    echo "Bạn cần đăng nhập để cập nhật thông tin!";
    exit();
}

$userId = $_SESSION['user']['id'];

// Xử lý upload avatar
$avatar = $_SESSION['user']['avatar'] ?? ''; // Avatar mặc định
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../assets/avatar/customes/';
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];

    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedExtensions)) {

        // Đặt tên file mới để tránh trùng lặp
        $newFileName = uniqid('avatar_customes', true) . '.' . $fileExtension;
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
        echo "Định dạng file không hợp lệ. Chỉ chấp nhận JPG, JPEG, PNG, GIF.";
        exit();
    }
}

// Cập nhật thông tin người dùng
$sql = "UPDATE customer 
        SET name = ?, email = ?, phone = ?, address = ?, avatar = ?, gender = ?
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssssi', $name, $email, $phone, $address, $avatar, $gender, $userId);

if ($stmt->execute()) {
    // Cập nhật session
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['phone'] = $phone;
    $_SESSION['user']['address'] = $address;
    $_SESSION['user']['avatar'] = $avatar;
    $_SESSION['user']['gender'] = $gender;

    // Chuyển hướng
    header('Location: account_customet.php?success=1');
    exit();
} else {
    echo "Cập nhật thông tin thất bại!";
    exit();
}
