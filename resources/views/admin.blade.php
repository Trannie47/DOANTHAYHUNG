<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Thuốc</title>

    <!-- Chỉ Bootstrap 5 + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin">

</head>

<body id="page-top" class="bg-light">

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="bg-primary vh-100 position-fixed start-0 top-0 overflow-auto" style="width:280px;">
            <div class="p-4 text-white">
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-pills fa-2x me-3" style="transform: rotate(-15deg);"></i>
                    <h4 class="mb-0">Admin Thuốc</h4>
                </div>
                <hr class="bg-white opacity-25">

                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <a class="nav-link text-white active" href="{{ route('dashboard.index') }}"><i class="fas fa-tachometer-alt me-2"></i>Bảng điều khiển</a>

                    <hr class="bg-white opacity-25">

                    <div class="text-white-50 small text-uppercase mb-2 ps-3">Quản lý thuốc</div>

                    <!-- Quản lý thuốc -->
                    <button class="btn text-white text-start w-100 mb-1" data-bs-toggle="collapse" data-bs-target="#collapseThuoc">
                        <i class="fas fa-capsules me-2"></i>Quản lý thuốc <i class="fas fa-chevron-down float-end"></i>
                    </button>
                    <div class="collapse" id="collapseThuoc">
                        <div class="donthuoc-menu ms-4 me-3">

                            <a class="donthuoc-item" href="{{ route('admin.thuoc.index') }}">
                                Danh sách thuốc
                            </a>

                            <a class="donthuoc-item" href="{{ route('admin.thuoc.create') }}">
                                Thêm thuốc
                            </a>

                            <a class="donthuoc-item" href="{{ route('admin.loaithuoc.index') }}">
                                Loại thuốc
                            </a>

                        </div>
                    </div>

                    <!-- Quản lý đơn thuốc -->
                    <!-- Quản lý đơn thuốc -->
                    <button class="btn text-white text-start w-100 mb-1" data-bs-toggle="collapse" data-bs-target="#collapseDonThuoc">
                        <i class="fas fa-file-medical me-2"></i>Quản lý đơn thuốc <i class="fas fa-chevron-down float-end"></i>
                    </button>

                    <div class="collapse" id="collapseDonThuoc">
                        <div class="donthuoc-menu ms-4 me-3">

                            <!-- Trang chung -->
                            <a class="donthuoc-item" href="{{ route('admin.donhang.index') }}">
                                Trạng thái đơn hàng
                            </a>

                            <a class="donthuoc-item" href="{{ route('admin.donhang.lichsu') }}">
                                Lịch sử đơn thuốc
                            </a>

                        </div>
                    </div>



                    <hr class="bg-white opacity-25">

                    <div class="text-white-50 small text-uppercase mb-2 ps-3">Tài khoản</div>
                    <a class="nav-link text-white"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1" style="margin-left:280px;">

            <!-- Topbar -->
            <nav class="navbar navbar-light bg-white shadow sticky-top">
                <div class="container-fluid">
                    <button class="btn d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                        <i class="fas fa-bars"></i>
                    </button>

                    <form class="d-none d-md-flex ms-3">
                        <div class="input-group">
                            <input type="text" class="form-control border-0 bg-light" placeholder="Tìm kiếm...">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </form>

                    <div class="dropdown">
                        <a class="dropdown-toggle text-decoration-none text-dark" data-bs-toggle="dropdown">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-2" width="40">
                            <span class="d-none d-lg-inline">Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cogs me-2"></i>Cài đặt</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Nội dung chính -->
            <div class="container-fluid py-4">
                @yield('content')

            </div>


        </div>
    </div>


    <div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="offcanvasSidebar" style="width:280px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Admin Thuốc</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>