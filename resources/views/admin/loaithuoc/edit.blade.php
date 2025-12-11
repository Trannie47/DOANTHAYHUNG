@extends('admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2><i class="fas fa-edit"></i> Chỉnh Sửa Loại Thuốc: {{ $loaithuoc->TenLoai }}</h2>

            {{-- Lỗi validation --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5><i class="fas fa-exclamation-circle"></i> Có lỗi xảy ra!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.loaithuoc.update', $loaithuoc->maLoai) }}" method="POST" class="card mt-4">
                @csrf
                @method('PUT')
                <div class="card-body">
                    {{-- Mã loại (readonly) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mã Loại</label>
                        <input type="text" class="form-control" value="{{ $loaithuoc->maLoai }}" readonly>
                        <small class="text-muted">Không thể chỉnh sửa</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Tên Loại Thuốc <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('TenLoai') is-invalid @enderror" 
                            name="TenLoai" value="{{ old('TenLoai', $loaithuoc->TenLoai) }}" required autofocus>
                        @error('TenLoai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ghi Chú</label>
                        <textarea class="form-control @error('GhiChu') is-invalid @enderror" 
                            name="GhiChu" rows="4">{{ old('GhiChu', $loaithuoc->GhiChu) }}</textarea>
                        @error('GhiChu')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Thông tin bổ sung --}}
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Có <strong>{{ $loaithuoc->thuocs()->count() }}</strong> thuốc thuộc loại này
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu Thay Đổi
                    </button>
                    <a href="{{ route('admin.loaithuoc.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
