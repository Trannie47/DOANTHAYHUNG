{{-- resources\views\ChiTietSanPham\index.blade.php --}}
@extends('app')

@section('title', 'ChiTietSanPham')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ChiTietSanPham') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="product-container">
        <div class="product-image">
            <div id="main-slider" class="splide">
                <div class="splide__track">
                <ul class="splide__list">
                    @foreach($thuoc->HinhAnh as $hinh)
                        <li class="splide__slide">
                            <img src="{{ asset('asset/img/' . $hinh) }}" 
                                alt="{{ $thuoc->tenThuoc }} - ảnh {{ $loop->iteration }}" 
                                loading="lazy">
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
            <p class="section-title">Sản phẩm 100% chính hãng, mẫu mã có thể thay đổi theo lô hàng</p>
            <!-- Slider thumbnail -->
            <div id="thumbnail-slider" class="splide related-products">
                <div class="splide__track">
                <ul class="splide__list">
                    @foreach($thuoc->HinhAnh as $hinh)
                        <li class="splide__slide"><img src="{{ asset('asset/img/' . $hinh) }}" alt="Thumb 1" /></li>
                    @endforeach
                </ul>
                </div>
            </div>
  
        </div>
        <div class="product-details">
            <h1 class="product-title">{{ $thuoc->tenThuoc }}</h1>
            <p class="product-code">{{ $thuoc->maThuoc }} • Thương hiệu: Oral-B</p>
            <div class="badges">
                <span class="badge official">CHÍNH HÃNG</span>
                <span class="badge freeship">FREESHIP</span>
            </div>
            @if ($thuoc->giaKhuyenMai)
                <div class="price">
                    <span class="discount">
                        -{{ round( (1 - $thuoc->giaKhuyenMai / $thuoc->GiaTien) * 100 ) }}%
                    </span>
                    <span class="old-price">{{formatPrice($thuoc->GiaTien)}}</span>
                    <span class="current-price">{{formatPrice($thuoc->giaKhuyenMai)}}/ {{$thuoc->DVTinh}}</span>
                </div>
            @else
              <div class="price">
                    <span class="current-price">{{formatPrice( $thuoc->GiaTien)}}/ {{$thuoc->DVTinh}}</span>
                </div>
            @endif
            <p class="price-note">Giá đã bao gồm thuế, phí vận chuyển và các chi phí khác (nếu có) sẽ được thể hiện khi đặt hàng.</p>
            <div class="rating">
                <span class="rating-value">62.2k</span>
                <span class="rating-count">Đã bán 8.8k</span>
            </div>
            <div class="product-variations-section">
                <p>Phân loại sản phẩm</p>
                <div class="product-variations">
                    <button class="variation-button active">{{$thuoc->DVTinh}}</button>
                </div>
            </div>
            <div id='product-description'>
                <div class="product-description-containner">
                    <p class="product-description-name">Tên sản phẩm :</p>
                    <p class="product-description-value">{{$thuoc->tenThuoc}}</p>
                </div>
                <div class="product-description-containner">
                    <p class="product-description-name">Danh mục :</p>
                    <p class="product-description-value">{{$thuoc->tenLoai}}</p>
                </div>
                <div class="product-description-containner">
                    <p class="product-description-name">Quy cách :</p>
                    <p class="product-description-value">{{$thuoc->QuiCach}}</p>
                </div>
                <div class="product-description-containner">
                    <p class="product-description-name">Công dụng :</p>
                    <p class="product-description-value">{{$thuoc->CongDung}}</p>
                </div>
                <div class="product-description-containner">
                    <p class="product-description-name">Tên nhà sản xuất:</p>
                    <p class="product-description-value">P&G</p>
                </div>   
            </div>
            <a href="#" class="view-more">Xem giấy công bố sản phẩm</a>
            <div class="product-details-containner">
                <h2>Mô tả sản phẩm</h2>
                <div class="product-details">
                    <p class="product-details-name">Thành phần:</p>
                    <p class="product-details-value">{{$thuoc->ThanhPhan}}</p>
                </div>
                <div class="product-details">
                    <p class="product-details-name">Cách sử dụng:</p>
                    <p class="product-details-value">{{$thuoc->CachSuDung}}</p>
                </div>
            </div>
        </div>
        <form class="order-section" method="POST" action="{{ route('cart.add', $thuoc->maThuoc) }}">
            @csrf
            <div class="quantity-selector">
                <span>Số lượng</span>
                <div class="quantity-input">
                    <div class="quantity-button minus">-</div>
                    <input type="number" value="1" min="1" name = "quantity" class="quantity-number">
                    <div class="quantity-button plus">+</div>
                </div>
            </div>
            <div class="buyer-container">
                <button class="buy-now-button" type="submit">Mua ngay</button>
                <button class="add-to-cart-button" type="submit">Thêm vào giỏ</button>
            </div>
            <div class="delivery-options">
                <div class="delivery-item">
                    <i class="fa-solid fa-tablets"></i>
                    <span>Đủ thuốc chuẩn</span>
                </div>
                <div class="delivery-item">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Giao hàng siêu tốc</span>
                </div>
                <div class="delivery-item">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Miễn phí vận chuyển</span>
                </div>
            </div>
        </div>
    </form>
 <!-- Chatbox -->
    <button id="open_chatbox" title="Mở chat"><i class="fa-regular fa-message"></i></button>
    <div id="chatbox" style="display:none;">
        <button id="close_chatbox" title="Đóng chatbox">×</button>
        <iframe src="https://www.chatbase.co/chatbot-iframe/iKp1d0Z7u4lW7wMauNcBu" width="100%" height="100%" frameborder="0" style="min-height: 500px;"></iframe>
    </div>

    <button id="backToTop" title="Về đầu trang"><i class="fa-solid fa-angle-up"></i></button>

@endsection

@push('scripts')
    <script src="{{ asset('js/ChiTietSanPham') }}?v={{ time() }}"></script>
@endpush   