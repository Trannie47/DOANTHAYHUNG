<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thuoc;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ThuocController extends Controller
{
    // Hiển thị chi tiết 1 thuốc
    public function show($id)
    {
        // Lấy thuốc + join loại thuốc để lấy tên loại
        $thuoc = Thuoc::join('loaithuoc', 'thuoc.maLoai', '=', 'loaithuoc.maLoai')
            ->select('thuoc.*', 'loaithuoc.tenLoai') // thêm trường tên loại
            ->where('thuoc.isDelete', false) // chỉ lấy thuốc chưa bị xóa
            ->where('thuoc.maThuoc', $id)
            ->firstOrFail(); // không thấy thì báo lỗi 404

        if (!$thuoc) {
            abort(404, 'Thuốc không tồn tại');
        }

        return view('ChiTietSanPham.index', compact('thuoc'));
    }

    // Lấy danh sách thuốc theo mã loại
    public function getByLoai(Request $request, $id)
    {
        $query = Thuoc::where('maLoai', $id)
            ->where('isDelete', false);

        // 🔥 LỌC THEO NSX (NẾU CÓ)
        if ($request->filled('nsx')) {
            $nsx = explode(',', $request->nsx);
            $query->whereIn('NSX', $nsx);
        }

        // PHÂN TRANG ĐÚNG THEO KẾT QUẢ LỌC
        $thuocs = $query->paginate(15)->withQueryString();

        if ($thuocs->isEmpty()) {
            abort(404, 'Sản phẩm không tồn tại');
        }

        //  DANH SÁCH NSX (KHÔNG LỌC – ĐỂ SIDEBAR)
        $DsNSX = Thuoc::where('maLoai', $id)
            ->where('isDelete', false)
            ->select('NSX', DB::raw('COUNT(*) as total'))
            ->groupBy('NSX')
            ->get();

        return view('LoaiThuoc.index', compact('thuocs', 'DsNSX'));
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

    public function search(Request $request)
    {
        $q = trim($request->q);

        if ($q === '') {
            return response()->json([]);
        }

        $thuocs = Thuoc::where('isDelete', false)
            ->where('tenThuoc', 'like', "%$q%")
            ->limit(8)
            ->get()
            ->map(function ($item) {

                // Nếu hinhAnh lưu dạng json
                $img = is_array($item->HinhAnh)
                    ? ($item->HinhAnh[0] ?? 'logo.png')
                    : ($item->HinhAnh ?? 'logo.png');

                return [
                    'maThuoc' => $item->maThuoc,
                    'tenThuoc' => $item->tenThuoc,
                    'gia' => number_format($item->GiaTien),
                    'giaKM' => number_format($item->giaKhuyenMai),
                    'hinhAnh' => asset($img),
                ];
            });

        return response()->json($thuocs);
    }
}
