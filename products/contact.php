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
    <style>
        :root {
            --black: #000000;
            --dark-gray: #2D3436;
            --white: #FFFFFF;
            --red: #FF0000;
            --neon-yellow: #FFF44F;
            --electric-blue: #00FFFF;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: var(--dark-gray);
        }

        .contact-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('../assets/images/contact-bg.jpg') center/cover;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            position: relative;
        }

        .contact-hero::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(90deg, var(--red), var(--electric-blue));
        }

        .contact-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .contact-info {
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-top: 5px solid var(--red);
        }

        .contact-info h2 {
            color: var(--black);
            font-size: 28px;
            margin-bottom: 20px;
            position: relative;
        }

        .contact-info h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--electric-blue);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: var(--red);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 15px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .info-item:hover .info-icon {
            background: var(--electric-blue);
            transform: rotate(360deg);
        }

        .info-text h3 {
            color: var(--black);
            margin: 0 0 5px 0;
            font-size: 18px;
        }

        .info-text p {
            margin: 0;
            color: var(--dark-gray);
        }

        .contact-form {
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-top: 5px solid var(--electric-blue);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--black);
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: var(--electric-blue);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 255, 255, 0.2);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            background: var(--red);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            background: var(--black);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3);
        }

        .map-container {
            margin-top: 50px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 5px solid var(--white);
            position: relative;
            width: 800px;
            height: 650;
            margin: 0 auto;
        }

        .map-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 2px solid var(--electric-blue);
            border-radius: 5px;
            pointer-events: none;
            z-index: 10;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--black);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s;
        }

        .social-link:hover {
            background: var(--red);
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .contact-container {
                grid-template-columns: 1fr;
            }

            .contact-hero {
                height: 200px;
            }
        }
    </style>
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
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.696997219741!2d105.84338987730047!3d21.004779739599755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac71294bf0ab%3A0xc7e2d20e5e04a9da!2zxJDhuqFpIEjhu41jIELDoWNoIEtob2EgSMOgIE7hu5lp!5e0!3m2!1svi!2sus!4v1746147903777!5m2!1svi!2sus"
            width="800"
            height="500" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy"
            ></iframe>
    </div>
</body>

</html>
<?php
require_once('../includes/footer.php');
?>