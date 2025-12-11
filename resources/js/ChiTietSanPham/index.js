document.addEventListener('DOMContentLoaded', function () {
    // Nút tăng giảm số lượng
    const quantityInput = document.querySelector('.quantity-number');
    const plusButton = document.querySelector('.quantity-button.plus');
    const minusButton = document.querySelector('.quantity-button.minus');

    plusButton?.addEventListener('click', () => {
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });

    minusButton?.addEventListener('click', () => {
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });

    // Cuộn sản phẩm liên quan
    const relatedProductsContainer = document.querySelector('.related-products');
    const nextButton = document.querySelector('.next-button');

    nextButton?.addEventListener('click', () => {
        relatedProductsContainer.scrollLeft += 150;
    });

    // Splide Slider và thay đổi ảnh chính
    const mainImage = document.getElementById('image-product');

    // const splide = new Splide('.splide', {
    //     // type: 'loop',
    //     perPage: 3,
    //     lazyLoad: 'nearby',
    //     autoplay: true,
    //     interval: 3000,
    //     pauseOnHover: true,
    //     rewind: true,
    // });
    var main = new Splide('#main-slider', {
        type       : 'loop',
        heightRatio: 1,
        pagination : false,
        arrows     : false,
        cover      : true,
        rewind     : true,
      });
    
      

    var thumbnails = new Splide('#thumbnail-slider', {
        rewind          : true,
        fixedWidth      : 104,
        fixedHeight     : 58,
        isNavigation    : true,
        gap             : 10,
        focus           : 'center',
        pagination      : false,
        cover           : true,
        perPage         : 1,
        dragMinThreshold: {
          mouse: 4,
          touch: 10,
        },
        breakpoints : {
          640: {
            fixedWidth  : 66,
            fixedHeight : 38,
          },
        },
      } );

    // splide.mount();
    main.sync( thumbnails );
    main.mount();
    thumbnails.mount();

    
});
