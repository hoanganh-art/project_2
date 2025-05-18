<?php
require_once('../includes/header.php');
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
                    <tbody>
                        <tr>
                            <td>Áo thun nam trắng</td>
                            <td>250,000đ</td>
                            <td>1</td>
                            <td>250,000đ</td>
                        </tr>
                        <tr>
                            <td>Quần jeans đen</td>
                            <td>450,000đ</td>
                            <td>2</td>
                            <td>900,000đ</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Tổng cộng:</td>
                            <td>1,150,000đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="checkout-form">
                <h2>Thông tin giao hàng</h2>
                <form id="checkoutForm">
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

        // Chuyển hướng đến trang cảm ơn (trong thực tế)
        // window.location.href = 'order_confirmation.html';
    });
</script>

</html>

<?php
require_once('../includes/footer.php');
?>