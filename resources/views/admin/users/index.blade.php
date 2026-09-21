@extends('admin.layouts.app')

@section('title', 'Users & Roles')
@section('page_title', 'Users & Roles Management')

@section('content')
<!-- Role Filter Strip & Action Bar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
  <div class="adm-role-tabs mb-0">
    <a href="{{ route('admin.users.index') }}" class="adm-role-pill {{ !request('role') ? 'is-active' : '' }}">
      <span>All Users</span>
      <span class="adm-role-pill-count">{{ $roleCounts['all'] }}</span>
    </a>
    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => 'super_admin'])) }}" class="adm-role-pill {{ request('role') === 'super_admin' ? 'is-active' : '' }}">
      <span>Super Admin</span>
      <span class="adm-role-pill-count">{{ $roleCounts['super_admin'] }}</span>
    </a>
    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => 'admin'])) }}" class="adm-role-pill {{ request('role') === 'admin' ? 'is-active' : '' }}">
      <span>Admin</span>
      <span class="adm-role-pill-count">{{ $roleCounts['admin'] }}</span>
    </a>
    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => 'editor'])) }}" class="adm-role-pill {{ request('role') === 'editor' ? 'is-active' : '' }}">
      <span>Editor</span>
      <span class="adm-role-pill-count">{{ $roleCounts['editor'] }}</span>
    </a>
    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => 'moderator'])) }}" class="adm-role-pill {{ request('role') === 'moderator' ? 'is-active' : '' }}">
      <span>Moderator</span>
      <span class="adm-role-pill-count">{{ $roleCounts['moderator'] }}</span>
    </a>
    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => 'member'])) }}" class="adm-role-pill {{ request('role') === 'member' ? 'is-active' : '' }}">
      <span>Member</span>
      <span class="adm-role-pill-count">{{ $roleCounts['member'] }}</span>
    </a>
  </div>

  <div>
    <button type="button" class="adm-btn adm-btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
      <i class="fa-solid fa-user-plus"></i> Add New User
    </button>
  </div>
</div>

<!-- Search & Filter Card -->
<div class="adm-card mb-4">
  <div class="adm-card-body">
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
      @if(request('role'))
        <input type="hidden" name="role" value="{{ request('role') }}">
      @endif
      <div class="col-md-5 col-12">
        <input type="text" name="search" class="adm-input" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
      </div>
      <div class="col-md-3 col-6">
        <select name="status" class="adm-select">
          <option value="">All Statuses</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
          <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
        </select>
      </div>
      <div class="col-md-4 col-12 d-flex gap-2">
        <button type="submit" class="adm-btn adm-btn-primary flex-grow-1">
          <i class="fa-solid fa-filter"></i> Filter
        </button>
        @if(request()->anyFilled(['search', 'status', 'role']))
          <a href="{{ route('admin.users.index') }}" class="adm-btn adm-btn-outline" title="Reset Filters">
            <i class="fa-solid fa-rotate-left"></i>
          </a>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Users Table Card -->
