<?php

namespace App\Http\Controllers;

use App\Models\Chitietdonhang;
use App\Models\Donhang;
use Illuminate\Http\Request;
use App\Models\Thuoc;
use Illuminate\Support\Facades\Auth;

class GioHangController extends Controller
{
    // Thêm sản phẩm vào giỏ
    public function addToCart(Request $request, $id)
    {
        $product = Thuoc::findOrFail($id); // Lấy thuốc theo ID

        // Validate số lượng
        $credentials = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Lấy hoặc tạo giỏ hàng (mảng trong session)
        $cart = session()->get('cart', []);

        // Lấy ảnh đầu tiên, nếu không có thì dùng ảnh mặc định
        $image = is_array($product->HinhAnh) && !empty($product->HinhAnh)
            ? $product->HinhAnh[0]
            : "logo.png";

        // Nếu có giá khuyến mãi thì lấy, không thì lấy giá gốc
        $giaTien = $product->giaKhuyenMai ?? $product->GiaTien;

        // Nếu sản phẩm đã có trong giỏ → tăng số lượng
        if (isset($cart[$id])) {
            $cart[$id]['soLuong'] += $credentials['quantity'];
        } else {
            // Nếu chưa có → thêm mới
            $cart[$id] = [
                'tenThuoc' => $product->tenThuoc,
                'gia' => $giaTien,
                'hinhAnh' => $image,
                'soLuong' => $credentials['quantity']
            ];
        }

        // Lưu lại vào session
        session()->put('cart', $cart);

        return back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Xóa sản phẩm
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    // Cập nhật số lượng trong giỏ
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        $action = $request->input('action'); // hành động: inc / dec / nhập trực tiếp
        $quantity = (int) $request->input('quantity', $cart[$id]['soLuong']);

        if ($action === 'inc') {
            $cart[$id]['soLuong'] = $quantity + 1; // tăng 1
        } elseif ($action === 'dec') {
            // giảm nhưng không để < 1
            $cart[$id]['soLuong'] = max(1, $quantity - 1);
        } else {
            // Nếu người dùng nhập trực tiếp số
            $cart[$id]['soLuong'] = max(1, $quantity);
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    // Hiển thị chi tiết giỏ hàng
    public function ShowCartDetail()
    {
        $cart = session('cart', []); // Lấy giỏ hàng
        return view('GioHang.index', compact('cart'));
    }

    // Thanh toán giỏ hàng
    public function pay()
    {
        $cart = session('cart', []);

        // Kiểm tra giỏ hàng rỗng
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        // Chưa đăng nhập thì không cho thanh toán
        if (!Auth::guard('khachhang')->check()) {
            return redirect('/dangnhap')->with('error', 'Bạn cần đăng nhập để thanh toán!');
        }

        $user = Auth::guard('khachhang')->user(); // Lấy thông tin khách

        // Tạo mã đơn theo ngày: YYYYMMDD + số tăng dần
        $today = now()->format('Ymd');

        $lastOrder = Donhang::where('ngaydat', $today)
            ->orderBy('maDonHang', 'DESC')
            ->first();

        if ($lastOrder) {
            $lastIndex = (int) substr($lastOrder->maDonHang, -3); // Lấy 3 số cuối
            $newIndex = str_pad($lastIndex + 1, 3, '0', STR_PAD_LEFT); // Tăng 1
        } else {
            $newIndex = "001"; // Đơn đầu tiên trong ngày
        }

        $maDon = $today . $newIndex; // Ghép mã cuối cùng

        // Tính tổng tiền giỏ hàng
        $tongTien = array_sum(array_map(
            fn($item) => $item['gia'] * $item['soLuong'],
            $cart
        ));

        // Lưu đơn hàng vào database
        Donhang::create([
            'maDonHang'   => $maDon,
            'ngaydat'     => $today,
            'tongTien'    => $tongTien,
            'DiaChi'      => $user->diaChi,
            'SdtNguoiDat' => $user->sdt,
            'MaKH'        => $user->maKhachHang ?? null
        ]);

        // Lưu chi tiết từng sản phẩm của đơn
        foreach ($cart as $maThuoc => $item) {
            Chitietdonhang::create([
                'maDonHang' => $maDon,
                'maThuoc'   => $maThuoc,
                'SoLuong'   => $item['soLuong'],
                'SoTien'    => $item['gia'] * $item['soLuong'],
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng xong
        session()->forget('cart');

        return redirect()->route('cart.index')
            ->with('success', "Đặt hàng thành công! Mã đơn: $maDon");
    }

    public function buyNow(Request $request, $maThuoc)
    {
        // Chưa đăng nhập → chuyển login
        if (!Auth::guard('khachhang')->check()) {
            return redirect('/dangnhap')
                ->with('error', 'Bạn cần đăng nhập để mua hàng!');
        }

        $user = Auth::guard('khachhang')->user();

        // Lấy số lượng (mặc định = 1)
        $quantity = max(1, (int) $request->query('quantity', 1));

        // Lấy thuốc
        $thuoc = Thuoc::where('maThuoc', $maThuoc)
            ->where('isDelete', false)
            ->first();

        if (!$thuoc) {
            return back()->with('error', 'Sản phẩm không tồn tại!');
        }

        // Giá bán (ưu tiên giá KM)
        $giaBan = $thuoc->giaKhuyenMai && $thuoc->giaKhuyenMai > 0
            ? $thuoc->giaKhuyenMai
            : $thuoc->GiaTien;

        // Tạo mã đơn hàng: YYYYMMDD + số tăng
        $today = now()->format('Ymd');

        $lastOrder = Donhang::where('ngaydat', $today)
            ->orderBy('maDonHang', 'DESC')
            ->first();

        if ($lastOrder) {
            $lastIndex = (int) substr($lastOrder->maDonHang, -3);
            $newIndex = str_pad($lastIndex + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newIndex = '001';
        }

        $maDon = $today . $newIndex;

        // Tổng tiền
        $tongTien = $giaBan * $quantity;

        // Lưu đơn hàng
        Donhang::create([
            'maDonHang'   => $maDon,
            'ngaydat'     => $today,
            'tongTien'    => $tongTien,
            'DiaChi'      => $user->diaChi,
            'SdtNguoiDat' => $user->sdt,
            'MaKH'        => $user->maKhachHang ?? null
        ]);

        // Lưu chi tiết đơn
        Chitietdonhang::create([
            'maDonHang' => $maDon,
            'maThuoc'   => $thuoc->maThuoc,
            'SoLuong'   => $quantity,
            'SoTien'    => $giaBan * $quantity,
        ]);

        return back()->with('success', "Mua ngay thành công! Mã đơn: $maDon");
    }
}
