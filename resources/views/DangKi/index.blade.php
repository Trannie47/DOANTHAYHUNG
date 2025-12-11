{{-- resources\views\DangKi\index.blade.php --}}
@extends('app')

@section('title', 'Đăng Kí')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/DangKi') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="register-container">
        <h2>ĐĂNG KÍ</h2>
        <form class="register-form" method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="input-wrapper">

                <div class="input-container">
                    <label class="label-container" for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" placeholder="+84" required>
                </div>

                <div class="input-container">
                    <label class="label-container" for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-container">
                    <label class="label-container" for="name">Họ Tên</label>
                    <input type="text" id="name" name="name" placeholder="Họ Tên" required>
                </div>

                <div class="input-container">
                    <label class="label-container" for="dateBorn">Năm Sinh</label>
                    <input type="number" id="dateBorn" name="dateBorn" min="1900" max="2099" placeholder="1999" required>
                </div>

                <div class="input-container">
                    <label class="label-container" for="Address">Địa Chỉ</label>
                    <input type="text" id="Address" name="address" placeholder="Address" required>
                </div>

                <div class="input-container">
                    <label class="label-container" for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="input-container">
                    <label class="label-container" for="password-confirm">Mật khẩu xác nhận</label>
                    <input type="password" id="password-confirm" name="password_confirmation" required>
                </div>

            </div>

            <button type="submit" class="register-btn">Đăng kí</button>
        </form>
    </div>
    @endsection

@push('scripts')
    <script src="{{ asset('js/DangKi') }}?v={{ time() }}"></script>
@endpush