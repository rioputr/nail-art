@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Pengguna</h2>
            <p class="text-muted mb-0">Kelola data pengguna sistem</p>
        </div>
    </div>

    <!-- Filter & Actions -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <form action="{{ route('admin.users.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0" 
                                   name="search" 
                                   placeholder="Cari pengguna..."
                                   value="{{ request('search') }}">
                        </div>
                    </form>
                </div>

                <!-- Role Filter -->
                <div class="col-md-3">
                    <form action="{{ route('admin.users.index') }}" method="GET" id="filterForm">
                        <select class="form-select" name="role" onchange="this.form.submit()">
                            <option value="">Semua Peran</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select> 
                    </form>
                </div>

                <!-- Actions -->
                <div class="col-md-5 text-end">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-pink">
                        <i class="bi bi-person-plus me-2"></i>Tambah Pengguna
                    </a>
                    <a href="{{ route('admin.users.export') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-download me-2"></i>Ekspor Data
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i> Aksi Massal
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" onclick="bulkAction('activate')">
                                    <i class="bi bi-check-circle me-2"></i>Aktifkan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">
                                    <i class="bi bi-x-circle me-2"></i>Nonaktifkan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                                    <i class="bi bi-trash me-2"></i>Hapus
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50" class="ps-4">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>Pengguna</th>
                            <th>Peran</th>
                            <th>Status</th>
                            <th>Terakhir Login</th>
                            <th width="150" class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $user->avatar_url }}" 
                                         class="rounded-circle" 
                                         width="40" 
                                         height="40"
                                         alt="{{ $user->name }}">
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $user->role_label }}</span>
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($user->status == 'inactive')
                                    <span class="badge bg-danger">Inactive</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah login' }}
                                </small>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="deleteUser({{ $user->id }})"
                                            title="Hapus"
                                            {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-3">Belum ada data pengguna</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small fw-medium">
                    Menampilkan <span class="text-dark fw-bold">{{ $users->firstItem() }}</span> - <span class="text-dark fw-bold">{{ $users->lastItem() }}</span> 
                    dari <span class="text-pink fw-bold">{{ $users->total() }}</span> pengguna
                </div>
                
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
                <p class="text-danger small mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" action="{{ route('admin.users.bulk-action') }}" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">
    <input type="hidden" name="user_ids" id="bulkUserIds">
</form>

@push('styles')
<style>
    .btn-pink {
        background: linear-gradient(135deg, #FF4D8D 0%, #D63B73 100%);
        color: white;
        border: none;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-pink:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 77, 141, 0.3);
        color: white;
    }

    .table thead th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr {
        transition: background-color 0.2s;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        font-weight: 500;
        padding: 0.375rem 0.75rem;
    }

    /* Custom Pagination Styling */
    .pagination {
        margin-bottom: 0;
        gap: 5px;
    }

    .page-item .page-link {
        border-radius: 8px !important;
        border: 1px solid #eef0f7;
        color: #6b7280;
        padding: 0.5rem 0.85rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #FF4D8D 0%, #D63B73 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 10px rgba(255, 77, 141, 0.2);
    }

    .page-item:not(.active):hover .page-link {
        background-color: #fff0f5;
        color: #FF4D8D;
        border-color: #FF4D8D;
    }

    .page-item.disabled .page-link {
        background-color: #f8f9fc;
        border-color: #eef0f7;
    }

    .card-footer {
        border-top: 1px solid #f1f5f9;
        padding: 1.25rem;
    }
</style>
@endpush

@push('scripts')
<script>
// Select All Checkbox
document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Delete User
function deleteUser(userId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/users/${userId}`;
    modal.show();
}

// Bulk Action
function bulkAction(action) {
    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    
    if (selectedCheckboxes.length === 0) {
        alert('Pilih minimal satu pengguna terlebih dahulu');
        return;
    }

    const userIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    
    let confirmMessage = '';
    switch(action) {
        case 'activate':
            confirmMessage = `Aktifkan ${userIds.length} pengguna?`;
            break;
        case 'deactivate':
            confirmMessage = `Nonaktifkan ${userIds.length} pengguna?`;
            break;
        case 'delete':
            confirmMessage = `Hapus ${userIds.length} pengguna? Tindakan ini tidak dapat dibatalkan!`;
            break;
    }

    if (confirm(confirmMessage)) {
        document.getElementById('bulkActionType').value = action;
        document.getElementById('bulkUserIds').value = JSON.stringify(userIds);
        document.getElementById('bulkActionForm').submit();
    }
}

// Auto-submit filter form
document.querySelector('select[name="role"]')?.addEventListener('change', function() {
    const form = this.closest('form');
    // Preserve search parameter
    const searchParam = new URLSearchParams(window.location.search).get('search');
    if (searchParam) {
        const searchInput = document.createElement('input');
        searchInput.type = 'hidden';
        searchInput.name = 'search';
        searchInput.value = searchParam;
        form.appendChild(searchInput);
    }
    form.submit();
});
</script>
@endpush
@endsection