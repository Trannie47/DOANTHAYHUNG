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

        <div class="km-wrapper">

            <button class="km-arrow km-left">&lt;</button>

            <div class="product-list" id="kmList">

                @foreach ($thuocKhuyenmai as $item)
                @php
                $firstImage = is_array($item->HinhAnh) ? ($item->HinhAnh[0] ?? 'logo.png') : 'logo.png';
                @endphp

                <a class="product-item" href="{{ url('/thuoc/' .$item->maThuoc ) }}">
                    @if ($item->getThumbnailImage())
                    <img src="{{ $item->getThumbnailImage() }}"
                        alt="{{ $item->tenThuoc }}">
                    @else
                    <img src="{{ asset('asset/img/'.$firstImage) }}">
                    @endif

                    <h3>{{ $item->tenThuoc }}</h3>

                    <p class="old-price">{{ number_format($item->GiaTien) }} đ</p>

                    <p class="price">{{ number_format($item->giaKhuyenMai) }} đ/{{ $item->DVTinh }}</p>

                    <button class="btn-item">Chọn sản phẩm</button>

                </a>
                @endforeach

            </div>

            <button class="km-arrow km-right">&gt;</button>

        </div>
        <h2>Sản phẩm mới</h2>

        <div class="km-wrapper">

            <!-- Mũi tên trái -->
            <button class="km-arrow new-left">&lt;</button>

            <div class="product-list" id="newList">

                @foreach ($thuocmoi as $item)
                @php
                $firstImage = is_array($item->HinhAnh) ? ($item->HinhAnh[0] ?? 'logo.png') : 'logo.png';
                @endphp

                <a class="product-item" href="{{ url('/thuoc/'.$item->maThuoc) }}">
                    @if ($item->getThumbnailImage())
                    <img src="{{ $item->getThumbnailImage() }}"
                        alt="{{ $item->tenThuoc }}">
                    @else
                    <img src="{{ asset('asset/img/'.$firstImage) }}">
                    @endif
                    <h3>{{ $item->tenThuoc }}</h3>

                    @if ($item->giaKhuyenMai)
                    <p class="old-price">{{ number_format($item->GiaTien) }} đ</p>
                    <p class="price">{{ number_format($item->giaKhuyenMai) }} đ/{{ $item->DVTinh }}</p>
                    @else
                    <p class="price">{{ number_format($item->GiaTien) }} đ/{{ $item->DVTinh }}</p>
                    @endif

                    <button class="btn-item">Chọn sản phẩm</button>
                </a>

                @endforeach

            </div>

            <!-- Mũi tên phải -->
            <button class="km-arrow new-right">&gt;</button>

        </div>


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