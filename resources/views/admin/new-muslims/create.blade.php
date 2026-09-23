@extends('admin.layouts.app')

@section('title', 'Add New Muslim')
@section('page_title', 'Add New Muslim')

@section('content')
<div class="adm-card" style="max-width: 800px; margin: 0 auto;">
  <div class="adm-card-header">
    <h2 class="adm-card-title"><i class="fa-solid fa-plus"></i> Enter Details</h2>
  </div>

  <form action="{{ route('admin.new-muslims.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="adm-card-body">
      
      <div class="adm-form-group">
        <label for="name" class="adm-label">Full Name <span class="adm-req">*</span></label>
        <input type="text" name="name" id="name" class="adm-input" value="{{ old('name') }}" required>
      </div>

      <div class="row g-3">
        <div class="col-md-6">
          <div class="adm-form-group mb-0">
            <label for="mobile" class="adm-label">Mobile Number (Optional)</label>
            <input type="text" name="mobile" id="mobile" class="adm-input" value="{{ old('mobile') }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="adm-form-group mb-0">
            <label for="email" class="adm-label">Email (Optional)</label>
            <input type="email" name="email" id="email" class="adm-input" value="{{ old('email') }}">
          </div>
        </div>
      </div>

      <div class="adm-form-group mt-3">
        <label for="facebook_link" class="adm-label">Facebook Profile Link (Optional)</label>
        <input type="url" name="facebook_link" id="facebook_link" class="adm-input" value="{{ old('facebook_link') }}" placeholder="https://facebook.com/username">
      </div>

      <div class="adm-form-group">
        <label for="photo" class="adm-label">Photo (Optional)</label>
        <input type="file" name="photo" id="photo" class="adm-input" accept="image/jpeg,image/png,image/jpg">
        <div class="form-text text-muted">Recommended aspect ratio 1:1 (Square).</div>
      </div>

    </div>
    
    <div class="adm-card-footer d-flex justify-content-between align-items-center">
      <a href="{{ route('admin.new-muslims.index') }}" class="adm-btn adm-btn-outline">Cancel</a>
      <button type="submit" class="adm-btn adm-btn-primary">
        <i class="fa-solid fa-floppy-disk"></i> Save New Muslim
      </button>
    </div>
  </form>
</div>
@endsection
