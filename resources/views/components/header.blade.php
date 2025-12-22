<!-- resources/views/components/header.blade.php -->
<header>
    <div class="top-header">
        <div class="logo">
            <img src="{{ asset('asset/img/logo.png') }}" alt="Logo">
        </div>
        <div class="search-bar">
            <div class="search-container">
                <input id="search-input" type="text" placeholder="Tìm kiếm sản phẩm" autocomplete="off">
                <button class="search-btn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div class="menu-icon"><i class="fa-solid fa-bars"></i></div>
        </div>
        <div class="user-bar">
            <a id="cart-toggle"><i class="fa-solid fa-cart-shopping"></i></a>
            @if(Auth::guard('khachhang')->check())
            <a class="user-card" id="user-login">
                <i class="fa-solid fa-circle-user"></i>
                <p>Xin chào, {{ Auth::guard('khachhang')->user()->ten }} </p>
            </a>
            @else
            <a class="user-card" href="{{ url('/dangnhap') }}">
                <i class="fa-solid fa-circle-user"></i>
                <p>Đăng nhập/ Đăng ký</p>
            </a>
            @endif
        </div>
        {{-- Dropdown kết quả --}}
        <div id="search-result" class="search-dropdown d-none"></div>
    </div>

    <nav class="nav">
        <div class="nav-wrapper">
            <div class="category-dropdown">
                <button class="dropdown-toggle">
                    <i class="fa fa-bars"></i> Danh mục sản phẩm <i class="fa fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    @foreach ($loaithuocs as $loaithuoc)
                    <li>
                        <a href="{{ url('/loaithuoc/' . $loaithuoc->maLoai) }}">
                            {{ $loaithuoc->TenLoai }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <ul class="menu-bar">
                <li><a href="{{ url('/trangchu') }}"><i class="fa-solid fa-home"></i> Trang chủ</a></li>
                <!-- <li><a href="#">Tin tức</a></li> -->
                <li><a href="{{ url('/lienhe') }}">Liên lạc</a></li>
                <li><a href="{{ url('/gioithieu') }}">Giới thiệu</a></li>

            </ul>
        </div>
    </nav>

    <div class="cart-wrapper">
        <div id="cart-modal" class="cart-modal">
            <ul class="cart-items">
                @forelse ($cart as $id => $item)
                <li id="sp-{{ $id }}">
                    <img src="{{ asset($item['hinhAnh']) }}" alt="{{ $item['tenThuoc'] }}">
                    <div class="item-info">
                        <p>{{ $item['tenThuoc'] }}</p>
                        <div class="item-info-price">
                            <small>{{ $item['soLuong'] }}</small>
                            <small>x</small>
                            <small class="storage-price">{{ number_format($item['gia']) }}</small>
                            <small>đ</small>
                        </div>
                    </div>
                    <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline">
                        @csrf
                        <button class="remove" type="submit">×</button>
                    </form>
                </li>
                @empty
                <li>Giỏ hàng trống.</li>
                @endforelse

            </ul>
            <div class="cart-footer">
                <p><strong>Tổng:</strong>{{ formatPrice(array_sum(array_map(fn($item) => $item['gia'] * $item['soLuong'], $cart))) }} </p>
                <div class="cart-actions">
                    <a href="{{ url('/giohang') }}" class="btn">Xem Giỏ Hàng</a>
                    <a href="{{ url('/pay') }}" class="btn">Thanh Toán</a>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-wrapper">
        @if(Auth::guard('khachhang')->check())
        <div id="user-model" class="user-model">
            <ul>
                <li><a href="{{ url('/capnhatthongtincanhan') }}">Đổi thông tin cá nhân</a></li>
                <li><a href="{{ url('/doimatkhau') }}">Đổi mật khẩu</a></li>
                <!-- nếu là admin thì hiện link quản trị -->
                @if(Auth::guard('khachhang')->user()->isAdmin)
                <li><a href="{{ url('/dashboard') }}">Quản trị</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:0;color:red;cursor:pointer;">Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>
        @endif
    </div>
</header>