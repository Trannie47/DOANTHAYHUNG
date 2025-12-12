@extends('admin')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3"><b>Lịch Sử Đơn Hàng</b></h3>

    {{-- Bộ lọc --}}
    <form class="row mb-4">

        <div class="col-md-3">
            <label>Mã đơn</label>
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm mã đơn">
        </div>

        <div class="col-md-3">
            <label>SĐT người mua</label>
            <input type="text" name="sdt" value="{{ request('sdt') }}" class="form-control" placeholder="Tìm theo SĐT">
        </div>

        <div class="col-md-2">
            <label>Từ ngày</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <label>Đến ngày</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <label>Sắp xếp</label>
            <select name="sort" class="form-select">
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Mới nhất</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Cũ nhất</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button class="btn btn-primary">Lọc</button>
            <a href="{{ route('admin.donhang.lichsu') }}" class="btn btn-danger">Xóa lọc</a>
        </div>

    </form>

    {{-- Bảng lịch sử --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày mua</th>
                    <th>SĐT người mua</th>
                    <th>Tổng tiền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->maDonHang }}</td>
                        <td>{{ $item->ngaydat }}</td>
                        <td>{{ $item->SdtNguoiDat }}</td>
                        <td>{{ number_format($item->tongTien) }}đ</td>

                        <td>
                            <a href="{{ route('admin.donhang.show', $item->maDonHang) }}" 
                               class="btn btn-sm btn-primary">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{-- Phân trang --}}
    <div class="d-flex justify-content-center">
        {{ $data->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
