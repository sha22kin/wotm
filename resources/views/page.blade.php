@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?: $page->title . ' - WOTM')
@section('meta_description', $page->meta_description ?: App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?: App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/activity-details.css?v=1.0') }}">
@endpush

@section('content')

    <!-- Hero / Breadcrumb Banner -->
    <section class="activity-details-hero-section">
      <img src="{{ asset('images/hero2.webp') }}" alt="{{ $page->title }}" class="activity-details-hero-bg-img">
      <div class="activity-details-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="Islamic Pattern" class="activity-details-hero-pattern-img">

      <div class="container activity-details-hero-container">
        <nav class="activity-details-breadcrumb-nav" aria-label="Breadcrumb">
          <a href="{{ route('home') }}" class="activity-details-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="activity-details-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="activity-details-breadcrumb-current">{{ $page->title }}</span>
        </nav>

        <h1 class="activity-details-hero-title">{{ $page->title }}</h1>
      </div>
    </section>

    <!-- Main Page Content Section -->
    <section class="activity-details-main-section py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-12">
            <article class="activity-details-article p-4 p-md-5 bg-white rounded-3 shadow-sm">
              <header class="mb-4 pb-3 border-bottom">
                <h1 class="h2 fw-bold text-dark mb-2">{{ $page->title }}</h1>
                <div class="text-muted small">
                  <i class="fa-regular fa-clock me-1"></i> {{ $page->updated_at ? $page->updated_at->format('d M, Y') : '' }}
                </div>
              </header>

              <div class="activity-details-body lh-lg fs-6 text-secondary">
                {!! $page->content !!}
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

@endsection
