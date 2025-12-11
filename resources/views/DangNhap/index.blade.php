{{-- resources\views\DangNhap\index.blade.php --}}
@extends('app')

@section('title', 'Đăng nhập')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/DangNhap') }}?v={{ time() }}">
@endpush

@section('content')

    <div class="login-container">

        <h2>ĐĂNG NHẬP</h2>
        <form class="login-form" method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="input-wrapper">
                <div class="input-container">
                    <label class="label-container" for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại" required>
                </div>
                <div class="input-container">
                    <label class="label-container" for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
                </div>
            </div>
            

            <a href="#" class="forgot-password">Quên mật khẩu?</a>

            <button type="submit" class="login-btn" >Đăng nhập</button>

            <p class="register-link">Chưa có tài khoản? <a href="{{url('/dangki')}}">Đăng kí</a></p>
        </form>
    </div>
    <!-- Chatbox -->
    <button id="open_chatbox" title="Mở chat"><i class="fa-regular fa-message"></i></button>
    <div id="chatbox" style="display:none;">
        <button id="close_chatbox" title="Đóng chatbox">×</button>
        <iframe src="https://www.chatbase.co/chatbot-iframe/iKp1d0Z7u4lW7wMauNcBu" width="100%" height="100%" frameborder="0" style="min-height: 500px;"></iframe>
    </div>

    <button id="backToTop" title="Về đầu trang"><i class="fa-solid fa-angle-up"></i></button>

@endsection

@push('scripts')
    <script src="{{ asset('js/DangNhap') }}?v={{ time() }}"></script>
@endpush