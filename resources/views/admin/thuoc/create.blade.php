@extends('admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-plus-circle"></i> Thêm Thuốc Mới</h2>
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

    <form action="{{ route('admin.thuoc.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation">
        @csrf
        <div class="row">
            {{-- Cột trái: Thông tin cơ bản --}}
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông Tin Cơ Bản</h5>
                    </div>
                    <div class="card-body">
                        {{-- Tên thuốc --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Thuốc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tenThuoc') is-invalid @enderror"
                                name="tenThuoc" placeholder="Nhập tên thuốc" value="{{ old('tenThuoc') }}" required>
                            @error('tenThuoc')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Quy cách --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quy Cách <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('QuiCach') is-invalid @enderror"
                                    name="QuiCach" placeholder="VD: 500mg, 10ml..." value="{{ old('QuiCach') }}" required>
                                @error('QuiCach')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Đơn vị tính --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Đơn Vị Tính <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('DVTinh') is-invalid @enderror"
                                    name="DVTinh" placeholder="VD: Viên, Lọ..." value="{{ old('DVTinh') }}" required>
                                @error('DVTinh')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Loại thuốc --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Loại Thuốc <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select @error('maLoai') is-invalid @enderror"
                                        name="maLoai" id="maLoai" required>
                                        <option value="">-- Chọn loại thuốc --</option>
                                        @foreach ($loaithuocs as $loaithuoc)
                                        <option value="{{ $loaithuoc->maLoai }}"
                                            {{ old('maLoai') == $loaithuoc->maLoai ? 'selected' : '' }}>
                                            {{ $loaithuoc->TenLoai }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="btnQuickAddLoai" data-bs-toggle="modal" data-bs-target="#quickAddLoaiModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('maLoai')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giá tiền --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá Tiền (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('GiaTien') is-invalid @enderror"
                                    name="GiaTien" placeholder="0" value="{{ old('GiaTien') }}" required>
                                @error('GiaTien')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Giá khuyến mại --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá Khuyến Mại (VNĐ)</label>
                                <input type="number" step="0.01" class="form-control @error('giaKhuyenMai') is-invalid @enderror"
                                    name="giaKhuyenMai" placeholder="0" value="{{ old('giaKhuyenMai') }}">
                                @error('giaKhuyenMai')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Danh mục --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh Mục</label>
                                <input type="text" class="form-control @error('DanhMuc') is-invalid @enderror"
                                    name="DanhMuc" placeholder="VD: Giảm đau, Hạ sốt..." value="{{ old('DanhMuc') }}">
                                @error('DanhMuc')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Chỉ định của bác sĩ --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="chiDinhCuaBacSi"
                                id="chiDinhCuaBacSi" value="1" {{ old('chiDinhCuaBacSi') ? 'checked' : '' }}>
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
                                name="NSX" placeholder="Tên nhà sản xuất" value="{{ old('NSX') }}" required>
                            @error('NSX')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Thành phần --}}
                        <div class="mb-3">
                            <label class="form-label">Thành Phần</label>
                            <textarea class="form-control @error('ThanhPhan') is-invalid @enderror"
                                name="ThanhPhan" rows="3" placeholder="Mô tả thành phần...">{{ old('ThanhPhan') }}</textarea>
                            @error('ThanhPhan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Công dụng --}}
                        <div class="mb-3">
                            <label class="form-label">Công Dụng</label>
                            <textarea class="form-control @error('CongDung') is-invalid @enderror"
                                name="CongDung" rows="3" placeholder="Mô tả công dụng...">{{ old('CongDung') }}</textarea>
                            @error('CongDung')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cách sử dụng --}}
                        <div class="mb-3">
                            <label class="form-label">Cách Sử Dụng</label>
                            <textarea class="form-control @error('CachSuDung') is-invalid @enderror"
                                name="CachSuDung" rows="3" placeholder="Hướng dẫn cách sử dụng...">{{ old('CachSuDung') }}</textarea>
                            @error('CachSuDung')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Số lượng hàng hoá</h5>
                    </div>
                    <div class="card-body">
                        {{-- Số lượng tồn kho --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số lượng tồn kho <span class="text-danger">*</span></label>
                            <input type="number" step="1" class="form-control @error('SoLuongTonKho') is-invalid @enderror"
                                name="SoLuongTonKho" placeholder="0" value="{{ old('SoLuongTonKho') }}" required>
                            @error('SoLuongTonKho')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>
                </div>
            </div>

            {{-- Cột phải: Upload ảnh --}}
            <div class="col-md-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Ảnh Sản Phẩm</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tải Lên Ảnh</label>
                            <input type="file" class="form-control @error('HinhAnh') is-invalid @enderror"
                                name="HinhAnh[]" multiple accept="image/*" id="imageInput">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Hỗ trợ: JPG, PNG, GIF (Max 2MB/ảnh)
                            </small>
                            @error('HinhAnh')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="imagePreview" class="mt-3">
                            {{-- Preview ảnh sẽ hiển thị ở đây --}}
                        </div>
                    </div>
                </div>

                {{-- Nút hành động --}}
                <div class="mt-3">
                    <button type="submit" class="btn btn-success w-100 mb-2">
                        <i class="fas fa-save"></i> Lưu Thuốc
                    </button>
                    <a href="{{ route('admin.thuoc.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Modal Quick Add Loại Thuốc --}}
<div class="modal fade" id="quickAddLoaiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Thêm Loại Thuốc Nhanh</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickAddLoaiForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Loại Thuốc</label>
                        <input type="text" class="form-control" name="TenLoai"
                            id="quickAddTenLoai" placeholder="Nhập tên loại thuốc" required>
                        <div id="loaiError" class="invalid-feedback d-block"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-success" id="btnQuickAddSave">
                        <i class="fas fa-plus"></i> Thêm Loại
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview ảnh
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'position-relative mb-2';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="img-thumbnail w-100">
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

    // Quick Add Loại Thuốc
    document.getElementById('btnQuickAddSave').addEventListener('click', async function() {
        const tenLoai = document.getElementById('quickAddTenLoai').value;
        const errorDiv = document.getElementById('loaiError');

        if (!tenLoai) {
            errorDiv.textContent = 'Vui lòng nhập tên loại thuốc';
            return;
        }

        try {
            const response = await fetch('{{ route("admin.loaithuoc.quickAdd") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    TenLoai: tenLoai
                })
            });

            const data = await response.json();

            if (data.success) {
                // Thêm option vào select
                const select = document.getElementById('maLoai');
                const option = new Option(data.data.TenLoai, data.data.maLoai, true, true);
                select.appendChild(option);
                select.value = data.data.maLoai;

                // Đóng modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('quickAddLoaiModal'));
                modal.hide();

                // Reset form
                document.getElementById('quickAddLoaiForm').reset();
                errorDiv.textContent = '';

                alert('Thêm loại thuốc thành công!');
            } else {
                errorDiv.textContent = data.message || 'Có lỗi xảy ra';
            }
        } catch (error) {
            errorDiv.textContent = 'Lỗi kết nối: ' + error.message;
        }
    });
</script>

<style>
    .sticky-top {
        z-index: 100;
    }

    .img-thumbnail {
        max-height: 150px;
        object-fit: cover;
    }
</style>
@endsection