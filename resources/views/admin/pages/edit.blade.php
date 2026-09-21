@extends('admin.layouts.app')

@section('title', 'Edit Page: ' . $page->title_en)
@section('page_title', 'Edit Page & SEO Settings')

@section('content')
<form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="row g-4">
    <!-- Left Column: Content (English & Bangla) -->
    <div class="col-lg-8 col-12">
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-file-pen"></i>
            <span>Page Content & Details</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <!-- Language Tab Bar -->
          <div class="adm-lang-nav">
            <button type="button" class="adm-lang-tab is-active" data-tab="en">
              <i class="fa-solid fa-globe me-1"></i> English
            </button>
            <button type="button" class="adm-lang-tab" data-tab="bn">
              <i class="fa-solid fa-language me-1"></i> বাংলা (Bangla)
            </button>
          </div>

          <!-- English Pane -->
          <div class="adm-lang-pane is-active" data-lang="en">
            <div class="adm-form-group">
              <label class="adm-label" for="title_en">Page Title (English) <span class="adm-req">*</span></label>
              <input type="text" name="title_en" id="title_en" class="adm-input" value="{{ old('title_en', $page->title_en) }}" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="subtitle_en">Subtitle / Tagline (English)</label>
              <input type="text" name="subtitle_en" id="subtitle_en" class="adm-input" value="{{ old('subtitle_en', $page->subtitle_en) }}">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="content_en">Page Body Content (English)</label>
              <textarea name="content_en" id="content_en" class="adm-textarea">{{ old('content_en', $page->content_en) }}</textarea>
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="title_bn">Page Title (Bangla) <span class="adm-req">*</span></label>
              <input type="text" name="title_bn" id="title_bn" class="adm-input" value="{{ old('title_bn', $page->title_bn) }}" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="subtitle_bn">Subtitle / Tagline (Bangla)</label>
              <input type="text" name="subtitle_bn" id="subtitle_bn" class="adm-input" value="{{ old('subtitle_bn', $page->subtitle_bn) }}">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="content_bn">Page Body Content (Bangla)</label>
              <textarea name="content_bn" id="content_bn" class="adm-textarea">{{ old('content_bn', $page->content_bn) }}</textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- SEO Meta Information Box -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
            <span>Search Engine Optimization (SEO)</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="meta_title">SEO Meta Title</label>
            <input type="text" name="meta_title" id="meta_title" class="adm-input" value="{{ old('meta_title', $page->meta_title) }}" placeholder="Custom meta title for Google search">
            <div class="adm-input-hint">Recommended: 50-60 characters.</div>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="meta_description">Meta Description</label>
            <textarea name="meta_description" id="meta_description" class="adm-textarea adm-textarea-sm" placeholder="Brief summary of the page for search results">{{ old('meta_description', $page->meta_description) }}</textarea>
            <div class="adm-input-hint">Recommended: 150-160 characters.</div>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="meta_keywords">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="adm-input" value="{{ old('meta_keywords', $page->meta_keywords) }}" placeholder="e.g. donation, charity, welfare">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="canonical_url">Canonical URL</label>
            <input type="url" name="canonical_url" id="canonical_url" class="adm-input" value="{{ old('canonical_url', $page->canonical_url) }}" placeholder="https://wotm.org/about-us">
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Settings, Images & Actions -->
    <div class="col-lg-4 col-12">
      <!-- Publish Box -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-gear"></i>
            <span>Status & Settings</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label">Page Slug</label>
            <input type="text" class="adm-input" value="{{ $page->slug }}" disabled>
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-switch">
              <input type="checkbox" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }}>
              <span class="adm-switch-slider"></span>
              <span>Page Published & Active</span>
            </label>
          </div>
        </div>
        <div class="adm-card-footer d-flex justify-content-between">
          <a href="{{ route('admin.pages.index') }}" class="adm-btn adm-btn-outline">Cancel</a>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save Changes
          </button>
        </div>
      </div>

      <!-- Featured Image Box -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-image"></i>
            <span>Featured Banner Image</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <input type="file" name="featured_image" id="featured_image" class="adm-input" accept="image/*" data-preview="pageFeaturedPreview">
            @if($page->featured_image)
              <img src="{{ asset($page->featured_image) }}" alt="Preview" class="adm-thumb-preview mt-2" id="pageFeaturedPreview">
            @else
              <img src="#" alt="Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="pageFeaturedPreview">
            @endif
          </div>
        </div>
      </div>

      <!-- Open Graph (OG) Image -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-share-nodes"></i>
            <span>Social Share Image (OG Image)</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <input type="file" name="og_image" id="og_image" class="adm-input" accept="image/*" data-preview="pageOgPreview">
            @if($page->og_image)
              <img src="{{ asset($page->og_image) }}" alt="OG Preview" class="adm-thumb-preview mt-2" id="pageOgPreview">
            @else
              <img src="#" alt="OG Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="pageOgPreview">
            @endif
            <div class="adm-input-hint">Used for Facebook, WhatsApp & Twitter previews (1200x630 recommended).</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
