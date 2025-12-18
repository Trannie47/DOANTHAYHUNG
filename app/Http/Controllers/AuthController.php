<?php

namespace App\Http\Controllers;

use App\Models\Donhang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Auth;
use App\Models\Loaithuoc;
use App\Models\Thuoc;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Hiển thị trang đăng ký
    public function showRegister()
    {
        return view('DangKi.index');
    }

    // Xử lý đăng ký tài khoản
    public function register(Request $request)
    {
        // Validate dữ liệu từ form
        $data = $request->validate([
            'phone' => 'required|string|unique:khachhang,sdt', // sdt không trùng
            'email' => 'nullable|email|unique:khachhang,email', // email có thể để trống
            'name' => 'required|string|min:3',
            'dateBorn' => 'required|string',
            'address' => 'required|string|min:3',
            'password' => 'required|min:6|confirmed', // cần password_confirmation
        ]);

        // Tạo khách hàng mới trong database
        $khachhang = Khachhang::create([
            'sdt' => $data['phone'],
            'ten' => $data['name'],
            'email' => $data['email'] ?? null,
            'namsinh' => $data['dateBorn'],
            'diaChi' => $data['address'],
            'matKhau' => Hash::make($data['password']), // mã hoá mật khẩu
            'GhiChu' => null
        ]);

        // Tự động đăng nhập khách hàng vừa đăng ký
        Auth::guard('khachhang')->login($khachhang);

        // Chuyển hướng về trang chủ kèm thông báo
        return redirect('/trangchu')->with('success', 'Đăng ký thành công, bạn đã được đăng nhập!');
    }

    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('DangNhap.index');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Kiểm tra dữ liệu nhập vào
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        // Tìm khách hàng theo số điện thoại
        $khachhang = Khachhang::where('sdt', $credentials['phone'])->first();

        // Kiểm tra tồn tại + đúng mật khẩu
        if ($khachhang && Hash::check($credentials['password'], $khachhang->matKhau)) {

            // Đăng nhập vào guard khachhang
            Auth::guard('khachhang')->login($khachhang);

            // Tạo session mới để bảo mật
            $request->session()->regenerate();

            // Kiểm tra quyền admin hay user
            if ($khachhang->isAdmin == 0) {
                return redirect('/trangchu')->with('success', 'Đăng nhập thành công!');
            } else if ($khachhang->isAdmin == 1) {
                return redirect('/dashboard')->with('success', 'Đăng nhập thành công!');
            }
        }

        // Sai thông tin => báo lỗi
        return back()
            ->with('error', 'Số điện thoại hoặc mật khẩu không đúng')
            ->onlyInput('phone');
    }


    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        // Logout guard 'khachhang'
        Auth::guard('khachhang')->logout();

        // Xoá toàn bộ session tránh lỗi 419
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Trả về trang đăng nhập
        return redirect('/dangnhap')->with('success', 'Bạn đã đăng xuất thành công!');
    }

    //Dăng nhâp admin
    public function showAdminLogin()
    {
        // Cards
        $SLLoaiThuoc = Loaithuoc::where('isDelete', false)->count();

        $SLThuoc = Thuoc::where('isDelete', false)->count();

        $SLDonHangTrongNgay = Donhang::whereDate('NgayDat', today())->count();



        // Chart: đơn thuốc theo tháng (năm hiện tại)
        $donThuocTheoThang = Thuoc::where('thuoc.isDelete', false)
            ->join(
                'chitietdonhang',
                'thuoc.maThuoc',
                '=',
                'chitietdonhang.maThuoc'
            )
            ->join(
                'donhang',
                'chitietdonhang.maDonHang',
                '=',
                'donhang.maDonHang'
            )
            ->select(
                'thuoc.tenThuoc',
                DB::raw('SUM(chitietdonhang.SoLuong) as tongSoLuong')
            )
            ->whereMonth('donhang.ngaydat', now()->month)
            ->whereYear('donhang.ngaydat', now()->year)
            ->groupBy('thuoc.tenThuoc')
            ->orderByDesc('tongSoLuong')
            ->limit(5)
            ->get();

        // Table: thuốc sắp hết
        $thuocSapHet = Thuoc::where('isDelete', false)
            ->where('SoLuongTonKho', '<=', 10)
            ->orderBy('SoLuongTonKho')
            ->limit(10)
            ->get();

        $year = now()->year;

        // Lấy số đơn theo từng tháng trong năm
        $ChartDonThuocTheoThang = Donhang::select(
            DB::raw('MONTH(ngaydat) as thang'),
            DB::raw('COUNT(*) as soDon')
        )
            ->whereYear('ngaydat', $year)
            ->groupBy(DB::raw('MONTH(ngaydat)'))
            ->orderBy(DB::raw('MONTH(ngaydat)'))
            ->get();

        // Tạo đủ 12 tháng (tháng không có đơn = 0)
        $labels = [];
        $data   = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = 'Tháng ' . $i;

            $found = $ChartDonThuocTheoThang->firstWhere('thang', $i);
            $data[] = $found ? $found->soDon : 0;
        }

        // Tỷ lệ thuốc theo loại (Phần trăm)
        $TyleThuocTheoLoai = Loaithuoc::join(
            'thuoc',
            'loaithuoc.maLoai',
            '=',
            'thuoc.maLoai'
        )
            ->select(
                'loaithuoc.TenLoai as tenLoaiThuoc',
                DB::raw('COUNT(thuoc.maThuoc) as soLuongThuoc')
            )
            ->where('loaithuoc.isDelete', false)
            ->where('thuoc.isDelete', false)
            ->groupBy('loaithuoc.TenLoai')
            ->get();
        $labelsLoaiThuoc = [];
        $dataLoaiThuoc = [];

        foreach ($TyleThuocTheoLoai as $item) {
            $labelsLoaiThuoc[] = $item->tenLoaiThuoc;
            $dataLoaiThuoc[] = $item->soLuongThuoc;
        }

        //Danh sách thuốc sắp hết hàng
        $dsThuocSapHetHang = Thuoc::where('isDelete', false)
            ->where('SoLuongTonKho', '<=', 50)
            ->orderBy('SoLuongTonKho', 'asc')
            ->get();    
        
        return view('dashboard.index', compact(
            'labels',
            'data',
            'labelsLoaiThuoc',
            'dataLoaiThuoc',
            'dsThuocSapHetHang',
            'SLLoaiThuoc',
            'SLThuoc',
            'SLDonHangTrongNgay',
            'donThuocTheoThang',
            'thuocSapHet'
        ));
    }
}
