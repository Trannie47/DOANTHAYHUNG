document.addEventListener("DOMContentLoaded", function () {
    initHeaderFeatures();
    addRemoveItemEvent();
    initTypingEffect("#search-input", ["Tìm thuốc ...", "Tin tức ...", "Dinh Dưỡng..."]);
    initSearchDropdown();
});

/* ================= HEADER CORE ================= */

function initHeaderFeatures() {
    setTimeout(() => {
        const menuIcon = document.querySelector(".menu-icon");
        const navMenu = document.querySelector(".menu-bar");

        const dropdownToggle = document.querySelector(".dropdown-toggle");
        const dropdownMenu = document.querySelector(".dropdown-menu");

        const cartIcon = document.querySelector(".fa-cart-shopping");
        const cartModal = document.getElementById("cart-modal");

        const userLogin = document.getElementById("user-login");
        const userModel = document.getElementById("user-model");

        const searchresult = document.getElementById("search-result");
        const searchdropdown = document.querySelector(".search-dropdown");

        function closeAll() {
            navMenu?.classList.remove("active");
            dropdownMenu?.classList.remove("show");
            cartModal?.classList.remove("show");
            userModel?.classList.remove("show");
            searchresult?.classList.add("d-none");
            searchdropdown?.classList.remove("show");
        }

        if (menuIcon && navMenu) {
            menuIcon.addEventListener("click", e => {
                e.stopPropagation();
                const isActive = navMenu.classList.contains("active");
                closeAll();
                if (!isActive) navMenu.classList.add("active");
            });
        }

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener("click", e => {
                e.stopPropagation();
                const isShow = dropdownMenu.classList.contains("show");
                closeAll();
                if (!isShow) dropdownMenu.classList.add("show");
            });
        }

        if (cartIcon && cartModal) {
            cartIcon.addEventListener("click", e => {
                e.stopPropagation();
                const isShow = cartModal.classList.contains("show");
                closeAll();
                if (!isShow) cartModal.classList.add("show");
            });
        }

        if (userLogin && userModel) {
            userLogin.addEventListener("click", e => {
                e.stopPropagation();
                const isShow = userModel.classList.contains("show");
                closeAll();
                if (!isShow) userModel.classList.add("show");
            });
        }

        document.addEventListener("click", closeAll);
    }, 300);
}

/* ================= SEARCH DROPDOWN ================= */

function initSearchDropdown() {
    const input = document.getElementById("search-input");
    const dropdown = document.getElementById("search-result");
    if (!input || !dropdown) return;

    let timer = null;

    input.addEventListener("input", function () {
        const keyword = this.value.trim();
        clearTimeout(timer);

        if (keyword.length < 2) {
            dropdown.classList.add("d-none");
            dropdown.innerHTML = "";
            return;
        }

        timer = setTimeout(() => {
            fetch(`/search-thuoc?q=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => renderSearchResult(data))
                .catch(() => {
                    dropdown.innerHTML =
                        `<div class="search-empty">Lỗi tìm kiếm</div>`;
                    dropdown.classList.remove("d-none");
                });
        }, 300);
    });

    function renderSearchResult(items) {
        if (!items || !items.length) {
            // dropdown.innerHTML =
            //     `<div class="search-empty">Không tìm thấy sản phẩm</div>`;
            dropdown.classList.remove("d-none");
            return;
        }

        dropdown.innerHTML = items.map(item => {
            const gia = item.gia;
            const giaKM = item.giaKM;

            let priceHtml = "";

            if (giaKM && giaKM != '0' ) {
                priceHtml = `
            <div class="price">
                <span class="original-price">
                    ${gia} đ
                </span>
                <span class="sale-price">
                    ${giaKM} đ
                </span>
            </div>
        `;
            } else {
                priceHtml = `
            <div class="price">
                ${gia} đ
            </div>
        `;
            }

            return `
        <a href="/thuoc/${item.maThuoc}" class="search-item">
            <img src="${item.hinhAnh}" alt="${item.tenThuoc}">
            <div class="info">
                <div class="name">${item.tenThuoc}</div>
                ${priceHtml}
            </div>
        </a>
    `;
        }).join("");


        dropdown.classList.remove("d-none");
    }
}


/* ================= CART ================= */

function addRemoveItemEvent() {
    document.querySelectorAll(".remove").forEach(btn => {
        btn.addEventListener("click", e => {
            e.stopPropagation();
            const itemId = btn.parentNode.id;
            document.getElementById(itemId)?.remove();
        });
    });
}

/* ================= PLACEHOLDER TYPING ================= */

function initTypingEffect(inputSelector, placeholders) {
    const input = document.querySelector(inputSelector);
    if (!input) return;

    let pIndex = 0, cIndex = 0;

    function type() {
        if (cIndex < placeholders[pIndex].length) {
            input.placeholder = placeholders[pIndex].substring(0, ++cIndex);
            setTimeout(type, 80);
        } else {
            setTimeout(erase, 1500);
        }
    }

    function erase() {
        if (cIndex > 0) {
            input.placeholder = placeholders[pIndex].substring(0, --cIndex);
            setTimeout(erase, 50);
        } else {
            pIndex = (pIndex + 1) % placeholders.length;
            setTimeout(type, 500);
        }
    }

    type();
}
