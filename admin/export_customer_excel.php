<?php
include_once("../includes/database.php");

// Lấy dữ liệu khách hàng
$sql = "SELECT id, name, email, phone FROM customer";
$result = $conn->query($sql);

// Tạo file Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=customers_export_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Xuất tiêu đề cột
echo "ID\tTên\tEmail\tSố điện thoại\n";

// Xuất dữ liệu
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row['id'] . "\t" . $row['name'] . "\t" . $row['email'] . "\t" . $row['phone'] . "\n";
    }
}

$conn->close();
exit;
?>