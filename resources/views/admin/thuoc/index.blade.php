@extends('admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-pills"></i> Quản lý Thuốc</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.thuoc.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Thuốc Mới
            </a>
        </div>
    </div>

    {{-- Hiển thị thông báo --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Tìm kiếm và Lọc --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.thuoc.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Tìm kiếm tên thuốc</label>
                    <input type="text" class="form-control" name="search" 
                        placeholder="Nhập tên thuốc..." value="{{ $keyword }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Lọc theo loại thuốc</label>
                    <select class="form-select" name="loai">
                        <option value="">-- Tất cả --</option>
                        @foreach ($loaithuocs as $loaithuoc)
                            <option value="{{ $loaithuoc->maLoai }}" 
                                {{ $loai == $loaithuoc->maLoai ? 'selected' : '' }}>
                                {{ $loaithuoc->TenLoai }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Bảng danh sách thuốc --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách {{ $thuocs->total() }} thuốc</h5>
        </div>
        <div class="card-body table-responsive">
            @if ($thuocs->count() > 0)
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">#</th>
                            <th width="80">Ảnh</th>
                            <th width="200">Tên Thuốc</th>
                            <th width="100">Loại</th>
                            <th width="100">Giá Tiền</th>
                            <th width="80">Giá GM</th>
                            <th width="80">ĐVT</th>
                            <th width="150" class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($thuocs as $index => $thuoc)
                            <tr>
                                <td class="text-center">
                                    {{ ($thuocs->currentPage() - 1) * $thuocs->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    @if ($thuoc->getThumbnailImage())
                                        <img src="{{ $thuoc->getThumbnailImage() }}" 
                                            alt="{{ $thuoc->tenThuoc }}" 
                                            class="img-thumbnail" style="max-width: 60px; height: auto;">
                                    @else
                                        <span class="badge bg-secondary">Không ảnh</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $thuoc->tenThuoc }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $thuoc->maThuoc }}</small>
                                </td>
                                <td>
                                    @if ($thuoc->loaithuoc)
                                        <span class="badge bg-info">{{ $thuoc->loaithuoc->TenLoai }}</span>
                                    @else
                                        <span class="badge bg-danger">N/A</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-danger">
                                    {{ formatPrice($thuoc->GiaTien) }}
                                </td>
                                <td>{{ formatPrice($thuoc->giaKhuyenMai) }}</td>
                                <td>{{ $thuoc->DVTinh }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.thuoc.edit', $thuoc->maThuoc) }}" 
                                        class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModalThuoc{{ $loop->iteration }}"
                                        title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    {{-- Modal xóa --}}
                                    <div class="modal fade" id="deleteModalThuoc{{ $loop->iteration }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Xóa thuốc</h5>
                                                    <button type="button" class="btn-close btn-close-white" 
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Bạn chắc chắn muốn xóa thuốc <strong>{{ $thuoc->tenThuoc }}</strong>?</p>
                                                    <p class="text-muted small">Thuốc sẽ được đánh dấu là xóa nhưng vẫn giữ dữ liệu.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Hủy
                                                    </button>
                                                    <form action="{{ route('admin.thuoc.destroy', $thuoc->maThuoc) }}" 
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <nav class="d-flex justify-content-center mt-4">
                    {{ $thuocs->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox"></i> Không tìm thấy thuốc nào
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }

    .img-thumbnail {
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }
</style>

<script>
// Ensure DELETE forms are properly handled
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('form[method="POST"]');
    deleteForms.forEach(form => {
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput && methodInput.value === 'DELETE') {
            form.addEventListener('submit', function(e) {
                // Form will be submitted with _method=DELETE
                // Laravel will handle it through middleware
            });
        }
    });
});
</script>
@endsection
