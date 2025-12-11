document.addEventListener("DOMContentLoaded", function () {
  function formatCurrency(value) {
    return value.toLocaleString('vi-VN') + ' đ';
  }

  function updateTotal() {
    let total = 0;
    document.querySelectorAll('.cart__row').forEach(row => {
      if (row.style.display !== 'none') {
        const price = parseInt(row.getAttribute('data-price'));
        const qty = parseInt(row.querySelector('.quantity-input').textContent);
        total += price * qty;
      }
    });

    const totalElement = document.querySelector('.order-summary .total strong');
    if (totalElement) {
      totalElement.textContent = formatCurrency(total);
    }
  }

  // document.querySelectorAll('.cart__row').forEach(row => {
  //   const decBtn = row.querySelector('.dec');
  //   const incBtn = row.querySelector('.inc');
  //   const qtyEl = row.querySelector('.quantity-input');
  //   const totalEl = row.querySelector('.cart__total');
  //   const price = parseInt(row.getAttribute('data-price'));

  //   decBtn.addEventListener('click', () => {
  //     let qty = parseInt(qtyEl.textContent);
  //     if (qty > 1) {
  //       qty--;
  //       qtyEl.textContent = qty;
  //       totalEl.textContent = formatCurrency(qty * price);
  //       updateTotal();
  //     }
  //   });

  //   incBtn.addEventListener('click', () => {
  //     let qty = parseInt(qtyEl.textContent);
  //     qty++;
  //     qtyEl.textContent = qty;
  //     totalEl.textContent = formatCurrency(qty * price);
  //     updateTotal();
  //   });
  // });

  // document.querySelectorAll('.icon_close').forEach(closeBtn => {
  //   closeBtn.addEventListener('click', () => {
  //     const row = closeBtn.closest('.cart__row');
  //     if (row) {
  //       row.style.display = 'none';
  //       updateTotal();
  //     }
  //   });
  // });

  // Tính tổng ban đầu khi load trang
  // updateTotal();
});