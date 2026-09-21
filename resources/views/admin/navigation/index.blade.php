@extends('admin.layouts.app')

@section('title', 'Header & Navigation')
@section('page_title', 'Header & Navigation Menu')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="adm-card">
      <div class="adm-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <h2 class="adm-card-title mb-0">
            <i class="fa-solid fa-bars-staggered"></i>
            <span>Main Navigation Menus</span>
          </h2>
          <span class="adm-badge adm-badge-primary">{{ $items->count() }} Main Menus</span>
        </div>
        <button type="button" class="adm-btn adm-btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
          <i class="fa-solid fa-plus me-1"></i> Add Main Menu
        </button>
      </div>

      <div class="adm-table-wrapper border-0">
        <table class="adm-table" id="navSortableTable">
          <thead>
            <tr>
              <th class="ps-3">Main Menu Label</th>
              <th>Link URL</th>
              <th>Order / Move</th>
              <th>Status</th>
              <th class="text-end pe-3">Actions</th>
            </tr>
          </thead>
          <tbody id="navSortableBody">
            @forelse($items as $item)
              <!-- Main Menu Row Only -->
              <tr class="nav-row-main nav-sortable-row" data-id="{{ $item->id }}">
                <td class="ps-3">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-grip-vertical adm-drag-handle me-2" title="Drag to reorder"></i>
                    <div>
                      <span class="text-dark fw-bold">{{ $item->title_en }}</span>
                      @if($item->title_bn && $item->title_bn !== $item->title_en)
                        <span class="text-muted small fw-normal ms-1">({{ $item->title_bn }})</span>
                      @endif
                      @if($item->children->count() > 0)
                        <span class="adm-badge adm-badge-info ms-2">
                          <i class="fa-solid fa-layer-group me-1"></i>{{ $item->children->count() }} Sub-menus
                        </span>
                      @endif
                    </div>
                  </div>
                </td>
                <td>
                  <span class="nav-url-pill">{{ $item->url }}</span>
                </td>
                <td>
                  <div class="adm-order-cell">
                    <span class="adm-badge adm-badge-secondary me-1">{{ $item->order }}</span>
                    <!-- Move Up Button -->
                    <form action="{{ route('admin.navigation.move', [$item->id, 'up']) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="adm-btn adm-btn-outline adm-btn-icon" title="Move Up" {{ $loop->first ? 'disabled' : '' }}>
                        <i class="fa-solid fa-arrow-up"></i>
                      </button>
                    </form>
                    <!-- Move Down Button -->
                    <form action="{{ route('admin.navigation.move', [$item->id, 'down']) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="adm-btn adm-btn-outline adm-btn-icon" title="Move Down" {{ $loop->last ? 'disabled' : '' }}>
                        <i class="fa-solid fa-arrow-down"></i>
                      </button>
                    </form>
                  </div>
                </td>
                <td>
                  @if($item->is_active)
                    <span class="adm-badge adm-badge-success">Active</span>
                  @else
                    <span class="adm-badge adm-badge-muted">Hidden</span>
                  @endif
                </td>
                <td class="text-end pe-3">
                  <div class="d-inline-flex align-items-center gap-1">
                    <!-- Edit Button navigates to Edit Page (with Main menu edit & Sub-menus management) -->
                    <a href="{{ route('admin.navigation.edit', $item->id) }}" 
                       class="adm-btn adm-btn-outline" 
                       title="Edit Menu & Sub-Menus">
                      <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                    </a>

                    <!-- Delete Button -->
                    <form action="{{ route('admin.navigation.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this menu item? Any sub-items will also be deleted.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="adm-btn adm-btn-danger adm-btn-icon" title="Delete Menu">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                  <i class="fa-solid fa-bars-staggered fs-2 mb-2 d-block"></i>
                  No navigation menu items found. Click "Add Main Menu" to get started.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- =========================================================================
     MODAL: ADD MAIN MENU ITEM
     ========================================================================= -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMenuModalLabel">
          <i class="fa-solid fa-plus text-primary me-2"></i>Add Main Menu Item
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.navigation.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <!-- Custom Source Selector -->
          <div class="adm-source-select-group">
            <label for="add_source_picker">
              <i class="fa-solid fa-bolt"></i> Quick Source / কাস্টম সোর্স বেছে নিন (ঐচ্ছিক)
            </label>
            <select id="add_source_picker" class="adm-select nav-source-picker" data-target-prefix="add_">
              <option value="" data-title-en="" data-title-bn="" data-url="">-- Custom Link / Manual Input (কাস্টম লিংক) --</option>
              @include('admin.navigation._source_options')
            </select>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="add_title_en">Menu Label (English) <span class="adm-req">*</span></label>
            <input type="text" name="title_en" id="add_title_en" class="adm-input" placeholder="e.g. About Us" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="add_title_bn">Menu Label (Bangla)</label>
            <input type="text" name="title_bn" id="add_title_bn" class="adm-input" placeholder="e.g. আমাদের সম্পর্কে">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="add_url">Target URL / Route <span class="adm-req">*</span></label>
            <input type="text" name="url" id="add_url" class="adm-input" placeholder="e.g. /about-us or /activities" required>
          </div>

          <div class="adm-form-group mb-1">
            <label class="adm-label">Visibility</label>
            <div class="pt-1">
              <label class="adm-switch mb-0">
                <input type="checkbox" name="is_active" value="1" checked>
                <span class="adm-switch-slider"></span>
                <span>Visible in Navbar</span>
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="adm-btn adm-btn-outline" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-check me-1"></i> Add Main Menu
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
    // Quick Source Picker Handler
    const sourcePickers = document.querySelectorAll('.nav-source-picker');
    sourcePickers.forEach(picker => {
      picker.addEventListener('change', function() {
        const prefix = this.getAttribute('data-target-prefix');
        const selectedOption = this.options[this.selectedIndex];
        
        const titleEn = selectedOption.getAttribute('data-title-en') || '';
        const titleBn = selectedOption.getAttribute('data-title-bn') || '';
        const url = selectedOption.getAttribute('data-url') || '';

        if (url) {
          const titleEnInput = document.getElementById(prefix + 'title_en');
          const titleBnInput = document.getElementById(prefix + 'title_bn');
          const urlInput = document.getElementById(prefix + 'url');

          if (titleEnInput) titleEnInput.value = titleEn;
          if (titleBnInput) titleBnInput.value = titleBn;
          if (urlInput) urlInput.value = url;
        }
      });
    });

    // Native HTML5 Drag and Drop for quick row reordering
    const sortableBody = document.getElementById('navSortableBody');
    let draggedRow = null;

    if (sortableBody) {
      const rows = sortableBody.querySelectorAll('tr.nav-sortable-row');
      rows.forEach(row => {
        row.setAttribute('draggable', 'true');

        row.addEventListener('dragstart', function(e) {
          draggedRow = this;
          e.dataTransfer.effectAllowed = 'move';
          this.style.opacity = '0.5';
        });

        row.addEventListener('dragend', function() {
          this.style.opacity = '1';
          rows.forEach(r => r.classList.remove('adm-drag-over'));
        });

        row.addEventListener('dragover', function(e) {
          e.preventDefault();
          e.dataTransfer.dropEffect = 'move';
          if (draggedRow && draggedRow !== this) {
            this.classList.add('adm-drag-over');
          }
        });

        row.addEventListener('dragleave', function() {
          this.classList.remove('adm-drag-over');
        });

        row.addEventListener('drop', function(e) {
          e.preventDefault();
          this.classList.remove('adm-drag-over');
          if (draggedRow && draggedRow !== this) {
            sortableBody.insertBefore(draggedRow, this);

            const orderedIds = [];
            sortableBody.querySelectorAll('tr.nav-sortable-row').forEach(r => {
              const id = r.getAttribute('data-id');
              if (id) orderedIds.push(id);
            });

            fetch('{{ route("admin.navigation.reorder") }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({ order: orderedIds })
            }).then(res => res.json()).then(data => {
              if (data.status === 'success') {
                window.location.reload();
              }
            }).catch(err => console.error(err));
          }
        });
      });
    }
  });
</script>
@endpush
