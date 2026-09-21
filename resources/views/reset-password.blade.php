@extends('layouts.frontend')

@section('meta_title', app()->getLocale() === 'en' ? 'Set New Password - WOTM' : 'নতুন পাসওয়ার্ড সেট করুন - WOTM')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/login.css?v=2.2') }}">
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
              <h2 class="auth-card-title">{{ app()->getLocale() === 'en' ? 'Set New Password' : 'নতুন পাসওয়ার্ড দিন' }}</h2>
              <p class="auth-card-subtitle">
                {{ app()->getLocale() === 'en' 
                  ? 'Please enter your new password before the link expires' 
                  : 'লিংকের মেয়াদ শেষ হওয়ার আগেই নতুন পাসওয়ার্ড দিন' }}
              </p>
            </div>

            <!-- Live 5-Minute Countdown Timer Bar -->
            <div class="auth-countdown-bar" id="countdownBar">
              <div class="d-flex align-items-center justify-content-between">
                <div class="auth-timer-label">
                  <i class="fa-solid fa-clock-rotate-left me-2 text-muted"></i>
                  <span>{{ app()->getLocale() === 'en' ? 'Time Remaining:' : 'মেয়াদ বাকি আছে:' }}</span>
                </div>
                <div class="auth-timer-digits" id="timerDigits">
                  05:00
                </div>
              </div>
              <div class="auth-progress-track">
                <div class="auth-progress-bar" id="progressBar"></div>
              </div>
            </div>

            <!-- Expired Alert (Shown automatically when 5 minutes finish) -->
            <div class="alert alert-danger d-none mx-4 mt-3 mb-0 p-3" id="expiredAlert" role="alert">
              <div class="fw-bold mb-1">
                <i class="fa-solid fa-triangle-exclamation me-1"></i>
                {{ app()->getLocale() === 'en' ? 'Link Expired!' : 'লিংকের মেয়াদ শেষ হয়ে গেছে!' }}
              </div>
              <p class="small mb-3">
                {{ app()->getLocale() === 'en' 
                  ? 'The 5-minute security limit for this reset link has ended. Please request a new link.' 
                  : 'নিরাপত্তার স্বার্থে ৫ মিনিটের সময়সীমা শেষ হয়ে গেছে। অনুগ্রহ করে আবার নতুন লিংক চান।' }}
              </p>
              <a href="{{ route('password.request') }}" class="btn btn-sm btn-danger">
                <i class="fa-solid fa-rotate-right me-1"></i>{{ app()->getLocale() === 'en' ? 'Request New Link' : 'নতুন লিংক চান' }}
              </a>
            </div>

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

            <!-- Reset Form Pane -->
            <div class="auth-form-pane is-active">
              <form id="resetPasswordForm" action="{{ route('password.update') }}" method="POST">
                @csrf

                <!-- Hidden Token -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Input -->
                <div class="auth-form-group">
                  <label for="resetEmail" class="auth-label">
                    {{ app()->getLocale() === 'en' ? 'Email Address' : 'ইমেইল ঠিকানা' }} <span class="req">*</span>
                  </label>
                  <div class="auth-input-wrapper">
                    <input
                      type="email"
                      name="email"
                      value="{{ old('email', $email) }}"
                      class="auth-input-field"
                      id="resetEmail"
                      placeholder="example@mail.com"
                      required
                      readonly>
                    <i class="fa-solid fa-envelope auth-input-icon"></i>
                  </div>
                </div>

                <!-- New Password Input -->
                <div class="auth-form-group">
                  <label for="resetPassword" class="auth-label">
                    {{ app()->getLocale() === 'en' ? 'New Password' : 'নতুন পাসওয়ার্ড' }} <span class="req">*</span>
                  </label>
                  <div class="auth-input-wrapper">
                    <input
                      type="password"
                      name="password"
                      class="auth-input-field"
                      id="resetPassword"
                      placeholder="••••••••"
                      required
                      autocomplete="new-password">
                    <i class="fa-solid fa-lock auth-input-icon"></i>
                  </div>
                </div>

                <!-- Confirm New Password Input -->
                <div class="auth-form-group">
                  <label for="resetPasswordConfirm" class="auth-label">
                    {{ app()->getLocale() === 'en' ? 'Confirm Password' : 'পাসওয়ার্ড নিশ্চিত করুন' }} <span class="req">*</span>
                  </label>
                  <div class="auth-input-wrapper">
                    <input
                      type="password"
                      name="password_confirmation"
                      class="auth-input-field"
                      id="resetPasswordConfirm"
                      placeholder="••••••••"
                      required
                      autocomplete="new-password">
                    <i class="fa-solid fa-shield-halved auth-input-icon"></i>
                  </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="auth-submit-btn" id="resetSubmitBtn">
                  <i class="fa-solid fa-check"></i> {{ app()->getLocale() === 'en' ? 'Reset Password' : 'পাসওয়ার্ড সংরক্ষণ করুন' }}
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

@push('scripts')
<script>
  (function () {
    let totalSeconds = {{ $remainingSeconds ?? 300 }};
    const maxSeconds = 300;

    const timerDigits = document.getElementById('timerDigits');
    const progressBar = document.getElementById('progressBar');
    const countdownBar = document.getElementById('countdownBar');
    const expiredAlert = document.getElementById('expiredAlert');
    const form = document.getElementById('resetPasswordForm');
    const submitBtn = document.getElementById('resetSubmitBtn');

    function renderTimer() {
      if (totalSeconds <= 0) {
        if (timerDigits) timerDigits.textContent = '00:00';
        if (progressBar) progressBar.style.width = '0%';
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.classList.add('opacity-50');
        }
        if (form) {
          const inputs = form.querySelectorAll('input');
          inputs.forEach(input => input.disabled = true);
        }
        if (expiredAlert) expiredAlert.classList.remove('d-none');
        if (countdownBar) countdownBar.classList.add('d-none');
        clearInterval(timerInterval);
        return;
      }

      const minutes = Math.floor(totalSeconds / 60);
      const seconds = totalSeconds % 60;
      const formatted = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

      if (timerDigits) {
        timerDigits.textContent = formatted;
        if (totalSeconds <= 60) {
          timerDigits.className = 'auth-timer-digits timer-critical';
          if (progressBar) progressBar.style.backgroundColor = '#dc2626';
        } else if (totalSeconds <= 120) {
          timerDigits.className = 'auth-timer-digits timer-warning';
          if (progressBar) progressBar.style.backgroundColor = '#ea580c';
        }
      }

      if (progressBar) {
        const percent = Math.max(0, Math.min(100, (totalSeconds / maxSeconds) * 100));
        progressBar.style.width = percent + '%';
      }

      totalSeconds--;
    }

    renderTimer();
    const timerInterval = setInterval(renderTimer, 1000);
  })();
</script>
@endpush
