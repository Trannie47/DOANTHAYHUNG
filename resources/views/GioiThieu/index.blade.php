{{-- resources\views\LienHe\index.blade.php --}}
@extends('app')

@section('title', 'Giới thiệu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/GioiThieu') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="about-container">
        <!-- Cột hình ảnh -->
        <div class="image-column">
            <img src="/asset/img/gt1.png" alt="banner" />
            <img src="/asset/img/banner.png" alt="banner2" />
            <img src="/asset/img/gt2.png" alt="banner3" />
        </div>

        <!-- Cột nội dung -->
        <div class="text-column">
            <h1>Thiện Tâm Medical</h1>
            <p>Thiện Tâm Medical là một website cung cấp thuốc và tư vấn y tế trực tuyến, là đồ án môn học thực hành
                nhập môn web và ứng dụng tại Trường Đại học Công nghệ Sài Gòn.</p>
            <p>Thị trường dược phẩm và dịch vụ y tế trực tuyến tại Việt Nam đang phát triển mạnh mẽ, đặc biệt trong bối
                cảnh nhu cầu chăm sóc sức khỏe cá nhân ngày càng tăng và sự tiện lợi của công nghệ số...</p>
            <p>Nhu cầu thị trường về việc tiếp cận thuốc và tư vấn y tế chất lượng, đáng tin cậy là vô cùng lớn...</p>
            <p>Bên cạnh nhu cầu thị trường cao, trách nhiệm và mong muốn đóng góp vào việc nâng cao sức khỏe cộng đồng
                cũng là một yếu tố quan trọng thúc đẩy dự án này...</p>

            <h2>Các chức năng đã thực hiện</h2>
            <ul>
                <li>Tương thích với thiết bị di động</li>
                <li>Cập nhật số lượng và giá tiền ở giỏ hàng <a href="/pages/GioHang/index.html">Xem demo</a> </li>
                <li>Trang chi tiết giỏ hàng <a href="/pages/GioHang/index.html">Xem demo</a></li>
                <li>Chức năng hiển thị sản phẩm theo danh mục <a href="/pages/LoaiThuoc/index.html">Xem demo</a></li>
                <li>Chức năng hiển thị chi tiết sản phẩm <a href="/pages/ChiTietSanPham/index.html">Xem demo</a></li>
                <li>Carousel tin tức <a href="/pages/Trangchu/index.html">Xem demo</a></li>
                <li>Hiệu ứng di chuyển đến header 2 <a href="/pages/ChiTietTinTuc/index.html">Xem demo</a></li>
                <li>AI CHAT box <a href="/pages/Trangchu/index.html">Xem demo</a></li>
                <li>back to top <a href="/pages/Trangchu/index.html">Xem demo</a></li>
                <li>Slider hình ảnh sản phẩm <a href="/pages/ChiTietSanPham/index.html">Xem demo</a></li>
                <li>Slider Quảng cáo <a href="/pages/TrangChuindex.html">Xem demo</a></li>
                <li>Map</li>
                <li>Hiệu ứng hover sản phẩm</li>
                <li>Hiệu ứng animation placeholder tìm kiếm</li>
                <li>Khi bấm thanh menu bất kì thanh vừa mở sẽ tắt ở header</li>
                <li>Kiểm tra form và hiện modal thành công khi nhập form hợp lệ <a href="/pages/LienHe/index.html">Xem
                        demo</a> </li>
            </ul>
        </div>
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
    <script src="{{ asset('js/GioiThieu') }}?v={{ time() }}"></script>
@endpush
  