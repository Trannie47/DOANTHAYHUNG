@extends('admin')

@section('content')
<div class="container mt-4">

    <h3>Chi tiết đơn hàng #{{ $don->maDonHang }}</h3>

    <p><b>Ngày đặt:</b> {{ $don->ngaydat }}</p>
    <p><b>Người đặt:</b> {{ $don->khachhang->ten ?? 'Không rõ' }}</p>
    <p><b>Địa chỉ:</b> {{ $don->DiaChi }}</p>
    <p><b>SĐT:</b> {{ $don->SdtNguoiDat }}</p>

    <h4 class="mt-4">Sản phẩm đã mua</h4>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Thuốc</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>

        <tbody>
            @foreach($don->chitietdonhangs as $ct)
            <tr>
                <td>{{ $ct->thuoc->TenThuoc }}</td>
                <td>{{ number_format($ct->thuoc->GiaTien) }}</td>
                <td>{{ $ct->SoLuong }}</td>
                <td>{{ number_format($ct->SoLuong * $ct->thuoc->GiaTien) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end">Tổng tiền: <b>{{ number_format($don->tongTien) }} VND</b></h4>

</div>
@endsection
