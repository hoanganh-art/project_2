<?php

require_once 'database.php';

$sql = "SELECT * FROM contact_settings";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$contact_info = $result->fetch_assoc();
if ($contact_info) {
    $address = $contact_info['address'];
    $phone_1 = $contact_info['phone_1'];
    $phone_2 = $contact_info['phone_2'];
    $email_1 = $contact_info['email_1'];
    $email_2 = $contact_info['email_2'];
    $map_url = $contact_info['map_url'];
    $facebook_url = $contact_info['facebook_url'];
    $instagram_url = $contact_info['instagram_url'];
    $youtube_url = $contact_info['youtube_url'];
    $tiktok_url = $contact_info['tiktok_url'];
} else {
    // Nếu không có thông tin liên hệ, có thể xử lý theo cách khác
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streetwear Footer</title>
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">SOÁI<span> PHONG</span></div>
                <p>Chúng tôi mang đến những sản phẩm streetwear chất lượng nhất, đậm chất urban style dành cho giới trẻ năng động.</p>

                <div class="social-media">
                    <a href="<?php echo $facebook_url ?>" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo $instagram_url; ?>" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo $tiktok_url; ?>" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    <a href="<?php echo $youtube_url ;?>" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h3 class="footer-title">Liên kết nhanh</h3>
                <ul>
                    <li><a href="../index.php">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm mới</a></li>
                    <li><a href="#">Bán chạy</a></li>
                    <li><a href="#">Khuyến mãi</a></li>
                    <li><a href="#">Bộ sưu tập</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3 class="footer-title">Hỗ trợ</h3>
                <ul>
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Hướng dẫn mua hàng</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản dịch vụ</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h3 class="footer-title">Liên hệ</h3>
                <p><i class="fas fa-map-marker-alt"></i><?php echo $address; ?></p>
                <p><i class="fas fa-phone-alt"></i> <?php echo $phone_1; ?></p>
                <p><i class="fas fa-envelope"></i> <?php echo $email_1; ?></p>
                <p><i class="fas fa-clock"></i> Mở cửa: 8:00 - 22:00 (T2 - CN)</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 SOÁI PHONG. Bảo lưu mọi quyền.</p>
        </div>
    </footer>
</body>

</html>