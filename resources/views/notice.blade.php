@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Notice Board - WOTM' : 'নোটিশ বোর্ড - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))
@section('body_class', 'notice-page')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/notice.css?v=1.0') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="notice-hero-section" id="noticeHero">
      <img src="{{ asset('images/hero.webp') }}" alt="WOTM ব্যানার" class="notice-hero-bg-img">
      <div class="notice-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="notice-hero-pattern-img">

      <div class="container notice-hero-container">
        <nav class="notice-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="notice-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="notice-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="notice-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Notice Board' : 'নোটিশ বোর্ড' }}</span>
        </nav>

        <h1 class="notice-hero-title">{{ app()->getLocale() === 'en' ? 'Notice Board & Circulars' : 'নোটিশ বোর্ড' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. NOTICE MAIN SECTION
         ====================================================================== -->
    <section class="notice-main-section" id="noticeMain">
      <div class="container">

        <!-- SEARCH & HEADER BAR -->
        <div class="notice-control-card">
          <div class="row g-3 align-items-center">
            <div class="col-lg-6 col-12">
              <h2 class="notice-section-heading">{{ app()->getLocale() === 'en' ? 'All Official Notices' : 'সকল বিজ্ঞপ্তি' }}</h2>
            </div>
            <div class="col-lg-6 col-12">
              <form action="{{ route('notice.index') }}" method="GET" class="notice-search-form" id="noticeSearchForm" role="search">
                <input type="text" name="q" value="{{ request('q') }}" id="noticeSearchInput" class="notice-search-input" placeholder="{{ app()->getLocale() === 'en' ? 'Search notices...' : 'নোটিশ বা বিষয় খুঁজুন...' }}" aria-label="নোটিশ খুঁজুন">
                <button type="submit" class="notice-search-btn" aria-label="অনুসন্ধান করুন">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- NOTICE CARDS GRID -->
        <div class="row g-4" id="noticeListContainer">
          @forelse($notices as $notice)
            <div class="col-lg-6 col-12">
              <article class="notice-card {{ $notice->is_pinned ? 'is-featured' : '' }}">
                <div class="notice-card-top-row">
                    <div class="notice-date-box">
                      <span class="notice-date-day">{{ $notice->notice_date ? $notice->notice_date->format('d') : $notice->created_at->format('d') }}</span>
                      <span class="notice-date-month">{{ $notice->notice_date ? $notice->notice_date->format('M Y') : $notice->created_at->format('M Y') }}</span>
                    </div>
                    <div class="notice-badge-group">
                      @if($notice->is_pinned)
                        <span class="notice-tag-badge urgent">
                          <i class="fa-solid fa-fire"></i> {{ app()->getLocale() === 'en' ? 'Urgent' : 'জরুরি নোটিশ' }}
                        </span>
                      @endif
                      <span class="notice-tag-badge project">
                        <i class="fa-solid fa-bullhorn"></i> {{ app()->getLocale() === 'en' ? 'Notice' : 'বিজ্ঞপ্তি' }}
                      </span>
                    </div>
                  </div>

                  @if($notice->notice_number)
                    <span class="notice-card-ref">{{ app()->getLocale() === 'en' ? 'Memo No: ' : 'স্মারক নং: ' }}{{ $notice->notice_number }}</span>
                  @endif

                  <h2 class="notice-card-title">{{ $notice->title }}</h2>

                  <p class="notice-card-desc">
                    {{ $notice->description ?? Str::limit(strip_tags($notice->content ?? ''), 140) }}
                  </p>

                  <div class="notice-card-footer">
                    <span class="notice-card-time">
                      <i class="fa-regular fa-clock me-1"></i> {{ $notice->notice_date ? $notice->notice_date->diffForHumans() : $notice->created_at->diffForHumans() }}
                    </span>
                    @if($notice->file_path)
                      <a href="{{ $notice->file_url }}" class="notice-dl-btn" target="_blank" download title="{{ app()->getLocale() === 'en' ? 'Download PDF Attachment' : 'পিডিএফ সংযুক্তি ডাউনলোড করুন' }}">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>{{ app()->getLocale() === 'en' ? 'Download PDF' : 'ডাউনলোড করুন' }}</span>
                        @if($notice->file_size)
                          <span class="notice-dl-size">({{ $notice->file_size }})</span>
                        @endif
                      </a>
                    @endif
                  </div>
                </article>
              </div>
          @empty
            <div class="col-12 text-center py-5">
              <p class="text-muted fs-5">{{ app()->getLocale() === 'en' ? 'No notices available.' : 'বর্তমানে কোনো নোটিশ নেই।' }}</p>
            </div>
          @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
          {{ $notices->links('pagination::bootstrap-5') }}
        </div>

      </div>
    </section>

@endsection
