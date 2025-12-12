@extends('admin')

@section('content')
<div class="container-fluid mt-4">

    <h2 class="mb-4"><b>Thống kê dữ liệu</b></h2>

    <div class="row text-center mb-4">

        <div class="col-md-3">
            <div class="p-4 bg-light rounded shadow-sm">
                <h6>Tổng đơn hàng</h6>
                <h2>{{ $stats['total'] }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-4 bg-light rounded shadow-sm">
                <h6>Đơn hôm nay</h6>
                <h2>{{ $stats['today'] }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-4 bg-light rounded shadow-sm">
                <h6>Đơn tháng này</h6>
                <h2>{{ $stats['month'] }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-4 bg-light rounded shadow-sm">
                <h6>Đơn năm nay</h6>
                <h2>{{ $stats['year'] }}</h2>
            </div>
        </div>

    </div>

    {{-- Bộ lọc --}}
    <form class="row mb-3">

        <div class="col-md-3">
            <label>Từ ngày</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-md-3">
            <label>Đến ngày</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-md-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option value="">Tất cả</option>
                <option value="0" {{ request('status') == 0 ? 'selected' : '' }}>Chờ duyệt</option>
                <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Đã duyệt</option>
                <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Bị hủy</option>
            </select>
        </div>

        <div class="col-md-3 mt-4 pt-2">
            <button class="btn btn-warning">Lọc</button>
            <a href="{{ route('admin.donhang.index') }}" class="btn btn-danger">Xóa</a>
        </div>
    </form>

    {{-- Bảng --}}
    <table class="table table-bordered table-hover text-center">
        <thead class="table-secondary">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->maDonHang }}</td>
                    <td>{{ $item->ngaydat }}</td>
                    <td>
                        @php 
                            $badge = ['warning','success','danger'][$item->trangthai];
                        @endphp
                        <span class="badge bg-{{ $badge }}">
                            {{ $item->trang_thai_text }}
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm">Xem</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
