@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Blog - WOTM' : 'ব্লগ - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/blog.css?v=1.0') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="blog-hero-section" id="blogHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="blog-hero-bg-img">
      <div class="blog-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="blog-hero-pattern-img">

      <div class="container blog-hero-container">
        <nav class="blog-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="blog-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="blog-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="blog-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Blog' : 'ব্লগ' }}</span>
        </nav>

        <h1 class="blog-hero-title">{{ app()->getLocale() === 'en' ? 'Blog & Recent Reports' : 'ব্লগ ও সাম্প্রতিক প্রতিবেদন' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. MAIN BLOG CONTENT SECTION
         ====================================================================== -->
    <section class="blog-main-section" id="blogMain">
      <div class="container">

        <!-- Top Search & Filter Bar -->
        <div class="blog-filter-bar">
          <form action="{{ route('blog.index') }}" method="GET" class="blog-search-box">
            <i class="fa-solid fa-magnifying-glass blog-search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" class="blog-search-input" id="blogSearchInput" placeholder="{{ app()->getLocale() === 'en' ? 'Search blog...' : 'ব্লগ সার্চ করুন' }}" aria-label="ব্লগ সার্চ করুন">
            @if(request('category'))
              <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
          </form>

          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('blog.index') }}" class="blog-filter-all-btn text-decoration-none {{ !request('category') ? 'active' : '' }}">
              {{ app()->getLocale() === 'en' ? 'All' : 'সকল' }}
            </a>
            @foreach($categories as $cat)
              <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="blog-filter-all-btn text-decoration-none {{ request('category') === $cat->slug ? 'active' : '' }}">
                {{ $cat->name }}
              </a>
            @endforeach
          </div>
        </div>

        <!-- Featured Blog Card (Top Horizontal Card) -->
        @if($featuredPost && !request('search') && !request('category') && request('page', 1) == 1)
          <div class="blog-featured-wrapper">
            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="blog-featured-card">
              <div class="row g-0 align-items-center">
                <div class="col-lg-6 col-12">
                  <div class="blog-featured-media">
                    <img src="{{ $featuredPost->featured_image ? asset($featuredPost->featured_image) : asset('images/projects/featured_imam.jpg') }}" alt="{{ $featuredPost->title }}" class="blog-featured-img" loading="lazy">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="blog-featured-body">
                    <h2 class="blog-featured-title">{{ $featuredPost->title }}</h2>
                    <p class="blog-featured-excerpt">{{ $featuredPost->excerpt ?? Str::limit(strip_tags($featuredPost->content), 180) }}</p>
                    <div class="blog-featured-date">
                      <i class="fa-regular fa-calendar-days me-1"></i> {{ $featuredPost->published_at ? $featuredPost->published_at->format('d F, Y') : $featuredPost->created_at->format('d F, Y') }}
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endif

        <!-- 3-Column Blog Grid Cards -->
        <div class="blog-grid-wrapper">
          <div class="row g-4" id="blogGridRow">
            @forelse($posts as $post)
              <div class="col-lg-4 col-md-6 col-12">
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-grid-card">
                  <div class="blog-card-media">
                    <img src="{{ $post->featured_image ? asset($post->featured_image) : asset('images/projects/flood_relief.jpg') }}" alt="{{ $post->title }}" class="blog-card-img" loading="lazy">
                  </div>
                  <div class="blog-card-body">
                    <h3 class="blog-card-title">{{ $post->title }}</h3>
                    <p class="blog-card-excerpt">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                    <div class="blog-card-date">
                      <i class="fa-regular fa-calendar-days me-1"></i> {{ $post->published_at ? $post->published_at->format('d F, Y') : $post->created_at->format('d F, Y') }}
                    </div>
                  </div>
                </a>
              </div>
            @empty
              <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">{{ app()->getLocale() === 'en' ? 'No blog posts found.' : 'কোনো ব্লগ পোস্ট পাওয়া যায়নি।' }}</p>
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
