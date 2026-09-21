@extends('layouts.frontend')

@section('meta_title', app()->getLocale() === 'en' ? 'Login - WOTM' : 'লগইন - WOTM')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/login.css?v=1.0') }}">
@endpush

@section('content')



    <!-- ======================================================================
         3. MAIN AUTHENTICATION SECTION (CENTERED CARD)
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
                <h2 class="auth-card-title" id="authCardTitle">{{ app()->getLocale() === 'en' ? 'Sign In' : 'লগইন করুন' }}</h2>
                <p class="auth-card-subtitle" id="authCardSubtitle">{{ app()->getLocale() === 'en' ? 'Enter credentials to access account' : 'আপনার অ্যাকাউন্টে প্রবেশ করতে সঠিক তথ্য দিন' }}</p>
              </div>

              @if($errors->any())
                <div class="alert alert-danger mx-4 mb-0 mt-3 p-3">
                  <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <!-- 1. LOGIN FORM PANE -->
              <div class="auth-form-pane is-active" id="paneLogin" role="region" aria-labelledby="authCardTitle">
                <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                  @csrf

                  <!-- Email / Phone Input -->
                  <div class="auth-form-group">
                    <label for="loginEmail" class="auth-label">
                      {{ app()->getLocale() === 'en' ? 'Email or Mobile Number' : 'ইমেইল অথবা মোবাইল নম্বর' }} <span class="req">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                      <input
                        type="text"
                        name="email"
                        value="{{ old('email') }}"
                        class="auth-input-field"
                        id="loginEmail"
                        placeholder="example@mail.com"
                        required
                        autocomplete="username">
                      <i class="fa-solid fa-envelope auth-input-icon"></i>
                    </div>
                  </div>

                  <!-- Password Input -->
                  <div class="auth-form-group">
                    <label for="loginPassword" class="auth-label">
                      {{ app()->getLocale() === 'en' ? 'Password' : 'পাসওয়ার্ড' }} <span class="req">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                      <input
                        type="password"
                        name="password"
                        class="auth-input-field"
                        id="loginPassword"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password">
                      <i class="fa-solid fa-lock auth-input-icon"></i>
                    </div>
                  </div>

                  <!-- Remember Me & Forgot Password -->
                  <div class="auth-options-bar">
                    <label class="auth-checkbox-group" for="rememberMe">
                      <input type="checkbox" name="remember" class="auth-checkbox" id="rememberMe">
                      <span>{{ app()->getLocale() === 'en' ? 'Remember Me' : 'মনে রাখুন' }}</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="auth-forgot-link">
                      {{ app()->getLocale() === 'en' ? 'Forgot Password?' : 'পাসওয়ার্ড ভুলে গেছেন?' }}
                    </a>
                  </div>

                  <!-- Submit Button -->
                  <button type="submit" class="auth-submit-btn" id="loginSubmitBtn">
                    <i class="fa-solid fa-right-to-bracket"></i> {{ app()->getLocale() === 'en' ? 'Login' : 'লগইন করুন' }}
                  </button>
                </form>

                <!-- User Registration Prompt Link -->
                <div class="text-center mt-4 pt-3 border-top">
                  <span class="text-muted small">{{ app()->getLocale() === 'en' ? "Don't have an account?" : 'নতুন একাউন্ট প্রয়োজন?' }}</span>
                  <a href="{{ route('register') }}" class="fw-semibold text-decoration-none ms-1 text-success">
                    {{ app()->getLocale() === 'en' ? 'Create an Account' : 'রেজিস্ট্রেশন করুন' }}
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
