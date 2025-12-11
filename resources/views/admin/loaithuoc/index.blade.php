@extends('admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-list"></i> Quản lý Loại Thuốc</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.loaithuoc.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Loại Thuốc
            </a>
        </div>
    </div>

    {{-- Thông báo --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách {{ $loaithuocs->total() }} loại thuốc</h5>
        </div>
        <div class="card-body">
            @if ($loaithuocs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Tên Loại Thuốc</th>
                                <th>Ghi Chú</th>
                                <th width="150" class="text-center">Số Thuốc</th>
                                <th width="180" class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loaithuocs as $index => $loaithuoc)
                                <tr>
                                    <td class="text-center">
                                        {{ ($loaithuocs->currentPage() - 1) * $loaithuocs->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <strong>{{ $loaithuoc->TenLoai }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $loaithuoc->maLoai }}</small>
                                    </td>
                                    <td>{{ $loaithuoc->GhiChu ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $loaithuoc->thuocs()->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.loaithuoc.edit', $loaithuoc->maLoai) }}" 
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModalLoai{{ $loop->iteration }}">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>

                                        {{-- Modal xóa --}}
                                        <div class="modal fade" id="deleteModalLoai{{ $loop->iteration }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Xóa loại thuốc</h5>
                                                        <button type="button" class="btn-close btn-close-white" 
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Bạn chắc chắn muốn xóa loại thuốc <strong>{{ $loaithuoc->TenLoai }}</strong>?</p>
                                                        <p class="text-muted small">
                                                            <i class="fas fa-warning"></i> Thuốc thuộc loại này sẽ bị ẩn.
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Hủy
                                                        </button>
                                                        <form action="{{ route('admin.loaithuoc.destroy', $loaithuoc->maLoai) }}" 
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
                </div>

                {{-- Pagination --}}
                <nav class="d-flex justify-content-center mt-4">
                    {{ $loaithuocs->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox"></i> Không có loại thuốc nào
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
</style>

<script>
// Ensure DELETE forms are properly handled
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('form[method="POST"]');
    deleteForms.forEach(form => {
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput && methodInput.value === 'DELETE') {
            form.addEventListener('submit', function(e) {
                // Make sure form is submitted properly
                if (!confirm('Bạn chắc chắn muốn xóa?')) {
                    e.preventDefault();
                    return false;
                }
            });
        }
    });
});
</script>
@endsection
