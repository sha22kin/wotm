@extends('admin.layouts.app')

@section('title', 'Edit Notice: ' . $notice->title_en)
@section('page_title', 'Edit Notice / Circular')

@section('content')
<form action="{{ route('admin.notices.update', $notice->id) }}" method="POST" enctype="multipart/form-data" novalidate>
  @csrf
  @method('PUT')

  <div class="row g-4">
    <div class="col-lg-8 col-12">
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-bullhorn"></i>
            <span>Notice Information</span>
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
              <label class="adm-label" for="title_en">Notice Title (English) <span class="adm-req">*</span></label>
              <input type="text" name="title_en" id="title_en" class="adm-input @error('title_en') is-invalid @enderror" value="{{ old('title_en', $notice->title_en) }}">
              @error('title_en')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
              <div class="form-text small text-muted">এক ভাষায় শিরোনাম দিলে অন্য ভাষা স্বয়ংক্রিয়ভাবে পূর্ণ হবে।</div>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="description_en">Brief Description (English)</label>
              <textarea name="description_en" id="description_en" rows="5" class="adm-textarea">{{ old('description_en', $notice->description_en) }}</textarea>
            </div>
          </div>

          <!-- Bangla Pane -->
          <div class="adm-lang-pane" data-lang="bn">
            <div class="adm-form-group">
              <label class="adm-label" for="title_bn">Notice Title (Bangla) <span class="adm-req">*</span></label>
              <input type="text" name="title_bn" id="title_bn" class="adm-input @error('title_bn') is-invalid @enderror" value="{{ old('title_bn', $notice->title_bn) }}">
              @error('title_bn')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
              <div class="form-text small text-muted">এক ভাষায় শিরোনাম দিলে অন্য ভাষা স্বয়ংক্রিয়ভাবে পূর্ণ হবে।</div>
            </div>

            <div class="adm-form-group">
              <label class="adm-label" for="description_bn">Brief Description (Bangla)</label>
              <textarea name="description_bn" id="description_bn" rows="5" class="adm-textarea">{{ old('description_bn', $notice->description_bn) }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Attachment & Settings -->
    <div class="col-lg-4 col-12">
      <!-- File Attachment -->
      <div class="adm-card mb-4">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-paperclip"></i>
            <span>Document Attachment (PDF)</span>
          </h2>
        </div>
        <div class="adm-card-body">
          @if($notice->file_path)
            <div class="mb-3 p-2 bg-light border rounded small">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                  <i class="fa-solid fa-file-pdf text-danger me-1"></i>
                  <a href="{{ $notice->file_url }}" target="_blank" class="fw-semibold text-break">{{ basename($notice->file_path) }}</a>
                  @if($notice->file_size)
                    <span class="text-muted">({{ $notice->file_size }})</span>
                  @endif
                </div>
              </div>
              <label class="adm-switch mb-0">
                <input type="checkbox" name="remove_file" value="1">
                <span class="adm-switch-slider"></span>
                <span class="text-danger small fw-semibold">Remove current attachment</span>
              </label>
            </div>
          @endif
          <div class="adm-form-group mb-0">
            <label class="adm-label" for="file">{{ $notice->file_path ? 'Replace Attachment' : 'Upload Document' }}</label>
            <input type="file" name="file" id="file" class="adm-input @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx,.png,.jpg">
            @error('file')
              <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
            @enderror
            <div class="adm-input-hint mt-2">
              <i class="fa-solid fa-circle-info me-1"></i>Accepted: PDF, DOC, DOCX, PNG, JPG (Max 20MB).
            </div>
          </div>
        </div>
      </div>

      <!-- Settings & Publish -->
      <div class="adm-card">
        <div class="adm-card-header">
          <h2 class="adm-card-title">
            <i class="fa-solid fa-gear"></i>
            <span>Settings & Publish</span>
          </h2>
        </div>
        <div class="adm-card-body">
          <div class="adm-form-group">
            <label class="adm-label" for="notice_number">Reference / Memo Number</label>
            <input type="text" name="notice_number" id="notice_number" class="adm-input" value="{{ old('notice_number', $notice->notice_number) }}">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="notice_date">Notice Date <span class="adm-req">*</span></label>
            <input type="date" name="notice_date" id="notice_date" class="adm-input" value="{{ old('notice_date', $notice->notice_date ? $notice->notice_date->format('Y-m-d') : '') }}" required>
          </div>

          <div class="adm-form-group">
            <label class="adm-switch">
              <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $notice->is_pinned) ? 'checked' : '' }}>
              <span class="adm-switch-slider"></span>
              <span>Pin this notice to top</span>
            </label>
          </div>

          <div class="adm-form-group mb-0">
            <label class="adm-switch">
              <input type="checkbox" name="is_active" value="1" {{ old('is_active', $notice->is_active) ? 'checked' : '' }}>
              <span class="adm-switch-slider"></span>
              <span>Published & Visible</span>
            </label>
          </div>
        </div>
        <div class="adm-card-footer d-flex justify-content-between">
          <a href="{{ route('admin.notices.index') }}" class="adm-btn adm-btn-outline">Cancel</a>
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Update Notice
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
