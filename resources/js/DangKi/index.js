const form = document.getElementById('registerForm');
form.addEventListener('submit', function(e) {
    e.preventDefault(); // Chặn gửi form
    alert('Đăng kí thành công!');
});