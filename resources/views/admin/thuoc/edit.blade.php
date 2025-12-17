@extends('admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-edit"></i> Chỉnh Sửa Thuốc: {{ $thuoc->tenThuoc }}</h2>
        </div>
    </div>

    {{-- Hiển thị lỗi validation --}}
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

    <form action="{{ route('admin.thuoc.update', $thuoc->maThuoc) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            {{-- Cột trái: Thông tin cơ bản --}}
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông Tin Cơ Bản</h5>
                    </div>
                    <div class="card-body">
                        {{-- Mã thuốc (readonly) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Thuốc</label>
                            <input type="text" class="form-control" value="{{ $thuoc->maThuoc }}" readonly>
                            <small class="text-muted">Không thể chỉnh sửa</small>
                        </div>

                        {{-- Tên thuốc --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Thuốc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tenThuoc') is-invalid @enderror"
                                name="tenThuoc" value="{{ old('tenThuoc', $thuoc->tenThuoc) }}" required>
                            @error('tenThuoc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Quy cách --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quy Cách <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('QuiCach') is-invalid @enderror"
                                    name="QuiCach" value="{{ old('QuiCach', $thuoc->QuiCach) }}" required>
                                @error('QuiCach')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Đơn vị tính --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Đơn Vị Tính <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('DVTinh') is-invalid @enderror"
                                    name="DVTinh" value="{{ old('DVTinh', $thuoc->DVTinh) }}" required>
                                @error('DVTinh')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Loại thuốc --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Loại Thuốc <span class="text-danger">*</span></label>
                                <select class="form-select @error('maLoai') is-invalid @enderror"
                                    name="maLoai" required>
                                    <option value="">-- Chọn loại thuốc --</option>
                                    @foreach ($loaithuocs as $loaithuoc)
                                    <option value="{{ $loaithuoc->maLoai }}"
                                        {{ old('maLoai', $thuoc->maLoai) == $loaithuoc->maLoai ? 'selected' : '' }}>
                                        {{ $loaithuoc->TenLoai }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('maLoai')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giá tiền --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá Tiền (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('GiaTien') is-invalid @enderror"
                                    name="GiaTien" value="{{ old('GiaTien', $thuoc->GiaTien) }}" required>
                                @error('GiaTien')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Giá khuyến mại --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá Khuyến Mại (VNĐ)</label>
                                <input type="number" step="0.01" class="form-control @error('giaKhuyenMai') is-invalid @enderror"
                                    name="giaKhuyenMai" value="{{ old('giaKhuyenMai', $thuoc->giaKhuyenMai) }}">
                                @error('giaKhuyenMai')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Danh mục --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh Mục</label>
                                <input type="text" class="form-control @error('DanhMuc') is-invalid @enderror"
                                    name="DanhMuc" value="{{ old('DanhMuc', $thuoc->DanhMuc) }}">
                                @error('DanhMuc')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Chỉ định của bác sĩ --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="chiDinhCuaBacSi"
                                id="chiDinhCuaBacSi" value="1" {{ old('chiDinhCuaBacSi', $thuoc->chiDinhCuaBacSi) ? 'checked' : '' }}>
                            <label class="form-check-label" for="chiDinhCuaBacSi">
                                Cần chỉ định của bác sĩ
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Thông tin chi tiết --}}
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Thông Tin Chi Tiết</h5>
                    </div>
                    <div class="card-body">
                        {{-- Nhà sản xuất --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nhà Sản Xuất <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('NSX') is-invalid @enderror"
                                name="NSX" value="{{ old('NSX', $thuoc->NSX) }}" required>
                            @error('NSX')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Thành phần --}}
                        <div class="mb-3">
                            <label class="form-label">Thành Phần</label>
                            <textarea class="form-control @error('ThanhPhan') is-invalid @enderror"
                                name="ThanhPhan" rows="3">{{ old('ThanhPhan', $thuoc->ThanhPhan) }}</textarea>
                            @error('ThanhPhan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Công dụng --}}
                        <div class="mb-3">
                            <label class="form-label">Công Dụng</label>
                            <textarea class="form-control @error('CongDung') is-invalid @enderror"
                                name="CongDung" rows="3">{{ old('CongDung', $thuoc->CongDung) }}</textarea>
                            @error('CongDung')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cách sử dụng --}}
                        <div class="mb-3">
                            <label class="form-label">Cách Sử Dụng</label>
                            <textarea class="form-control @error('CachSuDung') is-invalid @enderror"
                                name="CachSuDung" rows="3">{{ old('CachSuDung', $thuoc->CachSuDung) }}</textarea>
                            @error('CachSuDung')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Số lượng hàng hoá --}}
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Số lượng hàng hoá</h5>
                    </div>
                    <div class="card-body">
                        {{-- Số lượng tồn kho --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số lượng tồn kho</label>
                            <input type="number" step="1" class="form-control @error('SoLuongTonKho') is-invalid @enderror"
                                name="SoLuongTonKho" value="{{ old('SoLuongTonKho', $thuoc->SoLuongTonKho) }}">
                            @error('SoLuongTonKho')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>
                </div>
            </div>

            {{-- Cột phải: Ảnh sản phẩm --}}
            <div class="col-md-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Ảnh Sản Phẩm</h5>
                    </div>
                    <div class="card-body">
                        {{-- Ảnh hiện tại --}}
                        @if ($thuoc->HinhAnh && is_array($thuoc->HinhAnh) && count($thuoc->HinhAnh) > 0)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh Hiện Tại</label>
                            <div id="currentImages">
                                @foreach ($thuoc->HinhAnh as $index => $image)
                                <div class="position-relative mb-2" id="image-{{ $index }}">
                                    <img src="{{ $image }}" alt="Product" class="img-thumbnail w-100">
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="button" class="btn btn-sm btn-danger flex-grow-1"
                                            onclick="deleteImage('{{ $image }}', {{ $index }})">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            onclick="downloadImage('{{ $image }}')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="delete_images[]" id="delete-{{ $index }}"
                                        class="delete-image-input">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-warning"></i> Chưa có ảnh
                        </div>
                        @endif

                        {{-- Upload ảnh mới --}}
                        <hr>
                        <div>
                            <label class="form-label fw-bold">Thêm Ảnh Mới</label>
                            <input type="file" class="form-control @error('HinhAnh') is-invalid @enderror"
                                name="HinhAnh[]" multiple accept="image/*" id="imageInput">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> JPG, PNG, GIF (Max 2MB/ảnh)
                            </small>
                            @error('HinhAnh')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="imagePreview" class="mt-3">
                            {{-- Preview ảnh mới sẽ hiển thị ở đây --}}
                        </div>
                    </div>
                </div>

                {{-- Nút hành động --}}
                <div class="mt-3">
                    <button type="submit" class="btn btn-success w-100 mb-2">
                        <i class="fas fa-save"></i> Lưu Thay Đổi
                    </button>
                    <a href="{{ route('admin.thuoc.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Preview ảnh mới
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        Array.from(e.target.files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'position-relative mb-2';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="New Preview" class="img-thumbnail w-100">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" 
                        onclick="this.parentElement.remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                    <small class="d-block mt-1">${file.name}</small>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Xóa ảnh
    function deleteImage(imageUrl, index) {
        if (confirm('Bạn chắc chắn muốn xóa ảnh này?')) {
            document.getElementById('delete-' + index).value = imageUrl;
            document.getElementById('image-' + index).style.opacity = '0.5';
            document.getElementById('image-' + index).style.textDecoration = 'line-through';
        }
    }

    // Download ảnh
    function downloadImage(url) {
        const link = document.createElement('a');
        link.href = url;
        link.download = 'image.jpg';
        link.click();
    }
</script>

<style>
    .sticky-top {
        z-index: 100;
    }

    .img-thumbnail {
        max-height: 200px;
        object-fit: cover;
    }
</style>
@endsection