@extends('admin.layouts.app')

@section('title', 'Edit Menu - ' . $navigation->title_en)
@section('page_title', 'Header & Navigation')

@section('content')
<div class="row">
  <div class="col-12">
    <!-- Top Action Bar -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.navigation.index') }}" class="adm-btn adm-btn-outline">
          <i class="fa-solid fa-arrow-left me-1"></i> Back to Navigation
        </a>
        <h2 class="adm-card-title mb-0">
          <i class="fa-solid fa-pen-to-square text-primary me-1"></i> Edit Menu: {{ $navigation->title_en }}
        </h2>
      </div>
      <span class="adm-badge adm-badge-primary fs-6">{{ $navigation->children->count() }} Sub-Items</span>
    </div>

    <!-- 1. COMPACT MAIN MENU EDIT OPTION (মেইন মেনু এডিট অপশন) -->
    <div class="adm-nav-edit-compact">
      <div class="adm-nav-edit-compact-title">
        <i class="fa-solid fa-sliders text-primary"></i> Main Menu Settings
      </div>
      <form action="{{ route('admin.navigation.update', $navigation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3 align-items-end">
          <div class="col-md-4 col-12">
            <div class="adm-form-group mb-0">
              <label class="adm-label" for="edit_main_title_en">Menu Label (English) <span class="adm-req">*</span></label>
              <input type="text" name="title_en" id="edit_main_title_en" class="adm-input" value="{{ $navigation->title_en }}" required>
            </div>
          </div>
          <div class="col-md-3 col-12">
            <div class="adm-form-group mb-0">
              <label class="adm-label" for="edit_main_title_bn">Menu Label (Bangla)</label>
              <input type="text" name="title_bn" id="edit_main_title_bn" class="adm-input" value="{{ $navigation->title_bn }}">
            </div>
          </div>
          <div class="col-md-3 col-12">
            <div class="adm-form-group mb-0">
              <label class="adm-label" for="edit_main_url">Target URL <span class="adm-req">*</span></label>
              <input type="text" name="url" id="edit_main_url" class="adm-input" value="{{ $navigation->url }}" required>
            </div>
          </div>
          <div class="col-md-2 col-12">
            <div class="d-flex align-items-center justify-content-between gap-2">
              <label class="adm-switch mb-0">
                <input type="checkbox" name="is_active" value="1" {{ $navigation->is_active ? 'checked' : '' }}>
                <span class="adm-switch-slider"></span>
                <span>Active</span>
              </label>
              <button type="submit" class="adm-btn adm-btn-primary">
                <i class="fa-solid fa-floppy-disk me-1"></i> Update
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- 2. SUB-MENUS OF THIS MAIN MENU (মেইন মেনুর ভেতরের সাব-মেনু অ্যাড ও তালিকা) -->
    <div class="adm-sub-card">
      <div class="adm-sub-card-header">
        <div class="d-flex align-items-center gap-2">
          <i class="fa-solid fa-layer-group text-primary fs-5"></i>
          <div>
            <h3 class="adm-card-title mb-0">Sub-Menus under "{{ $navigation->title_en }}"</h3>
            <p class="adm-card-desc mb-0">Drag or use arrows to adjust order. Website updates automatically.</p>
          </div>
        </div>
        <span class="adm-badge adm-badge-info">{{ $navigation->children->count() }} Sub-Menus</span>
      </div>

      <div class="adm-sub-card-body">
        <div class="row g-4">
          <!-- Left Column: Add Sub-Menu Form -->
          <div class="col-lg-5 col-12">
            <div class="adm-add-sub-box-page">
              <div class="adm-add-sub-box-page-title">
                <i class="fa-solid fa-circle-plus"></i> Add Sub-Menu
              </div>
              <form action="{{ route('admin.navigation.store') }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $navigation->id }}">

                <!-- Custom Source Selector -->
                <div class="adm-source-select-group">
                  <label for="sub_page_source_picker">
                    <i class="fa-solid fa-bolt"></i> Quick Source / কাস্টম সোর্স বেছে নিন (ঐচ্ছিক)
                  </label>
                  <select id="sub_page_source_picker" class="adm-select nav-source-picker" data-target-prefix="sub_page_">
                    <option value="" data-title-en="" data-url="">-- Custom Link / Manual Input (কাস্টম লিংক) --</option>
                    @include('admin.navigation._source_options')
                  </select>
                </div>

                <div class="adm-form-group">
                  <label class="adm-label" for="sub_page_title_en">Sub-Menu Title <span class="adm-req">*</span></label>
                  <input type="text" name="title_en" id="sub_page_title_en" class="adm-input" placeholder="e.g. Education & Dawah" required>
                </div>

                <div class="adm-form-group">
                  <label class="adm-label" for="sub_page_url">Sub-Menu URL <span class="adm-req">*</span></label>
                  <input type="text" name="url" id="sub_page_url" class="adm-input" placeholder="e.g. /activities?cat=education" required>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-2">
                  <label class="adm-switch mb-0">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span class="adm-switch-slider"></span>
                    <span>Active</span>
                  </label>
                  <button type="submit" class="adm-btn adm-btn-primary">
                    <i class="fa-solid fa-plus me-1"></i> Add Sub-Menu
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Right Column: Sub-Menus List Table -->
          <div class="col-lg-7 col-12">
            <div class="table-responsive">
              <table class="adm-table border" id="subNavSortableTable">
                <thead>
                  <tr>
                    <th class="ps-3">Sub-Menu Title</th>
                    <th>Target URL</th>
                    <th>Order / Move</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Action</th>
                  </tr>
                </thead>
                <tbody id="subNavSortableBody">
                  @forelse($navigation->children as $child)
                    <tr class="sub-sortable-row" data-id="{{ $child->id }}">
                      <td class="ps-3">
                        <div class="d-flex align-items-center">
                          <i class="fa-solid fa-grip-vertical adm-drag-handle me-2" title="Drag to reorder"></i>
                          <div>
                            <span class="fw-semibold text-dark">{{ $child->title_en }}</span>
                            @if($child->title_bn && $child->title_bn !== $child->title_en)
                              <span class="text-muted small ms-1">({{ $child->title_bn }})</span>
                            @endif
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="nav-url-pill">{{ $child->url }}</span>
                      </td>
                      <td>
                        <div class="adm-order-cell">
                          <span class="adm-badge adm-badge-secondary me-1">{{ $child->order }}</span>
                          <!-- Move Up Sub-item -->
                          <form action="{{ route('admin.navigation.move', [$child->id, 'up']) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="adm-btn adm-btn-outline adm-btn-icon" title="Move Up (উপরে নিন)" {{ $loop->first ? 'disabled' : '' }}>
                              <i class="fa-solid fa-arrow-up"></i>
                            </button>
                          </form>
                          <!-- Move Down Sub-item -->
                          <form action="{{ route('admin.navigation.move', [$child->id, 'down']) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="adm-btn adm-btn-outline adm-btn-icon" title="Move Down (নিচে নিন)" {{ $loop->last ? 'disabled' : '' }}>
                              <i class="fa-solid fa-arrow-down"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                      <td>
                        @if($child->is_active)
                          <span class="adm-badge adm-badge-success">Active</span>
                        @else
                          <span class="adm-badge adm-badge-muted">Hidden</span>
                        @endif
                      </td>
                      <td class="text-end pe-3">
                        <div class="d-inline-flex align-items-center gap-1">
                          <!-- Edit Sub-Menu Button -->
                          <button type="button" 
                                  class="adm-btn adm-btn-outline adm-btn-icon btn-edit-sub" 
                                  title="Edit Sub-Menu"
                                  data-id="{{ $child->id }}"
                                  data-title-en="{{ $child->title_en }}"
                                  data-url="{{ $child->url }}"
                                  data-active="{{ $child->is_active ? '1' : '0' }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </button>

                          <!-- Delete Sub-Menu Button -->
                          <form action="{{ route('admin.navigation.destroy', $child->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this sub-menu?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="adm-btn adm-btn-danger adm-btn-icon" title="Delete Sub-Menu">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fa-solid fa-circle-info fs-3 mb-2 d-block"></i>
                        No sub-menus added under "{{ $navigation->title_en }}" yet. Use the form on the left to add your first sub-menu.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- =========================================================================
     MODAL: EDIT SUB-MENU ITEM
     ========================================================================= -->
