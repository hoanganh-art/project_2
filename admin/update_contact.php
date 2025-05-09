<?php
// update_contact.php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}

require_once('../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $address = $_POST['address'] ?? '';
    $phone_1 = $_POST['tell_1'] ?? '';
    $phone_2 = $_POST['tell_2'] ?? '';
    $email_1 = $_POST['email_1'] ?? '';
    $email_2 = $_POST['email_2'] ?? '';
    $map_url = $_POST['maps'] ?? '';
    $facebook_url = $_POST['facebook'] ?? '';
    $instagram_url = $_POST['instagram'] ?? '';
    $youtube_url = $_POST['youtube'] ?? '';
    $tiktok_url = $_POST['tiktok'] ?? '';

    // Lấy ID của admin đang thực hiện cập nhật
    $updated_by = $_SESSION['user']['id'] ?? null;

    // Chuẩn bị câu lệnh SQL để cập nhật thông tin liên hệ
    $sql = "UPDATE contact_settings SET 
            address = ?, 
            phone_1 = ?, 
            phone_2 = ?, 
            email_1 = ?, 
            email_2 = ?, 
            map_url = ?, 
            facebook_url = ?, 
            instagram_url = ?, 
            youtube_url = ?, 
            tiktok_url = ?, 
            updated_by = ? 
            WHERE id = 1"; // Giả sử chỉ có 1 bản ghi với id = 1

    $stmt = $conn->prepare($sql);

    // Kiểm tra và gán các giá trị NULL nếu trường rỗng
    $phone_2 = !empty($phone_2) ? $phone_2 : null;
    $email_2 = !empty($email_2) ? $email_2 : null;
    $map_url = !empty($map_url) ? $map_url : null;
    $facebook_url = !empty($facebook_url) ? $facebook_url : null;
    $instagram_url = !empty($instagram_url) ? $instagram_url : null;
    $youtube_url = !empty($youtube_url) ? $youtube_url : null;
    $tiktok_url = !empty($tiktok_url) ? $tiktok_url : null;

    $stmt->bind_param(
        "ssssssssssi",
        $address,
        $phone_1,
        $phone_2,
        $email_1,
        $email_2,
        $map_url,
        $facebook_url,
        $instagram_url,
        $youtube_url,
        $tiktok_url,
        $updated_by
    );

    if ($stmt->execute()) {
        // Cập nhật thành công
        $_SESSION['success_message'] = "Cập nhật thông tin liên hệ thành công!";
    } else {
        // Lỗi khi cập nhật
        $_SESSION['error_message'] = "Có lỗi xảy ra khi cập nhật thông tin liên hệ: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Chuyển hướng trở lại trang quản lý thông tin liên hệ
    header("Location: admin_setting.php");
    exit();
} else {
    // Nếu không phải method POST, chuyển hướng về trang chủ
    header("Location: ../index.php");
    exit();
}
