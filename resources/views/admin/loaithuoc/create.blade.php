@extends('admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2><i class="fas fa-plus-circle"></i> Thêm Loại Thuốc Mới</h2>

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

            <form action="{{ route('admin.loaithuoc.store') }}" method="POST" class="card mt-4">
                @csrf
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tên Loại Thuốc <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('TenLoai') is-invalid @enderror" 
                            name="TenLoai" placeholder="VD: Giảm đau, Hạ sốt, Kháng sinh..."
                            value="{{ old('TenLoai') }}" required autofocus>
                        @error('TenLoai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ghi Chú</label>
                        <textarea class="form-control @error('GhiChu') is-invalid @enderror" 
                            name="GhiChu" rows="4" placeholder="Mô tả chi tiết về loại thuốc này...">{{ old('GhiChu') }}</textarea>
                        @error('GhiChu')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu Loại Thuốc
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