<div class="modal fade" id="editSubMenuModal" tabindex="-1" aria-labelledby="editSubMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSubMenuModalLabel">
          <i class="fa-solid fa-pen-to-square text-primary me-2"></i>Edit Sub-Menu
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editSubMenuForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <!-- Quick Source Picker -->
          <div class="adm-source-select-group">
            <label for="edit_sub_picker">
              <i class="fa-solid fa-bolt"></i> Quick Source / কাস্টম সোর্স বেছে নিন (ঐচ্ছিক)
            </label>
            <select id="edit_sub_picker" class="adm-select nav-source-picker" data-target-prefix="edit_sub_modal_">
              <option value="" data-title-en="" data-url="">-- Custom Link / Keep Current (কাস্টম লিংক) --</option>
              @include('admin.navigation._source_options')
            </select>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="edit_sub_modal_title_en">Sub-Menu Title <span class="adm-req">*</span></label>
            <input type="text" name="title_en" id="edit_sub_modal_title_en" class="adm-input" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="edit_sub_modal_url">Sub-Menu URL <span class="adm-req">*</span></label>
            <input type="text" name="url" id="edit_sub_modal_url" class="adm-input" required>
          </div>

          <div class="adm-form-group mb-1">
            <label class="adm-label">Visibility</label>
            <div class="pt-1">
              <label class="adm-switch mb-0">
                <input type="checkbox" name="is_active" id="edit_sub_modal_is_active" value="1">
                <span class="adm-switch-slider"></span>
                <span>Active in Dropdown</span>
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="adm-btn adm-btn-outline" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
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
    const baseUrl = '{{ url("admin/navigation") }}';

    // 1. Quick Source Picker Handler
    const sourcePickers = document.querySelectorAll('.nav-source-picker');
    sourcePickers.forEach(picker => {
      picker.addEventListener('change', function() {
        const prefix = this.getAttribute('data-target-prefix');
        const selectedOption = this.options[this.selectedIndex];
        
        const titleEn = selectedOption.getAttribute('data-title-en') || '';
        const url = selectedOption.getAttribute('data-url') || '';

        if (url) {
          const titleEnInput = document.getElementById(prefix + 'title_en');
          const urlInput = document.getElementById(prefix + 'url');

          if (titleEnInput) titleEnInput.value = titleEn;
          if (urlInput) urlInput.value = url;
        }
      });
    });

    // 2. Edit Sub-Menu Modal Trigger
    const editSubButtons = document.querySelectorAll('.btn-edit-sub');
    const editSubModal = new bootstrap.Modal(document.getElementById('editSubMenuModal'));
    const editSubForm = document.getElementById('editSubMenuForm');

    editSubButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const titleEn = this.getAttribute('data-title-en');
        const url = this.getAttribute('data-url');
        const active = this.getAttribute('data-active') === '1';

        editSubForm.action = baseUrl + '/' + id;
        document.getElementById('edit_sub_modal_title_en').value = titleEn;
        document.getElementById('edit_sub_modal_url').value = url;
        document.getElementById('edit_sub_modal_is_active').checked = active;
        document.getElementById('edit_sub_picker').selectedIndex = 0;

        editSubModal.show();
      });
    });

    // 3. Drag and Drop Sub-Menu Reordering
    const sortableBody = document.getElementById('subNavSortableBody');
    let draggedRow = null;

    if (sortableBody) {
      const rows = sortableBody.querySelectorAll('tr.sub-sortable-row');
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
            sortableBody.querySelectorAll('tr.sub-sortable-row').forEach(r => {
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
