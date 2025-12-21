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
            <h2>Thương hiệu</h2>
            <ul>
                @php
                $selectedNSX = request('nsx') ? explode(',', request('nsx')) : [];
                @endphp

                @foreach ($DsNSX as $item)
                <li>
                    <input type="checkbox"
                        class="brand-filter"
                        value="{{ $item->NSX }}"
                        {{ in_array($item->NSX, $selectedNSX) ? 'checked' : '' }}>
                    {{ $item->NSX }} 
                </li>
                @endforeach

            </ul>

        </div>
    </div>

    <div class="product-grid">
        @foreach ($thuocs as $thuoc)
        @php
        // Nếu HinhAnh là mảng, lấy phần tử đầu tiên
        $firstImage = is_array($thuoc->HinhAnh) ? ($thuoc->HinhAnh[0] ?? 'logo.png') : 'logo.png';
        @endphp

        <a class="product-card" href="{{ url('/thuoc/' .$thuoc->maThuoc ) }}" data-brand="{{ strtolower(trim($thuoc->NSX)) }}">
            @if ($thuoc->getThumbnailImage())
            <img src="{{ $thuoc->getThumbnailImage() }}"
                alt="{{ $thuoc->tenThuoc }}">
            @else
            <img src="{{ asset('asset/img/'.$firstImage) }}" alt="{{ $thuoc->tenThuoc }}">
            @endif
            <h3>{{ $thuoc->tenThuoc }}</h3>
            @if ($thuoc->giaKhuyenMai)
            <p class="old-price">{{ formatPrice($thuoc->GiaTien) }} / {{$thuoc->DVTinh}}</p>
            <p class="price">{{ formatPrice($thuoc->giaKhuyenMai) }}/ {{$thuoc->DVTinh}}</p>
            @else
            <p class="price">{{ formatPrice($thuoc->GiaTien) }}/ {{$thuoc->DVTinh}}</p>
            @endif
            <button class="btn-item"
                data-id="{{ $thuoc->maThuoc }}">
                <p>Chọn sản phẩm</p>
            </button>
        </a>
        @endforeach

    </div>

    <div class="pagination-container">
        {{ $thuocs->links('pagination::bootstrap-4') }}
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
<script src="{{ asset('js/LoaiThuoc') }}?v={{ time() }}"></script>
@endpush