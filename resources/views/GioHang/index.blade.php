{{-- resources\views\GioHang\index.blade.php --}}
@extends('app')

@section('title', 'Giỏ Hàng')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/GioHang') }}?v={{ time() }}">
@endpush

@section('content')

<div class="storage-container">
    <div class="cart-page">
        <!-- LEFT: Cart Items -->
        <div class="shoping__cart__table">
            <div class="cart__header">
                <div class="cart__item">
                    <span>Sản phẩm</span>
                    <div class="image-placeholder"></div> <!-- giữ chỗ cho ảnh -->
                </div>
                <div>Giá</div>
                <div>Số lượng</div>
                <div>Tổng</div>
                <div></div>
            </div>


            <div class="cart__body">
                <!-- Cart Item 1 -->
                @foreach($cart as $id => $item)
                <div class="cart__row" data-price="{{ $item['gia'] }}">
                    <!-- Sản phẩm -->
                    <div class="cart__col cart__product">
                        <div class="cart__item">
                            <img src="{{ asset($item['hinhAnh']) }}" alt="{{ $item['tenThuoc'] }}" width="100px">
                            <div class="cart__name">{{ $item['tenThuoc'] }}</div>
                        </div>
                    </div>

                    <!-- Giá 1 sản phẩm -->
                    <div class="cart__col cart__price">{{ number_format($item['gia'], 0, ',', '.') }} đ</div>

                    <!-- Số lượng -->

                    <form class="cart__col cart__quantity" action="{{ route('cart.update', $id) }}" method="POST">
                        @csrf
                        <div class="quantity">
                            <div class="pro-qty">
                                <button type="submit" class="dec" name="action" value="dec">-</button>
                                <input type="number" name="quantity" value="{{ $item['soLuong'] }}" min="1" class="quantity-input" onchange="this.form.submit()">
                                <button type="submit" class="inc" name="action" value="inc">+</button>
                            </div>
                        </div>
                    </form>


                    <!-- Tổng tiền -->
                    <div class="cart__col cart__total">{{ formatPrice( $item['gia'] * $item['soLuong'] ) }}</div>

                    <!-- Xóa sản phẩm -->
                    <div class="cart__col cart__remove">
                        <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline">
                            @csrf
                            <button class="icon_close remove-btn" type="submit"></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


        <!-- RIGHT: Order Summary -->
        <div class="order-summary">
            <h2>Thông tin đơn hàng</h2>

            <form action="{{ route('cart.pay') }}" method="POST">
                @csrf

                {{-- Số điện thoại --}}
                <label for="phone">Số điện thoại người nhận</label>
                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    class="address-input"
                    placeholder="Nhập số điện thoại"
                    pattern="[0-9]{10}"
                    required>
                
                {{-- Địa chỉ --}}
                <label for="address_detail">Địa chỉ giao hàng</label>
                <textarea
                    name="address_detail"
                    class="address-textarea"
                    rows="3"
                    placeholder="Nhập địa chỉ chi tiết..."
                    required></textarea>

                {{-- Tổng tiền --}}
                <div class="total">
                    <span>Tổng tiền:</span>
                    <strong>
                        {{ formatPrice(array_sum(array_map(fn($item) => $item['gia'] * $item['soLuong'], $cart))) }}
                    </strong>
                </div>

                {{-- Thanh toán --}}
                <button type="submit" class="checkout-btn">
                    Thanh toán
                </button>
            </form>
        </div>

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
<script src="{{ asset('js/GioHang') }}?v={{ time() }}"></script>
@endpush