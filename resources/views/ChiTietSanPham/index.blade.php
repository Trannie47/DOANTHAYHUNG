@extends('app')

@section('title', 'ChiTietSanPham')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ChiTietSanPham') }}?v={{ time() }}">
@endpush

@section('content')
<div class="product-container">

    {{-- ================= HÌNH ẢNH SẢN PHẨM ================= --}}
    <div class="product-image">

        <div id="main-slider" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    @if(!empty($thuoc->HinhAnh))
                        @foreach($thuoc->HinhAnh as $hinh)
                        <li class="splide__slide">
                            <img src="{{ $hinh }}"
                                 alt="{{ $thuoc->tenThuoc }} - ảnh {{ $loop->iteration }}"
                                 loading="lazy">
                        </li>
                        @endforeach
                    @else
                        <li class="splide__slide">
                            <span class="badge bg-secondary">Không có hình ảnh</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <p class="section-title">Sản phẩm 100% chính hãng, mẫu mã có thể thay đổi theo lô hàng</p>

        <div id="thumbnail-slider" class="splide related-products">
            <div class="splide__track">
                <ul class="splide__list">
                    @if(!empty($thuoc->HinhAnh))
                        @foreach($thuoc->HinhAnh as $hinh)
                        <li class="splide__slide">
                            <img src="{{ $hinh }}" alt="{{ $thuoc->tenThuoc }}">
                        </li>
                        @endforeach
                    @else
                        <li class="splide__slide">
                            <span class="badge bg-secondary">Không ảnh</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>

    {{-- ================= THÔNG TIN SẢN PHẨM ================= --}}
    <div class="product-details">

        <h1 class="product-title">{{ $thuoc->tenThuoc }}</h1>

        @if(!empty($thuoc->maThuoc))
        <p class="product-code">{{ $thuoc->maThuoc }} • Thương hiệu: Oral-B</p>
        @endif

        <div class="badges">
            <span class="badge official">CHÍNH HÃNG</span>
            <span class="badge freeship">FREESHIP</span>
        </div>

        {{-- GIÁ --}}
        @if(!empty($thuoc->GiaTien))
            @if(!empty($thuoc->giaKhuyenMai))
            <div class="price">
                <span class="discount">
                    -{{ round((1 - $thuoc->giaKhuyenMai / $thuoc->GiaTien) * 100) }}%
                </span>
                <span class="old-price">{{ formatPrice($thuoc->GiaTien) }}</span>
                <span class="current-price">
                    {{ formatPrice($thuoc->giaKhuyenMai) }}
                    @if(!empty($thuoc->DVTinh))
                        / {{ $thuoc->DVTinh }}
                    @endif
                </span>
            </div>
            @else
            <div class="price">
                <span class="current-price">
                    {{ formatPrice($thuoc->GiaTien) }}
                    @if(!empty($thuoc->DVTinh))
                        / {{ $thuoc->DVTinh }}
                    @endif
                </span>
            </div>
            @endif

            <p class="price-note">Giá đã bao gồm thuế, phí vận chuyển và các chi phí khác.</p>
        @endif

        {{-- PHÂN LOẠI --}}
        @if(!empty($thuoc->DVTinh))
        <div class="product-variations-section">
            <p>Phân loại sản phẩm</p>
            <div class="product-variations">
                <button class="variation-button active">{{ $thuoc->DVTinh }}</button>
            </div>
        </div>
        @endif

        {{-- MÔ TẢ NGẮN --}}
        <div id="product-description">

            @if(!empty($thuoc->tenThuoc))
            <div class="product-description-containner">
                <p class="product-description-name">Tên sản phẩm :</p>
                <p class="product-description-value">{{ $thuoc->tenThuoc }}</p>
            </div>
            @endif

            @if(!empty($thuoc->tenLoai))
            <div class="product-description-containner">
                <p class="product-description-name">Danh mục :</p>
                <p class="product-description-value">{{ $thuoc->tenLoai }}</p>
            </div>
            @endif

            @if(!empty($thuoc->QuiCach))
            <div class="product-description-containner">
                <p class="product-description-name">Quy cách :</p>
                <p class="product-description-value">{{ $thuoc->QuiCach }}</p>
            </div>
            @endif

            @if(!empty($thuoc->CongDung))
            <div class="product-description-containner">
                <p class="product-description-name">Công dụng :</p>
                <p class="product-description-value">{{ $thuoc->CongDung }}</p>
            </div>
            @endif

            <div class="product-description-containner">
                <p class="product-description-name">Tên nhà sản xuất:</p>
                <p class="product-description-value">P&G</p>
            </div>

        </div>

        {{-- MÔ TẢ CHI TIẾT --}}
        @if(!empty($thuoc->ThanhPhan) || !empty($thuoc->CachSuDung))
        <div class="product-details-containner">
            <h2>Mô tả sản phẩm</h2>

            @if(!empty($thuoc->ThanhPhan))
            <div class="product-details">
                <p class="product-details-name">Thành phần:</p>
                <p class="product-details-value">{{ $thuoc->ThanhPhan }}</p>
            </div>
            @endif

            @if(!empty($thuoc->CachSuDung))
            <div class="product-details">
                <p class="product-details-name">Cách sử dụng:</p>
                <p class="product-details-value">{{ $thuoc->CachSuDung }}</p>
            </div>
            @endif
        </div>
        @endif

    </div>

    {{-- ================= MUA HÀNG ================= --}}
    <div class="order-section">

    <!-- Chọn số lượng (dùng chung) -->
        <div class="quantity-selector">
            <span>Số lượng</span>
            <div class="quantity-input">
                <div class="quantity-button minus">-</div>
                <input type="number" value="1" min="1" id="quantityInput" class="quantity-number">
                <div class="quantity-button plus">+</div>
            </div>
        </div>

        <div class="buyer-container">

            <form method="GET" action="{{ route('cart.muaNgay', $thuoc->maThuoc) }}">
                <input type="hidden" name="quantity" id="quantityBuy">
                <button type="submit" class="buy-now-button">Mua ngay</button>
            </form>

            <form method="POST" action="{{ route('cart.add', $thuoc->maThuoc) }}">
                @csrf
                <input type="hidden" name="quantity" id="quantityCart">
                <button type="submit" class="add-to-cart-button">Thêm vào giỏ</button>
            </form>

        </div>
    </div>

    {{-- Chatbox --}}
    <button id="open_chatbox"><i class="fa-regular fa-message"></i></button>
    <div id="chatbox" style="display:none;">
        <button id="close_chatbox">×</button>
        <iframe src="https://www.chatbase.co/chatbot-iframe/iKp1d0Z7u4lW7wMauNcBu"
                width="100%" height="100%" frameborder="0"
                style="min-height:500px"></iframe>
    </div>

    <button id="backToTop"><i class="fa-solid fa-angle-up"></i></button>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/ChiTietSanPham') }}?v={{ time() }}"></script>
@endpush