@extends('admin')

@section('content')

<div class="container-fluid">

    <!-- Title -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Xuất báo cáo
        </a>
    </div>

    <!-- Row 1: Cards -->
    <div class="row">

        <!-- Số lượng thuốc -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Số loại thuốc</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">128</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-capsules fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Số đơn thuốc -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Đơn thuốc hôm nay</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">52</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tồn kho thấp -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Thuốc sắp hết hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">14</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nhà cung cấp -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Nhà cung cấp</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row 2: Charts -->
    <div class="row">

        <!-- Chart 1 -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ đơn thuốc theo tháng</h6>
                </div>
                <!-- Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartDonThuoc"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 2 -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tỷ lệ các loại thuốc</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="chartLoaiThuoc"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2"><i class="fas fa-circle text-primary"></i> Thuốc cảm</span>
                        <span class="mr-2"><i class="fas fa-circle text-success"></i> Kháng sinh</span>
                        <span class="mr-2"><i class="fas fa-circle text-info"></i> Vitamin</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row 3: Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thuốc sắp hết hàng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tên thuốc</th>
                                    <th>Loại</th>
                                    <th>Tồn kho</th>
                                    <th>Hạn sử dụng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Paracetamol 500mg</td>
                                    <td>Giảm đau</td>
                                    <td><span class="text-danger">5 hộp</span></td>
                                    <td>12/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Chart đơn thuốc
    var ctx = document.getElementById('chartDonThuoc').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["T1","T2","T3","T4","T5","T6"],
            datasets: [{
                label: "Đơn thuốc",
                data: [40, 55, 48, 60, 72, 90],
                borderWidth: 3,
                borderColor: '#4e73df',
                fill: false
            }]
        },
    });

    // Chart loại thuốc
    var ctx2 = document.getElementById('chartLoaiThuoc').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Thuốc cảm", "Kháng sinh", "Vitamin"],
            datasets: [{
                data: [40, 30, 30],
                backgroundColor: ['#4e73df','#1cc88a','#36b9cc']
            }]
        },
    });
</script>
@endsection
