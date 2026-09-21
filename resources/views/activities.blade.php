@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Activities - WOTM' : 'কার্যক্রমসমূহ - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/activities.css?v=1.0') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="activity-hero-section" id="activityHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="activity-hero-bg-img">
      <div class="activity-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="activity-hero-pattern-img">

      <div class="container activity-hero-container">
        <nav class="activity-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="activity-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="activity-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="activity-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Activities' : 'কার্যক্রমসমূহ' }}</span>
        </nav>

        <h1 class="activity-hero-title">{{ app()->getLocale() === 'en' ? 'Our Activities' : 'আমাদের কার্যক্রমসমূহ' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. MAIN ACTIVITIES CONTENT SECTION
         ====================================================================== -->
    <section class="activity-main-section" id="activityMain">
      <div class="container">

        <!-- Top Search Bar & Category Filter -->
        <div class="activity-filter-bar">
          <h2 class="activity-section-heading">{{ app()->getLocale() === 'en' ? 'All Activities' : 'সকল কার্যক্রম' }}</h2>
          <form action="{{ route('activities.index') }}" method="GET" class="activity-search-box">
            <i class="fa-solid fa-magnifying-glass activity-search-icon"></i>
            <input type="text" name="q" value="{{ request('q') }}" class="activity-search-input" id="activitySearchInput" placeholder="{{ app()->getLocale() === 'en' ? 'Search activities...' : 'কার্যক্রম সার্চ করুন...' }}" aria-label="কার্যক্রম সার্চ করুন">
            @if(request('cat'))
              <input type="hidden" name="cat" value="{{ request('cat') }}">
            @endif
          </form>
        </div>

        <!-- Category Badges -->
        <div class="d-flex flex-wrap gap-2 mb-4">
          <a href="{{ route('activities.index') }}" class="btn btn-sm {{ !request('cat') ? 'btn-success' : 'btn-outline-secondary' }}">
            {{ app()->getLocale() === 'en' ? 'All' : 'সকল' }}
          </a>
          <a href="{{ route('activities.index', ['cat' => 'livelihood']) }}" class="btn btn-sm {{ request('cat') === 'livelihood' ? 'btn-success' : 'btn-outline-secondary' }}">
            {{ app()->getLocale() === 'en' ? 'Livelihood' : 'স্বাবলম্বীকরণ' }}
          </a>
          <a href="{{ route('activities.index', ['cat' => 'education']) }}" class="btn btn-sm {{ request('cat') === 'education' ? 'btn-success' : 'btn-outline-secondary' }}">
            {{ app()->getLocale() === 'en' ? 'Education' : 'শিক্ষা' }}
          </a>
          <a href="{{ route('activities.index', ['cat' => 'dawah']) }}" class="btn btn-sm {{ request('cat') === 'dawah' ? 'btn-success' : 'btn-outline-secondary' }}">
            {{ app()->getLocale() === 'en' ? 'Dawah' : 'দাওয়াহ' }}
          </a>
          <a href="{{ route('activities.index', ['cat' => 'relief']) }}" class="btn btn-sm {{ request('cat') === 'relief' ? 'btn-success' : 'btn-outline-secondary' }}">
            {{ app()->getLocale() === 'en' ? 'Relief' : 'ত্রাণ ও পুনর্বাসন' }}
          </a>
          <a href="{{ route('activities.index', ['cat' => 'welfare']) }}" class="btn btn-sm {{ request('cat') === 'welfare' ? 'btn-success' : 'btn-outline-secondary' }}">
            {{ app()->getLocale() === 'en' ? 'Welfare' : 'সেবা ও পুনর্বাসন' }}
          </a>
        </div>

        <!-- 3-Column Activities Grid -->
        <div class="row g-4" id="activityGridRow">
          @forelse($services as $service)
            <div class="col-lg-4 col-md-6 col-12">
              <article class="activity-card" data-category="{{ $service->category }}">
                <div class="activity-card-media">
                  <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="activity-card-img" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('2.jpeg') }}';">
                  <span class="activity-card-badge">
                    <i class="fa-solid fa-seedling"></i> {{ $service->category ? ucfirst($service->category) : (app()->getLocale() === 'en' ? 'Regular Activity' : 'কার্যক্রম') }}
                  </span>
                </div>
                <div class="activity-card-body">
                  <h3 class="activity-card-title">{{ $service->title }}</h3>
                  <p class="activity-card-desc">{{ $service->short_description ?? Str::limit(strip_tags($service->description), 120) }}</p>
                  <div class="activity-card-footer">
                    <a href="{{ route('activities.show', $service->slug) }}" class="activity-btn-details">
                      {{ app()->getLocale() === 'en' ? 'View Details' : 'বিস্তারিত দেখুন' }} <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                  </div>
                </div>
              </article>
            </div>
          @empty
            <div class="col-12 text-center py-5">
              <div class="py-5">
                <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">{{ app()->getLocale() === 'en' ? 'No activities found.' : 'কোনো কার্যক্রম পাওয়া যায়নি।' }}</h4>
              </div>
            </div>
          @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
          {{ $services->links('pagination::bootstrap-5') }}
        </div>

      </div>
    </section>

@endsection
