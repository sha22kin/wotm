@extends('layouts.frontend')

@section('meta_title', $post->title . ' - WOTM')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/project-details.css?v=1.2') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="project-details-hero-section" id="projectDetailsHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="project-details-hero-bg-img">
      <div class="project-details-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="project-details-hero-pattern-img">

      <div class="container project-details-hero-container">
        <nav class="project-details-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="project-details-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="project-details-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <a href="{{ route('projects.index') }}" class="project-details-breadcrumb-link">
            {{ app()->getLocale() === 'en' ? 'Projects' : 'প্রকল্পসমূহ' }}
          </a>
          <span class="project-details-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="project-details-breadcrumb-current">{{ $post->title }}</span>
        </nav>

        <h1 class="project-details-hero-title">{{ $post->title }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. MAIN PROJECT DETAILS SECTION
         ====================================================================== -->
    <section class="project-details-main-section py-5">
      <div class="container">
        <div class="row g-4 g-lg-5">

          <!-- Left Column (8 Cols) -->
          <div class="col-lg-8 col-12">
            <article class="project-article-wrapper">
              <header class="mb-4">
                <h1 class="h2 fw-bold text-dark mb-3">{{ $post->title }}</h1>
                <div class="text-muted small d-flex gap-3">
                  <span><i class="fa-regular fa-calendar-days me-1"></i> {{ $post->published_at ? $post->published_at->format('d F, Y') : $post->created_at->format('d F, Y') }}</span>
                  <span><i class="fa-regular fa-user me-1"></i> {{ $post->author->name ?? 'WOTM' }}</span>
                </div>
              </header>

              <figure class="mb-4">
                <img
                  src="{{ $post->featured_image_url }}"
                  alt="{{ $post->title }}"
                  class="img-fluid rounded-3 w-100"
                  loading="eager"
                  onerror="this.onerror=null;this.src='{{ asset('images/projects/featured_imam.jpg') }}';">
                @if($post->excerpt)
                  <figcaption class="text-muted small mt-2 fst-italic">{{ $post->excerpt }}</figcaption>
                @endif
              </figure>

              <div class="project-article-content lh-lg">
                {!! $post->content !!}
              </div>
            </article>
          </div>

          <!-- Right Column: Sidebar (4 Cols) -->
          <div class="col-lg-4 col-12">
            <aside>
              <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                <h4 class="fw-bold mb-3 fs-5">{{ app()->getLocale() === 'en' ? 'Other Projects' : 'অন্যান্য প্রকল্প' }}</h4>
                <div class="d-flex flex-column gap-3">
                  @foreach($relatedPosts as $rel)
                    <a href="{{ route('projects.show', $rel->slug) }}" class="d-flex gap-3 text-decoration-none text-dark align-items-center">
                      <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}" class="rounded-2 project-rel-thumb" onerror="this.onerror=null;this.src='{{ asset('images/projects/flood_relief.jpg') }}';">
                      <div>
                        <h6 class="mb-1 small fw-semibold text-truncate project-rel-title">{{ $rel->title }}</h6>
                        <small class="text-muted">{{ $rel->published_at ? $rel->published_at->format('d M, Y') : '' }}</small>
                      </div>
                    </a>
                  @endforeach
                </div>
              </div>
            </aside>
          </div>

        </div>
      </div>
    </section>

@endsection
