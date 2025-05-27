<?php
include_once("../includes/database.php");

// Lấy dữ liệu đơn hàng
$sql = "SELECT o.id, o.name AS customer_name, o.created_at, o.phone, o.total, o.status, o.payment_method
        FROM orders o
        ORDER BY o.id DESC";
$result = $conn->query($sql);

// Tạo file Excel với định dạng UTF-8 và phân tách cột bằng dấu phẩy
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=orders_export_" . date('Ymd_His') . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen('php://output', 'w');

// Thêm BOM UTF-8 để Excel nhận diện đúng định dạng
fwrite($output, "\xEF\xBB\xBF");

// Xuất tiêu đề cột
fputcsv($output, [
    'Mã đơn',
    'Khách hàng',
    'Ngày đặt',
    'Số điện thoại',
    'Tổng tiền',
    'Trạng thái',
    'Phương thức thanh toán'
], ',');

// Xuất dữ liệu
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Định dạng trạng thái
        $statusText = [
            'pending' => 'Chờ xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy'
        ];
        fputcsv($output, [
            '#' . str_pad($row['id'], 6, '0', STR_PAD_LEFT),
            $row['customer_name'],
            date('d/m/Y H:i', strtotime($row['created_at'])),
            $row['phone'],
            number_format($row['total'], 0, ',', '.') . 'đ',
            $statusText[$row['status']] ?? $row['status'],
            $row['payment_method']
        ], ',');
    }
}

fclose($output);
$conn->close();
exit;
?>