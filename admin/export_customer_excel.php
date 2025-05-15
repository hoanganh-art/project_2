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

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Sử dụng CSV với delimiter là dấu phẩy (Excel nhận diện tốt hơn)
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=customers_export_" . date('Ymd_His') . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

// BOM UTF-8
echo "\xEF\xBB\xBF";

// Xuất tiêu đề cột (dùng dấu phẩy)
echo "ID,Tên,Email,Số điện thoại\n";

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