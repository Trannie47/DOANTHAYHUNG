<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thuoc;
use App\Models\Loaithuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ThuocController extends Controller
{
    /**
     * Hiển thị danh sách thuốc với phân trang và tìm kiếm
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $loai = $request->input('loai');
        $perPage = 10;

        $query = Thuoc::with('loaithuoc');

        if ($keyword) {
            $query->search($keyword);
        }

        if ($loai) {
            $query->byCategory($loai);
        }

        $thuocs = $query->paginate($perPage);
        $loaithuocs = Loaithuoc::orderBy('maLoai', 'desc')->get();

        return view('admin.thuoc.index', compact('thuocs', 'loaithuocs', 'keyword', 'loai'));
    }

    /**
     * Hiển thị form tạo thuốc mới
     */
    public function create()
    {
        $loaithuocs = Loaithuoc::orderBy('maLoai', 'desc')->get();

        return view('admin.thuoc.create', compact('loaithuocs'));
    }

    /**
     * Lưu thuốc mới vào database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenThuoc' => 'required|string|max:255',
            'QuiCach' => 'required|string|max:255',
            'GiaTien' => 'required|numeric|min:0',
            'DVTinh' => 'required|string|max:50',
            'maLoai' => 'required|exists:loaithuoc,maLoai',
            'DanhMuc' => 'nullable|string|max:255',
            'NSX' => 'nullable|string|max:255',
            'ThanhPhan' => 'nullable|string',
            'CongDung' => 'nullable|string',
            'CachSuDung' => 'nullable|string',
            'giaKhuyenMai' => 'nullable|numeric|min:0',
            'chiDinhCuaBacSi' => 'nullable|boolean',
            'HinhAnh' => 'nullable|array',
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý upload ảnh
        $images = [];
        if ($request->hasFile('HinhAnh')) {
            foreach ($request->file('HinhAnh') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'uploads/thuoc/' . $filename;

                Storage::disk('public')->put($path, file_get_contents($image));
                $images[] = asset('storage/' . $path);
            }
        }

        $validated['maThuoc'] = Thuoc::generateMaThuoc();
        $validated['HinhAnh'] = $images ?: null;
        $validated['CreateAt'] = Carbon::now();

        // Một số cột trong DB không cho phép NULL — đảm bảo có giá trị mặc định
        $validated['NSX'] = $validated['NSX'] ?? '';
        $validated['ThanhPhan'] = $validated['ThanhPhan'] ?? '';
        $validated['CongDung'] = $validated['CongDung'] ?? '';
        $validated['CachSuDung'] = $validated['CachSuDung'] ?? '';
        $validated['DanhMuc'] = $validated['DanhMuc'] ?? '';
        $validated['chiDinhCuaBacSi'] = $validated['chiDinhCuaBacSi'] ?? false;
        $validated['giaKhuyenMai'] = $validated['giaKhuyenMai'] ?? 0;
        Thuoc::create($validated);

        return redirect()->route('admin.thuoc.index')->with('success', 'Thêm thuốc thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa thuốc
     */
    public function edit($id)
    {
        $thuoc = Thuoc::findOrFail($id);
        $loaithuocs = Loaithuoc::orderBy('maLoai', 'desc')->get();

        return view('admin.thuoc.edit', compact('thuoc', 'loaithuocs'));
    }

    /**
     * Cập nhật thuốc
     */
    public function update(Request $request, $id)
    {
        $thuoc = Thuoc::findOrFail($id);

        $validated = $request->validate([
            'tenThuoc' => 'required|string|max:255',
            'QuiCach' => 'required|string|max:255',
            'GiaTien' => 'required|numeric|min:0',
            'DVTinh' => 'required|string|max:50',
            'maLoai' => 'required|exists:loaithuoc,maLoai',
            'DanhMuc' => 'nullable|string|max:255',
            'NSX' => 'nullable|string|max:255',
            'ThanhPhan' => 'nullable|string',
            'CongDung' => 'nullable|string',
            'CachSuDung' => 'nullable|string',
            'giaKhuyenMai' => 'nullable|numeric|min:0',
            'chiDinhCuaBacSi' => 'nullable|boolean',
            'HinhAnh' => 'nullable|array',
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
        ]);

        // Xử lý xóa ảnh cũ
        if ($request->has('delete_images')) {
            $deleteImages = $request->input('delete_images');
            $currentImages = $thuoc->HinhAnh ?? [];

            foreach ($deleteImages as $imageUrl) {
                $currentImages = array_filter($currentImages, fn($img) => $img !== $imageUrl);

                // Xóa file từ storage
                if (strpos($imageUrl, 'storage/') !== false) {
                    $path = str_replace(asset('storage/'), '', $imageUrl);
                    Storage::disk('public')->delete($path);
                }
            }

            $validated['HinhAnh'] = array_values($currentImages) ?: null;
        } else {
            $validated['HinhAnh'] = $thuoc->HinhAnh;
        }

        // Xử lý upload ảnh mới
        if ($request->hasFile('HinhAnh')) {
            $newImages = [];
            foreach ($request->file('HinhAnh') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'uploads/thuoc/' . $filename;

                Storage::disk('public')->put($path, file_get_contents($image));
                $newImages[] = asset('storage/' . $path);
            }

            $validated['HinhAnh'] = array_merge($validated['HinhAnh'] ?? [], $newImages);
        }

        // Đảm bảo các trường không null trước khi update
        $validated['NSX'] = $validated['NSX'] ?? $thuoc->NSX ?? '';
        $validated['ThanhPhan'] = $validated['ThanhPhan'] ?? $thuoc->ThanhPhan ?? '';
        $validated['CongDung'] = $validated['CongDung'] ?? $thuoc->CongDung ?? '';
        $validated['CachSuDung'] = $validated['CachSuDung'] ?? $thuoc->CachSuDung ?? '';
        $validated['DanhMuc'] = $validated['DanhMuc'] ?? $thuoc->DanhMuc ?? '';
        $validated['chiDinhCuaBacSi'] = $validated['chiDinhCuaBacSi'] ?? $thuoc->chiDinhCuaBacSi ?? false;
        $validated['giaKhuyenMai'] = $validated['giaKhuyenMai'] ?? $thuoc->giaKhuyenMai ?? 0;

        $thuoc->update($validated);

        return redirect()->route('admin.thuoc.index')->with('success', 'Cập nhật thuốc thành công!');
    }

    /**
     * Xóa (soft delete) thuốc
     */
    public function destroy($id)
    {
        $thuoc = Thuoc::findOrFail($id);

        // Xóa ảnh từ storage nếu có
        if ($thuoc->HinhAnh) {
            foreach ($thuoc->HinhAnh as $imageUrl) {
                if (strpos($imageUrl, 'storage/') !== false) {
                    $path = str_replace(asset('storage/'), '', $imageUrl);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $thuoc->delete();

        return redirect()->route('admin.thuoc.index')->with('success', 'Xóa thuốc thành công!');
    }

    /**
     * Khôi phục thuốc đã xóa
     */
    public function restore($id)
    {
        // restore no longer applicable — keep for compatibility or remove routes
        return redirect()->route('admin.thuoc.index')->with('info', 'Chức năng khôi phục không khả dụng.');
    }

    /**
     * Xóa vĩnh viễn (Hard delete)
     */
    public function forceDelete($id)
    {
        // forceDelete falls back to normal delete now
        return $this->destroy($id);
    }
}
