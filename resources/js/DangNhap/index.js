const form = document.getElementById('loginForm');
form.addEventListener('submit', function(e) {
    e.preventDefault(); // Chặn gửi form
    alert('Đăng nhập thành công!');
});