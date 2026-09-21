@extends('admin.layouts.app')

@section('title', 'Footer Settings')
@section('page_title', 'Footer Content & Copyright')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-shoe-prints"></i>
          <span>Footer Content Management</span>
        </h2>
      </div>
      <form action="{{ route('admin.footer.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="adm-card-body">
          <!-- Footer Dedicated Logo -->
          <div class="adm-form-group mb-4">
            <label class="adm-label" for="footer_logo">Footer Logo (Dedicated for Dark Background)</label>
            <div class="adm-input-hint mb-2">Upload a dedicated logo for the dark footer background (Default: logo4.webp). Supported formats: PNG, WEBP, SVG, JPG.</div>
            <input type="file" name="footer_logo" id="footer_logo" class="adm-input" accept="image/*" data-preview="footerLogoPreview">
            
            <div class="adm-dark-preview-box">
              <span class="adm-preview-caption">Preview on dark green footer background:</span>
              <img src="{{ App\Models\Setting::getImageUrl('footer_logo', 'images/logos/logo4.webp') }}" alt="Footer Logo Preview" class="adm-footer-logo-preview" id="footerLogoPreview" onerror="this.onerror=null;this.src='{{ asset('images/logos/logo4.webp') }}';">
            </div>
          </div>

          <div class="adm-lang-nav">
            <button type="button" class="adm-lang-tab is-active" data-tab="en">English Content</button>
            <button type="button" class="adm-lang-tab" data-tab="bn">বাংলা কনটেন্ট</button>
          </div>

          <!-- English Pane -->
          <div class="adm-lang-pane is-active" data-lang="en">
            <div class="adm-form-group">
              <label class="adm-label" for="footer_about_en">Footer About Organization Text (English)</label>
              <textarea name="footer_about_en" id="footer_about_en" class="adm-textarea" placeholder="Brief summary under the logo in footer...">{{ old('footer_about_en', $settings['footer_about_en'] ?? '') }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="footer_copyright_en">Footer Copyright Line (English)</label>
              <input type="text" name="footer_copyright_en" id="footer_copyright_en" class="adm-input" value="{{ old('footer_copyright_en', $settings['footer_copyright_en'] ?? '') }}" placeholder="Copyright © 2026 WOTM - All Rights Reserved.">
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="footer_about_bn">Footer About Organization Text (Bangla)</label>
              <textarea name="footer_about_bn" id="footer_about_bn" class="adm-textarea" placeholder="ফুটারের লোগোর নিচের পরিচিতি টেক্সট...">{{ old('footer_about_bn', $settings['footer_about_bn'] ?? '') }}</textarea>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="footer_copyright_bn">Footer Copyright Line (Bangla)</label>
              <input type="text" name="footer_copyright_bn" id="footer_copyright_bn" class="adm-input" value="{{ old('footer_copyright_bn', $settings['footer_copyright_bn'] ?? '') }}" placeholder="স্বত্ব © ২০২৬ WOTM - সর্ব স্বত্ব সংরক্ষিত।">
            </div>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save Footer Settings
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
