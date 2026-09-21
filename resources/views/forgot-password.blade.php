@extends('layouts.frontend')

@section('meta_title', app()->getLocale() === 'en' ? 'Forgot Password - WOTM' : 'পাসওয়ার্ড ভুলে গেছেন - WOTM')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/login.css?v=2.1') }}">
@endpush

@section('content')

  <section class="auth-main-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 col-12">
          <div class="auth-form-card">

            <!-- Card Header with Brand Badge -->
            <div class="auth-card-header">
              <div class="auth-brand-badge">
                <img src="{{ asset(App\Models\Setting::get('site_logo', 'images/logos/logo.webp')) }}" alt="WOTM" class="auth-badge-logo">
              </div>
              <h2 class="auth-card-title">{{ app()->getLocale() === 'en' ? 'Reset Password' : 'পাসওয়ার্ড পুনরুদ্ধার' }}</h2>
              <p class="auth-card-subtitle">
                {{ app()->getLocale() === 'en' 
                  ? 'Enter your registered email address to receive a password reset link (valid for 5 minutes)' 
                  : 'আপনার অ্যাকাউন্টের নিবন্ধিত ইমেইল দিন, ৫ মিনিটের জন্য সক্রিয় একটি রিসেট লিংক পাঠানো হবে' }}
              </p>
            </div>

            <!-- Success Status Alert -->
            @if(session('status'))
              <div class="alert alert-success mx-4 mb-0 mt-3 p-3">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('status') }}
              </div>
            @endif

            <!-- Errors Alert -->
            @if(isset($errors) && $errors->any())
              <div class="alert alert-danger mx-4 mb-0 mt-3 p-3">
                <ul class="mb-0 ps-3">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- Form Pane -->
            <div class="auth-form-pane is-active">
              <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="auth-form-group">
                  <label for="forgotEmail" class="auth-label">
                    {{ app()->getLocale() === 'en' ? 'Email Address' : 'ইমেইল ঠিকানা' }} <span class="req">*</span>
                  </label>
                  <div class="auth-input-wrapper">
                    <input
                      type="email"
                      name="email"
                      value="{{ old('email') }}"
                      class="auth-input-field"
                      id="forgotEmail"
                      placeholder="example@mail.com"
                      required
                      autocomplete="email">
                    <i class="fa-solid fa-envelope auth-input-icon"></i>
                  </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="auth-submit-btn">
                  <i class="fa-solid fa-paper-plane"></i> {{ app()->getLocale() === 'en' ? 'Send Reset Link' : 'রিসেট লিংক পাঠান' }}
                </button>
              </form>

              <!-- Back to Login Link -->
              <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none text-success">
                  <i class="fa-solid fa-arrow-left me-1"></i>{{ app()->getLocale() === 'en' ? 'Back to Login' : 'লগইন পেজে ফিরে যান' }}
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
