<?php
session_start();
include_once('../includes/database.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}
$sql_1 = "SELECT * FROM contact";
$stmt_1 = $conn->prepare($sql_1);
$stmt_1->execute();
$result = $stmt_1->get_result(); // Lấy kết quả truy vấn
$contacts = $result->fetch_all(MYSQLI_ASSOC);


function getContactStatusVN($status)
{
    switch ($status) {
        case 'active':
            return 'Mới';
        case 'inactive':
            return 'Đã giải quyết';
        case 'archived':
            return 'Đang xử lý';
        case 'deleted':
            return 'Đã xóa';
        default:
            return 'Không xác định';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hỗ Trợ Khách Hàng | SOÁI PHONG</title>
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/cusromer_support.css">
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include_once("../admin/header/admin-header.php"); ?>
    <div class="container">
        <?php include_once("../admin/sidebar/admin_sidebar.php"); ?>
        <div class="main-content">
            <div class="header">
                <h1>Hỗ Trợ Khách Hàng</h1>
            </div>

            <!-- Support Dashboard -->
            <div class="support-dashboard">
                <div class="support-card">
                    <h3>Yêu cầu mới</h3>
                    <p>
                        <?php
                        $newCount = 0;
                        foreach ($contacts as $contact) {
                            if ($contact['status'] === 'active') {
                                $newCount++;
                            }
                        }
                        echo $newCount;
                        ?>
                    </p>
                </div>
                <div class="support-card">
                    <h3>Đang chờ phản hồi</h3>
                    <p>
                        <?php
                        $pendingCount = 0;
                        foreach ($contacts as $contact) {
                            if ($contact['status'] === 'archived') {
                                $pendingCount++;
                            }
                        }
                        echo $pendingCount;
                        ?>
                    </p>
                </div>
                <div class="support-card">
                    <h3>Đã giải quyết hôm nay</h3>
                    <p>
                        <?php
                        $resolvedTodayCount = 0;
                        $today = date('Y-m-d');
                        foreach ($contacts as $contact) {
                            if ($contact['status'] === 'inactive' && strpos($contact['updated_at'], $today) === 0) {
                                $resolvedTodayCount++;
                            }
                        }
                        echo $resolvedTodayCount;
                        ?>
                    </p>
                </div>
            </div>

            <!-- Ticket List -->


            <div class="ticket-card">
                <?php foreach ($contacts as $contact): ?>
                    <div class="ticket-header">
                        <div class="ticket-info">
                            <div class="ticket-avatar">TV</div>
                            <div class="ticket-meta">
                                <h3><?php echo htmlspecialchars($contact['name']); ?> - #SW<?php echo htmlspecialchars($contact['id']); ?></h3>
                                <p>Vấn đề: <?php echo htmlspecialchars($contact['subject']); ?></p>
                            </div>
                        </div>
                        <span class="ticket-status status-new">
                            <?php echo getContactStatusVN($contact['status']); ?>
                        </span>
                    </div>

                    <div class="ticket-content">
                        <p><strong>Nội dung:</strong></p>
                        <p><?php echo htmlspecialchars($contact['message']) ?>.</p>
                    </div>

                    <div class="ticket-actions">
                        <span class="ticket-date">Gửi lúc: <?php echo htmlspecialchars($contact['created_at']); ?></span>
                        <button class="btn btn-primary">Phản hồi</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Response Form (hidden by default, shows when clicking "Phản hồi") -->
            <div class="response-form" style="display: none;">
                <h2>Phản hồi yêu cầu #12345</h2>
                <div class="form-group">
                    <label>Nội dung phản hồi</label>
                    <textarea
                        placeholder="Nhập nội dung phản hồi cho khách hàng..."></textarea>
                </div>
                <div class="form-actions">
                    <button class="btn btn-secondary">Hủy</button>
                    <button class="btn btn-primary">Gửi phản hồi</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("../admin/footer/admin-footer.php"); ?>
    <script>
        // Simple JavaScript to show/hide response form
        document.querySelectorAll('.btn-primary').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelector('.response-form').style.display = 'block';
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            });
        });

        document.querySelector('.btn-secondary').addEventListener('click', function() {
            document.querySelector('.response-form').style.display = 'none';
        });
    </script>
</body>

</html>