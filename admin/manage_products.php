<?php require_once('../admin//header/admin-header.php'); ?>
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login/index.php");
    exit();
}
include('../includes/database.php');
$sql = "SELECT * FROM product";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result(); // Lấy kết quả truy vấn
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - Admin Clothing Store</title>
    <link rel="stylesheet" href="../../assets/css/admin/manage_products.css">
</head>

<body>
    <div class="admin-container">
        <?php require_once('../admin/sidebar/admin_sidebar.php'); ?>

        <div class="admin-content">
            <div class="page-header">
                <h1 class="page-title">Quản lý sản phẩm</h1>
                <button class="btn-add" id="addProductBtn">
                    <span>+</span> Thêm sản phẩm
                </button>
            </div>

            <div class="product-actions">
                <input type="text" class="search-box" placeholder="Tìm kiếm sản phẩm...">
                <div class="filter-group">
                    <label for="category-filter">Danh mục:</label>
                    <select id="category-filter">
                        <option value="all">Tất cả</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>

                    </select>
                </div>
                <div class="filter-group">
                    <label for="status">Trạng thái:</label>
                    <select id="status" name="status" required>
                        <option value="all">Tất cả</option>
                        <option value="active">Đang bán</option>
                        <option value="inactive">Ngừng bán</option>
                    </select>
                </div>
            </div>

            <table class="products-table">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Danh mục</th>
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
                            data-subcategory="<?php echo htmlspecialchars($product['subcategory']); ?>"
                            data-code="<?php echo htmlspecialchars($product['code']); ?>"
                            data-description="<?php echo htmlspecialchars($product['description']); ?>">
                            <td><img src="<?php echo htmlspecialchars('../../assets/image_products/' . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image"></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td><?php echo $categoryName; ?></td>
                            <td><span class="status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                            <td>
                                <button class="action-btn btn-view">Xem</button>
                                <button class="action-btn btn-edit">Sửa</button>
                                <a href="delete_product.php?id=<?php echo $product['id'];  ?>" class="action-btn btn-delete" style="text-decoration: none;">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <button class="pagination-btn">←</button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">→</button>
            </div>
        </div>
    </div>

    <!-- Modal Thêm sản phẩm -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm sản phẩm mới</h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="code">Mã sản phẩm</label>
                            <input type="text" id="code" name="code" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Giá bán (đ)</label>
                            <input type="number" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="original_price">Giá gốc (đ)</label>
                            <input type="number" id="original_price" name="original_price">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Danh mục</label>
                            <select id="category" name="category" required>
                                <option value="">Chọn danh mục</option>
                                <option value="men">Thời trang nam</option>
                                <option value="women">Thời trang nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategory">Loại sản phẩm</label>
                            <select id="subcategory" name="subcategory" required>
                                <option value="">Chọn loại sản phẩm</option>
                                <option value="thun">Áo thun</option>
                                <option value="hoodie">Áo Hoodie</option>
                                <option value="jeans">Quần jeans</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="stock">Số lượng tồn kho</label>
                            <input type="number" id="stock" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status" required>
                                <option value="active">Đang bán</option>
                                <option value="inactive">Ngừng bán</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả sản phẩm</label>
                        <textarea id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Hình ảnh sản phẩm</label>
                        <input type="file" id="imageUpload" name="image" accept="image/*" multiple>
                        <div id="imagePreview" class="image-preview">
                            <!-- Preview images will be displayed here -->
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="action-btn btn-delete" id="cancelBtn">Hủy</button>
                        <button type="submit" class="action-btn btn-view" id="saveBtn">Lưu sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Chỉnh sửa sản phẩm -->
    <div class="modal" id="editProductModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Chỉnh sửa sản phẩm</h3>
                <button class="modal-close" id="closeEditModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" action="update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editProductId" name="id">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="editName">Tên sản phẩm</label>
                            <input type="text" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editCode">Mã sản phẩm</label>
                            <input type="text" id="editCode" name="code" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="editPrice">Giá bán (đ)</label>
                            <input type="number" id="editPrice" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="editOriginalPrice">Giá gốc (đ)</label>
                            <input type="number" id="editOriginalPrice" name="original_price">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="editCategory">Danh mục</label>
                            <select id="editCategory" name="category" required>
                                <option value="men">Thời trang nam</option>
                                <option value="women">Thời trang nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editSubcategory">Loại sản phẩm</label>
                            <select id="editSubcategory" name="subcategory" required>
                                <option value="thun">Áo thun</option>
                                <option value="hoodie">Áo Hoodie</option>
                                <option value="jeans">Quần jeans</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="editStock">Số lượng tồn kho</label>
                            <input type="number" id="editStock" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Trạng thái</label>
                            <select id="editStatus" name="status" required>
                                <option value="active">Đang bán</option>
                                <option value="inactive">Ngừng bán</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editDescription">Mô tả sản phẩm</label>
                        <textarea id="editDescription" name="description" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Hình ảnh sản phẩm</label>
                        <div class="current-image">
                            <img id="currentProductImage" src="" alt="Current Image" style="max-width: 200px; display: block; margin-bottom: 10px;">
                            <span class="image-change-notice">Chọn ảnh mới để thay đổi</span>
                        </div>
                        <input type="file" id="editImageUpload" name="image" accept="image/*">
                        <input type="hidden" id="currentImage" name="current_image">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="action-btn btn-delete" id="cancelEditBtn">Hủy</button>
                        <button type="submit" class="action-btn btn-view" id="saveEditBtn">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Chi tiết sản phẩm -->
    <div class="modal" id="viewProductModal">
        <div class="modal-content" style="max-width: 800px;">
            <div class="modal-header">
                <h3>Chi tiết sản phẩm</h3>
                <button class="modal-close" id="closeViewModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="product-detail-container">
                    <div class="product-images">
                        <img id="detailProductImage" src="" alt="Product Image" class="main-image">
                    </div>
                    <div class="product-info">
                        <h2 id="detailProductName"></h2>
                        <div class="price-section">
                            <span class="current-price" id="detailProductPrice"></span>
                            <span class="original-price" id="detailOriginalPrice"></span>
                        </div>
                        <div class="meta-info">
                            <p><strong>Mã sản phẩm:</strong> <span id="detailProductCode"></span></p>
                            <p><strong>Danh mục:</strong> <span id="detailProductCategory"></span></p>
                            <p><strong>Loại sản phẩm:</strong> <span id="detailProductSubcategory"></span></p>
                            <p><strong>Tồn kho:</strong> <span id="detailProductStock"></span></p>
                            <p><strong>Trạng thái:</strong> <span id="detailProductStatus"></span></p>
                        </div>
                        <div class="description-section">
                            <h3>Mô tả sản phẩm</h3>
                            <p id="detailProductDescription"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="action-btn btn-view" id="closeViewBtn">Đóng</button>
            </div>
        </div>
    </div>
    <!-- Modal Xác nhận xóa -->
    <div class="modal" id="confirmModal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3>Xác nhận xóa sản phẩm</h3>
                <button class="modal-close" id="closeConfirmModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="productToDelete">Áo thun nam cổ tròn</strong>?</p>
                <p class="text-danger">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <button class="action-btn btn-delete" id="cancelDeleteBtn">Hủy</button>
                <button class="action-btn btn-view" id="confirmDeleteBtn">Xác nhận xóa</button>
            </div>
        </div>
    </div>

    <script>
        // Xử lý modal xem chi tiết
        const viewModal = document.getElementById('viewProductModal');
        const closeViewBtn = document.getElementById('closeViewBtn');
        const closeViewModalBtn = document.getElementById('closeViewModal');

        // Xử lý khi nhấn nút Xem
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('btn-view') && !this.classList.contains('btn-edit') && !this.classList.contains('btn-delete')) {
                    const row = this.closest('tr');
                    const productData = {
                        name: row.querySelector('td:nth-child(2)').textContent,
                        price: row.querySelector('td:nth-child(3)').textContent,
                        stock: row.querySelector('td:nth-child(4)').textContent,
                        category: row.querySelector('td:nth-child(5)').textContent,
                        status: row.querySelector('.status').textContent,
                        image: row.querySelector('.product-image').src,
                        original_price: row.dataset.original_price,
                        code: row.dataset.code,
                        subcategory: row.dataset.subcategory,
                        description: row.dataset.description
                    };

                    // Điền dữ liệu vào modal
                    document.getElementById('detailProductName').textContent = productData.name;
                    document.getElementById('detailProductPrice').textContent = productData.price;
                    document.getElementById('detailOriginalPrice').textContent = productData.original_price ? `${parseInt(productData.original_price).toLocaleString()}đ` : '';
                    document.getElementById('detailProductStock').textContent = productData.stock;
                    document.getElementById('detailProductCategory').textContent = productData.category;
                    document.getElementById('detailProductSubcategory').textContent = productData.subcategory;
                    document.getElementById('detailProductCode').textContent = productData.code;
                    document.getElementById('detailProductStatus').textContent = productData.status;
                    document.getElementById('detailProductDescription').textContent = productData.description || 'Không có mô tả';
                    document.getElementById('detailProductImage').src = productData.image;

                    // Hiển thị modal
                    viewModal.style.display = 'flex';
                }
            });
        });

        // Edit Product Modal
        const editModal = document.getElementById('editProductModal');
        const closeEditBtn = document.getElementById('closeEditModal');
        const cancelEditBtn = document.getElementById('cancelEditBtn');

        // Xử lý khi nhấn nút Sửa
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const productId = row.dataset.id;

                // Lấy dữ liệu sản phẩm
                const productData = {
                    id: productId,
                    name: row.querySelector('td:nth-child(2)').textContent,
                    price: row.querySelector('td:nth-child(3)').textContent.replace(/[^\d]/g, ''),
                    original_price: row.dataset.original_price,
                    stock: row.querySelector('td:nth-child(4)').textContent,
                    code: row.dataset.code,
                    description: row.dataset.description,
                    category: row.querySelector('td:nth-child(5)').textContent === 'Nam' ? 'men' : 'women',
                    subcategory: row.dataset.subcategory,
                    status: row.querySelector('.status').classList.contains('status-active') ? 'active' : 'inactive',
                    image: row.querySelector('.product-image').src
                };

                // Điền dữ liệu vào form chỉnh sửa
                document.getElementById('editProductId').value = productData.id;
                document.getElementById('editName').value = productData.name;
                document.getElementById('editPrice').value = productData.price;
                document.getElementById('editOriginalPrice').value = productData.original_price;
                document.getElementById('editStock').value = productData.stock;
                document.getElementById('editCode').value = productData.code;
                document.getElementById('editDescription').value = productData.description;
                document.getElementById('editCategory').value = productData.category;
                document.getElementById('editSubcategory').value = productData.subcategory;
                document.getElementById('editStatus').value = productData.status;

                // Hiển thị ảnh hiện tại
                document.getElementById('currentProductImage').src = productData.image;
                document.getElementById('currentImage').value = productData.image.split('/').pop();

                // Hiển thị modal chỉnh sửa
                editModal.style.display = 'flex';
            });
        });

        
        // Xử lý submit form chỉnh sửa
        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            
            fetch('update_product.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Cập nhật sản phẩm thành công!');
                        editModal.style.display = 'none';
                        location.reload();
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert('Đã xảy ra lỗi khi cập nhật sản phẩm!');
                });
        });

        // Đóng modal chỉnh sửa
        closeEditBtn.addEventListener('click', () => {
            editModal.style.display = 'none';
        });

        cancelEditBtn.addEventListener('click', () => {
            editModal.style.display = 'none';
        });
        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === editModal) {
                editModal.style.display = 'none';
            }
        });
        // Đóng modal xem chi tiết
        closeViewBtn.addEventListener('click', () => {
            viewModal.style.display = 'none';
        });

        closeViewModalBtn.addEventListener('click', () => {
            viewModal.style.display = 'none';
        });

        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === viewModal) {
                viewModal.style.display = 'none';
            }
        });
        // Xử lý modal sản phẩm
        const productModal = document.getElementById('productModal');
        const addBtn = document.getElementById('addProductBtn');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');

        // Xử lý modal xác nhận xóa
        const confirmModal = document.getElementById('confirmModal');
        const closeConfirmBtn = document.getElementById('closeConfirmModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Mở modal thêm sản phẩm
        addBtn.addEventListener('click', () => {
            document.getElementById('modalTitle').textContent = 'Thêm sản phẩm mới';
            productModal.style.display = 'flex';
        });

        // Đóng modal
        closeBtn.addEventListener('click', () => {
            productModal.style.display = 'none';
            document.getElementById('productForm').reset();
            document.getElementById('imagePreview').innerHTML = '';
        });

        closeConfirmBtn.addEventListener('click', () => {
            confirmModal.style.display = 'none';
        });

        cancelBtn.addEventListener('click', () => {
            productModal.style.display = 'none';
            document.getElementById('productForm').reset();
            document.getElementById('imagePreview').innerHTML = '';
        });

        cancelDeleteBtn.addEventListener('click', () => {
            confirmModal.style.display = 'none';
        });

        // Xác nhận xóa sản phẩm
        confirmDeleteBtn.addEventListener('click', () => {
            alert('Đã xóa sản phẩm thành công!');
            confirmModal.style.display = 'none';
        });

        // Đóng modal khi click bên ngoài
        window.addEventListener('click', (e) => {
            if (e.target === productModal) {
                productModal.style.display = 'none';
                document.getElementById('productForm').reset();
                document.getElementById('imagePreview').innerHTML = '';
            }
            if (e.target === confirmModal) {
                confirmModal.style.display = 'none';
            }
        });

        // Xử lý tìm kiếm sản phẩm theo tên
        const searchBox = document.querySelector('.search-box');
        searchBox.addEventListener('input', function() {
            const keyword = this.value.trim().toLowerCase();
            const rows = document.querySelectorAll('.products-table tbody tr');
            rows.forEach(row => {
            const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (productName.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
            });
        });
        // Xử lý lọc theo danh mục
        const categoryFilter = document.getElementById('category-filter');
        categoryFilter.addEventListener('change', (e) => {
            const selectedCategory = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.products-table tbody tr');

            rows.forEach(row => {
            const rowCategory = row.cells[4].textContent.toLowerCase();
            if (selectedCategory === 'all' || rowCategory === selectedCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
            });
        });
       

        // Xử lý lọc theo trạng thái
        const statusSelect = document.getElementById('status');
        statusSelect.addEventListener('change', (e) => {
            const status = e.target.value;
            const rows = document.querySelectorAll('.products-table tbody tr');

            rows.forEach(row => {
            const rowStatus = row.querySelector('.status').classList.contains('status-active') ?
                'active' : 'inactive';

            if (status === 'all' || status === rowStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
            });
        });

        // Xử lý phân trang động
        const paginationBtns = document.querySelectorAll('.pagination-btn');
        const rowsPerPage = 10;
        const tableRows = Array.from(document.querySelectorAll('.products-table tbody tr'));
        let currentPage = 1;
        const totalPages = Math.ceil(tableRows.length / rowsPerPage);

        // Số lượng nút số trang hiển thị cùng lúc
        const maxVisiblePages = 3;

        function renderPagination() {
            const pagination = document.querySelector('.pagination');
            // Xóa các nút số cũ (giữ lại ← và →)
            pagination.querySelectorAll('.pagination-btn:not(:first-child):not(:last-child)').forEach(btn => btn.remove());

            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = startPage + maxVisiblePages - 1;
            if (endPage > totalPages) {
            endPage = totalPages;
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            // Thêm các nút số trang mới
            for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.className = 'pagination-btn' + (i === currentPage ? ' active' : '');
            btn.textContent = i;
            if (i === currentPage) btn.classList.add('active');
            pagination.insertBefore(btn, pagination.querySelector('.pagination-btn:last-child'));
            btn.addEventListener('click', function () {
                currentPage = i;
                showPage(currentPage);
                renderPagination();
            });
            }
        }

        function showPage(page) {
            tableRows.forEach((row, idx) => {
            if (idx >= (page - 1) * rowsPerPage && idx < page * rowsPerPage) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
            });
        }

        // Sự kiện cho nút ← và →
        document.querySelector('.pagination-btn:first-child').addEventListener('click', function () {
            if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
            renderPagination();
            }
        });
        document.querySelector('.pagination-btn:last-child').addEventListener('click', function () {
            if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
            renderPagination();
            }
        });

        // Khởi tạo
        showPage(currentPage);
        renderPagination();

        // Initial display
        showPage(currentPage);

        paginationBtns.forEach((btn, idx) => {
            btn.addEventListener('click', function () {
            if (btn.textContent === '←') {
                if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
                }
            } else if (btn.textContent === '→') {
                if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
                }
            } else {
                currentPage = parseInt(btn.textContent);
                showPage(currentPage);
            }
            });
        });
    </script>
</body>

</html>
<?php require_once('../admin/footer/admin-footer.php'); ?>