document.addEventListener('DOMContentLoaded', function () {

    // ======================
    //  SPLIDE SLIDER
    // ======================
    const splide = new Splide('.splide', {
        type: 'loop',
        perPage: 1,
        lazyLoad: 'nearby',
        autoplay: true,
        interval: 3000,
        pauseOnHover: true,
        rewind: true,
        breakpoints: {
            768: { height: '20rem' }
        }
    });
    splide.mount();


    // ======================
    //  NEWS LIST SLIDER
    // ======================
    const newsList = document.querySelector('.news-list');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const firstItem = document.querySelector('.news-item');

    let newsItemWidth = firstItem ? firstItem.offsetWidth : 0;

    if (newsList && prevBtn && nextBtn && firstItem) {

        function updateNewsButtons() {
            prevBtn.classList.toggle('hidden', newsList.scrollLeft <= 0);

            const isEnd =
                newsList.scrollWidth - newsList.clientWidth - newsList.scrollLeft <= 1;

            nextBtn.classList.toggle('hidden', isEnd);
        }

        updateNewsButtons();

        prevBtn.addEventListener('click', () => {
            newsList.scrollBy({ left: -newsItemWidth, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            newsList.scrollBy({ left: newsItemWidth, behavior: 'smooth' });
        });

        newsList.addEventListener('scroll', updateNewsButtons);

        window.addEventListener('resize', () => {
            const first = document.querySelector('.news-item');
            if (first) newsItemWidth = first.offsetWidth;
        });
    }


    // ==============================================
    //  FUNCTION TÁI SỬ DỤNG CHO 2 SLIDER SẢN PHẨM
    // ==============================================
    function setupProductSlider(listId, leftBtnClass, rightBtnClass) {
        const list = document.getElementById(listId);
        const btnLeft = document.querySelector(leftBtnClass);
        const btnRight = document.querySelector(rightBtnClass);
        const cardWidth = 250;

        if (!list || !btnLeft || !btnRight) return;

        function updateArrows() {

            // Nếu không đủ tràn ngang → ẩn hết
            if (list.scrollWidth <= list.clientWidth) {
                btnLeft.style.display = "none";
                btnRight.style.display = "none";
                return;
            }

            // Mặc định hiện cả hai
            btnLeft.style.display = "block";
            btnRight.style.display = "block";

            // Ở đầu → ẩn trái
            if (list.scrollLeft <= 0) {
                btnLeft.style.display = "none";
            }

            // Ở cuối → ẩn phải
            if (list.scrollLeft + list.clientWidth >= list.scrollWidth - 1) {
                btnRight.style.display = "none";
            }
        }

        // Sự kiện nút scroll
        btnLeft.onclick = () => {
            list.scrollBy({ left: -cardWidth * 2, behavior: "smooth" });
            setTimeout(updateArrows, 300);
        };

        btnRight.onclick = () => {
            list.scrollBy({ left: cardWidth * 2, behavior: "smooth" });
            setTimeout(updateArrows, 300);
        };

        // Khi scroll bằng tay
        list.addEventListener("scroll", updateArrows);

        // Khi resize
        window.addEventListener("resize", updateArrows);

        // Gọi lần đầu
        updateArrows();
    }

    // ==========================
    // ÁP DỤNG CHO 2 DANH SÁCH
    // ==========================
    setupProductSlider("kmList", ".km-left", ".km-right");
    setupProductSlider("newList", ".new-left", ".new-right");

});
