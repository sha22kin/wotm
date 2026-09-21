@extends('admin.layouts.app')

@section('title', 'Social Media Links')
@section('page_title', 'Social Media & WhatsApp Settings')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-share-nodes"></i>
          <span>Official Social Channels</span>
        </h2>
      </div>
      <form action="{{ route('admin.social.update') }}" method="POST">
        @csrf
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="social_facebook">
              <i class="fa-brands fa-facebook text-primary me-1"></i> Facebook Page URL
            </label>
            <input type="url" name="social_facebook" id="social_facebook" class="adm-input" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" placeholder="https://facebook.com/yourpage">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="social_twitter">
              <i class="fa-brands fa-x-twitter me-1"></i> X (Twitter) URL
            </label>
            <input type="url" name="social_twitter" id="social_twitter" class="adm-input" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" placeholder="https://x.com/yourhandle">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="social_youtube">
              <i class="fa-brands fa-youtube text-danger me-1"></i> YouTube Channel URL
            </label>
            <input type="url" name="social_youtube" id="social_youtube" class="adm-input" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" placeholder="https://youtube.com/@channel">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="social_instagram">
              <i class="fa-brands fa-instagram text-danger me-1"></i> Instagram Profile URL
            </label>
            <input type="url" name="social_instagram" id="social_instagram" class="adm-input" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" placeholder="https://instagram.com/profile">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="social_linkedin">
              <i class="fa-brands fa-linkedin text-info me-1"></i> LinkedIn Company Page URL
            </label>
            <input type="url" name="social_linkedin" id="social_linkedin" class="adm-input" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" placeholder="https://linkedin.com/company/profile">
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-label" for="whatsapp_number">
              <i class="fa-brands fa-whatsapp text-success me-1"></i> WhatsApp Floating Button Number
            </label>
            <input type="text" name="whatsapp_number" id="whatsapp_number" class="adm-input" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" placeholder="e.g. 8801700000000">
            <div class="adm-input-hint">Include country code without '+' sign (e.g. 88017XXXXXXXX). Controls floating chat on frontend.</div>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Save Social Links
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
