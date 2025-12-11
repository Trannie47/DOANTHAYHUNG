{{-- resources\views\LienHe\index.blade.php --}}
@extends('app')

@section('title', 'Loại Thuốc')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/LoaiThuoc') }}?v={{ time() }}">
@endpush

@section('content')

    <!-- Code  -->
    <div class="type-container">
        <div class="sidebar">
            <div>
                <h2>Loại</h2>
                <ul>
                    <li><input type="checkbox" /> Thuốc kháng sinh</li>
                    <li><input type="checkbox" /> Vitamin</li>
                    <li><input type="checkbox" /> Thuốc ngừ thai</li>
                    <li><input type="checkbox" /> Thuốc kháng viêm</li>
                    <li><input type="checkbox" /> Thuốc giảm cân</li>
                    <li><input type="checkbox" /> Thuốc Mắt/Tai/Mũi</li>
                    <li><input type="checkbox" /> Thuốc tiêu hóa</li>
                </ul>
            </div>
            <div>

                <h2>Thương hiệu</h2>
                <ul>
                    <li><input type="checkbox" /> Abbot</li>
                    <li><input type="checkbox" /> Bayer HealthCare</li>
                    <li><input type="checkbox" /> Foripharm (TW3)</li>
                </ul>
            </div>
        </div>

        <div class="product-grid">
            @foreach ($thuocs as $thuoc)
                @php
                    // Nếu HinhAnh là mảng, lấy phần tử đầu tiên
                    $firstImage = is_array($thuoc->HinhAnh) ? ($thuoc->HinhAnh[0] ?? 'logo.png') : 'logo.png';
                @endphp

                <a class="product-card" href="{{ url('/thuoc/' .$thuoc->maThuoc ) }}">
                    <img src="{{ asset('asset/img/' . $firstImage) }}" alt="{{ $thuoc->tenThuoc }}" />
                    <h3>{{ $thuoc->tenThuoc }}</h3>
                    @if ($thuoc->giaKhuyenMai)
                        <p class="old-price">{{ formatPrice($thuoc->GiaTien) }} / {{$thuoc->DVTinh}}</p>
                        <p class="price">{{ formatPrice($thuoc->giaKhuyenMai) }}/ {{$thuoc->DVTinh}}</p>
                    @else
                        <p class="price">{{ formatPrice($thuoc->GiaTien) }}/ {{$thuoc->DVTinh}}</p>
                    @endif
                    <button class="btn-item">
                        <p>Chọn sản phẩm</p>
                    </button>
                </a>
            @endforeach      

            <a class="product-card" href="/pages/ChiTietSanPham/Tobidex.html">
                <img src="/asset/img/sp2.png" alt="Tobidex" />
                <h3>Thuốc nhỏ mắt Tobidex</h3>
                <p class="old-price"></p>
                <p class="price">Tư vấn với dược sỹ</p>
                <button class="btn-item">
                    <p>Chọn sản phẩm</p>
                </button>
            </a>


        </div>
    </div>
    <<!-- Chatbox -->
    <button id="open_chatbox" title="Mở chat"><i class="fa-regular fa-message"></i></button>
    <div id="chatbox" style="display:none;">
        <button id="close_chatbox" title="Đóng chatbox">×</button>
        <iframe src="https://www.chatbase.co/chatbot-iframe/iKp1d0Z7u4lW7wMauNcBu" width="100%" height="100%" frameborder="0" style="min-height: 500px;"></iframe>
    </div>

    <button id="backToTop" title="Về đầu trang"><i class="fa-solid fa-angle-up"></i></button>

@endsection

@push('scripts')
    
@endpush