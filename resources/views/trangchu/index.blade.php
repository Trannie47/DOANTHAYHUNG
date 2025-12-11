{{-- resources/views/pages/trang-chu.blade.php --}}
@extends('app')

@section('title', 'Trang Chủ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/trangchu') }}?v={{ time() }}">
@endpush

@section('content')

<div id="body-container">
    <!-- Quảng cáo -->
    <div class="advertisement">
        <div class="splide large-ad">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide"><img src="{{ asset('asset/img/banner.png') }}" alt="QC1" /></li>
                    <li class="splide__slide"><img src="{{ asset('asset/img/banner2.png') }}" alt="QC2" /></li>
                    <li class="splide__slide"><img src="{{ asset('asset/img/banner3.png') }}" alt="QC3" /></li>
                    <li class="splide__slide"><img src="{{ asset('asset/img/banner4.png') }}" alt="QC4" /></li>
                    <li class="splide__slide"><img src="{{ asset('asset/img/banner1.png') }}" alt="QC5" /></li>
                    <li class="splide__slide"><img src="{{ asset('asset/img/banner5.png') }}" alt="QC6" /></li>
                    <li class="splide__slide"><img src="{{ asset('asset/img/banner6.png') }}" alt="QC7" /></li>
                </ul>
            </div>
        </div>

        <div class="small-ads">
            <img src="{{ asset('asset/img/qc1.png') }}" alt="QC nhỏ 1" />
            <img src="{{ asset('asset/img/qc2.png') }}" alt="QC nhỏ 2" />
        </div>
    </div>

    <!-- Sản phẩm -->
    <section class="products">

        <!-- SẢN PHẨM KHUYẾN MÃI -->
        <h2>Sản phẩm Khuyến Mãi</h2>
        <div class="product-list">

            @foreach ($thuocKhuyenmai as $item)
            @php
            $firstImage = is_array($item->HinhAnh) ? ($item->HinhAnh[0] ?? 'logo.png') : 'logo.png';
            @endphp
            <a class="product-item" href="{{ url('/thuoc/' .$item->maThuoc ) }}">

                {{-- Hình ảnh (lấy ảnh đầu tiên trong mảng JSON) --}}
                <img src="{{ asset('asset/img/' . $firstImage) }}" alt="{{ $item->tenThuoc }}" />

                <h3>{{ $item->tenThuoc }}</h3>

                {{-- Giá gốc --}}
                <p class="old-price">{{ number_format($item->GiaTien) }} đ</p>

                {{-- Giá khuyến mãi --}}
                <p class="price">{{ number_format($item->giaKhuyenMai) }} đ/{{ $item->DVTinh }}</p>

                <button class="btn-item">
                    <p>Chọn sản phẩm</p>
                </button>
            </a>
            @endforeach

        </div>


        <!-- SẢN PHẨM MỚI -->
        <h2>Sản phẩm mới</h2>
        <div class="product-list">

            @foreach ($thuocmoi as $item)
            @php
            $firstImage = is_array($item->HinhAnh) ? ($item->HinhAnh[0] ?? 'logo.png') : 'logo.png';
            @endphp
            <a class="product-item" href="{{ url('/thuoc/' .$item->maThuoc ) }}">

                <img src="{{ asset('asset/img/' . $firstImage) }}" alt="{{ $item->tenThuoc }}" />

                <h3>{{ $item->tenThuoc }}</h3>

                {{-- Nếu có khuyến mãi thì hiện giá cũ --}}
                @if ($item->giaKhuyenMai)
                <p class="old-price">{{ number_format($item->GiaTien) }} đ</p>
                <p class="price">{{ number_format($item->giaKhuyenMai) }} đ/{{ $item->DVTinh }}</p>
                @else
                <p class="price">{{ number_format($item->GiaTien) }} đ/{{ $item->DVTinh }}</p>
                @endif

                <button class="btn-item">
                    <p>Chọn sản phẩm</p>
                </button>
            </a>
            @endforeach

        </div>

    </section>


    <!-- Tin tức -->
    <section class="news">
        <h2>Góc sức khỏe</h2>
        <div class="news-wrapper">
            <button class="prev-btn"><i class="fa-solid fa-chevron-left"></i></button>

            <div class="news-list">
                <a class="news-item news-item-large" href="#">
                    <img src="{{ asset('asset/img/covid.png') }}" alt="Covid">
                    <div class="news-content">
                        <span class="news-category">Tin dịch bệnh</span>
                        <h3>Tình trạng covid 19 hiện nay và cách phòng tránh</h3>
                        <p>So với cùng kỳ năm ngoái, tổng số ca mắc Covid-19 được ghi nhận tại TPHCM năm 2023 giảm đến 83%...</p>
                    </div>
                </a>

                {{--<a class="news-item" href="{{ route('chi-tiet-tin-tuc', 'sua-bi-do') }}">
                <img src="{{ asset('asset/img/suabido.png') }}" alt="Sữa bí đỏ">
                <div class="news-content">
                    <span class="news-category">Sống khỏe</span>
                    <h4>Sữa bí đỏ - bữa phụ bổ dưỡng cho bé yêu</h4>
                    <p>Bữa phụ sữa bí đỏ được xem là một món đồ uống rất bổ dưỡng cho trẻ nhỏ...</p>
                </div>
                </a>

                <a class="news-item" href="{{ route('chi-tiet-tin-tuc', 'gia-vi-rac-com') }}">
                    <img src="{{ asset('asset/img/gvị rắc cơm.png') }}" alt="Gia vị rắc cơm">
                    <div class="news-content">
                        <span class="news-category">Sống khỏe</span>
                        <h4>Gia vị rắc cơm cho bé: tăng thêm hương vị và dinh dưỡng</h4>
                        <p>Gia vị là một trong những cách đơn giản giúp cơm thêm ngon miệng và đủ chất...</p>
                    </div>
                </a> --}}
            </div>

            <button class="next-btn"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
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
<script src="{{ asset('js/trangchu') }}?v={{ time() }}"></script>
@endpush