<!-- resources/views/components/header.blade.php -->
<header>
    <div class="top-header">
        <div class="logo">
            <img src="{{ asset('asset/img/logo.png') }}" alt="Logo">
        </div>
        <div class="search-bar">
            <div class="search-container">
                <input id="search-input" type="text" placeholder="Tìm kiếm sản phẩm">
                <button class="search-btn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div class="menu-icon"><i class="fa-solid fa-bars"></i></div>
        </div>
        <div class="user-bar">
            <a id="cart-toggle"><i class="fa-solid fa-cart-shopping"></i></a>
            @if(Auth::guard('khachhang')->check())
                <a class="user-card" id="user-login" >
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
    </div>

    <nav class="nav">
        <div class="nav-wrapper">
            <div class="category-dropdown">
                <button class="dropdown-toggle">
                    <i class="fa fa-bars"></i> Danh mục sản phẩm <i class="fa fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <!-- <li><a href="#">Thuốc kê đơn</a></li>
                    <li><a href="#">Thuốc không kê đơn</a></li> -->
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
                <li><a href="#">Tin tức</a></li>
                <li><a href="{{ url('/lienhe') }}">Liên lạc</a></li>
                <li><a href="{{ url('/gioithieu') }}">Giới thiệu</a></li>
                
            </ul>
        </div>
    </nav>

    <div class="cart-wrapper">
        <div id="cart-modal" class="cart-modal">
            <ul class="cart-items">
                <li id="sp-1">
                    <img src="{{ asset('asset/img/spm1.png') }}" alt="">
                    <div class="item-info">
                        <p>Cao dán Salonpas Hisamitsu</p>
                        <div class="item-info-price">
                            <small>1</small>
                            <small>x</small>
                            <small class="storage-price">12.000</small>
                            <small>đ</small>
                        </div>
                    </div>
                    <button class="remove">×</button>
                </li>
                <li id="sp-2">
                    <img src="{{ asset('asset/img/sp2.png') }}" alt="">
                    <div class="item-info">
                        <p>Postinor</p>
                        <div class="item-info-price">
                            <small>1</small>
                            <small>x</small>
                            <small class="storage-price">35.000</small>
                            <small>đ</small>
                        </div>
                    </div>
                    <button class="remove">×</button>
                </li>
                <li id="sp-3">
                    <img src="{{ asset('asset/img/sp3.png') }}" alt="">
                    <div class="item-info">
                        <p>Smecta</p>
                        <div class="item-info-price">
                            <small>1</small>
                            <small>x</small>
                            <small class="storage-price">140.000</small>
                            <small>đ</small>
                        </div>
                    </div>
                    <button class="remove">×</button>
                </li>
            </ul>
            <div class="cart-footer">
                <p><strong>Tổng:</strong> 187.000 đ</p>
                <div class="cart-actions">
                    <a href="{{ url('/giohang') }}" class="btn">Xem Giỏ Hàng</a>
                    <a href="{{ url('/giohang') }}" class="btn">Thanh Toán</a>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-wrapper">
        @if(Auth::guard('khachhang')->check())
            <div id="user-model" class="user-model">
                <ul>
                    <li><a href="#">Đổi thông tin cá nhân</a></li>
                    <li><a href="#">Đổi mật khẩu</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}"  >
                            @csrf
                            <button type="submit" style="background:none;border:none;padding:0;color:red;cursor:pointer;">Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</header>
