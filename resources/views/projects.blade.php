@extends('layouts.frontend')

@section('meta_title', 'Projects - WOTM')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/project-details.css?v=1.2') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="project-hero-section" id="projectHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="project-hero-bg-img">
      <div class="project-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="project-hero-pattern-img">

      <div class="container project-hero-container">
        <nav class="project-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="project-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="project-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="project-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Projects' : 'প্রকল্পসমূহ' }}</span>
        </nav>

        <h1 class="project-hero-title">{{ app()->getLocale() === 'en' ? 'Our Projects & Reports' : 'আমাদের প্রকল্পসমূহ' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. MAIN PROJECTS CONTENT SECTION
         ====================================================================== -->
    <section class="project-main-section" id="projectMain">
      <div class="container">

        <!-- Top Search & Filter Bar -->
        <div class="project-filter-bar">
          <form action="{{ route('projects.index') }}" method="GET" class="project-search-box">
            <i class="fa-solid fa-magnifying-glass project-search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" class="project-search-input" id="projectSearchInput" placeholder="{{ app()->getLocale() === 'en' ? 'Search projects...' : 'প্রকল্প সার্চ করুন' }}" aria-label="সার্চ করুন">
          </form>
          <a href="{{ route('projects.index') }}" class="project-filter-all-btn text-decoration-none">
            {{ app()->getLocale() === 'en' ? 'All' : 'সকল' }}
          </a>
        </div>

        <!-- Featured Project Card -->
        @if($featuredPost && !request('search') && request('page', 1) == 1)
          <div class="project-featured-wrapper">
            <a href="{{ route('projects.show', $featuredPost->slug) }}" class="project-featured-card">
              <div class="row g-0 align-items-center">
                <div class="col-lg-6 col-12">
                  <div class="project-featured-media">
                    <img src="{{ $featuredPost->featured_image_url }}" alt="{{ $featuredPost->title }}" class="project-featured-img" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/projects/featured_imam.jpg') }}';">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="project-featured-body">
                    <h2 class="project-featured-title">{{ $featuredPost->title }}</h2>
                    <p class="project-featured-excerpt">{{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 180) }}</p>
                    <div class="project-featured-date">
                      {{ $featuredPost->published_at ? $featuredPost->published_at->format('d F, Y') : $featuredPost->created_at->format('d F, Y') }}
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endif

        <!-- 3-Column Projects Grid Cards -->
        <div class="project-grid-wrapper">
          <div class="row g-4" id="projectGridRow">
            @forelse($posts as $post)
              <div class="col-lg-4 col-md-6 col-12">
                <a href="{{ route('projects.show', $post->slug) }}" class="project-grid-card">
                  <div class="project-card-media">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="project-card-img" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/projects/flood_relief.jpg') }}';">
                  </div>
                  <div class="project-card-body">
                    <h3 class="project-card-title">{{ $post->title }}</h3>
                    <p class="project-card-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                    <div class="project-card-date">
                      {{ $post->published_at ? $post->published_at->format('d F, Y') : $post->created_at->format('d F, Y') }}
                    </div>
                  </div>
                </a>
              </div>
            @empty
              <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">{{ app()->getLocale() === 'en' ? 'No projects found.' : 'কোনো প্রকল্প পাওয়া যায়নি।' }}</p>
              </div>
            @endforelse
          </div>
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
          {{ $posts->links('pagination::bootstrap-5') }}
        </div>

      </div>
    </section>

@endsection
