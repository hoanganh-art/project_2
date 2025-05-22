<?php
session_start();
require_once('../includes/header.php');
require_once('../includes/database.php');

// Xử lý khi là mua ngay
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
        // Khi thêm vào giỏ hàng
        $carts = [[
            'product_id' => $product['id'],
            'name' => $product['name'] . " ({$color}, {$size})",
            'price' => $product['price'],
            'quantity' => $quantity,
            'color' => $color,
            'size' => $size,
            'image' => $product['image'] ?? '',
        ]];
        $_SESSION['cart_items'] = $carts;
    } else {
        $carts = [];
    }
} else {
    // Lấy giỏ hàng từ session
    $carts = $_SESSION['cart_items'] ?? [];
}

// Xử lý khi submit đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['address'], $_POST['phone'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'] ?? '';
    $payment_method = $_POST['payment_method'];
    $notes = $_POST['notes'] ?? '';
    $order_date = date('Y-m-d H:i:s');
    $total = 0;

    // Tính tổng tiền từ giỏ hàng trong session
    $cart_items = $_SESSION['cart_items'] ?? [];
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    $shippingFee = ($total > 500000) ? 0 : 30000;
    $discount = 130000;
    $finalTotal = $total - $discount + $shippingFee;

    try {
        // Kiểm tra xem khách hàng đã tồn tại chưa
        $customer_id = null;
        if (!empty($email)) {
            $stmt = $conn->prepare("SELECT id FROM customer WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Khách hàng đã tồn tại - lấy ID
                $customer = $result->fetch_assoc();
                $customer_id = $customer['id'];
                
                // Cập nhật thông tin khách hàng nếu cần
                $stmt = $conn->prepare("UPDATE customer SET name = ?, address = ?, phone = ? WHERE id = ?");
                $stmt->bind_param("sssi", $name, $address, $phone, $customer_id);
                $stmt->execute();
            }
        }

        // Nếu khách hàng chưa tồn tại, thêm mới
        if (empty($customer_id)) {
            $stmt = $conn->prepare("INSERT INTO customer (name, address, phone, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $address, $phone, $email);
            $stmt->execute();
            $customer_id = $conn->insert_id;
        }

        // Lưu đơn hàng
        $stmt = $conn->prepare("INSERT INTO orders (customer_id, name, address, phone, total, payment_method, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssiss", $customer_id, $name, $address, $phone, $finalTotal, $payment_method, $notes);
        $stmt->execute();
        $order_id = $conn->insert_id;

        // Lưu chi tiết đơn hàng
        foreach ($cart_items as $item) {
            $color = $item['color'] ?? '';
            $size = $item['size'] ?? '';
            $image = $item['image'] ?? '';
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, color, size, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisdisss", $order_id, $item['product_id'], $item['name'], $item['price'], $item['quantity'], $color, $size, $image);
            $stmt->execute();
        }

        // Xóa giỏ hàng trong database
        if (!empty($customer_id)) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE customer_id = ?");
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart_items']);

        // Thông báo thành công và chuyển hướng về trang giỏ hàng
        echo "<script>alert('Đặt hàng thành công!'); window.location.href = 'cart1.php';</script>";
        exit;
    } catch (Exception $e) {
        // Xử lý lỗi nếu có
        $error = "Có lỗi xảy ra khi đặt hàng: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/Custome/checkout.css">
    <title>Thanh toán</title>
</head>
<body>
    <div class="container">
        <h1 class="checkout-title">Thanh toán đơn hàng</h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

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
                        <input type="text" id="name" name="name" value="<?php echo !empty($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ giao hàng</label>
                        <textarea id="address" name="address" required><?php echo !empty($_SESSION['user']['address']) ? htmlspecialchars($_SESSION['user']['address']) : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo !empty($_SESSION['user']['phone']) ? htmlspecialchars($_SESSION['user']['phone']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo !empty($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Phương thức thanh toán</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                            <option value="momo">Ví điện tử MoMo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">Ghi chú đơn hàng</label>
                        <textarea id="notes" name="notes" placeholder="Ghi chú về đơn hàng của bạn..."></textarea>
                    </div>

                    <button type="submit" class="checkout-button">Đặt hàng</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tính toán và hiển thị phí vận chuyển, giảm giá
        const cartTotalRaw = <?php echo $grandTotal; ?>;
        let shippingFee = cartTotalRaw > 500000 ? 0 : 30000;
        const discount = 130000;
        const finalTotal = cartTotalRaw - discount + shippingFee;

        document.getElementById('shippingFee').textContent = shippingFee.toLocaleString('vi-VN') + 'đ';
        document.getElementById('discount').textContent = '-' + discount.toLocaleString('vi-VN') + 'đ';
        document.getElementById('cartTotal').textContent = finalTotal.toLocaleString('vi-VN') + 'đ';
    </script>
</body>
</html>

<?php
require_once('../includes/footer.php');
?>