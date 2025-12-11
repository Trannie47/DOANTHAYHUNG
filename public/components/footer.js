document.addEventListener("DOMContentLoaded", function () {
    fetch("/asset/component/Footer/footer.html")
        .then(response => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.text();
        })
        .then(data => {
            document.getElementById("footer-container").innerHTML = data;
            loadLeafletScript(initLeafletMap);
            initBackToTopButton();
        })
        .catch(error => console.error("Error loading footer:", error));

    // Khởi tạo chatbox sau khi DOM sẵn sàng
    initChatboxToggle();
});

// 👉 Hàm tải Leaflet script (nếu chưa có)
function loadLeafletScript(callback) {
    if (typeof L !== "undefined") {
        callback();
        return;
    }
    const script = document.createElement("script");
    script.src = "https://unpkg.com/leaflet/dist/leaflet.js";
    script.onload = callback;
    document.body.appendChild(script);
}

// 👉 Hàm khởi tạo bản đồ
function initLeafletMap() {
    const mapContainer = document.getElementById("map");
    if (!mapContainer) {
        console.error("Không tìm thấy phần tử #map để hiển thị bản đồ.");
        return;
    }

    const map = L.map("map").setView([12.6969684, 108.0799667], 15);
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
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}

// 👉 Tích hợp Chatbase Chatbot
(function () {
    if (!window.chatbase || window.chatbase("getState") !== "initialized") {
        window.chatbase = (...args) => {
            window.chatbase.q = window.chatbase.q || [];
            window.chatbase.q.push(args);
        };

        window.chatbase = new Proxy(window.chatbase, {
            get(target, prop) {
                if (prop === "q") return target.q;
                return (...args) => target(prop, ...args);
            }
        });
    }

    const loadChatbase = function () {
        const script = document.createElement("script");
        script.src = "https://www.chatbase.co/embed.min.js";
        script.id = "uq5aassurwhaot1jqdjyy5054wvdip7c"; // Thay ID nếu cần
        script.domain = "www.chatbase.co";
        document.body.appendChild(script);
    };

    if (document.readyState === "complete") {
        loadChatbase();
    } else {
        window.addEventListener("load", loadChatbase);
    }
})();

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
