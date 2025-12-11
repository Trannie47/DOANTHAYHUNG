<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Auth;

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
            } 
            else if ($khachhang->isAdmin == 1) {
                return redirect('/dashboard')->with('success', 'Đăng nhập thành công!');
            } 
        }

        // Sai thông tin => báo lỗi
        return back()->withErrors([
            'phone' => 'Số điện thoại hoặc mật khẩu không đúng',
        ])->onlyInput('phone'); // giữ lại giá trị phone
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

}
