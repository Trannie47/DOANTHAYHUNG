<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thuoc;
use Illuminate\Support\Carbon;

class ThuocController extends Controller
{
    // Hiển thị chi tiết 1 thuốc
    public function show($id)
    {
        // Lấy thuốc + join loại thuốc để lấy tên loại
        $thuoc = Thuoc::join('Loaithuoc', 'thuoc.maLoai', '=', 'Loaithuoc.maLoai')
            ->select('thuoc.*', 'Loaithuoc.tenLoai') // thêm trường tên loại
            ->where('thuoc.isDelete', false) // chỉ lấy thuốc chưa bị xóa
            ->where('thuoc.maThuoc', $id)
            ->firstOrFail(); // không thấy thì báo lỗi 404

        if (!$thuoc) {
            abort(404, 'Thuốc không tồn tại');
        }

        return view('ChiTietSanPham.index', compact('thuoc'));
    }

    // Lấy danh sách thuốc theo mã loại
    public function getByLoai($id)
    {
        $thuocs = Thuoc::where('maLoai', $id)
            ->where('isDelete', false)
            ->get(); // lấy tất cả thuốc thuộc loại này

        if (!$thuocs) {
            abort(404, 'Sản phẩm không tồn tại');
        }

        return view('LoaiThuoc.index', compact('thuocs'));
    }

    // Lấy dữ liệu cho trang chủ
    public function getTrangChu()
    {
        // Sản phẩm khuyến mãi: có giá KM và nhỏ hơn giá gốc
        $thuocKhuyenmai = Thuoc::whereNotNull('giaKhuyenMai') // có giá KM
            ->where('giaKhuyenMai', '>', 0)
            ->where('thuoc.isDelete', false)
            ->whereRaw('giaKhuyenMai < GiaTien') // đảm bảo đúng KM
            ->orderBy('giaKhuyenMai', 'desc') // KM nhiều trước
            ->limit(20)
            ->get();

        // Sản phẩm mới: tạo trong 30 ngày gần đây
        $thuocmoi = Thuoc::where('CreateAt', '>=', Carbon::now()->subDays(30))
            ->where('thuoc.isDelete', false)
            ->orderBy('CreateAt', 'desc')
            ->limit(20)
            ->get();


        // Trả về view với TẤT CẢ dữ liệu
        return view('trangchu.index', compact(
            'thuocKhuyenmai',
            'thuocmoi'

        ));
    }

    public function ajaxGetProduct($maThuoc)
    {
        $thuoc = Thuoc::where('maThuoc', $maThuoc)
            ->where('isDelete', false)
            ->firstOrFail();

        return response()->json([
            'tenThuoc' => $thuoc->tenThuoc,
            'GiaTien' => $thuoc->GiaTien,
            'DVTinh' => $thuoc->DVTinh,
            'HinhAnh' => $thuoc->HinhAnh,
            'maThuoc' => $thuoc->maThuoc,
            'giaKhuyenMai' => $thuoc->giaKhuyenMai,
        ]);
    }
}
