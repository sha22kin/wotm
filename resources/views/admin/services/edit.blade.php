@extends('admin.layouts.app')

@section('title', 'Edit Activity: ' . $service->title_en)
@section('page_title', 'Edit Activity / Service')

@section('content')
<form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" id="serviceEditForm">
  @csrf
  @method('PUT')

  <div class="row g-4">
    <div class="col-lg-8 col-12">
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-hand-holding-heart"></i>
            <span>Activity Details</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-lang-nav">
            <button type="button" class="adm-lang-tab is-active" data-tab="en">English</button>
            <button type="button" class="adm-lang-tab" data-tab="bn">বাংলা (Bangla)</button>
          </div>

          <!-- English Pane -->
          <div class="adm-lang-pane is-active" data-lang="en">
            <div class="adm-form-group">
              <label class="adm-label" for="title_en">Activity Title (English) <span class="adm-req">*</span></label>
              <input type="text" name="title_en" id="title_en" class="adm-input" value="{{ old('title_en', $service->title_en) }}" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="short_description_en">Short Description (English)</label>
              <textarea name="short_description_en" id="short_description_en" class="adm-textarea adm-textarea-sm">{{ old('short_description_en', $service->short_description_en) }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label">Detailed Description (English)</label>
              <div id="serviceQuillEn" class="adm-quill-editor">{!! old('description_en', $service->description_en) !!}</div>
              <input type="hidden" name="description_en" id="description_en" value="{{ old('description_en', $service->description_en) }}">
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="title_bn">Activity Title (Bangla) <span class="adm-req">*</span></label>
              <input type="text" name="title_bn" id="title_bn" class="adm-input" value="{{ old('title_bn', $service->title_bn) }}" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="short_description_bn">Short Description (Bangla)</label>
              <textarea name="short_description_bn" id="short_description_bn" class="adm-textarea adm-textarea-sm">{{ old('short_description_bn', $service->short_description_bn) }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label">Detailed Description (Bangla)</label>
              <div id="serviceQuillBn" class="adm-quill-editor">{!! old('description_bn', $service->description_bn) !!}</div>
              <input type="hidden" name="description_bn" id="description_bn" value="{{ old('description_bn', $service->description_bn) }}">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Settings, Category & Image -->
    <div class="col-lg-4 col-12">
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-sliders"></i>
            <span>Attributes</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="category">Category <span class="adm-req">*</span></label>
            <select name="category" id="category" class="adm-select" required>
              <option value="education" {{ old('category', $service->category) === 'education' ? 'selected' : '' }}>শিক্ষা (Education)</option>
              <option value="dawah" {{ old('category', $service->category) === 'dawah' ? 'selected' : '' }}>দাওয়াহ (Dawah)</option>
              <option value="welfare" {{ old('category', $service->category) === 'welfare' ? 'selected' : '' }}>সেবা ও পুনর্বাসন (Welfare & Rehabilitation)</option>
              <option value="relief" {{ old('category', $service->category) === 'relief' ? 'selected' : '' }}>জরুরি ত্রাণ কার্যক্রম (Emergency Relief)</option>
              <option value="livelihood" {{ old('category', $service->category) === 'livelihood' ? 'selected' : '' }}>স্বাবলম্বীকরণ (Livelihood Support)</option>
              <option value="general" {{ old('category', $service->category) === 'general' ? 'selected' : '' }}>সাধারণ কার্যক্রম (General Activity)</option>
            </select>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="icon">FontAwesome Icon Class</label>
            <input type="text" name="icon" id="icon" class="adm-input" value="{{ old('icon', $service->icon) }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="beneficiaries_count">Beneficiaries Impact Count</label>
            <input type="text" name="beneficiaries_count" id="beneficiaries_count" class="adm-input" value="{{ old('beneficiaries_count', $service->beneficiaries_count) }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="districts_count">Coverage Districts</label>
            <input type="text" name="districts_count" id="districts_count" class="adm-input" value="{{ old('districts_count', $service->districts_count) }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="order">Display Order</label>
            <input type="number" name="order" id="order" class="adm-input" value="{{ old('order', $service->order) }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="slug">URL Slug</label>
            <input type="text" name="slug" id="slug" class="adm-input" value="{{ old('slug', $service->slug) }}">
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-switch">
              <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
              <span class="adm-switch-slider"></span>
              <span>Active on Website</span>
            </label>
          </div>
        </div>
        <div class="adm-card-footer d-flex justify-content-between">
          <a href="{{ route('admin.services.index') }}" class="adm-btn adm-btn-outline">Cancel</a>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Update Activity
          </button>
        </div>
      </div>

      <!-- Feature Image -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-image"></i>
            <span>Banner / Cover Image</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group mb-0">
            <input type="file" name="image" id="image" class="adm-input" accept="image/*" data-preview="serviceImgPreview">
            @if($service->image)
              <img src="{{ $service->image_url }}" alt="Preview" class="adm-thumb-preview mt-2" id="serviceImgPreview" onerror="this.onerror=null;this.src='{{ asset('2.jpeg') }}';">
            @else
              <img src="#" alt="Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="serviceImgPreview">
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
    [{ 'header': [1, 2, 3, false] }],
    ['bold', 'italic', 'underline'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    ['link'],
    ['clean']
  ];

  const qEn = new Quill('#serviceQuillEn', { theme: 'snow', modules: { toolbar: toolbarOptions } });
  const qBn = new Quill('#serviceQuillBn', { theme: 'snow', modules: { toolbar: toolbarOptions } });

  document.getElementById('serviceEditForm').addEventListener('submit', function() {
    document.getElementById('description_en').value = qEn.root.innerHTML === '<p><br></p>' ? '' : qEn.root.innerHTML;
    document.getElementById('description_bn').value = qBn.root.innerHTML === '<p><br></p>' ? '' : qBn.root.innerHTML;
  });
</script>
@endpush
