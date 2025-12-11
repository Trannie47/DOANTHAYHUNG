document.addEventListener("DOMContentLoaded", function () {
    // Khởi tạo bản đồ Leaflet
    initLeafletMap();

    // Khởi tạo nút back to top
    initBackToTopButton();

    // Khởi tạo chatbox
    initChatboxToggle();

    // Tích hợp Chatbase Chatbot
    loadChatbase();
});

// 👉 Hàm khởi tạo bản đồ Leaflet
function initLeafletMap() {
    const mapContainer = document.getElementById("map");
    if (!mapContainer) return;

    if (typeof L === "undefined") {
        const script = document.createElement("script");
        script.src = "https://unpkg.com/leaflet/dist/leaflet.js";
        script.onload = () => setupMap(mapContainer);
        document.body.appendChild(script);
    } else {
        setupMap(mapContainer);
    }
}

function setupMap(mapContainer) {
    const map = L.map(mapContainer).setView([12.6969684, 108.0799667], 15);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
    }).addTo(map);
    L.marker([12.6969684, 108.0799667])
        .addTo(map)
        .bindPopup("THIỆN TÂM MEDICAL")
        .openPopup();
}

// 👉 Nút quay về đầu trang
function initBackToTopButton() {
    const button = document.getElementById("backToTop");
    if (!button) return;

    window.addEventListener("scroll", () => {
        button.style.display = window.scrollY > 300 ? "block" : "none";
    });

    button.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}

// 👉 Tích hợp Chatbase Chatbot
function loadChatbase() {
    if (window.chatbase && window.chatbase("getState") === "initialized") return;

    window.chatbase = (...args) => {
        window.chatbase.q = window.chatbase.q || [];
        window.chatbase.q.push(args);
    };

    window.chatbase = new Proxy(window.chatbase, {
        get(target, prop) {
            if (prop === "q") return target.q;
            return (...args) => target(prop, ...args);
        },
    });

    const script = document.createElement("script");
    script.src = "https://www.chatbase.co/embed.min.js";
    script.id = "chatbase-script"; // Thay ID nếu cần
    document.body.appendChild(script);
}

// 👉 Hàm mở/đóng chatbox
function initChatboxToggle() {
    const openBtn = document.getElementById("open_chatbox");
    const chatbox = document.getElementById("chatbox");
    const closeBtn = document.getElementById("close_chatbox");
    if (!openBtn || !chatbox || !closeBtn) return;

    openBtn.addEventListener("click", () => {
        chatbox.style.display = "block";
        openBtn.style.display = "none";
    });

    closeBtn.addEventListener("click", () => {
        chatbox.style.display = "none";
        openBtn.style.display = "block";
    });
}
