@extends('admin.layouts.app')

@section('title', 'General Settings')
@section('page_title', 'General Site Settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="row g-4">
    <!-- Left Column: Branding & Multilingual Details -->
    <div class="col-lg-8 col-12">
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-sliders"></i>
            <span>Site Identity & Branding</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-lang-nav">
            <button type="button" class="adm-lang-tab is-active" data-tab="en">English Identity</button>
            <button type="button" class="adm-lang-tab" data-tab="bn">বাংলা পরিচিতি</button>
          </div>

          <!-- English Pane -->
          <div class="adm-lang-pane is-active" data-lang="en">
            <div class="adm-form-group">
              <label class="adm-label" for="site_title_en">Website Name / Brand Title (English) <span class="adm-req">*</span></label>
              <input type="text" name="site_title_en" id="site_title_en" class="adm-input" value="{{ old('site_title_en', $settings['site_title_en'] ?? '') }}" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="site_tagline_en">Motto / Tagline (English)</label>
              <input type="text" name="site_tagline_en" id="site_tagline_en" class="adm-input" value="{{ old('site_tagline_en', $settings['site_tagline_en'] ?? '') }}">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="site_description_en">Brief Description (English)</label>
              <textarea name="site_description_en" id="site_description_en" class="adm-textarea adm-textarea-sm">{{ old('site_description_en', $settings['site_description_en'] ?? '') }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="site_address_en">Physical Address (English)</label>
              <input type="text" name="site_address_en" id="site_address_en" class="adm-input" value="{{ old('site_address_en', $settings['site_address_en'] ?? '') }}">
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="site_title_bn">Website Name / Brand Title (Bangla) <span class="adm-req">*</span></label>
              <input type="text" name="site_title_bn" id="site_title_bn" class="adm-input" value="{{ old('site_title_bn', $settings['site_title_bn'] ?? '') }}" required>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="site_tagline_bn">Motto / Tagline (Bangla)</label>
              <input type="text" name="site_tagline_bn" id="site_tagline_bn" class="adm-input" value="{{ old('site_tagline_bn', $settings['site_tagline_bn'] ?? '') }}">
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="site_description_bn">Brief Description (Bangla)</label>
              <textarea name="site_description_bn" id="site_description_bn" class="adm-textarea adm-textarea-sm">{{ old('site_description_bn', $settings['site_description_bn'] ?? '') }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="site_address_bn">Physical Address (Bangla)</label>
              <input type="text" name="site_address_bn" id="site_address_bn" class="adm-input" value="{{ old('site_address_bn', $settings['site_address_bn'] ?? '') }}">
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Details -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-address-book"></i>
            <span>Official Contact Information</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="row g-3">
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="site_phone">Primary Phone / Hotline</label>
                <input type="text" name="site_phone" id="site_phone" class="adm-input" value="{{ old('site_phone', $settings['site_phone'] ?? '') }}" placeholder="+880 1700-000000">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="site_phone_secondary">Secondary Phone (Optional)</label>
                <input type="text" name="site_phone_secondary" id="site_phone_secondary" class="adm-input" value="{{ old('site_phone_secondary', $settings['site_phone_secondary'] ?? '') }}" placeholder="+880 1800-000000">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="site_email">Official Email Address</label>
                <input type="email" name="site_email" id="site_email" class="adm-input" value="{{ old('site_email', $settings['site_email'] ?? '') }}" placeholder="info@wotm.org">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="site_reg_no">Govt. Registration Number</label>
                <input type="text" name="site_reg_no" id="site_reg_no" class="adm-input" value="{{ old('site_reg_no', $settings['site_reg_no'] ?? '') }}" placeholder="এস-১৩১১১/২০১৯">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Logo & Favicon -->
    <div class="col-lg-4 col-12">
      <!-- Site Logo Card -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-image"></i>
            <span>Website Logo</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group mb-0">
            <input type="file" name="site_logo" id="site_logo" class="adm-input" accept="image/*" data-preview="siteLogoPreview">
            @if(!empty($settings['site_logo']))
              <img src="{{ App\Models\Setting::getImageUrl('site_logo', 'images/logos/logo.webp') }}" alt="Site Logo" class="adm-thumb-preview mt-2" id="siteLogoPreview" onerror="this.onerror=null;this.src='{{ asset('images/logos/logo.webp') }}';">
            @else
              <img src="#" alt="Site Logo" class="adm-thumb-preview adm-preview-hidden mt-2" id="siteLogoPreview">
            @endif
            <div class="adm-input-hint">Displayed on header and mobile drawer.</div>
          </div>
        </div>
      </div>

      <!-- Footer Logo Card -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-image"></i>
            <span>Footer Logo (Dark Background)</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group mb-0">
            <input type="file" name="footer_logo" id="footer_logo" class="adm-input" accept="image/*" data-preview="footerLogoPreview">
            <div class="adm-dark-preview-box">
              <span class="adm-preview-caption">Preview on dark background:</span>
              <img src="{{ App\Models\Setting::getImageUrl('footer_logo', 'images/logos/logo4.webp') }}" alt="Footer Logo" class="adm-footer-logo-preview" id="footerLogoPreview" onerror="this.onerror=null;this.src='{{ asset('images/logos/logo4.webp') }}';">
            </div>
            <div class="adm-input-hint mt-2">Dedicated horizontal logo for the dark footer (Default: logo4.webp).</div>
          </div>
        </div>
      </div>

      <!-- Favicon Card -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-circle-dot"></i>
            <span>Favicon Icon</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group mb-0">
            <input type="file" name="site_favicon" id="site_favicon" class="adm-input" accept="image/*" data-preview="siteFaviconPreview">
            @if(!empty($settings['site_favicon']))
              <img src="{{ App\Models\Setting::getImageUrl('site_favicon', 'images/logos/logo.webp') }}" alt="Favicon" class="adm-thumb-preview adm-fav-preview mt-2" id="siteFaviconPreview" onerror="this.onerror=null;this.src='{{ asset('images/logos/logo.webp') }}';">
            @else
              <img src="#" alt="Favicon" class="adm-thumb-preview adm-preview-hidden adm-fav-preview mt-2" id="siteFaviconPreview">
            @endif
            <div class="adm-input-hint">Small browser tab icon (PNG or ICO, 32x32 px).</div>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary w-100">
            <i class="fa-solid fa-floppy-disk"></i> Save All Settings
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
