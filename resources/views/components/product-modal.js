// product-modal.js
document.addEventListener('DOMContentLoaded', function () {

  // Hàm rút gọn query selector
  const $ = (sel, ctx = document) => ctx.querySelector(sel);

  // Lấy các phần tử trong modal
  const modal = document.getElementById('productModal');
  const modalImage = $('#modal-image');
  const modalName = $('#modal-name');
  const modalPrice = $('#modal-price');
  const modalOldPrice = $('#modal-old-price');
  const qtyInput = $('#modal-qty');
  const qtyHidden = $('#modal-qty-hidden');
  const btnMinus = $('.qty-minus');
  const btnPlus = $('.qty-plus');
  const closeBtn = $('.modal-close');
  const buyNowBtn = $('#modal-buy-now');
  const addCartForm = $('#modal-form');

  // Kiểm tra phần tử bắt buộc
  if (!modal || !modalImage || !modalName || !modalPrice || !qtyInput || !qtyHidden || !addCartForm) {
    console.warn('Thiếu phần tử modal — JS không thể chạy');
    return;
  }

  // Format tiền VNĐ
  function formatVND(n) {
    if (n === null || n === undefined) return '';
    return new Intl.NumberFormat('vi-VN').format(n) + ' đ';
  }

  // Hàm gán giá + đơn vị cho UI
  function setPriceAndUnit(priceNumber, unitText, oldPriceNumber = null) {

    // Xóa nội dung cũ
    while (modalPrice.firstChild) modalPrice.removeChild(modalPrice.firstChild);

    // Gắn giá chính
    const priceText = document.createTextNode(formatVND(priceNumber) + (unitText ? ' ' : ''));
    modalPrice.appendChild(priceText);

    // Gắn đơn vị
    if (unitText) {
      const spanUnit = document.createElement('span');
      spanUnit.className = 'modal-unit';
      spanUnit.textContent = '/' + unitText;
      modalPrice.appendChild(spanUnit);
    }

    // Giá cũ: chỉ hiện nếu có khuyến mãi
    if (oldPriceNumber && oldPriceNumber > priceNumber) {
      modalOldPrice.style.display = 'block';
      modalOldPrice.textContent = formatVND(oldPriceNumber);
    } else {
      modalOldPrice.style.display = 'none';
      modalOldPrice.textContent = '';
    }
  }

  // Hàm mở modal
  window.openProductModal = function (product) {
    if (!product) return;

    // Hình sản phẩm
    const img = Array.isArray(product.HinhAnh) && product.HinhAnh[0]
      ? product.HinhAnh[0]
      : (product.HinhAnh || '/asset/img/logo.png');

    modalImage.src = img;
    modalImage.alt = product.tenThuoc || 'Sản phẩm';

    // Tên sản phẩm
    modalName.textContent = product.tenThuoc || '';

    // ======== XỬ LÝ GIÁ =========
    let displayPrice; // giá để hiển thị chính
    let oldPrice = null; // giá cũ (nếu có KM)

    if (product.giaKhuyenMai && product.giaKhuyenMai > 0) {
      // Có khuyến mãi
      displayPrice = product.giaKhuyenMai;
      oldPrice = product.GiaTien;
    } else {
      // Không có khuyến mãi → chỉ hiện giá gốc
      displayPrice = product.GiaTien || 0;
      oldPrice = null;
    }

    // Gán giá + đơn vị vào UI
    setPriceAndUnit(displayPrice, product.DVTinh || '', oldPrice);

    // Reset số lượng
    qtyInput.value = 1;
    qtyHidden.value = 1;

    // Gán action form cho thêm vào giỏ
    addCartForm.action = '/cart/add/' + encodeURIComponent(product.maThuoc);

    // Xử lý nút Mua ngay
    if (buyNowBtn) {
      buyNowBtn.onclick = function (e) {
        e.preventDefault();
        const q = Math.max(1, parseInt(qtyInput.value || 1));
        window.location.href =
          '/mua-ngay/' + encodeURIComponent(product.maThuoc) + '?quantity=' + q;
      };
    }

    // Hiện modal
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');

    // Khóa scroll trang
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
  };

  // Đóng modal
  function closeModal() {
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
    document.documentElement.style.overflow = '';
    document.body.style.overflow = '';
  }

  // Nút X
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  // Click ra ngoài
  modal.addEventListener('click', function (e) {
    if (e.target === modal) closeModal();
  });

  // ESC
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  // Tăng / giảm số lượng
  if (btnMinus) btnMinus.addEventListener('click', function () {
    let v = Math.max(1, parseInt(qtyInput.value || 1) - 1);
    qtyInput.value = v;
    qtyHidden.value = v;
  });

  if (btnPlus) btnPlus.addEventListener('click', function () {
    let v = Math.max(1, parseInt(qtyInput.value || 1) + 1);
    qtyInput.value = v;
    qtyHidden.value = v;
  });

  qtyInput.addEventListener('input', function () {
    let v = parseInt(qtyInput.value || 1);
    if (!Number.isFinite(v) || v <= 0) v = 1;
    qtyInput.value = v;
    qtyHidden.value = v;
  });

  // AJAX fetch sản phẩm
  window.fetchAndOpenProduct = function (maThuoc) {
    if (!maThuoc) return;

    fetch('/ajax/product/' + encodeURIComponent(maThuoc))
      .then(res => {
        if (!res.ok) throw new Error('Không lấy được sản phẩm');
        return res.json();
      })
      .then(data => openProductModal(data))
      .catch(err => {
        console.error(err);
        alert('Không thể tải sản phẩm.');
      });
  };

  // Gán event cho tất cả nút "Chọn sản phẩm"
  document.querySelectorAll('.btn-item').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const id = this.dataset.id;
      fetchAndOpenProduct(id);
    });
  });

});
