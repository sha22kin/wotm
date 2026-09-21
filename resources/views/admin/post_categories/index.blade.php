@extends('admin.layouts.app')

@section('title', 'Post Categories')
@section('page_title', 'Blog Post Categories')

@section('content')
<div class="row g-4">
  <!-- Create New Category -->
  <div class="col-lg-4 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-plus"></i>
          <span>Add New Category</span>
        </h2>
      </div>
      <form action="{{ route('admin.post-categories.store') }}" method="POST">
        @csrf
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="name_en">Category Name (English) <span class="adm-req">*</span></label>
            <input type="text" name="name_en" id="name_en" class="adm-input" placeholder="e.g. Relief & Emergency" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="name_bn">Category Name (Bangla) <span class="adm-req">*</span></label>
            <input type="text" name="name_bn" id="name_bn" class="adm-input" placeholder="e.g. ত্রাণ ও পুনর্বাসন" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="slug">Custom Slug (Optional)</label>
            <input type="text" name="slug" id="slug" class="adm-input" placeholder="e.g. relief-emergency">
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-switch">
              <input type="checkbox" name="is_active" value="1" checked>
              <span class="adm-switch-slider"></span>
              <span>Active</span>
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

  <!-- Category List -->
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-folder-tree"></i>
          <span>Existing Categories</span>
        </h2>
      </div>
      <div class="adm-table-wrapper border-0">
        <table class="adm-table">
          <thead>
            <tr>
              <th>English Name</th>
              <th>Bangla Name</th>
              <th>Slug</th>
              <th>Posts Count</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
              <tr>
                <td class="fw-semibold">{{ $category->name_en }}</td>
                <td>{{ $category->name_bn }}</td>
                <td><code>{{ $category->slug }}</code></td>
                <td>
                  <span class="adm-badge adm-badge-primary">{{ $category->posts_count }} posts</span>
                </td>
                <td>
                  <form action="{{ route('admin.post-categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="adm-btn adm-btn-danger adm-btn-sm" title="Delete">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">No categories created yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
