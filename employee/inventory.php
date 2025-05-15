<?php
include('../includes/database.php');
$sql = "SELECT * FROM product";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result(); // Lấy kết quả truy vấn
$products = $result->fetch_all(MYSQLI_ASSOC); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Kho Hàng | SOÁI PHONG</title>
    <link rel="stylesheet" href="../assets/css/employee/dashboard.css">
    <link rel="stylesheet" href="../assets/css/employee/inventory.css">
    <link rel="shortcut icon" href="../assets/image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>SOÁI<span> PHONG</span></h2>
            <p style="color: var(--gray); font-size: 12px;">Quản lý kho hàng</p>
        </div>

        <nav class="nav-menu">
            <div class="nav-item">
                <a href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tổng quan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="manage_orders.php">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="inventory.php" class="active">
                    <i class="fas fa-boxes"></i>
                    <span>Kho hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="cusromer_support.php">
                    <i class="fas fa-headset"></i>
                    <span>Hỗ trợ khách hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="sales_report.php">
                    <i class="fas fa-chart-line"></i>
                    <span>Báo cáo bán hàng</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="account.php">
                    <i class="fas fa-user-cog"></i>
                    <span>Tài khoản</span>
                </a>
            </div>
            <div class="nav-item" style="margin-top: 30px;">
                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Khởi động session nếu chưa được khởi động
                }
                if (!isset($_SESSION['user'])) {
                    header('Location: ../login/index.php');
                    exit();
                }
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
        <div class="header">
            <h1>Quản Lý Kho Hàng</h1>
            <div class="user-profile">
                <?php
                $avatar = isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'https://randomuser.me/api/portraits/men/32.jpg';
                // Kiểm tra nếu avatar đã là URL đầy đủ
                $avatarSrc = (filter_var($avatar, FILTER_VALIDATE_URL)) ? $avatar : "../assets/avatar/" . htmlspecialchars($avatar);
                ?>
                <img src="<?php echo $avatarSrc; ?>" alt="Avatar" class="account-avatar">
                <?php
                $name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Tên của bạn';
                ?>
                <span>Nhân viên: <?php echo htmlspecialchars($name); ?></span>
            </div>
        </div>

        <!-- Inventory Actions -->
        <div class="inventory-actions">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Tìm kiếm sản phẩm...">
            </div>
            <div class="action-buttons">
                <button class="btn btn-secondary">
                    <i class="fas fa-filter"></i> Lọc
                </button>
                <button class="btn btn-primary" id="add-product-btn">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </button>
            </div>
        </div>

        <!-- Inventory Stats -->
        <div class="inventory-stats">
            <div class="stat-card">
                <h3>Tổng sản phẩm</h3>
                <p><?php
                echo count($products);
                ?>
                </p>
            </div>
            <div class="stat-card">
                <h3>Sản phẩm sắp hết</h3>
                <?php
                // Đếm số sản phẩm có số lượng tồn kho <= 10 và > 0 (sắp hết hàng)
                $low_stock_count = 0;
                foreach ($products as $product) {
                    if ($product['stock'] > 0 && $product['stock'] <= 10) {
                        $low_stock_count++;
                    }
                }
                ?>
                <p><?php echo $low_stock_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>Sản phẩm hết hàng</h3>
                <?php
                // Đếm số sản phẩm có số lượng tồn kho = 0 (hết hàng)
                $out_of_stock_count = 0;
                foreach ($products as $product) {
                    if ($product['stock'] == 0) {
                        $out_of_stock_count++;
                    }
                }
                ?>
                <p><?php echo $out_of_stock_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>Giá trị tồn kho</h3>
                <?php
                $total_inventory_value = 0;
                foreach ($products as $product) {
                    $total_inventory_value += $product['original_price'] * $product['stock'];
                }
                ?>
                <p><?php echo number_format($total_inventory_value, 0, ',', '.') . 'đ'; ?></p>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="inventory-table">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($products as $product): ?>
                            <?php

                            $categoryName = ($product['category'] == 'men') ? 'Nam' : 'Nữ';
                            $statusClass = ($product['status'] == 'active') ? 'status-active' : 'status-inactive';
                            $statusText = ($product['status'] == 'active') ? 'Đang Bán' : 'Ngừng Bán';
                            ?>
                            <style>

                            </style>
                            <tr data-id="<?php echo htmlspecialchars($product['id']); ?>"
                                data-original_price="<?php echo htmlspecialchars($product['original_price']); ?>"
                                data-code="<?php echo htmlspecialchars($product['code']); ?>"
                                data-description="<?php echo htmlspecialchars($product['description']); ?>">
                                <td><img src="<?php echo htmlspecialchars('../../assets/image_products/' . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image"></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['subcategory']); ?></td>
                                <td><?php echo number_format($product['original_price'], 0, ',', '.') . 'đ'; ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td class="status <?php echo $statusClass; ?>"><?php echo $statusText; ?></td>
                                <td>
                                   <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                <button class="action-btn restock"><i class="fas fa-warehouse"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="page-item"><i class="fas fa-angle-left"></i></div>
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal" id="add-product-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Thêm Sản Phẩm Mới</h2>
                <button class="close-modal">&times;</button>
            </div>

            <form>
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" placeholder="Nhập tên sản phẩm">
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select>
                        <option value="">Chọn danh mục</option>
                        <option value="ao">Áo</option>
                        <option value="quan">Quần</option>
                        <option value="phukien">Phụ kiện</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Giá bán</label>
                    <input type="number" placeholder="Nhập giá bán">
                </div>

                <div class="form-group">
                    <label>Số lượng nhập</label>
                    <input type="number" placeholder="Nhập số lượng">
                </div>

                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea placeholder="Nhập mô tả sản phẩm"></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary close-modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        const addProductBtn = document.getElementById('add-product-btn');
        const modal = document.getElementById('add-product-modal');
        const closeModalBtns = document.querySelectorAll('.close-modal');

        addProductBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>

</html>