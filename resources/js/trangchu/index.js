document.addEventListener('DOMContentLoaded', function () {
  // --- Khởi tạo Splide ---
  const splide = new Splide('.splide', {
    type: 'loop',
    perPage: 1,
    lazyLoad: 'nearby',
    autoplay: true,
    interval: 3000,
    pauseOnHover: true,
    rewind: true,
    breakpoints: {
      768: {
        height: '20rem'
      }
    }
  });

  splide.mount();

  // --- Các phần tử scroll news list ---
  const newsList = document.querySelector('.news-list');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');
  const firstItem = document.querySelector('.news-item');
  const width = firstItem ? firstItem.offsetWidth : 0;

  if (!newsList || !prevBtn || !nextBtn || !firstItem) {
    console.warn('Các phần tử news list hoặc buttons chưa tồn tại.');
    return;
  }

  // --- Hàm cập nhật trạng thái nút ---
  function updateButtons() {
    if (newsList.scrollLeft <= 0) {
      prevBtn.classList.add('hidden');
    } else {
      prevBtn.classList.remove('hidden');
    }

    if (newsList.scrollWidth - newsList.clientWidth - newsList.scrollLeft <= 1) {
      nextBtn.classList.add('hidden');
    } else {
      nextBtn.classList.remove('hidden');
    }
  }

  // --- Cập nhật lần đầu ---
  updateButtons();

  // --- Sự kiện nút Prev/Next ---
  prevBtn.addEventListener('click', () => {
    newsList.scrollBy({ left: -width, behavior: 'smooth' });
  });

  nextBtn.addEventListener('click', () => {
    newsList.scrollBy({ left: width, behavior: 'smooth' });
  });

  // --- Cập nhật khi scroll ---
  newsList.addEventListener('scroll', updateButtons);

  // --- Nếu cần, thêm resize để cập nhật width item ---
  window.addEventListener('resize', () => {
    const newFirst = document.querySelector('.news-item');
    if (newFirst) width = newFirst.offsetWidth;
  });
});
