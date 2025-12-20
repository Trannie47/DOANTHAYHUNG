{{-- resources/views/TaiKhoan/doimatkhau.blade.php --}}
@extends('app')

@section('title', 'Đổi mật khẩu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/DangKi') }}?v={{ time() }}">
@endpush

@section('content')
<div class="register-container">
    <h2>ĐỔI MẬT KHẨU</h2>

    <form class="register-form" method="POST" action="{{ route('updatepassword.update') }}">
        @csrf
        @method('PUT')

        <div class="input-wrapper">

            <!-- Mật khẩu hiện tại -->
            <div class="input-container">
                <label class="label-container" for="current_password">Mật khẩu hiện tại</label>
                <input type="password"
                       id="current_password"
                       name="current_password"
                       required>
            </div>

            <!-- Mật khẩu mới -->
            <div class="input-container">
                <label class="label-container" for="password">Mật khẩu mới</label>
                <input type="password"
                       id="password"
                       name="password"
                       required>
            </div>

            <!-- Xác nhận mật khẩu mới -->
            <div class="input-container">
                <label class="label-container" for="password_confirmation">Xác nhận mật khẩu mới</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       required>
            </div>

        </div>

        <button type="submit" class="register-btn">Đổi mật khẩu</button>
    </form>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/DangKi') }}?v={{ time() }}"></script>
@endpush
