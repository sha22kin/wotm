@extends('admin.layouts.app')

@section('title', 'Global SEO Settings')
@section('page_title', 'Global SEO & Metadata')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-magnifying-glass-chart"></i>
          <span>Global Search Engine Optimization</span>
        </h2>
      </div>
      <form action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="seo_meta_title">Default Meta Title <span class="adm-req">*</span></label>
            <input type="text" name="seo_meta_title" id="seo_meta_title" class="adm-input" value="{{ old('seo_meta_title', $settings['seo_meta_title'] ?? '') }}" required>
            <div class="adm-input-hint">Displayed in Google search results and browser title tab.</div>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="seo_meta_description">Default Meta Description <span class="adm-req">*</span></label>
            <textarea name="seo_meta_description" id="seo_meta_description" class="adm-textarea" required>{{ old('seo_meta_description', $settings['seo_meta_description'] ?? '') }}</textarea>
            <div class="adm-input-hint">Displayed as search snippet summary under the title link.</div>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="seo_meta_keywords">Default Keywords</label>
            <input type="text" name="seo_meta_keywords" id="seo_meta_keywords" class="adm-input" value="{{ old('seo_meta_keywords', $settings['seo_meta_keywords'] ?? '') }}">
            <div class="adm-input-hint">Comma-separated keywords (e.g. WOTM, donation, relief, welfare).</div>
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="google_analytics_id">Google Analytics Tracking ID / G-Tag</label>
            <input type="text" name="google_analytics_id" id="google_analytics_id" class="adm-input" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXXXX">
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-label" for="seo_og_image">Default Social Share Image (Open Graph)</label>
            <input type="file" name="seo_og_image" id="seo_og_image" class="adm-input" accept="image/*" data-preview="seoOgPreview">
            @if(!empty($settings['seo_og_image']))
              <img src="{{ App\Models\Setting::getImageUrl('seo_og_image', 'images/hero.webp') }}" alt="OG Preview" class="adm-thumb-preview mt-2" id="seoOgPreview" onerror="this.onerror=null;this.src='{{ asset('images/hero.webp') }}';">
            @else
              <img src="#" alt="OG Preview" class="adm-thumb-preview adm-preview-hidden mt-2" id="seoOgPreview">
            @endif
            <div class="adm-input-hint">Standard social sharing preview banner (1200x630 px).</div>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save SEO Settings
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
