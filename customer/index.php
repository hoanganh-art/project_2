<?php
//=================================PHẦN XỬ LÝ PHP=================================
// Update the path below to the correct location of database.php if needed
include_once(__DIR__ . '/../includes/database.php');

$sql = "SELECT * FROM product";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

//lấy tên danh mục để hiển thị
$category_names = [
    'thun' => 'Áo Thun',
    'hoodie' => 'Hoodie',
    'jeans' => 'Quần Jeans'
];
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOÁI PHONG - Thời Trang Đường Phố</title>
    <link rel="stylesheet" href="../assets/css/Custome/index.css">
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

    </style>
</head>

<body>


    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="hero-content">
            <h1>SOÁI PHONG COLLECTION 2025</h1>
            <p>Phong cách đường phố đậm chất urban, thể hiện cá tính riêng của bạn</p>
            <button class="btn btn-primary">KHÁM PHÁ NGAY</button>
        </div>
    </section>

    <!-- Featured Products -->
    <section>
        <div class="section-title">
            <h2>SẢN PHẨM NỔI BẬT</h2>
            <p>Những sản phẩm streetwear được yêu thích nhất hiện nay</p>
        </div>

        <div class="product-grid">

            <?php
            $count = 0;
            foreach ($products as $product):
                if ($count >= 4) break;
                $count++;
            ?>
                <div class="product-card">
                    <!-- Hiển thị thông tin sản phẩm ở đây -->
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image" style="height:220px;object-fit:cover;width:100%;">
                    <div class="product-info">
                        <div class="product-category">
                            <?php
                            $cat = $product['subcategory'] ?? '';
                            echo isset($category_names[$cat]) ? $category_names[$cat] : htmlspecialchars($cat);
                            ?>
                        </div>
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="gai">
                            <div class="product-price">
                                <?php if (!empty($product['original_price'])): ?>
                                    <del><?php echo number_format($product['original_price'], 0, ',', '.') . 'đ'; ?></del>
                                <?php endif; ?>
                            </div>
                            <div class="price"><?php echo number_format($product['price'], 0, ',', '.') . 'đ'; ?></div>
                        </div>
                        <div class="product-actions">
                            <a href="../customer/product_detail.php?id=<?php echo $product['id']; ?>" class="product-link">
                                <button class="btn-add-to-cart">Thêm vào giỏ</button>

                                <button class="btn-view">Xem nhanh</button>

                            </a>
                        </div>
                        <div class="sele">
                            <?php
                            $original = $product['original_price'];
                            $sale = $product['price'];
                            if ($original > 0 && $sale < $original) {
                                $percent = round((($original - $sale) / $original) * 100);
                                echo $percent . '%';
                            } else {
                                echo '0%';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- New Arrivals -->
    <section>
        <div class="section-title">
            <h2>SẢN PHẨM MỚI</h2>
            <p>Cập nhật những mẫu thiết kế mới nhất mỗi tuần</p>
        </div>

        <div class="product-grid">
            <?php
            $count = 0;
            foreach ($products as $product):
                if ($count >= 4) break;
                $count++;
            ?>
                <div class="product-card">
                    <!-- Hiển thị thông tin sản phẩm ở đây -->
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image" style="height:220px;object-fit:cover;width:100%;">
                    <div class="product-info">
                        <div class="product-category">
                            <?php
                            $cat = $product['subcategory'] ?? '';
                            echo isset($category_names[$cat]) ? $category_names[$cat] : htmlspecialchars($cat);
                            ?>
                        </div>
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="gai">
                            <div class="product-price">
                                <?php if (!empty($product['original_price'])): ?>
                                    <del><?php echo number_format($product['original_price'], 0, ',', '.') . 'đ'; ?></del>
                                <?php endif; ?>
                            </div>
                            <div class="price"><?php echo number_format($product['price'], 0, ',', '.') . 'đ'; ?></div>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-to-cart">Thêm vào giỏ</button>
                            <button class="btn-view">Xem nhanh</button>
                        </div>
                        <div class="sele">
                            <?php
                            $original = $product['original_price'];
                            $sale = $product['price'];
                            if ($original > 0 && $sale < $original) {
                                $percent = round((($original - $sale) / $original) * 100);
                                echo $percent . '%';
                            } else {
                                echo '0%';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>


    <script>
        //Di chuyển đến trang giỏ hàng
        // document.querySelectorAll('.btn-add-to-cart').forEach(function(btn) {
        //     btn.addEventListener('click', function() {

        //         window.location.href = '../customer/product_detail.php';
        //     });
        // });
    </script>
</body>



</html>