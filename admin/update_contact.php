<?php
session_start();
require_once('../includes/database.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die(json_encode(['status' => 'error', 'message' => 'Unauthorized access']));
}

$response = ['status' => 'error', 'message' => 'Invalid request'];

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy và validate dữ liệu
        $address = $_POST['address'] ?? '';
        $phone_1 = $_POST['tell_1'] ?? '';
        $phone_2 = $_POST['tell_2'] ?? '';
        $email_1 = $_POST['email_1'] ?? '';
        $email_2 = $_POST['email_2'] ?? '';
        $maps = $_POST['maps'] ?? '';
        $facebook = $_POST['facebook'] ?? '';
        $instagram = $_POST['instagram'] ?? '';
        $youtube = $_POST['youtube'] ?? '';
        $tiktok = $_POST['tiktok'] ?? '';

        // Thực hiện update
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
            updated_at = NOW(),
            updated_by = ?
            WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $address, $phone_1, $phone_2, $email_1, $email_2, $maps, $facebook, $instagram, $youtube, $tiktok, $_SESSION['user']['id'], $_POST['id']);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = ['status' => 'success', 'message' => 'Contact settings updated successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'No changes made or update failed'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid request method'];
    }
} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()];
} finally {
    echo json_encode($response);
    exit;
}
?>
