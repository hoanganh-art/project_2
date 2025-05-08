<?php
session_start();

require_once '../includes/header.php';
require_once '../includes/database.php';


// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn thông tin sản phẩm
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Kiểm tra nếu sản phẩm không tồn tại
if (!$product) {
    echo "<h1>Sản phẩm không tồn tại</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/Custome/product_detail.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Product Detail -->
    <form method="POST" action="">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <div class="product-detail">
            <div class="product-gallery">
                <img src="../assets/image_products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="main-image">
                <div class="thumbnail-container">
                    <img src="../assets/image/ao/hoodiemau.png" alt="Áo Hoodie 1" class="thumbnail" onclick="changeImage(this)">
                    <img src="../assets/image/ao/hoodiemau.png" alt="Áo Hoodie 2" class="thumbnail" onclick="changeImage(this)">
                    <img src="../assets/image/ao/hoodiemau.png" alt="Áo Hoodie 3" class="thumbnail" onclick="changeImage(this)">
                    <img src="../assets/image/ao/hoodiemau.png" alt="Áo Hoodie 4" class="thumbnail" onclick="changeImage(this)">
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                <div class="product-sku">Mã SP: <?php echo htmlspecialchars($product['code']); ?></div>
                <div class="product-price">
                    <?php echo number_format($product['price'], 0, ',', '.'); ?>đ
                    <span class="old-price"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>đ</span>
                </div>

                <div class="product-description">
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Danh mục:</span>
                        <span>Áo, Hoodie</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tình trạng:</span>
                        <span style="color: <?php echo $product['status'] === 'active' ? 'green' : 'red'; ?>;">
                            <?php echo $product['status'] === 'active' ? 'Còn hàng' : 'Hết hàng'; ?>
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Đánh giá:</span>
                        <span>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star-half-alt" style="color: gold;"></i>
                            (42 đánh giá)
                        </span>
                    </div>
                </div>



                <div class="product-variants">
                    <div class="variant-title">Màu sắc:</div>
                    <div class="variant-options">
                        <input type="hidden" name="color" id="selected-color" value="Đen">
                        <div class="variant-btn active" onclick="selectColor('Đen', this)">Đen</div>
                        <div class="variant-btn" onclick="selectColor('Xám', this)">Xám</div>
                        <div class="variant-btn" onclick="selectColor('Trắng', this)">Trắng</div>
                    </div>

                    <div class="variant-title">Kích cỡ:</div>
                    <div class="variant-options">
                        <input type="hidden" name="size" id="selected-size" value="M">
                        <div class="variant-btn" onclick="selectSize('S', this)">S</div>
                        <div class="variant-btn active" onclick="selectSize('M', this)">M</div>
                        <div class="variant-btn" onclick="selectSize('L', this)">L</div>
                        <div class="variant-btn" onclick="selectSize('XL', this)">XL</div>
                    </div>
                </div>

                <div class="quantity-selector">
                    <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                    <input type="number" name="quantity" value="1" min="1" class="quantity-input" id="quantity-input">
                    <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                </div>

                <div class="product-actions">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">THÊM VÀO GIỎ</button>
                    <button type="button" class="btn btn-secondary">MUA NGAY</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Product Tabs -->
    <div class="product-tabs">
        <div class="tabs-header">
            <div class="tab-btn active" onclick="openTab('description')">Mô tả sản phẩm</div>
            <div class="tab-btn" onclick="openTab('specs')">Thông số kỹ thuật</div>
            <div class="tab-btn" onclick="openTab('reviews')">Đánh giá</div>
        </div>

        <div id="description" class="tab-content active">
            <h3>Chi tiết sản phẩm</h3>
            <p>Áo hoodie streetwear phiên bản giới hạn với nhiều ưu điểm vượt trội:</p>
            <ul>
                <li>Chất liệu: Cotton 100% dày dặn, co giãn nhẹ</li>
                <li>Form áo: Oversize rộng rãi thoải mái</li>
                <li>Họa tiết: In kỹ thuật số không bong tróc</li>
                <li>Màu sắc: Đen/Xám/Trắng</li>
                <li>Kiểu dáng: Có mũ trùm, túi kangaroo phía trước</li>
                <li>Phù hợp: Đi chơi, đi học, dạo phố</li>
            </ul>
            <p>Hướng dẫn bảo quản: Giặt ở nhiệt độ thường, không sử dụng chất tẩy mạnh.</p>
        </div>

        <div id="specs" class="tab-content">
            <h3>Thông số kỹ thuật</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE; width: 30%;">Chất liệu</td>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">Cotton 100%</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">Xuất xứ</td>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">Việt Nam</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">Kích thước</td>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">S/M/L/XL</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">Màu sắc</td>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">Đen, Xám, Trắng</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">Trọng lượng</td>
                    <td style="padding: 10px; border-bottom: 1px solid #EEE;">450g</td>
                </tr>
            </table>
        </div>

        <div id="reviews" class="tab-content">
            <h3>Đánh giá sản phẩm</h3>
            <div style="display: flex; align-items: center; margin-bottom: 20px;">
                <div style="font-size: 24px; margin-right: 10px;">4.5/5</div>
                <div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <div style="width: 100px; margin-right: 10px;">5 sao</div>
                        <progress value="30" max="42" style="width: 200px; height: 10px;"></progress>
                        <span style="margin-left: 10px;">30</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <div style="width: 100px; margin-right: 10px;">4 sao</div>
                        <progress value="8" max="42" style="width: 200px; height: 10px;"></progress>
                        <span style="margin-left: 10px;">8</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <div style="width: 100px; margin-right: 10px;">3 sao</div>
                        <progress value="3" max="42" style="width: 200px; height: 10px;"></progress>
                        <span style="margin-left: 10px;">3</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <div style="width: 100px; margin-right: 10px;">2 sao</div>
                        <progress value="1" max="42" style="width: 200px; height: 10px;"></progress>
                        <span style="margin-left: 10px;">1</span>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 100px; margin-right: 10px;">1 sao</div>
                        <progress value="0" max="42" style="width: 200px; height: 10px;"></progress>
                        <span style="margin-left: 10px;">0</span>
                    </div>
                </div>
            </div>

            <div style="background-color: #F9F9F9; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <h4>Viết đánh giá của bạn</h4>
                <div style="margin-bottom: 15px;">
                    <span>Đánh giá của bạn:</span>
                    <div style="font-size: 24px; color: #DDD; cursor: pointer;">
                        <i class="far fa-star" onmouseover="rateProduct(1)" onclick="setRating(1)"></i>
                        <i class="far fa-star" onmouseover="rateProduct(2)" onclick="setRating(2)"></i>
                        <i class="far fa-star" onmouseover="rateProduct(3)" onclick="setRating(3)"></i>
                        <i class="far fa-star" onmouseover="rateProduct(4)" onclick="setRating(4)"></i>
                        <i class="far fa-star" onmouseover="rateProduct(5)" onclick="setRating(5)"></i>
                    </div>
                </div>
                <textarea style="width: 100%; padding: 10px; border: 1px solid #DDD; border-radius: 4px; margin-bottom: 10px;" rows="4" placeholder="Nhận xét của bạn về sản phẩm..."></textarea>
                <button style="padding: 10px 20px; background-color: var(--red); color: white; border: none; border-radius: 4px; cursor: pointer;">GỬI ĐÁNH GIÁ</button>
            </div>

            <div class="review">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <strong>Nguyễn Văn A</strong>
                    <div>
                        <i class="fas fa-star" style="color: gold;"></i>
                        <i class="fas fa-star" style="color: gold;"></i>
                        <i class="fas fa-star" style="color: gold;"></i>
                        <i class="fas fa-star" style="color: gold;"></i>
                        <i class="fas fa-star" style="color: gold;"></i>
                    </div>
                </div>
                <div style="color: #666; font-size: 14px; margin-bottom: 10px;">Đã mua tại STREETWEAR | 15/05/2023</div>
                <p>Áo đẹp, chất lượng tốt, mặc rất thoải mái. Họa tiết in sắc nét, không bong tróc sau nhiều lần giặt.</p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-products">
        <h2 class="section-title">SẢN PHẨM TƯƠNG TỰ</h2>
        <div class="product-grid">
            <!-- Product 1 -->
            <?php
            $sql_related = "SELECT * FROM product WHERE id != ? ORDER BY RAND() LIMIT 4";
            $stmt_related = $conn->prepare($sql_related);
            $stmt_related->bind_param("i", $product_id);
            $stmt_related->execute();
            $result_related = $stmt_related->get_result();

            while ($related_product = $result_related->fetch_assoc()): ?>
                <div class="product-card">
                    <a href="../customer/product_detail.php?id=<?php echo $related_product['id']; ?>" class="product-link">
                        <img src="../assets/image_products/<?php echo htmlspecialchars($related_product['image']); ?>" alt="<?php echo htmlspecialchars($related_product['name']); ?>" class="product-image">
                    </a>
                    <div class="product-info-small">
                        <h3 class="product-name"><?php echo htmlspecialchars($related_product['name']); ?></h3>
                        <div class="product-price-small"><?php echo number_format($related_product['price'], 0, ',', '.'); ?>đ</div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script>
        // Hàm chọn màu sắc
        function selectColor(color, element) {
            document.getElementById('selected-color').value = color;
            const buttons = element.parentElement.querySelectorAll('.variant-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');
        }

        // Hàm chọn kích cỡ
        function selectSize(size, element) {
            document.getElementById('selected-size').value = size;
            const buttons = element.parentElement.querySelectorAll('.variant-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            element.classList.add('active');
        }

        // Hàm thay đổi số lượng
        function changeQuantity(change) {
            const input = document.getElementById('quantity-input');
            let value = parseInt(input.value) + change;
            if (value < 1) value = 1;
            input.value = value;
        }

        // Hàm chuyển tab
        function openTab(tabName) {
            const tabContents = document.querySelectorAll('.tab-content');
            const tabButtons = document.querySelectorAll('.tab-btn');
            
            tabContents.forEach(tab => tab.classList.remove('active'));
            tabButtons.forEach(btn => btn.classList.remove('active'));
            
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
<?php
require_once '../includes/footer.php';
?>

</html>