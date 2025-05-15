<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Access denied");
}

include_once("../includes/database.php");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, email, phone FROM customer";
$result = $conn->query($sql);

// Tạo file Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=customers_export_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// BOM UTF-8
echo "\xEF\xBB\xBF";

echo "\xEF\xBB\xBF"; // Thêm BOM UTF-8 để Excel nhận diện đúng định dạng
// Xuất tiêu đề cột
echo "ID\t | Tên | \tEmail |\tSố điện thoại\n";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Bao quanh mỗi giá trị bằng dấu ngoặc kép và phân cách bằng dấu phẩy
        $id = '"' . str_replace('"', '""', $row['id']) . '"';
        $name = '"' . str_replace('"', '""', $row['name']) . '"';
        $email = '"' . str_replace('"', '""', $row['email']) . '"';
        $phone = '"' . str_replace('"', '""', $row['phone']) . '"';
        
        echo "$id,$name,$email,$phone\n";
    }
} else {
    echo '"No records found","","",""'."\n";
}

$conn->close();
exit;
?>