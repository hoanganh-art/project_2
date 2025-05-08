// ==================== PHẦN JAVASCRIPT ====================
document.addEventListener('DOMContentLoaded', function () {
    // Xử lý thêm vào giỏ hàng
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            const productCard = this.closest('.product-card');
            const productName = productCard.querySelector('.product-title').textContent;
            alert(`Đã thêm ${productName} vào giỏ hàng`);
            // Có thể thêm AJAX call ở đây để xử lý thêm vào giỏ hàng thực tế
        });
    });

    // Xử lý nút yêu thích
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function () {
            this.classList.toggle('active');
            // Có thể thêm logic xử lý yêu thích ở đây
        });
    });
});