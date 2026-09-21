@extends('admin.layouts.app')

@section('title', 'Edit Media')
@section('page_title', 'Edit Media Item')

@section('content')
<form action="{{ route('admin.gallery.update', $item->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="row g-4 justify-content-center">
    <div class="col-lg-8 col-12">
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-photo-film"></i>
            <span>Media Information</span>
          </h2>
          <a href="{{ route('admin.gallery.index') }}" class="adm-btn adm-btn-outline adm-btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back to Gallery
          </a>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label">Media Type <span class="adm-req">*</span></label>
            <div class="d-flex gap-4 mt-1">
              <label class="d-flex align-items-center gap-2 cursor-pointer">
                <input type="radio" name="type" value="image" {{ $item->type === 'image' ? 'checked' : '' }} onchange="toggleMediaType(this.value)">
                <span>Photo / Image</span>
              </label>
              <label class="d-flex align-items-center gap-2 cursor-pointer">
                <input type="radio" name="type" value="video" {{ $item->type === 'video' ? 'checked' : '' }} onchange="toggleMediaType(this.value)">
                <span>Video (YouTube / URL)</span>
              </label>
            </div>
          </div>

          <div class="adm-lang-nav">
            <button type="button" class="adm-lang-tab is-active" data-tab="en">English</button>
            <button type="button" class="adm-lang-tab" data-tab="bn">বাংলা (Bangla)</button>
          </div>

          <div class="adm-lang-pane is-active" data-lang="en">
            <div class="adm-form-group">
              <label class="adm-label" for="title_en">Media Title / Caption (English)</label>
              <input type="text" name="title_en" id="title_en" class="adm-input" value="{{ old('title_en', $item->title_en) }}">
            </div>
          </div>

          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="title_bn">Media Title / Caption (Bangla)</label>
              <input type="text" name="title_bn" id="title_bn" class="adm-input" value="{{ old('title_bn', $item->title_bn) }}">
            </div>
          </div>

          <div class="adm-form-group">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <label class="adm-label mb-0" for="gallery_category_id">Media Category</label>
              <a href="{{ route('admin.gallery-categories.index') }}" class="adm-text-sky fw-medium fs-sm text-decoration-none" target="_blank">
                <i class="fa-solid fa-plus-circle"></i> Manage Categories
              </a>
            </div>
            <select name="gallery_category_id" id="gallery_category_id" class="adm-select">
              <option value="">-- Select Category --</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ (old('gallery_category_id', $item->gallery_category_id) == $cat->id || old('category', $item->category) == $cat->slug) ? 'selected' : '' }}>
                  {{ $cat->name_en }} ({{ $cat->name_bn }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="adm-form-group {{ $item->type === 'video' ? '' : 'adm-preview-hidden' }}" id="videoUrlGroup">
            <label class="adm-label" for="video_url">Video Embed URL</label>
            <input type="url" name="video_url" id="video_url" class="adm-input" value="{{ old('video_url', $item->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="image">Replace Media Image / Thumbnail Poster</label>
            @if($item->image_path)
              <div class="mb-2 p-2 border rounded bg-light d-inline-block">
                <span class="fs-xs text-muted d-block mb-1"><i class="fa-solid fa-image me-1"></i> Current Image:</span>
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="adm-thumb-preview" id="currentImgPreview" style="max-height:140px;width:auto;border-radius:4px;" onerror="this.onerror=null;this.src='{{ asset('images/hero2.webp') }}';">
              </div>
            @endif
            <input type="file" name="image" id="image" class="adm-input @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml,image/avif" onchange="previewEditImage(this)">
            @error('image')
              <div class="text-danger fs-xs mt-1 fw-medium"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
            @enderror
            <div id="newImagePreviewWrap" class="adm-preview-hidden mt-2 p-2 border rounded bg-light d-inline-block">
              <span class="fs-xs text-success d-block mb-1 fw-medium"><i class="fa-solid fa-check-circle me-1"></i> New Selected Preview:</span>
              <img src="" alt="New Preview" class="adm-thumb-preview" id="galleryImgPreview" style="max-height:140px;width:auto;border-radius:4px;object-fit:cover;">
              <div class="text-muted fs-xs mt-1" id="newImageInfo"></div>
            </div>
            <div class="adm-input-hint">Leave blank to keep existing image. Supports PNG, JPG, WebP (max 10MB).</div>
          </div>

          <div class="row g-3">
            <div class="col-6">
              <div class="adm-form-group">
                <label class="adm-label" for="order">Display Order</label>
                <input type="number" name="order" id="order" class="adm-input" value="{{ old('order', $item->order) }}">
              </div>
            </div>
            <div class="col-6">
              <div class="adm-form-group pt-4">
                <label class="adm-switch">
                  <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                  <span class="adm-switch-slider"></span>
                  <span>Active & Visible</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="adm-card-footer d-flex justify-content-between">
          <a href="{{ route('admin.gallery.index') }}" class="adm-btn adm-btn-outline">Cancel</a>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Update Media Item
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
  function toggleMediaType(type) {
    const videoGroup = document.getElementById('videoUrlGroup');
    if (type === 'video') {
      videoGroup.classList.remove('adm-preview-hidden');
    } else {
      videoGroup.classList.add('adm-preview-hidden');
    }
  }

  function previewEditImage(input) {
    const preview = document.getElementById('galleryImgPreview');
    const wrap = document.getElementById('newImagePreviewWrap');
    const info = document.getElementById('newImageInfo');

    if (input.files && input.files[0]) {
      const file = input.files[0];
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        wrap.classList.remove('adm-preview-hidden');
        info.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
      };
      reader.readAsDataURL(file);
    }
  }
</script>
@endpush
