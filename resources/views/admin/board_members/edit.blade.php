@extends('admin.layouts.app')

@section('title', 'Edit Member: ' . $member->name_en)
@section('page_title', 'Edit Member Profile')

@section('content')
<form action="{{ route('admin.board-members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="row g-4">
    <!-- Left Column: Details -->
    <div class="col-lg-8 col-12">
      <div class="adm-card mb-4">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-user-tie text-primary"></i>
            <span>Edit Member Profile: {{ $member->name_en }}</span>
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
              <label class="adm-label" for="name_en">Full Name (English) <span class="adm-req">*</span></label>
              <input type="text" name="name_en" id="name_en" class="adm-input @error('name_en') is-invalid @enderror" 
                     value="{{ old('name_en', $member->name_en) }}" required>
              @error('name_en')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="designation_en">Designation / Role (English) <span class="adm-req">*</span></label>
              <input type="text" name="designation_en" id="designation_en" class="adm-input @error('designation_en') is-invalid @enderror" 
                     value="{{ old('designation_en', $member->designation_en) }}" required>
              @error('designation_en')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="bio_en">Brief Biography / Message (English)</label>
              <textarea name="bio_en" id="bio_en" rows="5" class="adm-textarea" 
                        placeholder="Short biography, professional achievements, or executive summary...">{{ old('bio_en', $member->bio_en) }}</textarea>
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="name_bn">Full Name (Bangla)</label>
              <input type="text" name="name_bn" id="name_bn" class="adm-input @error('name_bn') is-invalid @enderror" 
                     value="{{ old('name_bn', $member->name_bn) }}">
              @error('name_bn')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="designation_bn">Designation / Role (Bangla)</label>
              <input type="text" name="designation_bn" id="designation_bn" class="adm-input @error('designation_bn') is-invalid @enderror" 
                     value="{{ old('designation_bn', $member->designation_bn) }}">
              @error('designation_bn')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="bio_bn">Brief Biography / Message (Bangla)</label>
              <textarea name="bio_bn" id="bio_bn" rows="5" class="adm-textarea" 
                        placeholder="সংক্ষিপ্ত জীবনী, কর্মপরিচয় বা বার্তা...">{{ old('bio_bn', $member->bio_bn) }}</textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact & Social Media -->
      <div class="adm-card mb-4">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-address-book text-primary"></i>
            <span>Contact & Social Channels</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="row g-3">
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="phone">
                  <i class="fa-solid fa-phone text-muted me-1"></i> Mobile / Phone Number
                </label>
                <input type="text" name="phone" id="phone" class="adm-input" 
                       value="{{ old('phone', $member->phone) }}" placeholder="+880 1700-000000">
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="email">
                  <i class="fa-solid fa-envelope text-muted me-1"></i> Email Address
                </label>
                <input type="email" name="email" id="email" class="adm-input" 
                       value="{{ old('email', $member->email) }}" placeholder="member@wotm.org">
              </div>
            </div>

            <div class="col-12"><hr class="my-2 text-muted"></div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="social_facebook">
                  <i class="fa-brands fa-facebook text-primary me-1"></i> Facebook Profile / Page URL
                </label>
                <input type="url" name="social_links[facebook]" id="social_facebook" class="adm-input" 
                       value="{{ old('social_links.facebook', $member->social_facebook ?: ($member->social_links['facebook'] ?? '')) }}" placeholder="https://facebook.com/username">
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="social_linkedin">
                  <i class="fa-brands fa-linkedin text-info me-1"></i> LinkedIn Profile URL
                </label>
                <input type="url" name="social_links[linkedin]" id="social_linkedin" class="adm-input" 
                       value="{{ old('social_links.linkedin', $member->social_linkedin ?: ($member->social_links['linkedin'] ?? '')) }}" placeholder="https://linkedin.com/in/username">
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="social_twitter">
                  <i class="fa-brands fa-x-twitter text-dark me-1"></i> Twitter / X Profile URL
                </label>
                <input type="url" name="social_links[twitter]" id="social_twitter" class="adm-input" 
                       value="{{ old('social_links.twitter', $member->social_twitter ?: ($member->social_links['twitter'] ?? '')) }}" placeholder="https://x.com/username">
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="social_instagram">
                  <i class="fa-brands fa-instagram text-danger me-1"></i> Instagram Profile URL
                </label>
                <input type="url" name="social_links[instagram]" id="social_instagram" class="adm-input" 
                       value="{{ old('social_links.instagram', $member->social_instagram ?: ($member->social_links['instagram'] ?? '')) }}" placeholder="https://instagram.com/username">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Settings & Photo -->
    <div class="col-lg-4 col-12">
      <!-- Role and Placement Card -->
      <div class="adm-card mb-4">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-sliders text-primary"></i>
            <span>Classification & Order</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="type">Member Classification <span class="adm-req">*</span></label>
            <select name="type" id="type" class="adm-select @error('type') is-invalid @enderror" required>
              <option value="chairman" {{ old('type', $member->type) === 'chairman' ? 'selected' : '' }}>
                Chairman & Leadership
              </option>
              <option value="director" {{ old('type', $member->type) === 'director' ? 'selected' : '' }}>
                Board of Director
              </option>
              <option value="advisor" {{ old('type', $member->type) === 'advisor' ? 'selected' : '' }}>
                Advisory Council Member
              </option>
            </select>
            <div class="form-text small text-muted">
              Chairman will be displayed prominently at the top of the Board & Council page and on the Chairman's Message page.
            </div>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="order">Display Position / Order</label>
            <input type="number" name="order" id="order" class="adm-input" 
                   value="{{ old('order', $member->order) }}" min="0" step="1">
            <div class="form-text small text-muted">Lower numbers appear first (0, 1, 2...).</div>
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-label d-flex align-items-center gap-2 cursor-pointer">
              <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="form-check-input mt-0">
              <span class="fw-semibold">Active & Visible on Website</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Profile Image Card -->
      <div class="adm-card mb-4">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-image text-primary"></i>
            <span>Profile Photo</span>
          </h2>
        </div>
        <div class="adm-card-body text-center">
          <div class="mb-3">
            <img id="memberPhotoPreview" src="{{ $member->image_url }}" 
                 alt="{{ $member->name_en }}" class="rounded-circle shadow-sm border" 
                 style="width: 140px; height: 140px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('images/avatar-placeholder.png') }}';">
          </div>
          <div class="adm-form-group mb-2">
            <label for="image" class="adm-btn adm-btn-outline w-100 cursor-pointer">
              <i class="fa-solid fa-upload me-1"></i> Change Photo
            </label>
            <input type="file" name="image" id="image" class="d-none" accept="image/*" 
                   onchange="previewMemberImage(this)">
          </div>
          <p class="small text-muted mb-0">
            Upload new photo to replace current image. Leave blank to keep existing.
          </p>
        </div>
      </div>

      <!-- Submit Actions Card -->
      <div class="adm-card">
        <div class="adm-card-body d-flex flex-column gap-2">
          <button type="submit" class="adm-btn adm-btn-primary w-100 justify-content-center py-2">
            <i class="fa-solid fa-floppy-disk me-1"></i> Update Member Profile
          </button>
          <a href="{{ route('admin.board-members.index') }}" class="adm-btn adm-btn-outline w-100 justify-content-center">
            Cancel
          </a>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
function previewMemberImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('memberPhotoPreview').src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection
