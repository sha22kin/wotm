@extends('admin.layouts.app')

@section('title', 'Media Gallery')
@section('page_title', 'Media Gallery')

@section('content')
<!-- Unified Filter & Action Toolbar -->
<div class="adm-card mb-3 p-3">
  <div class="row g-2 align-items-center justify-content-between">
    <!-- Left: Search & Filter Controls -->
    <div class="col-xl-8 col-lg-7 col-12">
      <form action="{{ route('admin.gallery.index') }}" method="GET" class="row g-2 align-items-center">
        <!-- Search Bar -->
        <div class="col-md-5 col-12">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0 text-muted">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0 adm-input" placeholder="Search caption or title..." value="{{ request('search') }}">
          </div>
        </div>

        <!-- Type Filter -->
        <div class="col-md-3 col-6">
          <select name="type" class="adm-select" onchange="this.form.submit()">
            <option value="">All Media Types</option>
            <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Photos Only</option>
            <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Videos Only</option>
          </select>
        </div>

        <!-- Category Filter -->
        <div class="col-md-3 col-6">
          <select name="category" class="adm-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                {{ $cat->name_en }} ({{ $cat->name_bn }})
              </option>
            @endforeach
          </select>
        </div>

        <!-- Filter & Clear -->
        <div class="col-md-1 col-12 d-flex gap-1">
          <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm w-100" title="Search">
            <i class="fa-solid fa-filter"></i>
          </button>
          @if(request('search') || request('type') || request('category'))
            <a href="{{ route('admin.gallery.index') }}" class="adm-btn adm-btn-outline adm-btn-sm" title="Clear Filters">
              <i class="fa-solid fa-xmark"></i>
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- Right: View Switcher, Categories Link & Upload Button -->
    <div class="col-xl-4 col-lg-5 col-12 d-flex justify-content-lg-end justify-content-between align-items-center gap-2">
      <!-- Grid / List Switcher -->
      <div class="adm-view-btn-group" role="group" aria-label="View switch">
        <button type="button" class="adm-view-btn is-active" id="btnGridView" title="Grid View">
          <i class="fa-solid fa-grip"></i>
        </button>
        <button type="button" class="adm-view-btn" id="btnListView" title="List View">
          <i class="fa-solid fa-list"></i>
        </button>
      </div>

      <a href="{{ route('admin.gallery-categories.index') }}" class="adm-btn adm-btn-outline adm-btn-sm" title="Manage Categories">
        <i class="fa-solid fa-folder-tree"></i> Categories
      </a>

      <a href="{{ route('admin.gallery.create') }}" class="adm-btn adm-btn-primary adm-btn-sm">
        <i class="fa-solid fa-plus"></i> Upload Media
      </a>
    </div>
  </div>
</div>

<!-- ==========================================================================
     1. MODERN GRID VIEW (DEFAULT)
     ========================================================================== -->
<div id="galleryGridView">
  @if($items->count() > 0)
    <div class="adm-media-grid">
      @foreach($items as $item)
        <div class="adm-media-tile">
          <div class="adm-media-thumb-box">
            @if($item->type === 'image')
              <img src="{{ asset($item->image_path ?: 'images/hero2.webp') }}" alt="{{ $item->title_en }}" class="adm-media-img" loading="lazy">
              <span class="adm-media-type-badge">
                <i class="fa-solid fa-camera"></i> Photo
              </span>
            @else
              <img src="{{ asset($item->image_path ?: 'images/video-thumb.jpg') }}" alt="{{ $item->title_en }}" class="adm-media-img" loading="lazy">
              <span class="adm-media-type-badge">
                <i class="fa-solid fa-video"></i> Video
              </span>
              <div class="adm-media-play-icon">
                <i class="fa-solid fa-play"></i>
              </div>
            @endif

            <!-- Category Pill Overlay -->
            <span class="adm-media-cat-badge">
              {{ $item->category_name }}
            </span>

            <!-- Hover Quick Action Buttons -->
            <div class="adm-media-overlay-actions">
              <a href="{{ route('admin.gallery.edit', $item->id) }}" class="adm-media-action-btn" title="Edit Media">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this media item?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="adm-media-action-btn is-danger" title="Delete">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </form>
            </div>
          </div>

          <!-- Card Meta Information -->
          <div class="adm-media-meta">
            <div>
              <div class="adm-media-title" title="{{ $item->title_en ?: $item->title_bn }}">
                {{ $item->title_en ?: $item->title_bn ?: 'Untitled Media' }}
              </div>
              @if($item->title_bn)
                <div class="text-muted fs-xs adm-truncate-sm">{{ $item->title_bn }}</div>
              @endif
            </div>

            <div class="adm-media-sub">
              <div>
                @if($item->is_active)
                  <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Hidden</span>
                @endif
              </div>
              <span>{{ $item->created_at->format('M d, Y') }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="adm-card text-center py-5 text-muted">
      <i class="fa-solid fa-photo-film fs-1 mb-2 d-block text-muted opacity-50"></i>
      <div class="fw-semibold">No media items found</div>
      <p class="fs-sm text-muted mt-1">Try changing your search or category filter, or upload new media.</p>
      <div class="mt-3">
        <a href="{{ route('admin.gallery.create') }}" class="adm-btn adm-btn-primary adm-btn-sm">
          <i class="fa-solid fa-plus"></i> Upload First Media
        </a>
      </div>
    </div>
  @endif
</div>

<!-- ==========================================================================
     2. SLEEK LIST / TABLE VIEW
     ========================================================================== -->
<div id="galleryListView" class="adm-preview-hidden">
  <div class="adm-card mb-0">
    <div class="adm-table-wrapper border-0">
      <table class="adm-table">
        <thead>
          <tr>
            <th class="ps-3">Media</th>
            <th>Title & Caption</th>
            <th>Type</th>
            <th>Category</th>
            <th>Status</th>
            <th>Uploaded</th>
            <th class="text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
            <tr>
              <td class="ps-3">
                <img src="{{ asset($item->image_path ?: 'images/hero2.webp') }}" alt="{{ $item->title_en }}" class="adm-gallery-thumb-table" loading="lazy">
              </td>
              <td>
                <div class="fw-semibold text-dark fs-sm adm-truncate-md">{{ $item->title_en ?: $item->title_bn ?: 'Untitled Media' }}</div>
                @if($item->title_bn)
                  <div class="text-muted fs-xs adm-truncate-md">{{ $item->title_bn }}</div>
                @endif
              </td>
              <td>
                @if($item->type === 'image')
                  <span class="adm-badge adm-badge-primary"><i class="fa-solid fa-camera me-1"></i> Photo</span>
                @else
                  <span class="adm-badge adm-badge-warning"><i class="fa-solid fa-video me-1"></i> Video</span>
                @endif
              </td>
              <td>
                <span class="adm-badge adm-badge-secondary">
                  {{ $item->category_name }}
                </span>
              </td>
              <td>
                @if($item->is_active)
                  <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Hidden</span>
                @endif
              </td>
              <td class="text-muted fs-xs">{{ $item->created_at->format('M d, Y') }}</td>
              <td class="text-end pe-3">
                <div class="d-inline-flex gap-1">
                  <a href="{{ route('admin.gallery.edit', $item->id) }}" class="adm-btn adm-btn-outline adm-btn-sm" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this media item?');">
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
              <td colspan="7" class="text-center py-4 text-muted">No media items found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Pagination -->
@if($items->hasPages())
  <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
    <div class="text-muted fs-xs">
      Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} media items
    </div>
    <div>
      {{ $items->links() }}
    </div>
  </div>
@endif

@push('scripts')
<script>
  // Instant View Switcher with localStorage persistence
  const btnGridView = document.getElementById('btnGridView');
  const btnListView = document.getElementById('btnListView');
  const gridView = document.getElementById('galleryGridView');
  const listView = document.getElementById('galleryListView');

  function setGalleryView(view) {
    if (view === 'list') {
      gridView.classList.add('adm-preview-hidden');
      listView.classList.remove('adm-preview-hidden');
      btnListView.classList.add('is-active');
      btnGridView.classList.remove('is-active');
      localStorage.setItem('admin_gallery_view', 'list');
    } else {
      listView.classList.add('adm-preview-hidden');
      gridView.classList.remove('adm-preview-hidden');
      btnGridView.classList.add('is-active');
      btnListView.classList.remove('is-active');
      localStorage.setItem('admin_gallery_view', 'grid');
    }
  }

  btnGridView.addEventListener('click', () => setGalleryView('grid'));
  btnListView.addEventListener('click', () => setGalleryView('list'));

  // Load saved view preference (default to grid)
  const savedView = localStorage.getItem('admin_gallery_view') || 'grid';
  setGalleryView(savedView);
</script>
@endpush
@endsection
