@extends('admin.layouts.app')

@section('title', 'Admin Profile')
@section('page_title', 'My Profile & Security')

@section('content')
<div class="row g-4 justify-content-center">
  <div class="col-lg-8 col-12">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2 class="adm-card-title">
          <i class="fa-solid fa-user-gear"></i>
          <span>Account Information & Password</span>
        </h2>
      </div>
      <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="adm-card-body">
          <div class="row g-3">
            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="name">Full Name <span class="adm-req">*</span></label>
                <input type="text" name="name" id="name" class="adm-input" value="{{ old('name', $user->name) }}" required>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="email">Email Address <span class="adm-req">*</span></label>
                <input type="email" name="email" id="email" class="adm-input" value="{{ old('email', $user->email) }}" required>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" class="adm-input" value="{{ old('phone', $user->phone) }}">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="avatar">Profile Avatar</label>
                <input type="file" name="avatar" id="avatar" class="adm-input" accept="image/*" data-preview="userAvatarPreview">
                @if($user->avatar)
                  <img src="{{ asset($user->avatar) }}" alt="Avatar" class="adm-thumb-preview mt-2" id="userAvatarPreview">
                @else
                  <img src="#" alt="Avatar" class="adm-thumb-preview adm-preview-hidden mt-2" id="userAvatarPreview">
                @endif
              </div>
            </div>
          </div>

          <hr class="my-4">

          <h3 class="fs-6 fw-bold mb-3 text-muted text-uppercase adm-profile-subhead">Change Password (Leave blank to keep current)</h3>

          <div class="row g-3">
            <div class="col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="current_password">Current Password (Required if changing password)</label>
                <input type="password" name="current_password" id="current_password" class="adm-input" placeholder="••••••••">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="password">New Password</label>
                <input type="password" name="password" id="password" class="adm-input" placeholder="••••••••">
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="adm-form-group">
                <label class="adm-label" for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="adm-input" placeholder="••••••••">
              </div>
            </div>
          </div>
        </div>
        <div class="adm-card-footer text-end">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Update Profile
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
