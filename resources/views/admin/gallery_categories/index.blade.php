@extends('admin.layouts.app')

@section('title', 'Media Categories')
@section('page_title', 'Media Categories')

@section('content')
<div class="row g-4">
  <!-- Create New Gallery Category -->
  <div class="col-lg-4 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-plus"></i>
          <span>Add Category</span>
        </h2>
      </div>
      <form action="{{ route('admin.gallery-categories.store') }}" method="POST">
        @csrf
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="name_en">English Name <span class="adm-req">*</span></label>
            <input type="text" name="name_en" id="name_en" class="adm-input" placeholder="e.g. Tree Plantation" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="name_bn">Bangla Name <span class="adm-req">*</span></label>
            <input type="text" name="name_bn" id="name_bn" class="adm-input" placeholder="e.g. বৃক্ষরোপণ কর্মসূচি" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="slug">Filter Slug (Optional)</label>
            <input type="text" name="slug" id="slug" class="adm-input" placeholder="e.g. tree-plantation">
            <span class="adm-help-text">Used on website URL filter (e.g. tree, relief).</span>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="order">Display Order</label>
            <input type="number" name="order" id="order" class="adm-input" value="0" min="0">
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-switch">
              <input type="checkbox" name="is_active" value="1" checked>
              <span class="adm-switch-slider"></span>
              <span>Active on Website</span>
            </label>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-plus"></i> Create Category
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Gallery Categories List -->
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h2 class="adm-card-title mb-0">
          <i class="fa-solid fa-layer-group"></i>
          <span>Media Categories</span>
          <span class="adm-badge adm-badge-secondary ms-1">{{ $categories->count() }}</span>
        </h2>
        <a href="{{ route('admin.gallery.index') }}" class="adm-btn adm-btn-outline adm-btn-sm">
          <i class="fa-solid fa-arrow-left"></i> Back to Gallery
        </a>
      </div>
      <div class="adm-table-wrapper border-0">
        <table class="adm-table">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th>Category Details</th>
              <th>Media Count</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $cat)
              <tr>
                <td class="text-center text-muted fs-sm">{{ $cat->order }}</td>
                <td>
                  <div class="adm-cat-title-block">
                    <span class="adm-cat-name-main">{{ $cat->name_en }}</span>
                    <span class="adm-cat-meta-sub">
                      <span>{{ $cat->name_bn }}</span>
                      <span>&bull;</span>
                      <span class="adm-cat-slug-tag">{{ $cat->slug }}</span>
                    </span>
                  </div>
                </td>
                <td>
                  <a href="{{ route('admin.gallery.index', ['category' => $cat->slug]) }}" class="adm-cat-pill text-decoration-none" title="View media in this category">
                    <i class="fa-regular fa-image me-1"></i>
                    <span>{{ $cat->items_count }} items</span>
                  </a>
                </td>
                <td>
                  @if($cat->is_active)
                    <span class="adm-badge adm-badge-success">Active</span>
                  @else
                    <span class="adm-badge adm-badge-secondary">Hidden</span>
                  @endif
                </td>
                <td class="text-end">
                  <div class="d-inline-flex gap-1">
                    <button type="button" 
                            class="adm-btn adm-btn-outline adm-btn-sm" 
                            title="Edit Category"
                            onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name_en) }}', '{{ addslashes($cat->name_bn) }}', '{{ $cat->slug }}', {{ $cat->order }}, {{ $cat->is_active ? 'true' : 'false' }})">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <form action="{{ route('admin.gallery-categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category? Associated media will be unlinked safely.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">No media categories created yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="adm-card mb-0">
        <div class="adm-card-header d-flex align-items-center justify-content-between">
          <h2 class="adm-card-title mb-0" id="editCategoryModalLabel">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Edit Category</span>
          </h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editCategoryForm" method="POST">
          @csrf
          @method('PUT')
          <div class="adm-card-body">
            <div class="adm-form-group">
              <label class="adm-label" for="edit_name_en">English Name <span class="adm-req">*</span></label>
              <input type="text" name="name_en" id="edit_name_en" class="adm-input" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="edit_name_bn">Bangla Name <span class="adm-req">*</span></label>
              <input type="text" name="name_bn" id="edit_name_bn" class="adm-input" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="edit_slug">Filter Slug</label>
              <input type="text" name="slug" id="edit_slug" class="adm-input">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="edit_order">Display Order</label>
              <input type="number" name="order" id="edit_order" class="adm-input" min="0">
            </div>

            <div class="adm-form-group mb-0">
              <label class="adm-switch">
                <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                <span class="adm-switch-slider"></span>
                <span>Active on Website</span>
              </label>
            </div>
          </div>
          <div class="adm-card-footer d-flex justify-content-between">
            <button type="button" class="adm-btn adm-btn-outline" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="adm-btn adm-btn-primary">
              <i class="fa-solid fa-check"></i> Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function openEditCategoryModal(id, nameEn, nameBn, slug, order, isActive) {
    var form = document.getElementById('editCategoryForm');
    form.action = "{{ url('admin/gallery-categories') }}/" + id;
    
    document.getElementById('edit_name_en').value = nameEn;
    document.getElementById('edit_name_bn').value = nameBn;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_order').value = order;
    document.getElementById('edit_is_active').checked = isActive;
    
    var modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
    modal.show();
  }
</script>
@endpush
@endsection
