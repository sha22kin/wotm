@extends('admin.layouts.app')

@section('title', 'Add New Activity')
@section('page_title', 'Create Activity / Service')

@section('content')
<form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" id="serviceForm">
  @csrf

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
              <input type="text" name="title_en" id="title_en" class="adm-input" value="{{ old('title_en') }}" placeholder="e.g. Regular Educational Scholarships">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="short_description_en">Short Description (English)</label>
              <textarea name="short_description_en" id="short_description_en" class="adm-textarea adm-textarea-sm" placeholder="Summary for listing cards...">{{ old('short_description_en') }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label">Detailed Description (English)</label>
              <div id="serviceQuillEn" class="adm-quill-editor">{!! old('description_en') !!}</div>
              <input type="hidden" name="description_en" id="description_en" value="{{ old('description_en') }}">
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="title_bn">Activity Title (Bangla) <span class="adm-req">*</span></label>
              <input type="text" name="title_bn" id="title_bn" class="adm-input" value="{{ old('title_bn') }}" placeholder="e.g. নিয়মিত শিক্ষাবৃত্তি ও মেধা বিকাশ">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="short_description_bn">Short Description (Bangla)</label>
              <textarea name="short_description_bn" id="short_description_bn" class="adm-textarea adm-textarea-sm" placeholder="তালিকা কার্ডের জন্য সংক্ষিপ্ত সারসংক্ষেপ...">{{ old('short_description_bn') }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label">Detailed Description (Bangla)</label>
              <div id="serviceQuillBn" class="adm-quill-editor">{!! old('description_bn') !!}</div>
              <input type="hidden" name="description_bn" id="description_bn" value="{{ old('description_bn') }}">
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
              <option value="education" {{ old('category') === 'education' ? 'selected' : '' }}>শিক্ষা ও দাওয়াহ (Education & Dawah)</option>
              <option value="welfare" {{ old('category') === 'welfare' ? 'selected' : '' }}>সেবা ও পুনর্বাসন (Welfare & Rehabilitation)</option>
              <option value="relief" {{ old('category') === 'relief' ? 'selected' : '' }}>জরুরি ত্রাণ কার্যক্রম (Emergency Relief)</option>
              <option value="livelihood" {{ old('category') === 'livelihood' ? 'selected' : '' }}>স্বাবলম্বীকরণ (Livelihood Support)</option>
            </select>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="icon">FontAwesome Icon Class</label>
            <input type="text" name="icon" id="icon" class="adm-input" value="{{ old('icon', 'fa-seedling') }}" placeholder="fa-seedling, fa-graduation-cap">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="beneficiaries_count">Beneficiaries Impact Count</label>
            <input type="text" name="beneficiaries_count" id="beneficiaries_count" class="adm-input" value="{{ old('beneficiaries_count') }}" placeholder="e.g. ২,৫০০+">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="districts_count">Coverage Districts</label>
            <input type="text" name="districts_count" id="districts_count" class="adm-input" value="{{ old('districts_count') }}" placeholder="e.g. ২৫+ টি জেলা">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="order">Display Order</label>
            <input type="number" name="order" id="order" class="adm-input" value="{{ old('order', 0) }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="slug">Custom Slug (Optional)</label>
            <input type="text" name="slug" id="slug" class="adm-input" value="{{ old('slug') }}">
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-switch">
              <input type="checkbox" name="is_active" value="1" checked>
              <span class="adm-switch-slider"></span>
              <span>Active on Website</span>
            </label>
          </div>
        </div>
        <div class="adm-card-footer d-flex justify-content-between">
          <a href="{{ route('admin.services.index') }}" class="adm-btn adm-btn-outline">Cancel</a>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save Activity
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
            <img src="#" alt="Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="serviceImgPreview">
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

  document.getElementById('serviceForm').addEventListener('submit', function(e) {
    const tEn = document.getElementById('title_en').value.trim();
    const tBn = document.getElementById('title_bn').value.trim();
    if (!tEn && !tBn) {
      e.preventDefault();
      alert('অনুগ্রহ করে কার্যক্রমের অন্তত একটি শিরোনাম (বাংলা বা ইংরেজি) লিখুন।');
      return false;
    }
    if (!tEn && tBn) document.getElementById('title_en').value = tBn;
    else if (tEn && !tBn) document.getElementById('title_bn').value = tEn;

    document.getElementById('description_en').value = qEn.root.innerHTML === '<p><br></p>' ? '' : qEn.root.innerHTML;
    document.getElementById('description_bn').value = qBn.root.innerHTML === '<p><br></p>' ? '' : qBn.root.innerHTML;
  });
</script>
@endpush
