@extends('admin.layouts.app')

@section('title', 'Edit Post: ' . $post->title_en)
@section('page_title', 'Edit Blog Post')

@section('content')
<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="postEditForm">
  @csrf
  @method('PUT')

  <div class="row g-4">
    <!-- Left Column: Content & Translations -->
    <div class="col-lg-8 col-12">
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-pen-nib"></i>
            <span>Post Content & Details</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <!-- Language Tabs -->
          <div class="adm-lang-nav">
            <button type="button" class="adm-lang-tab is-active" data-tab="en">
              <i class="fa-solid fa-globe me-1"></i> English Version
            </button>
            <button type="button" class="adm-lang-tab" data-tab="bn">
              <i class="fa-solid fa-language me-1"></i> বাংলা সংস্করণ (Bangla)
            </button>
          </div>

          <!-- English Pane -->
          <div class="adm-lang-pane is-active" data-lang="en">
            <div class="adm-form-group">
              <label class="adm-label" for="title_en">Post Title (English) <span class="adm-req">*</span></label>
              <input type="text" name="title_en" id="title_en" class="adm-input" value="{{ old('title_en', $post->title_en) }}">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="excerpt_en">Short Summary / Excerpt (English)</label>
              <textarea name="excerpt_en" id="excerpt_en" class="adm-textarea adm-textarea-sm">{{ old('excerpt_en', $post->excerpt_en) }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label">Full Article Content (English)</label>
              <div id="quillEditorEn" class="adm-quill-editor">{!! old('content_en', $post->content_en) !!}</div>
              <input type="hidden" name="content_en" id="content_en" value="{{ old('content_en', $post->content_en) }}">
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="title_bn">Post Title (Bangla) <span class="adm-req">*</span></label>
              <input type="text" name="title_bn" id="title_bn" class="adm-input" value="{{ old('title_bn', $post->title_bn) }}">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="excerpt_bn">Short Summary / Excerpt (Bangla)</label>
              <textarea name="excerpt_bn" id="excerpt_bn" class="adm-textarea adm-textarea-sm">{{ old('excerpt_bn', $post->excerpt_bn) }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label">Full Article Content (Bangla)</label>
              <div id="quillEditorBn" class="adm-quill-editor">{!! old('content_bn', $post->content_bn) !!}</div>
              <input type="hidden" name="content_bn" id="content_bn" value="{{ old('content_bn', $post->content_bn) }}">
            </div>
          </div>
        </div>
      </div>

      <!-- SEO Meta Information Box -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
            <span>Post SEO Settings</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="meta_title">SEO Title (Overrides Title)</label>
            <input type="text" name="meta_title" id="meta_title" class="adm-input" value="{{ old('meta_title', $post->meta_title) }}" placeholder="Custom SEO Title">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="meta_description">Meta Description</label>
            <textarea name="meta_description" id="meta_description" class="adm-textarea adm-textarea-sm">{{ old('meta_description', $post->meta_description) }}</textarea>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="meta_keywords">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="adm-input" value="{{ old('meta_keywords', $post->meta_keywords) }}">
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Publishing, Meta & Media -->
    <div class="col-lg-4 col-12">
      <!-- Publish Action Box -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Publishing Options</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="status">Publication Status <span class="adm-req">*</span></label>
            <select name="status" id="status" class="adm-select" required>
              <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
              <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="category_id">Category</label>
            <select name="category_id" id="category_id" class="adm-select">
              <option value="">Select Category</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name_en }} ({{ $cat->name_bn }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="author_name">Author Name</label>
            <input type="text" name="author_name" id="author_name" class="adm-input" value="{{ old('author_name', $post->author_name) }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="published_at">Publish Date</label>
            <input type="datetime-local" name="published_at" id="published_at" class="adm-input" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="slug">URL Slug</label>
            <input type="text" name="slug" id="slug" class="adm-input" value="{{ old('slug', $post->slug) }}">
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-switch">
              <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
              <span class="adm-switch-slider"></span>
              <span>Mark as Featured Post</span>
            </label>
          </div>
        </div>
        <div class="adm-card-footer d-flex justify-content-between">
          <a href="{{ route('admin.posts.index') }}" class="adm-btn adm-btn-outline">Cancel</a>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Update Post
          </button>
        </div>
      </div>

      <!-- Featured Image Box -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-image"></i>
            <span>Featured Cover Image</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group mb-0">
            <input type="file" name="featured_image" id="featured_image" class="adm-input" accept="image/*" data-preview="postCoverPreview">
            @if($post->featured_image)
              <img src="{{ $post->featured_image_url }}" alt="Preview" class="adm-thumb-preview mt-2" id="postCoverPreview" onerror="this.onerror=null;this.src='{{ asset('images/projects/featured_imam.jpg') }}';">
            @else
              <img src="#" alt="Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="postCoverPreview">
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
  const toolbarOptions = [
    [{ 'header': [1, 2, 3, 4, false] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ 'color': [] }, { 'background': [] }],
    [{ 'align': [] }],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    ['blockquote', 'code-block'],
    ['link', 'image'],
    ['clean']
  ];

  const quillEn = new Quill('#quillEditorEn', {
    theme: 'snow',
    modules: { toolbar: toolbarOptions }
  });

  const quillBn = new Quill('#quillEditorBn', {
    theme: 'snow',
    modules: { toolbar: toolbarOptions }
  });

  // Sync Quill content and validate titles on form submit
  document.getElementById('postEditForm').addEventListener('submit', function(e) {
    const titleEn = document.getElementById('title_en').value.trim();
    const titleBn = document.getElementById('title_bn').value.trim();

    if (!titleEn && !titleBn) {
      e.preventDefault();
      alert('অনুগ্রহ করে অন্তত একটি শিরোনাম (বাংলা বা ইংরেজি) প্রদান করুন।');
      return false;
    }

    // Auto-fill opposite title if empty
    if (!titleEn && titleBn) {
      document.getElementById('title_en').value = titleBn;
    } else if (titleEn && !titleBn) {
      document.getElementById('title_bn').value = titleEn;
    }

    document.getElementById('content_en').value = quillEn.root.innerHTML === '<p><br></p>' ? '' : quillEn.root.innerHTML;
    document.getElementById('content_bn').value = quillBn.root.innerHTML === '<p><br></p>' ? '' : quillBn.root.innerHTML;
  });
</script>
@endpush
