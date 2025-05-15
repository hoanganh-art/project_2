<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}

//Truy Vấn cơ sở dữ liệu
require_once('../includes/database.php');
$sql = "SELECT * FROM contact_settings";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result(); // Lấy kết quả truy vấn
$contact = $result->fetch_assoc(); // Fetch a single row as an associative array
require_once('../admin/header/admin-header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/admin/manage_employees.css">
    <link rel="stylesheet" href="../../assets/css/admin/setting/style_setting.css">
</head>

<body>

    <div class="admin-container">
        <?php require_once('../admin/sidebar/admin_sidebar.php'); ?>
        <div class="form-container">
            <div class="section-header">
                <h2 class="section-title">Quản lý thông tin liên hệ</h2>
                <button id="editContactBtn" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Chỉnh sửa liên hệ
                </button>
            </div>

            <!-- Hiển thị thông tin liên hệ hiện tại -->
            <div class="contact-info" id="currentContactInfo">
                <div class="contact-info-item">
                    <span class="contact-info-label">Địa chỉ:</span>
                    <span class="contact-info-value" id="displayAddress"><?php echo isset($contact['address']) ? htmlspecialchars($contact['address']) : 'Chưa có thông tin'; ?></span>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-label">Điện thoại 1:</span>
                    <span class="contact-info-value" id="displayPhone1"><?php echo isset($contact['phone_1']) ? htmlspecialchars($contact['phone_1']) : 'Chưa có thông tin'; ?></span>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-label">Điện thoại 2:</span>
                    <span class="contact-info-value" id="displayPhone2"><?php  echo isset($contact['phone_2']) ? htmlspecialchars($contact['phone_2']) : 'Chưa có thông tin'; ?></span>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-label">Email 1:</span>
                    <span class="contact-info-value" id="displayEmail1"><?php echo isset($contact['email_1']) ? htmlspecialchars($contact['email_1']) : 'Chưa có thông tin'; ?></span>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-label">Email 2:</span>
                    <span class="contact-info-value" id="displayEmail2"><?php echo isset($contact['email_2']) ? htmlspecialchars($contact['email_2']) : 'Chưa có thông tin'; ?></span>
                </div>
                <div class="contact-info-item" style="display: flex; flex-direction: column; align-items: flex-start;">
                    <span class="contact-info-label">Bản đồ:</span>
                    <span class="contact-info-value">
                        <iframe
                            src="<?php echo htmlspecialchars($contact['map_url']); ?>"
                            width="500"
                            height="400"
                            style="border:0; border-radius: 10px;"
                            allowfullscreen=""
                            loading="lazy"></iframe>
                    </span>
                </div>
                <div class="social-media-section">
                    <h3>Mạng xã hội</h3>
                    <div class="social-media-icons">
                        <a href="<?php echo htmlspecialchars($contact['facebook_url']); ?>" id="displayFacebook" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="<?php echo htmlspecialchars($contact['instagram_url']) ?>" id="displayInstagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="<?php echo htmlspecialchars($contact['youtube_url']) ?>" id="displayYoutube" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="<?php echo htmlspecialchars($contact['tiktok_url']) ?>" id="displayTiktok" target="_blank"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <!-- Form chỉnh sửa thông tin liên hệ -->
            <div class="edit-contact-form" id="editContactForm">
                <form action="update_contact.php" method="POST" class="contact-form">
                    <div class="tetli">
                        <h2>Chỉnh sửa thông tin liên hệ</h2>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="address">Địa chỉ cửa hàng:</label>
                        <input type="text" id="address" name="address" placeholder="Nhập địa chỉ cửa hàng" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tell_1">Điện thoại 1:</label>
                            <input type="tel" id="tell_1" name="tell_1" placeholder="Nhập số điện thoại" required>
                        </div>

                        <div class="form-group">
                            <label for="tell_2">Điện thoại 2:</label>
                            <input type="tel" name="tell_2" id="tell_2" placeholder="Nhập số điện thoại (nếu có)">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email_1">Email 1:</label>
                            <input type="email" name="email_1" id="email_1" placeholder="Nhập email liên hệ" required>
                        </div>

                        <div class="form-group">
                            <label for="email_2">Email 2:</label>
                            <input type="email" name="email_2" id="email_2" placeholder="Nhập email liên hệ (nếu có)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="maps">Bản đồ (URL Google Maps):</label>
                        <input type="url" name="maps" id="maps" placeholder="Dán link bản đồ Google Maps">
                    </div>

                    <div class="social-media-section">
                        <h3>Mạng xã hội</h3>

                        <div class="form-group">
                            <label for="facebook">Facebook:</label>
                            <input type="url" name="facebook" id="facebook" placeholder="https://facebook.com/trang-cua-ban">
                        </div>

                        <div class="form-group">
                            <label for="instagram">Instagram:</label>
                            <input type="url" name="instagram" id="instagram" placeholder="https://instagram.com/trang-cua-ban">
                        </div>

                        <div class="form-group">
                            <label for="youtube">Youtube:</label>
                            <input type="url" name="youtube" id="youtube" placeholder="https://youtube.com/trang-cua-ban">
                        </div>

                        <div class="form-group">
                            <label for="tiktok">Tiktok:</label>
                            <input type="url" name="tiktok" id="tiktok" placeholder="https://tiktok.com/trang-cua-ban">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" id="cancelEditBtn" class="btn btn-secondary">Hủy bỏ</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thêm icon cho các trường input
            const fields = [{
                    id: 'address',
                    icon: 'fa-map-marker-alt'
                },
                {
                    id: 'tell_1',
                    icon: 'fa-phone'
                },
                {
                    id: 'tell_2',
                    icon: 'fa-phone'
                },
                {
                    id: 'email_1',
                    icon: 'fa-envelope'
                },
                {
                    id: 'email_2',
                    icon: 'fa-envelope'
                },
                {
                    id: 'maps',
                    icon: 'fa-map'
                },
                {
                    id: 'facebook',
                    icon: 'fa-facebook-f'
                },
                {
                    id: 'instagram',
                    icon: 'fa-instagram'
                },
                {
                    id: 'youtube',
                    icon: 'fa-youtube'
                },
                {
                    id: 'tiktok',
                    icon: 'fa-tiktok'
                }
            ];

            fields.forEach(field => {
                const input = document.getElementById(field.id);
                if (input) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'input-with-icon';
                    wrapper.style.position = 'relative';

                    input.parentNode.insertBefore(wrapper, input);
                    wrapper.appendChild(input);

                    const icon = document.createElement('i');
                    icon.className = `fas ${field.icon} input-icon`;
                    wrapper.appendChild(icon);
                }
            });

            // Xử lý hiển thị form chỉnh sửa
            const editContactBtn = document.getElementById('editContactBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            const editContactForm = document.getElementById('editContactForm');
            const currentContactInfo = document.getElementById('currentContactInfo');

            editContactBtn.addEventListener('click', function() {
                // Ẩn thông tin hiện tại và hiển thị form chỉnh sửa
                currentContactInfo.style.display = 'none';
                editContactForm.style.display = 'block';

                // Điền dữ liệu hiện tại vào form
                document.getElementById('address').value = document.getElementById('displayAddress').textContent;
                document.getElementById('tell_1').value = document.getElementById('displayPhone1').textContent;
                document.getElementById('tell_2').value = document.getElementById('displayPhone2').textContent;
                document.getElementById('email_1').value = document.getElementById('displayEmail1').textContent;
                document.getElementById('email_2').value = document.getElementById('displayEmail2').textContent;

                // Lấy URL từ thẻ a
                const mapLink = document.getElementById('displayMapLink').href;
                document.getElementById('maps').value = mapLink !== '#' ? mapLink : '';

                // Lấy URL từ các icon mạng xã hội
                document.getElementById('facebook').value = document.getElementById('displayFacebook').href !== '#' ?
                    document.getElementById('displayFacebook').href : '';
                document.getElementById('instagram').value = document.getElementById('displayInstagram').href !== '#' ?
                    document.getElementById('displayInstagram').href : '';
                document.getElementById('youtube').value = document.getElementById('displayYoutube').href !== '#' ?
                    document.getElementById('displayYoutube').href : '';
                document.getElementById('tiktok').value = document.getElementById('displayTiktok').href !== '#' ?
                    document.getElementById('displayTiktok').href : '';
            });

            cancelEditBtn.addEventListener('click', function() {
                // Ẩn form chỉnh sửa và hiển thị lại thông tin hiện tại
                editContactForm.style.display = 'none';
                currentContactInfo.style.display = 'block';
            });

            
        });
    </script>
</body>

</html>
<?php require_once('../admin/footer/admin-footer.php'); ?>