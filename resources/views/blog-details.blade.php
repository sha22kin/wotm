@extends('layouts.frontend')

@section('meta_title', $post->title . ' - WOTM')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))
@section('body_class', 'blog-details-page')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/blog-details.css?v=1.0') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="blog-details-hero-section" id="blogDetailsHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="blog-details-hero-bg-img">
      <div class="blog-details-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="blog-details-hero-pattern-img">

      <div class="container blog-details-hero-container">
        <nav class="blog-details-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="blog-details-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="blog-details-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <a href="{{ route('blog.index') }}" class="blog-details-breadcrumb-link">
            {{ app()->getLocale() === 'en' ? 'Blog' : 'ব্লগ' }}
          </a>
          <span class="blog-details-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="blog-details-breadcrumb-current">{{ $post->title }}</span>
        </nav>

        <h1 class="blog-details-hero-title">{{ app()->getLocale() === 'en' ? 'Blog Details' : 'ব্লগ বিস্তারিত' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. MAIN BLOG DETAILS SECTION (ARTICLE & RIGHT SIDEBAR)
         ====================================================================== -->
    <section class="blog-details-main-section">
      <div class="container">
        <div class="row g-4 g-lg-5">

          <!-- Column 1: Main Article Content (Left, 8 Cols) -->
          <div class="col-lg-8 col-12">
            <article class="blog-article-wrapper">

              <!-- Article Header & Meta -->
              <header class="blog-article-header">
                @if($post->category)
                  <span class="blog-article-category-badge">
                    <i class="fa-solid fa-graduation-cap"></i> {{ $post->category->name }}
                  </span>
                @endif

                <h1 class="blog-article-title">{{ $post->title }}</h1>

                <div class="blog-article-meta-list">
                  <span class="blog-article-meta-item">
                    <i class="fa-regular fa-calendar-days"></i> {{ $post->published_at ? $post->published_at->format('d F, Y') : $post->created_at->format('d F, Y') }}
                  </span>
                  <span class="blog-article-meta-item">
                    <i class="fa-regular fa-user"></i> {{ $post->author->name ?? 'WOTM Media' }}
                  </span>
                  <span class="blog-article-meta-item">
                    <i class="fa-regular fa-eye"></i> {{ $post->views_count ?? 1 }} {{ app()->getLocale() === 'en' ? 'views' : 'বার পঠিত' }}
                  </span>
                </div>
              </header>

              <!-- Featured Media Figure -->
              <figure class="blog-article-figure">
                <img
                  src="{{ $post->featured_image ? asset($post->featured_image) : asset('images/projects/featured_imam.jpg') }}"
                  alt="{{ $post->title }}"
                  class="blog-article-img"
                  loading="eager">
                @if($post->excerpt)
                  <figcaption class="blog-article-caption">{{ $post->excerpt }}</figcaption>
                @endif
              </figure>

              <!-- Article Content Body -->
              <div class="blog-article-content">
                {!! $post->content !!}
              </div>

              <!-- Article Tags & Social Share Footer -->
              <footer class="blog-article-footer">
                <!-- Social Share Bar -->
                <div class="blog-share-container">
                  <h3 class="blog-share-title">
                    <i class="fa-solid fa-share-nodes"></i> {{ app()->getLocale() === 'en' ? 'Share this article:' : 'লেখাটি শেয়ার করুন:' }}
                  </h3>
                  <div class="blog-share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="blog-share-btn btn-facebook" aria-label="Facebook">
                      <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="blog-share-btn btn-twitter" aria-label="Twitter">
                      <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="blog-share-btn btn-whatsapp" aria-label="WhatsApp">
                      <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="blog-share-btn btn-linkedin" aria-label="LinkedIn">
                      <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                  </div>
                </div>
              </footer>

            </article>
          </div>

          <!-- Column 2: Right Sidebar (4 Cols) -->
          <div class="col-lg-4 col-12">
            <aside class="blog-sidebar-wrapper">

              <!-- Categories Widget -->
              <section class="blog-sidebar-widget mb-4" aria-label="ক্যাটাগরি">
                <header class="blog-widget-header">
                  <h3 class="blog-widget-title">{{ app()->getLocale() === 'en' ? 'Categories' : 'বিভাগসমূহ' }}</h3>
                </header>
                <ul class="list-unstyled p-3 mb-0">
                  @foreach($categories as $cat)
                    <li class="d-flex justify-content-between py-2 border-bottom">
                      <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="text-decoration-none text-dark fw-medium">
                        {{ $cat->name }}
                      </a>
                      <span class="badge bg-light text-dark rounded-pill">{{ $cat->posts_count }}</span>
                    </li>
                  @endforeach
                </ul>
              </section>

              <!-- Recent Blogs / Posts Widget -->
              <section class="blog-sidebar-widget" aria-label="সাম্প্রতিক প্রতিবেদনসমূহ">
                <header class="blog-widget-header">
                  <h3 class="blog-widget-title">{{ app()->getLocale() === 'en' ? 'Recent Reports' : 'সাম্প্রতিক প্রতিবেদনসমূহ' }}</h3>
                </header>
                <div class="blog-recent-list">
                  @forelse($relatedPosts as $rel)
                    <a href="{{ route('blog.show', $rel->slug) }}" class="blog-recent-card">
                      <div class="blog-recent-media">
                        <img src="{{ $rel->featured_image ? asset($rel->featured_image) : asset('images/projects/flood_relief.jpg') }}" alt="{{ $rel->title }}" class="blog-recent-thumb" loading="lazy">
                      </div>
                      <div class="blog-recent-info">
                        <span class="blog-recent-date">
                          <i class="fa-regular fa-calendar-days"></i> {{ $rel->published_at ? $rel->published_at->format('d F, Y') : $rel->created_at->format('d F, Y') }}
                        </span>
                        <h4 class="blog-recent-title">{{ $rel->title }}</h4>
                      </div>
                    </a>
                  @empty
                    <p class="text-muted small p-3">{{ app()->getLocale() === 'en' ? 'No recent posts.' : 'কোনো সাম্প্রতিক পোস্ট নেই।' }}</p>
                  @endforelse
                </div>
              </section>

            </aside>
          </div>

        </div>
      </div>
    </section>

@endsection
