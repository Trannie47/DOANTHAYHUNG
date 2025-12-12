<div id="productModal" class="modal" aria-hidden="true" style="display:none;">
  <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modal-title">

    <button class="modal-close" aria-label="Đóng modal">&times;</button>

    <div class="modal-body">

      <div class="modal-left">
        <img id="modal-image" src="" alt="Hình sản phẩm">
      </div>

      <div class="modal-right">
        <span class="badge">Miễn phí vận chuyển cho đơn hàng 0đ</span>
        <h2 id="modal-name">Tên sản phẩm</h2>
        <div class="old-price" id="modal-old-price" style="display:none;"></div>
        <div id="modal-price" class="price">0 đ</div>

        <div class="quantity-box" aria-label="Chọn số lượng">
          <button type="button" class="qty-minus" aria-label="Giảm số lượng">−</button>
          <input type="number" id="modal-qty" value="1" min="1" step="1" aria-live="polite">
          <button type="button" class="qty-plus" aria-label="Tăng số lượng">+</button>
        </div>

        <form id="modal-form" method="POST" action="">
          @csrf
          <input type="hidden" name="quantity" id="modal-qty-hidden" value="1">

          <button type="button" id="modal-buy-now" class="btn-buy">Mua ngay</button>
          <button type="submit" id="modal-add-cart" class="btn-add-cart">Thêm vào giỏ</button>
        </form>

      </div>

    </div>
  </div>
</div>
