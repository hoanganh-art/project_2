<?php
session_start();
require_once('../includes/header.php');
require_once('../includes/database.php'); // Đảm bảo đã kết nối DB

// Nếu là mua ngay (POST từ buy-now-form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_now'])) {
    $product_id = intval($_POST['product_id']);
    $color = $_POST['color'] ?? '';
    $size = $_POST['size'] ?? '';
    $quantity = intval($_POST['quantity']);

    // Lấy thông tin sản phẩm từ DB
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $carts = [[
            'id' => $product['id'],
            'name' => $product['name'] . " ({$color}, {$size})",
            'price' => $product['price'],
            'quantity' => $quantity,
        ]];
    } else {
        $carts = [];
    }
} else {
    // Lấy giỏ hàng từ session (mua nhiều sản phẩm)
    $carts = $_SESSION['cart_items'] ?? [];
}

// Xử lý khi submit đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['address'], $_POST['phone'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];
    $notes = $_POST['notes'] ?? '';
    $order_date = date('Y-m-d H:i:s');
    $total = 0;

    // Lấy giỏ hàng từ session
    $cart_items = $_SESSION['cart_items'] ?? [];

    // Tính tổng tiền
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    $shippingFee = ($total > 500000) ? 0 : 30000;
    $discount = 130000;
    $finalTotal = $total - $discount + $shippingFee;

    // Lưu khách hàng (nếu chưa có)
    $stmt = $conn->prepare("INSERT INTO customer (name, address, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $phone);
    $stmt->execute();
    $customer_id = $conn->insert_id;

    // Lưu đơn hàng
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, order_date, total, payment_method, notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $customer_id, $order_date, $finalTotal, $payment_method, $notes);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // Lưu chi tiết đơn hàng
    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdi", $order_id, $item['id'], $item['name'], $item['price'], $item['quantity']);
        $stmt->execute();
    }

    // Xóa giỏ hàng sau khi đặt hàng
    unset($_SESSION['cart_items']);

    // Thông báo thành công
    echo "<script>alert('Đặt hàng thành công!');window.location='checkout.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/Custome/checkout.css">
</head>

<body>
    <div class="container">
        <div class="container">
            <h1 class="checkout-title">Thanh toán đơn hàng</h1>

            <div class="checkout-container">
                <div class="checkout-summary">
                    <h2>Thông tin giỏ hàng</h2>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody id="cartItemsBody">
                            <?php
                            $grandTotal = 0;
                            foreach ($carts as $item):
                                $itemTotal = $item['price'] * $item['quantity'];
                                $grandTotal += $itemTotal;



                            ?>

                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.') . 'đ'; ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td><?php echo number_format($itemTotal, 0, ',', '.') . 'đ'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Phí vận chuyển:</td>
                                <td id="shippingFee"></td>
                            </tr>
                            <tr>
                                <td colspan="3">Giảm giá:</td>
                                <td id="discount"></td>
                            </tr>

                            <tr>
                                <td colspan="3">Tổng cộng:</td>
                                <td id="cartTotal"><?php echo number_format($grandTotal, 0, ',', '.') . 'đ'; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="checkout-form">
                    <h2>Thông tin giao hàng</h2>
                    <form id="checkoutForm" method="POST" action="checkout.php">
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" id="name" name="name"
                                value="<?php echo !empty($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ giao hàng</label>
                            <textarea id="address" name="address" required><?php
                                                                            echo !empty($_SESSION['user']['address']) ? htmlspecialchars($_SESSION['user']['address']) : '';
                                                                            ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone"
                                value="<?php echo !empty($_SESSION['user']['phone']) ? htmlspecialchars($_SESSION['user']['phone']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="payment_method">Phương thức thanh
                                toán</label>
                            <select id="payment_method" name="payment_method"
                                required>
                                <option value="cod">Thanh toán khi nhận hàng
                                    (COD)</option>
                                <option value="bank_transfer">Chuyển khoản ngân
                                    hàng</option>
                                <option value="momo">Ví điện tử MoMo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes">Ghi chú đơn hàng</label>
                            <textarea id="notes" name="notes"
                                placeholder="Ghi chú về đơn hàng của bạn..."></textarea>
                        </div>

                        <button type="submit" class="checkout-button">Đặt
                            hàng</button>
                    </form>
                </div>
            </div>
        </div>
</body>
<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Lấy dữ liệu từ form
        const formData = {
            name: document.getElementById('name').value,
            address: document.getElementById('address').value,
            phone: document.getElementById('phone').value,
            payment_method: document.getElementById('payment_method').value,
            notes: document.getElementById('notes').value
        };

        // Hiển thị thông báo (thay bằng AJAX call trong thực tế)
        alert(`Đặt hàng thành công!\nPhương thức thanh toán: ${formData.payment_method}\nĐơn hàng sẽ được giao đến: ${formData.address}`);
    });
    // Lấy tổng tiền hàng từ PHP đã render sẵn
    const cartTotalElement = document.getElementById('cartTotal');
    const cartTotalRaw = <?php echo $grandTotal; ?>;

    // Tính tổng thanh toán khi có phí vận chuyển và giảm giá
    let shippingFee = 30000;
    if (cartTotalRaw > 500000) {
        shippingFee = 0;
    }
    const discount = 130000;

    // Hiển thị phí vận chuyển và giảm giá lên bảng
    document.getElementById('shippingFee').textContent = shippingFee.toLocaleString('vi-VN') + 'đ';
    document.getElementById('discount').textContent = '-' + discount.toLocaleString('vi-VN') + 'đ';

    // Tính tổng cộng cuối cùng
    const finalTotal = cartTotalRaw - discount + shippingFee;
    cartTotalElement.textContent = finalTotal.toLocaleString('vi-VN') + 'đ';
</script>

</html>

<?php
require_once('../includes/footer.php');
?>