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
}
