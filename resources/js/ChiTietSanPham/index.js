document.addEventListener('DOMContentLoaded', function () {

    // ===== NÚT TĂNG GIẢM SỐ LƯỢNG =====
    const quantityInput = document.querySelector('.quantity-number');
    const plusButton = document.querySelector('.quantity-button.plus');
    const minusButton = document.querySelector('.quantity-button.minus');

    // 🔹 input hidden cho Mua ngay & Thêm giỏ
    const quantityBuy  = document.getElementById('quantityBuy');
    const quantityCart = document.getElementById('quantityCart');

    function syncQuantity() {
        if (!quantityInput) return;

        let q = parseInt(quantityInput.value) || 1;
        if (q < 1) q = 1;

        quantityInput.value = q;

        if (quantityBuy) {
            quantityBuy.value = q;
        }

        if (quantityCart) {
            quantityCart.value = q;
        }
    }

    plusButton?.addEventListener('click', () => {
        quantityInput.value = parseInt(quantityInput.value) + 1;
        syncQuantity();
    });

    minusButton?.addEventListener('click', () => {
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            syncQuantity();
        }
    });

    quantityInput?.addEventListener('input', syncQuantity);

    syncQuantity(); // chạy lần đầu


    // ===== CUỘN SẢN PHẨM LIÊN QUAN =====
    const relatedProductsContainer = document.querySelector('.related-products');
    const nextButton = document.querySelector('.next-button');

    nextButton?.addEventListener('click', () => {
        relatedProductsContainer.scrollLeft += 150;
    });


    // ===== SPLIDE SLIDER =====
    const mainImage = document.getElementById('image-product');

    var main = new Splide('#main-slider', {
        type        : 'loop',
        heightRatio : 1,
        pagination  : false,
        arrows      : false,
        cover       : true,
        rewind      : true,
    });

    var thumbnails = new Splide('#thumbnail-slider', {
        rewind           : true,
        fixedWidth       : 104,
        fixedHeight      : 58,
        isNavigation     : true,
        gap              : 10,
        focus            : 'center',
        pagination       : false,
        cover            : true,
        perPage          : 1,
        dragMinThreshold : {
            mouse: 4,
            touch: 10,
        },
        breakpoints: {
            640: {
                fixedWidth  : 66,
                fixedHeight : 38,
            },
        },
    });

    main.sync(thumbnails);
    main.mount();
    thumbnails.mount();

});
