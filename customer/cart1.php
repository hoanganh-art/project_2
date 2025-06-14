<?php
session_start();
require_once('../includes/database.php');

if (!isset($_SESSION['user']['id'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location.href='../login/index.php';</script>";
    exit();
}

$current_customer_id = $_SESSION['user']['id'];

// Lấy giỏ hàng từ database
$sql = "SELECT cart.id as cart_id, cart.product_id, cart.quantity, cart.color, cart.size, 
               product.id as product_id, product.name, product.price, product.image 
        FROM cart 
        INNER JOIN product ON cart.product_id = product.id
        WHERE cart.customer_id = ?";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('i', $current_customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $carts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Lưu giỏ hàng vào session với cấu trúc rõ ràng
$_SESSION['cart_items'] = array_map(function ($cart) {
    return [
        'id' => $cart['product_id'], // Đảm bảo dùng product_id thay vì cart_id
        'product_id' => $cart['product_id'],
        'name' => $cart['name'],
        'price' => $cart['price'],
        'quantity' => $cart['quantity'],
        'color' => $cart['color'],
        'size' => $cart['size'],
        'image' => $cart['image'],
        'cart_id' => $cart['cart_id'] // Giữ lại cart_id nếu cần
    ];
}, $carts);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng | SOÁI PHONG</title>
    <link rel="shortcut icon" href="../assets/image/logo.ico"
        type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/account.css">
    <link rel="stylesheet" href="../assets/css/Custome/cart.css">
    <link rel="stylesheet"
        href="../assets/css/Custome/account_customet.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>SOÁI<span> PHONG</span></h2>
        </div>
        <div class="usear">
            <div class="avata">
                <?php
                if (isset($_SESSION['user']['avatar']) && !empty($_SESSION['user']['avatar'])) {
                    echo '<img src="' . htmlspecialchars($_SESSION['user']['avatar']) . '" alt="Avatar">';
                } else {
                    echo '<img src="../assets/avatar/default-avatar.png" alt="Default Avatar">';
                }
                ?> </div>
            <div class="users">
                <?php
                if (isset($_SESSION['user']['name'])) {
                    echo '<h3>' . htmlspecialchars($_SESSION['user']['name']) . '</h3>';
                } else {
                    echo '<h3>Khách</h3>';
                }
                ?>
            </div>
        </div>
        <nav class="nav-menu">
            <div class="nav-item">
                <a href="../index.php">
                    <i class="fas fa-home"></i>
                    <span>Trang chủ</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="cart1.php" class="active">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Giỏ hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="order_history.php">
                    <i class="fas fa-boxes"></i>
                    <span>Lịch sử mua hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="account_customet.php">
                    <i class="fas fa-user-cog"></i>
                    <span>Tài khoản</span>
                </a>
            </div>
            <div class="nav-item" style="margin-top: 6px;">
                <?php
                if (isset($_SESSION['user'])) {
                    // Hiển thị nút đăng xuất
                    echo '<a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>';
                } else {
                    // Hiển thị nút đăng nhập
                    echo '<a href="../login/index.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>';
                }
                ?>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="cart-items">
            <h2 class="cart-title">GIỎ HÀNG CỦA BẠN</h2>

            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Product 1 -->

                    <?php foreach ($_SESSION['cart_items'] as $item): ?>
                        <tr data-product-id="<?= htmlspecialchars($item['product_id']) ?>"
                            data-cart-id="<?= htmlspecialchars($item['cart_id']) ?>">
                            <td data-label="Sản phẩm">
                                <div class="product-cell">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="product-image">
                                    <div class="product-info">
                                        <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                        <p>Màu: <?php echo htmlspecialchars($item['color']) ?> | Size: <?php echo htmlspecialchars($item['size']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Giá"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                            <td data-label="Số lượng">
                                <div class="quantity-selector">
                                    <button class="quantity-btn">-</button>
                                    <input type="number" value="<?php echo htmlspecialchars($item['quantity']) ?>" min="1" class="quantity-input">
                                    <button class="quantity-btn">+</button>
                                </div>
                            </td>
                            <td data-label="Tổng"></td>
                            <td>
                                <button class="remove-btn" title="Xóa sản phẩm">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                            </data-product-id=>
                        <?php endforeach; ?>
                </tbody>
            </table>

            <div class="continue-shopping">
                <a href="../products/product.php">
                    <i class="fas fa-arrow-left"></i>
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>

        <div class="cart-summary">
            <h2 class="summary-title">TÓM TẮT ĐƠN HÀNG</h2>

            <div class="summary-row">
                <span>Tạm tính:</span>
                <span></span>
            </div>

            <div class="summary-row">
                <span>Giảm giá:</span>
                <span></span>
            </div>

            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <span>30.000đ</span>
            </div>

            <div class="summary-row summary-total">
                <span>Tổng cộng:</span>
                <span></span>
            </div>

            <form method="post" action="checkout.php">
                <button type="submit" name="checkout" class="btn btn-primary">TIẾN HÀNH THANH TOÁN</button>
            </form>
            <button class="btn btn-secondary">CẬP NHẬT GIỎ HÀNG</button>

            <div style="margin-top: 20px; font-size: 14px; color: #666; text-align: center;">
                <p>Miễn phí vận chuyển cho đơn hàng từ 500.000đ</p>
            </div>
        </div>
    </div>
</body>
<script>
    // Remove product from cart
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                // Update cart totals here

                // If no more items, show empty cart
                if (document.querySelectorAll('.cart-table tbody tr').length === 0) {
                    document.querySelector('.cart-items').style.display = 'none';
                    document.querySelector('.cart-summary').style.display = 'none';
                    document.querySelector('.empty-cart').style.display = 'block';
                }
            }, 300);
        });
    });

    // Update cart button
    document.querySelector('.btn-secondary').addEventListener('click', function() {
        alert('Giỏ hàng đã được cập nhật!');
    });


    //Số lượng sản phẩm
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value);
            const row = this.closest('tr');
            const productId = row.getAttribute('data-product-id');

            if (this.textContent === '+' || this.innerHTML.includes('+')) {
                input.value = value + 1;
            } else {
                if (value > 1) {
                    input.value = value - 1;
                }
            }

            // Gửi AJAX cập nhật quantity
            fetch('update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${productId}&quantity=${input.value}`
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) alert('Cập nhật thất bại!');
                });

            // Cập nhật tổng từng dòng và tổng giỏ hàng NGAY LẬP TỨC
            updateRowTotal(input);
            updateCartSummary();
        });
    });

    // Nếu người dùng nhập số trực tiếp vào input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            if (parseInt(this.value) < 1) this.value = 1;
            const row = this.closest('tr');
            const productId = row.getAttribute('data-product-id');

            // Gửi AJAX cập nhật quantity
            fetch('update_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${productId}&quantity=${this.value}`
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) alert('Cập nhật thất bại!');
                });

            updateRowTotal(this);
            updateCartSummary();
        });
    });

    function updateRowTotal(input) {
        const row = input.closest('tr');
        const priceCell = row.querySelector('td[data-label="Giá"]');
        const totalCell = row.querySelector('td[data-label="Tổng"]');
        let price = parseInt(priceCell.textContent.replace(/\D/g, ''));
        let quantity = parseInt(input.value);
        let total = price * quantity;
        totalCell.textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    function updateCartSummary() {
        let subtotal = 0;
        document.querySelectorAll('.cart-table tbody tr').forEach(row => {
            const totalCell = row.querySelector('td[data-label="Tổng"]');
            subtotal += parseInt(totalCell.textContent.replace(/\D/g, '')) || 0;
        });

        // Update summary rows
        document.querySelectorAll('.summary-row span')[1].textContent = subtotal.toLocaleString('vi-VN') + 'đ';

        // Example: discount and shipping
        let discount = 130000;
        let shipping = subtotal >= 500000 ? 0 : 30000;
        document.querySelectorAll('.summary-row span')[3].textContent = '' + discount.toLocaleString('vi-VN') + 'đ';
        document.querySelectorAll('.summary-row span')[5].textContent = shipping.toLocaleString('vi-VN') + 'đ';

        let total = subtotal - discount + shipping;
        document.querySelector('.summary-total span:last-child').textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    // Also update when clicking +/-
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            updateRowTotal(input);
            updateCartSummary();
        });
    });

    // Initial calculation
    document.querySelectorAll('.quantity-input').forEach(input => updateRowTotal(input));
    updateCartSummary();



    //Xóa sản phầm trong giỏ hàng 
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const productId = row.getAttribute('data-product-id');
            const cartId = row.getAttribute('data-cart-id');

            // Gửi AJAX xóa sản phẩm khỏi cart
            fetch('remove_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${cartId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Tự động load lại trang sau khi xóa thành công
                        window.location.reload();
                    } else {
                        alert('Xóa sản phẩm thất bại!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi xóa sản phẩm');
                });
        });
    });

    document.querySelector('form[action="checkout.php"]').addEventListener('submit', function(e) {
        e.preventDefault();

        // Lấy thông tin giỏ hàng hiện tại trên giao diện
        const cartItems = Array.from(document.querySelectorAll('.cart-table tbody tr')).map(row => ({
            cart_id: row.getAttribute('data-product-id'),
            name: row.querySelector('h4').textContent,
            price: parseInt(row.querySelector('td[data-label="Giá"]').textContent.replace(/\D/g, '')),
            quantity: parseInt(row.querySelector('.quantity-input').value),
            color: row.querySelector('.product-info p').textContent.split('|')[0].replace('Màu:', '').trim(),
            size: row.querySelector('.product-info p').textContent.split('|')[1].replace('Size:', '').trim(),
            image: row.querySelector('.product-image').src
        }));

        // Gửi AJAX cập nhật session
        fetch('update_cart_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cartItems)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Chuyển sang trang checkout
                    window.location.href = 'checkout.php';
                } else {
                    alert('Cập nhật giỏ hàng thất bại!');
                }
            })
            .catch(() => alert('Có lỗi xảy ra!'));
    });
    // Khi click thanh toán
    document.querySelector('form[action="checkout.php"]').addEventListener('submit', function(e) {
        e.preventDefault();

        const cartItems = Array.from(document.querySelectorAll('.cart-table tbody tr')).map(row => ({
            cart_id: row.getAttribute('data-cart-id'),
            product_id: row.getAttribute('data-product-id'),
            name: row.querySelector('h4').textContent,
            price: parseInt(row.querySelector('td[data-label="Giá"]').textContent.replace(/\D/g, '')),
            quantity: parseInt(row.querySelector('.quantity-input').value),
            color: row.querySelector('.product-info p').textContent.split('|')[0].replace('Màu:', '').trim(),
            size: row.querySelector('.product-info p').textContent.split('|')[1].replace('Size:', '').trim(),
            image: row.querySelector('.product-image').src
        }));

        // Gửi AJAX cập nhật session
        fetch('update_cart_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cartItems)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Chuyển hướng sau khi cập nhật session thành công
                    window.location.href = 'checkout.php';
                } else {
                    alert('Cập nhật giỏ hàng thất bại!');
                }
            });
    });
    //Kiểm tra giỏ hàng có rỗng không nếu có thì không cho thanh toán
    function updateCheckoutButton() {
        const cartRows = document.querySelectorAll('.cart-table tbody tr');
        const checkoutBtn = document.querySelector('.btn.btn-primary[name="checkout"]') || document.querySelector('.btn.btn-primary[disabled]');
        if (cartRows.length === 0) {
            if (checkoutBtn) {
                checkoutBtn.disabled = true;
                checkoutBtn.style.opacity = 0.5;
                checkoutBtn.style.pointerEvents = 'none';
            }
        } else {
            if (checkoutBtn) {
                checkoutBtn.disabled = false;
                checkoutBtn.style.opacity = 1;
                checkoutBtn.style.pointerEvents = 'auto';
            }
        }
    }

    // Gọi hàm này sau khi xóa/cập nhật giỏ hàng
    updateCheckoutButton();
</script>

</html>