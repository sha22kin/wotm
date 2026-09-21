@extends('layouts.frontend')

@section('meta_title', app()->getLocale() === 'en' ? 'Register - WOTM' : 'রেজিস্ট্রেশন - WOTM')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/login.css?v=1.1') }}">
@endpush

@section('content')

    <!-- ======================================================================
         MAIN REGISTRATION SECTION (CENTERED CARD, NO BANNER)
         ====================================================================== -->
    <section class="auth-main-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 col-12">
            <div class="auth-form-card">

              <!-- Card Header with Brand Badge -->
              <div class="auth-card-header">
                <div class="auth-brand-badge">
                  <img src="{{ App\Models\Setting::getImageUrl('site_logo', 'images/logos/logo.webp') }}" alt="WOTM লোগো" class="auth-badge-logo" onerror="this.onerror=null;this.src='{{ asset('images/logos/logo.webp') }}';">
                </div>
                <h2 class="auth-card-title" id="authCardTitle">{{ app()->getLocale() === 'en' ? 'Create Account' : 'অ্যাকাউন্ট তৈরি করুন' }}</h2>
                <p class="auth-card-subtitle" id="authCardSubtitle">{{ app()->getLocale() === 'en' ? 'Register to connect with our welfare activities' : 'আমাদের সেবামূলক কার্যক্রমে যুক্ত হতে তথ্য দিন' }}</p>
              </div>

              @if($errors->any())
                <div class="alert alert-danger mx-4 mb-0 mt-2 p-3">
                  <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <!-- REGISTRATION FORM PANE -->
              <div class="auth-form-pane is-active" id="paneRegister">
                <form id="registerForm" action="{{ route('register.post') }}" method="POST">
                  @csrf

                  <!-- Full Name Input -->
                  <div class="auth-form-group">
                    <label for="regName" class="auth-label">
                      {{ app()->getLocale() === 'en' ? 'Full Name' : 'পূর্ণ নাম' }} <span class="req">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                      <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="auth-input-field"
                        id="regName"
                        placeholder="{{ app()->getLocale() === 'en' ? 'Your Name' : 'আপনার নাম' }}"
                        required
                        autocomplete="name">
                      <i class="fa-solid fa-user auth-input-icon"></i>
                    </div>
                  </div>

                  <!-- Email Input -->
                  <div class="auth-form-group">
                    <label for="regEmail" class="auth-label">
                      {{ app()->getLocale() === 'en' ? 'Email Address' : 'ইমেইল অ্যাড্রেস' }} <span class="req">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                      <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="auth-input-field"
                        id="regEmail"
                        placeholder="example@mail.com"
                        required
                        autocomplete="email">
                      <i class="fa-solid fa-envelope auth-input-icon"></i>
                    </div>
                  </div>

                  <!-- Phone Input -->
                  <div class="auth-form-group">
                    <label for="regPhone" class="auth-label">
                      {{ app()->getLocale() === 'en' ? 'Mobile Number' : 'মোবাইল নম্বর' }}
                    </label>
                    <div class="auth-input-wrapper">
                      <input
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="auth-input-field"
                        id="regPhone"
                        placeholder="+880 1..."
                        autocomplete="tel">
                      <i class="fa-solid fa-phone auth-input-icon"></i>
                    </div>
                  </div>

                  <!-- Password Input -->
                  <div class="auth-form-group">
                    <label for="regPassword" class="auth-label">
                      {{ app()->getLocale() === 'en' ? 'Password' : 'পাসওয়ার্ড' }} <span class="req">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                      <input
                        type="password"
                        name="password"
                        class="auth-input-field"
                        id="regPassword"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password">
                      <i class="fa-solid fa-lock auth-input-icon"></i>
                    </div>
                  </div>

                  <!-- Confirm Password Input -->
                  <div class="auth-form-group">
                    <label for="regPasswordConfirm" class="auth-label">
                      {{ app()->getLocale() === 'en' ? 'Confirm Password' : 'পাসওয়ার্ড নিশ্চিত করুন' }} <span class="req">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                      <input
                        type="password"
                        name="password_confirmation"
                        class="auth-input-field"
                        id="regPasswordConfirm"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password">
                      <i class="fa-solid fa-shield-halved auth-input-icon"></i>
                    </div>
                  </div>

                  <!-- Submit Button -->
                  <button type="submit" class="auth-submit-btn" id="registerSubmitBtn">
                    <i class="fa-solid fa-user-plus"></i> {{ app()->getLocale() === 'en' ? 'Create Account' : 'রেজিস্ট্রেশন করুন' }}
                  </button>
                </form>

                <!-- Login Shortcut Link -->
                <div class="text-center mt-4 pt-3 border-top">
                  <span class="text-muted small">{{ app()->getLocale() === 'en' ? 'Already have an account?' : 'ইতিমধ্যে একাউন্ট আছে?' }}</span>
                  <a href="{{ route('login') }}" class="fw-semibold text-decoration-none ms-1 text-success">
                    {{ app()->getLocale() === 'en' ? 'Login here' : 'লগইন করুন' }}
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