<div class="adm-card">
  <div class="adm-card-header">
    <h2 class="adm-card-title">
      <i class="fa-solid fa-users"></i>
      <span>User Accounts ({{ $users->total() }})</span>
    </h2>
  </div>

  <div class="adm-table-wrapper border-0">
    <table class="adm-table">
      <thead>
        <tr>
          <th>User</th>
          <th>Phone</th>
          <th>Assigned Role</th>
          <th>Status</th>
          <th>Registered</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
          <tr>
            <td>
              <div class="adm-user-cell">
                @if($user->avatar)
                  <div class="adm-avatar-circle">
                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="adm-avatar-img">
                  </div>
                @else
                  <div class="adm-avatar-circle {{ $user->role === 'super_admin' ? 'is-super' : ($user->role === 'admin' ? 'is-admin' : ($user->role === 'editor' ? 'is-editor' : ($user->role === 'moderator' ? 'is-moderator' : 'is-member'))) }}">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                  </div>
                @endif
                <div>
                  <div class="fw-semibold text-dark">
                    {{ $user->name }}
                    @if(auth()->id() === $user->id)
                      <span class="adm-badge adm-badge-warning ms-1">You</span>
                    @endif
                  </div>
                  <div class="text-muted small">{{ $user->email }}</div>
                </div>
              </div>
            </td>
            <td>
              {{ $user->phone ?: '-' }}
            </td>
            <td>
              @if($user->role === 'super_admin')
                <span class="adm-badge adm-badge-danger"><i class="fa-solid fa-shield-halved me-1"></i> Super Admin</span>
              @elseif($user->role === 'admin')
                <span class="adm-badge adm-badge-primary"><i class="fa-solid fa-user-shield me-1"></i> Administrator</span>
              @elseif($user->role === 'editor')
                <span class="adm-badge adm-badge-info"><i class="fa-solid fa-pen-nib me-1"></i> Editor</span>
              @elseif($user->role === 'moderator')
                <span class="adm-badge adm-badge-warning"><i class="fa-solid fa-user-check me-1"></i> Moderator</span>
              @else
                <span class="adm-badge adm-badge-secondary"><i class="fa-solid fa-user me-1"></i> Member</span>
              @endif
            </td>
            <td>
              @if($user->status === 'active')
                <span class="adm-badge adm-badge-success">Active</span>
              @elseif($user->status === 'inactive')
                <span class="adm-badge adm-badge-muted">Inactive</span>
              @else
                <span class="adm-badge adm-badge-danger">Banned</span>
              @endif
            </td>
            <td>
              {{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}
            </td>
            <td class="text-end">
              <div class="d-inline-flex gap-1">
                <button type="button" 
                        class="adm-btn adm-btn-outline adm-btn-icon btn-edit-user" 
                        title="Edit User & Role"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-email="{{ $user->email }}"
                        data-phone="{{ $user->phone }}"
                        data-role="{{ $user->role }}"
                        data-status="{{ $user->status }}"
                        data-avatar="{{ $user->avatar ? asset($user->avatar) : '' }}">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>

                @if(auth()->id() !== $user->id)
                  <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete user {{ $user->name }}? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="adm-btn adm-btn-danger adm-btn-icon" title="Delete User">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <i class="fa-solid fa-users fs-2 mb-2 d-block"></i>
              No users found matching the given criteria.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($users->hasPages())
    <div class="adm-card-footer">
      {{ $users->links('pagination::bootstrap-5') }}
    </div>
  @endif
</div>

<!-- Modal: Add New User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">
          <i class="fa-solid fa-user-plus text-primary me-2"></i>Add New User
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="adm-form-group">
            <label class="adm-label" for="add_name">Full Name <span class="adm-req">*</span></label>
            <input type="text" name="name" id="add_name" class="adm-input" placeholder="e.g. John Doe" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="add_email">Email Address <span class="adm-req">*</span></label>
            <input type="email" name="email" id="add_email" class="adm-input" placeholder="e.g. user@example.com" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="add_phone">Phone Number</label>
            <input type="text" name="phone" id="add_phone" class="adm-input" placeholder="e.g. +8801XXXXXXXXX">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="add_avatar">Profile Image / Avatar</label>
            <input type="file" name="avatar" id="add_avatar" class="adm-input" accept="image/*" data-preview="addAvatarPreview">
            <img src="#" alt="Avatar Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="addAvatarPreview">
          </div>

          <div class="row g-3">
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="add_role">User Role <span class="adm-req">*</span></label>
                <select name="role" id="add_role" class="adm-select" required>
                  <option value="member">Member (General User)</option>
                  <option value="moderator">Moderator</option>
                  <option value="editor">Editor</option>
                  <option value="admin">Administrator</option>
                  <option value="super_admin">Super Admin</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="add_status">Account Status <span class="adm-req">*</span></label>
                <select name="status" id="add_status" class="adm-select" required>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                  <option value="banned">Banned</option>
                </select>
              </div>
            </div>
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-label" for="add_password">Initial Password <span class="adm-req">*</span></label>
            <input type="password" name="password" id="add_password" class="adm-input" placeholder="Minimum 6 characters" minlength="6" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="adm-btn adm-btn-outline" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-check"></i> Create User
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Edit User & Role -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">
          <i class="fa-solid fa-user-pen text-primary me-2"></i>Edit User Account
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editUserForm" method="POST" action="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="adm-form-group">
            <label class="adm-label" for="edit_name">Full Name <span class="adm-req">*</span></label>
            <input type="text" name="name" id="edit_name" class="adm-input" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="edit_email">Email Address <span class="adm-req">*</span></label>
            <input type="email" name="email" id="edit_email" class="adm-input" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="edit_phone">Phone Number</label>
            <input type="text" name="phone" id="edit_phone" class="adm-input">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="edit_avatar">Profile Image / Avatar</label>
            <input type="file" name="avatar" id="edit_avatar" class="adm-input" accept="image/*" data-preview="editAvatarPreview">
            <img src="#" alt="Avatar Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="editAvatarPreview">
          </div>

          <div class="row g-3">
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="edit_role">User Role <span class="adm-req">*</span></label>
                <select name="role" id="edit_role" class="adm-select" required>
                  <option value="member">Member (General User)</option>
                  <option value="moderator">Moderator</option>
                  <option value="editor">Editor</option>
                  <option value="admin">Administrator</option>
                  <option value="super_admin">Super Admin</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="edit_status">Account Status <span class="adm-req">*</span></label>
                <select name="status" id="edit_status" class="adm-select" required>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                  <option value="banned">Banned</option>
                </select>
              </div>
            </div>
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-label" for="edit_password">New Password (Optional)</label>
            <input type="password" name="password" id="edit_password" class="adm-input" placeholder="Leave blank to keep unchanged" minlength="6">
            <div class="adm-input-hint">Only fill this if you want to reset this user's password.</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="adm-btn adm-btn-outline" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Update User
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit-user');
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    const editForm = document.getElementById('editUserForm');

    editButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const email = this.getAttribute('data-email');
        const phone = this.getAttribute('data-phone') || '';
        const role = this.getAttribute('data-role');
        const status = this.getAttribute('data-status');
        const avatar = this.getAttribute('data-avatar');

        editForm.action = '{{ url("admin/users") }}/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_password').value = '';

        const previewEl = document.getElementById('editAvatarPreview');
        if (avatar) {
          previewEl.src = avatar;
          previewEl.classList.remove('adm-preview-hidden');
          previewEl.classList.add('adm-preview-shown');
        } else {
          previewEl.src = '#';
          previewEl.classList.add('adm-preview-hidden');
          previewEl.classList.remove('adm-preview-shown');
        }
        document.getElementById('edit_avatar').value = '';

        editModal.show();
      });
    });
  });
</script>
@endpush
