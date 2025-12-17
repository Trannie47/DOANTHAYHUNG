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
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>

        <tbody>
            @php $tongTien = 0; @endphp

            @foreach($don->chitietdonhangs as $ct)
                @php
                    $thanhTien = $ct->SoLuong * $ct->SoTien;
                    $tongTien += $thanhTien;
                @endphp
                <tr>
                    <td>{{ $ct->thuoc->tenThuoc }}</td>
                    <td>{{ number_format($ct->SoTien) }} đ</td>
                    <td>{{ $ct->SoLuong }}</td>
                    <td>{{ number_format($thanhTien) }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end">
        Tổng tiền: <b>{{ number_format($tongTien) }} đ</b>
    </h4>

</div>
@endsection
