<?php
session_start();
require_once '../includes/database.php';

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

require_once('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - Clothing Store</title>
    <link rel="stylesheet" href="../assets/css/contact/contact.css">
</head>

<body>
    <!-- Hero Section -->
    <section class="contact-hero">
        <div>
            <h1 style="font-size: 42px; margin-bottom: 15px;">LIÊN HỆ VỚI CHÚNG TÔI</h1>
            <p style="font-size: 18px; max-width: 600px; margin: 0 auto;">Chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc,
                mọi nơi</p>
        </div>
    </section>

    <!-- Contact Content -->
    <div class="contact-container">
        <!-- Contact Info -->
        <div class="contact-info">
            <h2>Thông tin liên hệ</h2>

            <div class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-text">
                    <h3>Địa chỉ cửa hàng</h3>
                    <p><?php echo $address; ?></p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📞</div>
                <div class="info-text">
                    <h3>Điện thoại</h3>
                    <p><?php echo $phone_1; ?></p>
                    <p> <?php echo $phone_2; ?> </p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">✉️</div>
                <div class="info-text">
                    <h3>Email</h3>
                    <p><?php echo $email_1; ?></p>
                    <p><?php echo $email_2; ?></p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">⏰</div>
                <div class="info-text">
                    <h3>Giờ làm việc</h3>
                    <p>Thứ 2 - Thứ 6: 8:00 - 21:00</p>
                    <p>Thứ 7 - CN: 9:00 - 22:00</p>
                </div>
            </div>

            <div class="social-links">
                <a href="#" class="social-link">📱</a>
                <a href="#" class="social-link">💻</a>
                <a href="#" class="social-link">📸</a>
                <a href="#" class="social-link">🎥</a>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            <h2>Gửi tin nhắn cho chúng tôi</h2>
            <form>
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" class="form-control">
                </div>

                <div class="form-group">
                    <label for="subject">Chủ đề</label>
                    <input type="text" id="subject" class="form-control">
                </div>

                <div class="form-group">
                    <label for="message">Nội dung</label>
                    <textarea id="message" class="form-control" required></textarea>
                </div>

                <button type="submit" class="submit-btn">Gửi tin nhắn</button>
            </form>
        </div>
    </div>

    <!-- Google Map -->
    <div class="map-container">
        <iframe
            src="<?php echo $map_url; ?>"
            width="800"
            height="500"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"></iframe>
    </div>
</body>

</html>
<?php
require_once('../includes/footer.php');
?>