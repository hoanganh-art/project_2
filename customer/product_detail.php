<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/database.php';

$customer_id = $_SESSION['user']['id'];
// Kiểm tra và lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id <= 0) {
    echo "<h1>ID sản phẩm không hợp lệ</h1>";
    exit;
}

// Truy vấn thông tin sản phẩm
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<h1>Sản phẩm không tồn tại</h1>";
    exit;
}

// // Xử lý thêm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user'])) {
        echo "<script>alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');</script>";
        echo "<script>setTimeout(function(){ window.location.href = '../login/index.php'; }, 1500);</script>";
        exit;
    }

    // Validate dữ liệu
    if (empty($_POST['color']) || empty($_POST['size']) || empty($_POST['quantity'])) {
        echo "<script>alert('Vui lòng chọn đầy đủ thông tin sản phẩm');</script>";
        exit;
    }

    // Sửa dòng này - lấy id từ mảng user trong session
    $customer_id = $_SESSION['user']['id'];
    $color = htmlspecialchars(trim($_POST['color']));
    $size = htmlspecialchars(trim($_POST['size']));
    $quantity = intval($_POST['quantity']);
    $product_id = intval($_POST['product_id']);

    // Kiểm tra số lượng hợp lệ
    if ($quantity <= 0) $quantity = 1;
    if ($quantity > $product['stock']) {
        echo "<script>alert('Số lượng vượt quá tồn kho. Chỉ còn {$product['stock']} sản phẩm');</script>";
        exit;
    }

    // Kiểm tra sản phẩm đã có trong giỏ chưa
    $check_sql = "SELECT id, quantity FROM cart WHERE customer_id = ? AND product_id = ? AND color = ? AND size = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("iiss", $customer_id, $product_id, $color, $size);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Cập nhật số lượng nếu đã có
        $cart_item = $check_result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + $quantity;

        if ($new_quantity > $product['stock']) {
            echo "<script>alert('Tổng số lượng trong giỏ vượt quá tồn kho');</script>";
        } else {
            $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $new_quantity, $cart_item['id']);
            $update_stmt->execute();
            echo "<script>alert('Đã cập nhật số lượng sản phẩm trong giỏ hàng');</script>";
        }
    } else {
        // Thêm mới vào giỏ hàng
        $insert_sql = "INSERT INTO cart (customer_id, product_id, color, size, quantity) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iissi", $customer_id, $product_id, $color, $size, $quantity);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Sản phẩm đã được thêm vào giỏ hàng');</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi thêm vào giỏ hàng');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> | Streetwear Shop</title>
    <link rel="stylesheet" href="../assets/css/Custome/product_detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Product Detail -->
    <div class="product-detail">
        <div class="product-gallery">
            <img src="<?php echo htmlspecialchars($product['image']); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>"
                class="main-image">
            <div class="thumbnail-container">
                <!-- Thay thế bằng hình ảnh thực tế từ database -->
                <img src="<?php echo htmlspecialchars($product['image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    class="thumbnail"
                    onclick="changeImage(this)">
                <!-- Có thể thêm nhiều hình ảnh khác nếu có -->
            </div>
        </div>

        <div class="product-info">
            <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="product-sku">Mã SP: <?php echo htmlspecialchars($product['code']); ?></div>
            <div class="product-price">
                <?php echo number_format($product['price'], 0, ',', '.'); ?>đ
                <?php if ($product['original_price'] > $product['price']): ?>
                    <span class="old-price"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>đ</span>
                <?php endif; ?>
            </div>

            <div class="product-description">
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <div class="product-meta">
                <div class="meta-item">
                    <span class="meta-label">Tình trạng:</span>
                    <span style="color: <?php echo $product['status'] === 'active' ? 'green' : 'red'; ?>;">
                        <?php echo $product['status'] === 'active' ? 'Còn hàng' : 'Hết hàng'; ?>
                    </span>
                </div>
            </div>

            <form method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                <div class="product-variants">
                    <div class="variant-title">Màu sắc:</div>
                    <div class="variant-options">
                        <input type="hidden" name="color" id="selected-color" value="Đen" required>
                        <div class="variant-btn active" onclick="selectVariant('color', 'Đen', this)">Đen</div>
                        <div class="variant-btn" onclick="selectVariant('color', 'Xám', this)">Xám</div>
                        <div class="variant-btn" onclick="selectVariant('color', 'Trắng', this)">Trắng</div>
                    </div>

                    <div class="variant-title">Kích cỡ:</div>
                    <div class="variant-options">
                        <input type="hidden" name="size" id="selected-size" value="M" required>
                        <div class="variant-btn" onclick="selectVariant('size', 'S', this)">S</div>
                        <div class="variant-btn active" onclick="selectVariant('size', 'M', this)">M</div>
                        <div class="variant-btn" onclick="selectVariant('size', 'L', this)">L</div>
                        <div class="variant-btn" onclick="selectVariant('size', 'XL', this)">XL</div>
                    </div>
                </div>

                <div class="quantity-selector">
                    <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>"
                        class="quantity-input" id="quantity-input" readonly>
                    <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                </div>

                <div class="product-actions">
                    <button type="submit" name="add_to_cart" class="btn btn-primary"
                        <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                        <?php echo $product['stock'] > 0 ? 'THÊM VÀO GIỎ' : 'HẾT HÀNG'; ?>
                    </button>
                    <button type="button" class="btn btn-secondary"
                        <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                        MUA NGAY
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="product-tabs">
        <div class="tabs-header">
            <div class="tab-btn active" onclick="openTab('description')">Mô tả sản phẩm</div>
            <div class="tab-btn" onclick="openTab('specs')">Thông số kỹ thuật</div>
            <div class="tab-btn" onclick="openTab('reviews')">Đánh giá</div>
        </div>

        <div id="description" class="tab-content active">
            <h3>Chi tiết sản phẩm</h3>
            <?php echo nl2br(htmlspecialchars($product['description'])); ?>
        </div>

        <div id="specs" class="tab-content">
            <h3>Thông số kỹ thuật</h3>
            <table>
                <tr>
                    <td>Chất liệu</td>
                    <td>Cotton 100%</td>
                </tr>
                <tr>
                    <td>Xuất xứ</td>
                    <td>Việt Nam</td>
                </tr>
                <!-- Thêm các thông số khác -->
            </table>
        </div>

        <div id="reviews" class="tab-content">
            <h3>Đánh giá sản phẩm</h3>
            <!-- Phần đánh giá -->
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-products">
        <h2 class="section-title">SẢN PHẨM TƯƠNG TỰ</h2>
        <div class="product-grid">
            <?php
            $sql_related = "SELECT * FROM product WHERE id != ? AND status = 'active' ORDER BY RAND() LIMIT 4";
            $stmt_related = $conn->prepare($sql_related);
            $stmt_related->bind_param("i", $product_id);
            $stmt_related->execute();
            $result_related = $stmt_related->get_result();

            while ($related_product = $result_related->fetch_assoc()): ?>
                <div class="product-card">
                    <a href="product_detail.php?id=<?php echo $related_product['id']; ?>" class="product-link">
                        <img src="../assets/image_products/<?php echo htmlspecialchars($related_product['image']); ?>"
                            alt="<?php echo htmlspecialchars($related_product['name']); ?>"
                            class="product-image">
                    </a>
                    <div class="product-info-small">
                        <h3 class="product-name"><?php echo htmlspecialchars($related_product['name']); ?></h3>
                        <div class="product-price-small">
                            <?php echo number_format($related_product['price'], 0, ',', '.'); ?>đ
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        // Hàm thay đổi hình ảnh chính
        function changeImage(thumbnail) {
            document.querySelector('.main-image').src = thumbnail.src;
        }

        // Hàm chọn biến thể (màu/kích cỡ)
        function selectVariant(type, value, element) {
            // Cập nhật giá trị input ẩn
            document.getElementById(`selected-${type}`).value = value;

            // Cập nhật giao diện
            const buttons = element.parentElement.querySelectorAll('.variant-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');
        }

        // Hàm thay đổi số lượng
        function changeQuantity(change) {
            const input = document.getElementById('quantity-input');
            let newValue = parseInt(input.value) + change;
            const max = parseInt(input.max);

            // Giới hạn số lượng trong khoảng 1 đến max
            newValue = Math.max(1, Math.min(newValue, max));
            input.value = newValue;
        }

        // Hàm chuyển tab
        function openTab(tabName) {
            // Ẩn tất cả tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Xóa active tất cả tab button
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Hiển thị tab được chọn
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>

    <?php
    require_once '../includes/footer.php';
    $conn->close();
    ?>
</body>

</html>