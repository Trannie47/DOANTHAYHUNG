{{-- resources/views/TaiKhoan/capnhat.blade.php --}}
@extends('app')

@section('title', 'Cập nhật thông tin cá nhân')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/DangKi') }}?v={{ time() }}">
@endpush

@section('content')
<div class="register-container">
    <h2>CẬP NHẬT THÔNG TIN</h2>

    <form class="register-form" method="POST" action="{{ route('updateprofile.update') }}">
        @csrf
        @method('PUT')

        <div class="input-wrapper">

            <!-- Số điện thoại (KHÔNG thay đổi) -->
            <div class="input-container">
                <label class="label-container">Số điện thoại</label>
                <input type="text"
                       value="{{ Auth::guard('khachhang')->user()->sdt }}"
                       disabled>
            </div>

            <!-- Email -->
            <div class="input-container">
                <label class="label-container" for="email">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ Auth::guard('khachhang')->user()->email }}"
                       required>
            </div>

            <!-- Họ tên -->
            <div class="input-container">
                <label class="label-container" for="ten">Họ tên</label>
                <input type="text"
                       id="ten"
                       name="ten"
                       value="{{ Auth::guard('khachhang')->user()->ten }}"
                       required>
            </div>

            <!-- Năm sinh -->
            <div class="input-container">
                <label class="label-container" for="dateBorn">Năm sinh</label>
                <input type="number"
                       id="dateBorn"
                       name="dateBorn"
                       min="1900"
                       max="2099"
                       value="{{ Auth::guard('khachhang')->user()->namsinh}}"
                       required>
            </div>

            <!-- Địa chỉ -->
            <div class="input-container">
                <label class="label-container" for="address">Địa chỉ</label>
                <input type="text"
                       id="address"
                       name="address"
                       value="{{ Auth::guard('khachhang')->user()->diaChi }}"
                       required>
            </div>

        </div>

        <button type="submit" class="register-btn">Cập nhật</button>
    </form>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/DangKi') }}?v={{ time() }}"></script>
@endpush
