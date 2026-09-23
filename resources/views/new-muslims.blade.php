@extends('layouts.frontend')

@section('meta_title', app()->getLocale() === 'en' ? 'New Muslims - WOTM' : 'নবমুসলিম - WOTM')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/about-us.css?v=1.1') }}">
  <link rel="stylesheet" href="{{ asset('css/new-muslims.css?v=1.0') }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero-section">
  <img src="{{ asset('images/hero.webp') }}" alt="WOTM ব্যানার" class="about-hero-bg-img">
  <div class="about-hero-overlay"></div>
  <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="Islamic Pattern" class="about-hero-pattern-img">
  <div class="container about-hero-container">
    <nav class="about-breadcrumb-nav">
      <a href="{{ route('home') }}" class="about-breadcrumb-link">
        <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
      </a>
      <span class="about-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
      <span class="about-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'New Muslims' : 'নবমুসলিম' }}</span>
    </nav>
    <h1 class="about-hero-title">{{ app()->getLocale() === 'en' ? 'New Muslims' : 'নবমুসলিম' }}</h1>
  </div>
</section>

<!-- Grid Section -->
<section class="nm-grid-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="nm-section-title">{{ app()->getLocale() === 'en' ? 'New Journey in the Light of Islam, We Stand By New Muslims' : 'ইসলামের আলোয় নতুন পথচলা, নবমুসলিমদের পাশে আমরা' }}</h2>
      <p class="nm-section-desc">{{ app()->getLocale() === 'en' ? 'A beautiful endeavor to stand by those who have started a new chapter of life by embracing Islam, with knowledge, guidance, love, and sincere cooperation on their journey of faith.' : 'ইসলাম গ্রহণের মাধ্যমে যারা জীবনের নতুন অধ্যায় শুরু করেছেন, তাদের ঈমানের পথচলায় জ্ঞান, দিকনির্দেশনা, ভালোবাসা ও আন্তরিক সহযোগিতার মাধ্যমে পাশে থাকার একটি সুন্দর প্রয়াস।' }}</p>
    </div>
    <div class="row g-4">
      @forelse($newMuslims as $person)
        <!-- Grid item: 4 per row on desktop (col-lg-3), 2 per row on mobile (col-6) -->
        <div class="col-lg-3 col-md-4 col-6">
          <div class="nm-card">
            <div class="nm-photo-wrapper">
              @if($person->photo_path)
                <img src="{{ asset('storage/' . $person->photo_path) }}" alt="{{ $person->name }}" class="nm-photo">
              @else
                <div class="nm-photo-placeholder">
                  <i class="fa-solid fa-user"></i>
                </div>
              @endif
            </div>
            
            <h3 class="nm-name">{{ $person->name }}</h3>
            
            <ul class="nm-details">
              @if($person->mobile)
                <li><i class="fa-solid fa-phone"></i> {{ $person->mobile }}</li>
              @endif
              @if($person->email)
                <li><i class="fa-solid fa-envelope"></i> <span class="text-truncate">{{ $person->email }}</span></li>
              @endif
            </ul>

            @if($person->facebook_link)
              <a href="{{ $person->facebook_link }}" target="_blank" class="nm-fb-link">
                <i class="fa-brands fa-facebook-f"></i> {{ app()->getLocale() === 'en' ? 'Facebook' : 'ফেইসবুক' }}
              </a>
            @endif
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="nm-empty">
            <i class="fa-solid fa-users-slash"></i>
            <h3>{{ app()->getLocale() === 'en' ? 'No records found' : 'কোনো তথ্য পাওয়া যায়নি' }}</h3>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
