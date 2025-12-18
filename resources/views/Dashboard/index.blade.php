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

        <!-- Số loại thuốc -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Số loại thuốc
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $SLLoaiThuoc }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-capsules fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đơn thuốc hôm nay -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Đơn thuốc hôm nay
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $SLDonHangTrongNgay }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thuốc sắp hết hàng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Thuốc sắp hết hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dsThuocSapHetHang->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng số thuốc -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tổng số thuốc
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $SLThuoc }}</div>
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

        <!-- Chart đơn thuốc -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Biểu đồ đơn thuốc theo tháng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" >
                        <canvas id="chartDonThuoc" style="display: block !important; "></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart loại thuốc -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Tỷ lệ các loại thuốc
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="chartLoaiThuoc"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row 3: Top 5 thuốc -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Top 5 thuốc bán nhiều nhất trong tháng {{ now()->format('m/Y') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Tên thuốc</th>
                                    <th>Số lượng đã bán</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($donThuocTheoThang as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->tenThuoc }}</td>
                                    <td>
                                        <span class="badge bg-success text-black ">
                                            {{ $item->tongSoLuong }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">Chưa có dữ liệu</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Danh sách thuốc sắp hết hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Mã thuốc</th>
                                    <th>Tên thuốc</th>
                                    <th>Số lượng còn lại</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dsThuocSapHetHang as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->maThuoc }}</td>
                                    <td>{{ $item->tenThuoc }}</td>
                                    <td>
                                        <span class="badge text-black ">
                                            {{ $item->SoLuongTonKho }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">Chưa có dữ liệu</td>
                                </tr>
                                @endforelse
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Chart đơn thuốc
    const labels = @json($labels);
    const dataValues = @json($data);

    new Chart(document.getElementById('chartDonThuoc'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Đơn thuốc năm {{ now()->year }}',
                data: dataValues,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.15)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#4e73df'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Chart loại thuốc
    const labelsLoaiThuoc = @json($labelsLoaiThuoc);
    const dataLoaiThuoc = @json($dataLoaiThuoc);
    new Chart(document.getElementById('chartLoaiThuoc'), {
        type: 'doughnut',
        data: {
            labels: labelsLoaiThuoc,
            datasets: [{
                data: dataLoaiThuoc,
               
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection