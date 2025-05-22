<?php
session_start();
// ==================== PHẦN XỬ LÝ PHP ====================
require_once('../includes/header.php');
include_once('../includes/database.php');

// Xác định subcategory từ URL (nếu có)
$current_subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : 'thun';

// Truy vấn sản phẩm theo subcategory
$valid_subcategories = ['thun', 'hoodie', 'jeans'];
if (!in_array($current_subcategory, $valid_subcategories)) {
    $current_subcategory = 'thun';
}

$sql = "SELECT * FROM product WHERE subcategory = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_subcategory);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

// Lấy tên danh mục để hiển thị
$category_names = [
    'thun' => 'Áo Thun',
    'hoodie' => 'Hoodie',
    'jeans' => 'Quần Jeans'
];
$current_category_name = $category_names[$current_subcategory];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($current_category_name); ?> - Clothing Store</title>
    <link rel="stylesheet" href="../assets/css/products.css">
</head>

<body>
    <!-- ==================== PHẦN HTML ==================== -->
    <header class="products-header">
        <h1><?php echo htmlspecialchars($current_category_name); ?></h1>
    </header>

    <!-- Navigation Tabs -->
    <div class="category-tabs">
        <?php foreach ($category_names as $key => $name): ?>
            <a href="product.php?subcategory=<?php echo $key; ?>"
                class="tab-btn <?php echo $current_subcategory == $key ? 'active' : ''; ?>">
                <?php echo htmlspecialchars($name); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <div class="products-container">
        <div class="products-grid">
            <?php foreach ($products as $product): ?>

                <div class="product-card">
                    <?php if ($current_subcategory == 'thun'): ?>
                        <div class="product-badge">Mới</div>
                    <?php elseif ($current_subcategory == 'jeans'): ?>
                        <div class="product-badge">-30%</div>
                    <?php endif; ?>
                    <a href="../customer/product_detail.php?id=<?php echo $product['id']; ?>" class="product-link">
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                    </a>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="product-price">
                            <span class="current-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                            <span class="old-price"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>đ</span>
                        </div>

                        <div class="product-actions">
                            <button class="add-to-cart">Thêm vào giỏ</button>
                            <button class="wishlist-btn">♥</button>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>

    <!-- ==================== PHẦN JAVASCRIPT ==================== -->
    <script>
        // Khi nhấn vào nút "Thêm vào giỏ", chuyển hướng đến trang chi tiết sản phẩm
        document.querySelectorAll('.add-to-cart').forEach(function(btn, idx) {
            btn.addEventListener('click', function(e) {
            e.preventDefault();
            // Lấy id sản phẩm từ thẻ cha .product-card
            var productCard = btn.closest('.product-card');
            var productLink = productCard.querySelector('.product-link');
            if (productLink) {
                window.location.href = productLink.getAttribute('href');
            }
            });
        });
       
    </script>
    
</body>

</html>

<?php require_once('../includes/footer.php'); ?>