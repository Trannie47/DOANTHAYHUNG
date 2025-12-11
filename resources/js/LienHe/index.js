document.querySelector(".contact-form").addEventListener("submit", function (e) {
  e.preventDefault(); // Ngăn submit form

  // Lấy giá trị từ form
  const name = document.getElementById("name").value.trim();
  const phone = document.getElementById("phone").value.trim();
  const email = document.getElementById("email").value.trim();
  const message = document.getElementById("message").value.trim();

  // Khởi tạo cờ kiểm tra và xóa thông báo lỗi cũ
  let isValid = true;
  document.getElementById("phone-error").textContent = "";
  document.getElementById("email-error").textContent = "";
  document.getElementById("message-error").textContent = "";
  document.getElementById("name-error").textContent = "";

  // Kiểm tra tên (không chứa số)
  const hasNumber = /\d/;
  if (hasNumber.test(name)) {
    document.getElementById("name-error").textContent = "Tên không được chứa số.";
    isValid = false;
  }

  // Kiểm tra số điện thoại (chỉ chứa số, ít nhất 9 số)
  const phoneRegex = /^\d{9,}$/;
  if (!phoneRegex.test(phone)) {
    document.getElementById("phone-error").textContent = "Số điện thoại không hợp lệ (chỉ chứa số, ít nhất 9 chữ số).";
    isValid = false;
  }

  // Kiểm tra email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    document.getElementById("email-error").textContent = "Email không hợp lệ.";
    isValid = false;
  }

  // Kiểm tra lời nhắn
  if (message.length <= 6) {
    document.getElementById("message-error").textContent = "Lời nhắn phải dài hơn 6 ký tự.";
    isValid = false;
  }

  // Nếu tất cả hợp lệ
  if (isValid) {
    alert("Gửi lời nhắn thành công!");
    this.reset(); // Reset form
  }
});
