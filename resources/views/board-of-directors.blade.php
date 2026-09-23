@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Board of Directors & Advisory Council - WOTM' : 'পরিচালনা পর্ষদ ও উপদেষ্টা পরিষদ - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/about-subpages.css?v=1.3') }}">
@endpush

@section('content')

    <!-- ======================================================================
         1. HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="about-hero-section" id="boardHero">
      <img src="{{ asset('images/hero.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="about-hero-bg-img">
      <div class="about-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="about-hero-pattern-img">

      <div class="container about-hero-container">
        <nav class="about-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="about-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="about-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <a href="{{ route('about') }}" class="about-breadcrumb-link">
            {{ app()->getLocale() === 'en' ? 'About Us' : 'আমাদের সম্পর্কে' }}
          </a>
          <span class="about-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="about-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Board of Directors & Advisory Council' : 'পরিচালনা পর্ষদ ও উপদেষ্টা পরিষদ' }}</span>
        </nav>

        <h1 class="about-hero-title">{{ app()->getLocale() === 'en' ? 'Board of Directors & Advisory Council' : 'পরিচালনা পর্ষদ ও উপদেষ্টা পরিষদ' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         2. MAIN MEMBERS SECTION (100% ADMIN CONTROLLED)
         ====================================================================== -->
    <section class="asp-main-sec">
      <div class="container">

        <!-- STEP 1: CHAIRMAN (PHOTO, NAME, AND DESIGNATION ONLY) -->
        @if($chairman)
          <div class="row justify-content-center mb-5">
            <div class="col-lg-5 col-md-7 col-11 text-center">
              <article class="asp-chairman-top-card">
                <div class="asp-card-avatar-wrap asp-chairman-avatar-lg">
                  <img src="{{ $chairman->image_url }}" alt="{{ $chairman->name }}" 
                       class="asp-card-avatar-img" loading="eager"
                       onerror="this.onerror=null;this.src='{{ asset('images/avatar-placeholder.png') }}';">
                </div>
                <h2 class="asp-chairman-top-name">{{ $chairman->name }}</h2>
                <div class="asp-chairman-top-role">{{ $chairman->designation }}</div>
              </article>
            </div>
          </div>
        @endif

        <!-- STEP 2: TEAM MEMBERS (PHOTO, NAME, DESIGNATION, EMAIL, PHONE, SOCIAL LINKS) -->
        @php
          $allTeamMembers = $teamMembers ?? (isset($directors) && isset($advisors) ? $directors->concat($advisors) : collect());
        @endphp
        @if($allTeamMembers->isNotEmpty())
          <div class="row g-4 mb-4">
            @foreach($allTeamMembers as $member)
              <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                <article class="asp-member-grid-card">
                  <div class="asp-card-avatar-wrap">
                    <img src="{{ $member->image_url }}" alt="{{ $member->name }}" 
                         class="asp-card-avatar-img" loading="lazy"
                         onerror="this.onerror=null;this.src='{{ asset('images/avatar-placeholder.png') }}';">
                  </div>

                  <h3 class="asp-card-name">{{ $member->name }}</h3>
                  <div class="asp-card-role">{{ $member->designation }}</div>

                  <!-- Contact Channels (Email & Phone) -->
                  <div class="asp-card-contacts">
                    @if($member->email)
                      <a href="mailto:{{ $member->email }}" class="asp-card-contact-item" title="Email">
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ $member->email }}</span>
                      </a>
                    @endif
                    @if($member->phone)
                      <a href="tel:{{ $member->phone }}" class="asp-card-contact-item" title="Call">
                        <i class="fa-solid fa-phone"></i>
                        <span>{{ $member->phone }}</span>
                      </a>
                    @endif
                  </div>

                  <!-- Social Media Links -->
                  @php
                    $fb = $member->social_facebook ?: ($member->social_links['facebook'] ?? null);
                    $li = $member->social_linkedin ?: ($member->social_links['linkedin'] ?? null);
                    $tw = $member->social_twitter ?: ($member->social_links['twitter'] ?? null);
                    $ig = $member->social_instagram ?: ($member->social_links['instagram'] ?? null);
                  @endphp
                  @if($fb || $li || $tw || $ig)
                    <div class="asp-card-socials">
                      @if($fb)
                        <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer" class="asp-social-btn facebook" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
                      @endif
                      @if($li)
                        <a href="{{ $li }}" target="_blank" rel="noopener noreferrer" class="asp-social-btn linkedin" title="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                      @endif
                      @if($tw)
                        <a href="{{ $tw }}" target="_blank" rel="noopener noreferrer" class="asp-social-btn twitter" title="Twitter/X"><i class="fa-brands fa-x-twitter"></i></a>
                      @endif
                      @if($ig)
                        <a href="{{ $ig }}" target="_blank" rel="noopener noreferrer" class="asp-social-btn instagram" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                      @endif
                    </div>
                  @endif
                </article>
              </div>
            @endforeach
          </div>
        @endif

      </div>
    </section>

@endsection
