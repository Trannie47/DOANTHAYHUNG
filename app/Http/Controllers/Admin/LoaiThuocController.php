<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loaithuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoaiThuocController extends Controller
{
    /**
     * Hiển thị danh sách loại thuốc
     */
    public function index(Request $request)
    {
        $loaithuocs = Loaithuoc::orderBy('maLoai', 'desc')
            ->paginate(15);

        return view('admin.loaithuoc.index', compact('loaithuocs'));
    }

    /**
     * Hiển thị form tạo loại thuốc
     */
    public function create()
    {
        return view('admin.loaithuoc.create');
    }

    /**
     * Lưu loại thuốc mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'TenLoai' => 'required|string|max:255|unique:loaithuoc',
            'GhiChu' => 'nullable|string',
        ]);

        Loaithuoc::create($validated);

        return redirect()->route('admin.loaithuoc.index')
            ->with('success', 'Thêm loại thuốc thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa loại thuốc
     */
    public function edit($id)
    {
        $loaithuoc = Loaithuoc::findOrFail($id);

        return view('admin.loaithuoc.edit', compact('loaithuoc'));
    }

    /**
     * Cập nhật loại thuốc
     */
    public function update(Request $request, $id)
    {
        $loaithuoc = Loaithuoc::findOrFail($id);

        $validated = $request->validate([
            'TenLoai' => 'required|string|max:255|unique:loaithuoc,TenLoai,' . $id . ',maLoai',
            'GhiChu' => 'nullable|string',
        ]);

        $loaithuoc->update($validated);

        return redirect()->route('admin.loaithuoc.index')
            ->with('success', 'Cập nhật loại thuốc thành công!');
    }

    /**
     * Xóa (soft delete) loại thuốc
     */
    public function destroy($id)
    {
        $loaithuoc = Loaithuoc::findOrFail($id);

        try {
            $loaithuoc->delete();

            return redirect()->route('admin.loaithuoc.index')
                ->with('success', 'Xóa loại thuốc thành công!');
        } catch (\Throwable $e) {
            Log::error('Failed to delete Loaithuoc id=' . $id . ' - ' . $e->getMessage());
            return redirect()->route('admin.loaithuoc.index')
                ->with('error', 'Đã xảy ra lỗi khi xóa loại thuốc.');
        }
    }

    /**
     * API: Thêm loại thuốc nhanh (Quick add)
     */
    public function quickAdd(Request $request)
    {
        $validated = $request->validate([
            'TenLoai' => 'required|string|max:255|unique:loaithuoc',
        ]);

        $loaithuoc = Loaithuoc::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm loại thuốc thành công!',
            'data' => $loaithuoc
        ]);
    }
}
