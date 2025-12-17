<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thuoc;
use App\Models\Loaithuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ThuocController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $loai = $request->input('loai');

        $query = Thuoc::with('loaithuoc')->where('isDelete', false);

        if ($keyword) {
            $query->search($keyword);
        }

        if ($loai) {
            $query->byCategory($loai);
        }

        $thuocs = $query->paginate(10);
        $loaithuocs = Loaithuoc::where('isDelete', false)->orderBy('maLoai', 'desc')->get();

        return view('admin.thuoc.index', compact('thuocs', 'loaithuocs', 'keyword', 'loai'));
    }

    public function create()
    {
        $loaithuocs = Loaithuoc::where('isDelete', false)->orderBy('maLoai', 'desc')->get();
        return view('admin.thuoc.create', compact('loaithuocs'));
    }

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
            'SoLuongTonKho' => 'nullable|numeric|min:0',
            'HinhAnh' => 'nullable|array',
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload hình
        $images = [];
        if ($request->hasFile('HinhAnh')) {
            foreach ($request->file('HinhAnh') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = "uploads/thuoc/$filename";
                Storage::disk('public')->put($path, file_get_contents($image));
                $images[] = asset("storage/$path");
            }
        }

        $validated['maThuoc'] = Thuoc::generateMaThuoc();
        $validated['HinhAnh'] = $images ?: null;
        $validated['CreateAt'] = Carbon::now();
        $validated['chiDinhCuaBacSi'] = $validated['chiDinhCuaBacSi'] ?? false;
        $validated['giaKhuyenMai'] = $validated['giaKhuyenMai'] ?? 0;
        $validated['SoLuongTonKho'] = $validated['SoLuongTonKho'] ?? 0;
        Thuoc::create($validated);

        return redirect()->route('admin.thuoc.index')->with('success', 'Thêm thuốc thành công!');
    }

    public function edit($id)
    {
        $thuoc = Thuoc::findOrFail($id);
        $loaithuocs = Loaithuoc::where('isDelete', false)->orderBy('maLoai', 'desc')->get();

        return view('admin.thuoc.edit', compact('thuoc', 'loaithuocs'));
    }

    public function update(Request $request, $id)
    {
        // FIX LỖI LỚN Ở ĐÂY
        $thuoc = Thuoc::where('isDelete', false)->findOrFail($id);

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
            'SoLuongTonKho' => 'nullable|numeric|min:0',
            'HinhAnh' => 'nullable|array',
            'HinhAnh.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
        ]);

        // Xóa ảnh cũ
        if ($request->has('delete_images')) {
            $remain = [];

            foreach ($thuoc->HinhAnh ?? [] as $img) {
                if (!in_array($img, $request->delete_images)) {
                    $remain[] = $img;
                } else {
                    $path = str_replace(asset('storage/') , '', $img);
                    Storage::disk('public')->delete($path);
                }
            }

            $validated['HinhAnh'] = $remain;
        } else {
            $validated['HinhAnh'] = $thuoc->HinhAnh;
        }

        // Thêm ảnh mới
        if ($request->hasFile('HinhAnh')) {
            foreach ($request->file('HinhAnh') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = "uploads/thuoc/$filename";
                Storage::disk('public')->put($path, file_get_contents($image));
                $validated['HinhAnh'][] = asset("storage/$path");
            }
        }

        $thuoc->update($validated);

        return redirect()->route('admin.thuoc.index')->with('success', 'Cập nhật thuốc thành công!');
    }

    public function destroy($id)
    {
        $thuoc = Thuoc::findOrFail($id);

        if ($thuoc->HinhAnh) {
            foreach ($thuoc->HinhAnh as $img) {
                $path = str_replace(asset('storage/'), '', $img);
                Storage::disk('public')->delete($path);
            }
        }

        $thuoc->update(['isDelete' => true]);

        return redirect()->route('admin.thuoc.index')->with('success', 'Xóa thuốc thành công!');
    }

    public function restore($id)
    {
        return redirect()->route('admin.thuoc.index')->with('info', 'Chức năng khôi phục không khả dụng.');
    }

    public function forceDelete($id)
    {
        return $this->destroy($id);
    }
}
