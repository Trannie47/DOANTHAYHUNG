<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donhang;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = Donhang::query();

        // Lọc trạng thái
        if ($request->filled('status')) {
            $query->where('trangthai', $request->status);
        }

        // Lọc từ ngày
        if ($request->filled('from_date')) {
            $query->whereDate('ngaydat', '>=', $request->from_date);
        }

        // Lọc đến ngày
        if ($request->filled('to_date')) {
            $query->whereDate('ngaydat', '<=', $request->to_date);
        }

        $data = $query->orderBy('ngaydat', 'desc')->get();

        // Thống kê
        $stats = [
            'total' => Donhang::count(),
            'today' => Donhang::whereDate('ngaydat', today())->count(),
            'month' => Donhang::whereMonth('ngaydat', now()->month)->count(),
            'year'  => Donhang::whereYear('ngaydat', now()->year)->count(),
        ];

        return view('admin.donhang.index', compact('data', 'stats'));
    }

    public function pageLichSu(Request $request)
    {
        $query = Donhang::where('trangthai', 1); // chỉ lấy đơn đã duyệt

        // Tìm kiếm theo mã đơn
        if ($request->filled('keyword')) {
            $query->where('maDonHang', 'LIKE', '%' . $request->keyword . '%');
        }

        // Lọc theo số điện thoại người mua
        if ($request->filled('sdt')) {
            $query->where('SdtNguoiDat', 'LIKE', '%' . $request->sdt . '%');
        }

        // Lọc thời gian
        if ($request->filled('from_date')) {
            $query->whereDate('ngaydat', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('ngaydat', '<=', $request->to_date);
        }

        // Sắp xếp theo mới nhất / cũ nhất
        $sort = $request->get('sort', 'desc');
        $query->orderBy('ngaydat', $sort);

        $data = $query->paginate(10);

        return view('admin.donhang.lichsu', compact('data'));
    }
}
