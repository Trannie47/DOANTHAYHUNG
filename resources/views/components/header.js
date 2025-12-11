document.addEventListener("DOMContentLoaded", function () {
    // Chạy tất cả các chức năng của Header
    initHeaderFeatures();
    addRemoveItemEvent();
    initTypingEffect("#search-input", ["Tìm thuốc ...", "Tin tức ...", "Dinh Dưỡng..."]);
});

function initHeaderFeatures() {
    // Delay 0.5s để đảm bảo DOM render xong
    setTimeout(() => {
        const menuIcon = document.querySelector(".menu-icon");
        const navMenu = document.querySelector(".menu-bar");

        const dropdownToggle = document.querySelector(".dropdown-toggle");
        const dropdownMenu = document.querySelector(".dropdown-menu");

        const cartIcon = document.querySelector(".fa-cart-shopping");
        const cartModal = document.getElementById("cart-modal");

        const userLogin = document.getElementById("user-login");
        const userModel = document.getElementById("user-model");

        function closeAll() {
            navMenu?.classList.remove("active");
            dropdownMenu?.classList.remove("show");
            cartModal?.classList.remove("show");
            userModel?.classList.remove("show");
        }

        // Menu chính
        if (menuIcon && navMenu) {
            menuIcon.addEventListener("click", function (e) {
                e.stopPropagation();
                const isActive = navMenu.classList.contains("active");
                closeAll();
                if (!isActive) navMenu.classList.add("active");
            });
            navMenu.addEventListener("click", e => e.stopPropagation());
        }

        // Dropdown
        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener("click", function (e) {
                e.stopPropagation();
                const isShow = dropdownMenu.classList.contains("show");
                closeAll();
                if (!isShow) dropdownMenu.classList.add("show");
            });
            dropdownMenu.addEventListener("click", e => e.stopPropagation());
        }

        // Cart modal
        if (cartIcon && cartModal) {
            cartIcon.addEventListener("click", function (e) {
                e.stopPropagation();
                const isShow = cartModal.classList.contains("show");
                closeAll();
                if (!isShow) cartModal.classList.add("show");
            });
            cartModal.addEventListener("click", e => e.stopPropagation());
        }

        if (userLogin && userModel) {
            userLogin.addEventListener("click", function (e) {
                e.stopPropagation();
                const isShow = userModel.classList.contains("show");
                closeAll();
                if (!isShow) userModel.classList.add("show");
            });
            userModel.addEventListener("click", e => e.stopPropagation());
        }

        // Click ngoài đóng hết
        document.addEventListener("click", closeAll);
    }, 500);
}

function addRemoveItemEvent() {
    const removeButtons = document.querySelectorAll(".remove");

    removeButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.stopPropagation();
            const itemId = this.parentNode.id;
            removeItem(itemId);
            updateTotalPrice();
        });
    });
}

function removeItem(itemId) {
    const item = document.getElementById(itemId);
    if (item) item.remove();
}

function updateTotalPrice() {
    // let total = 0;
    // const cartItems = document.querySelectorAll(".cart-items li");

    // cartItems.forEach(item => {
    //     const priceText = item.querySelector(".storage-price")?.innerText || "0";
    //     const price = parseInt(priceText.replace(/\D/g, '')) || 0;
    //     total += price;
    // });

    // const totalPriceElement = document.querySelector(".cart-footer p");
    // if (totalPriceElement) {
    //     totalPriceElement.innerHTML = `<strong>Tổng:</strong> ${total.toLocaleString()} đ`;
    // }
}

function initTypingEffect(inputSelector, placeholders) {
    const input = document.querySelector(inputSelector);
    if (!input) return;

    let placeholderIndex = 0;
    let charIndex = 0;
    const typingDelay = 100;
    const erasingDelay = 60;
    const newTextDelay = 2000;

    function typePlaceholder() {
        if (charIndex < placeholders[placeholderIndex].length) {
            input.setAttribute('placeholder', placeholders[placeholderIndex].substring(0, charIndex + 1));
            charIndex++;
            setTimeout(typePlaceholder, typingDelay);
        } else {
            setTimeout(erasePlaceholder, newTextDelay);
        }
    }

    function erasePlaceholder() {
        if (charIndex > 0) {
            input.setAttribute('placeholder', placeholders[placeholderIndex].substring(0, charIndex - 1));
            charIndex--;
            setTimeout(erasePlaceholder, erasingDelay);
        } else {
            placeholderIndex = (placeholderIndex + 1) % placeholders.length;
            setTimeout(typePlaceholder, typingDelay + 500);
        }
    }

    setTimeout(typePlaceholder, newTextDelay);
}
