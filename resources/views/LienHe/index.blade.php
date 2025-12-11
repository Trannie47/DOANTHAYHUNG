{{-- resources\views\LienHe\index.blade.php --}}
@extends('app')

@section('title', 'Liên Hệ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/LienHe') }}?v={{ time() }}">
@endpush

@section('content')

    <!-- Code  -->
    <div class="Contact-wrapper">
      <div class="info-company-container">
        <h2 class="contact-title">Thông tin công ty</h2>
        <div class="info-company-decription">
          <p class="info-company-title">Tên công ty</p>
          <p>CÔNG TY TNHH THƯƠNG MẠI THIỆN TÂM MEDICAL</p>
        </div>
        <div class="info-company-decription">
          <p class="info-company-title">Email:</p>
          <p><a href="mailto:tranghuyenmail.com">tranghuyen@gmail.com</a></p>
        </div>
        <div class="info-company-decription">
          <p class="info-company-title">Hotline: </p>
          <p><a href="tel: 0123456789"> 0123456789</a></p>
        </div>
      </div>
      <section class="Contact-container">
        <h2 class="contact-title">LIÊN HỆ</h2>
        <form class="contact-form">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Tên:</label>
              <input type="text" id="name" placeholder="Tên">
              <div class="error-message" id="name-error"></div>
            </div>
            <div class="form-group">
              <label for="phone">Số điện thoại:</label>
              <input type="text" id="phone" placeholder="+84">
              <div class="error-message" id="phone-error"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group"> 
              <label for="email">Email:</label>
              <input type="email" id="email" placeholder="example@gmail.com">
              <div class="error-message" id="email-error"></div>
            </div>
            <div class="form-group">
              <label for="subject">Tiêu đề:</label>
              <input type="text" id="subject" placeholder="Tiêu đề">
            </div>
          </div>
          <div class="form-group full">
            <label for="message">Lời nhắn:</label>
            <textarea id="message" rows="6" placeholder="Lời nhắn"></textarea>
            <div class="error-message" id="message-error"></div>
          </div>
          <div class="form-submit">
            <button type="submit">Gửi lời nhắn</button>
          </div>
        </form>
      </section>
    </div>

    <!-- Chatbox -->
    <button id="open_chatbox" title="Mở chat"><i class="fa-regular fa-message"></i></button>
    <div id="chatbox" style="display:none;">
        <button id="close_chatbox" title="Đóng chatbox">×</button>
        <iframe src="https://www.chatbase.co/chatbot-iframe/iKp1d0Z7u4lW7wMauNcBu" width="100%" height="100%" frameborder="0" style="min-height: 500px;"></iframe>
    </div>

    <button id="backToTop" title="Về đầu trang"><i class="fa-solid fa-angle-up"></i></button>

@endsection

@push('scripts')
    <script src="{{ asset('js/LienHe') }}?v={{ time() }}"></script>
@endpush