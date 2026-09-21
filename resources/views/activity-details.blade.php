@extends('layouts.frontend')

@section('meta_title', $service->title . ' - WOTM')
@section('meta_description', $service->short_description ?? Str::limit(strip_tags($service->description), 160))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/activity-details.css?v=1.0') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="activity-details-hero-section" id="activityDetailsHero">
      <img src="{{ asset('images/hero2.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="activity-details-hero-bg-img">
      <div class="activity-details-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="activity-details-hero-pattern-img">

      <div class="container activity-details-hero-container">
        <nav class="activity-details-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="activity-details-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="activity-details-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <a href="{{ route('activities.index') }}" class="activity-details-breadcrumb-link">
            {{ app()->getLocale() === 'en' ? 'Activities' : 'কার্যক্রমসমূহ' }}
          </a>
          <span class="activity-details-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="activity-details-breadcrumb-current">{{ $service->title }}</span>
        </nav>

        <h1 class="activity-details-hero-title">{{ $service->title }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. MAIN ACTIVITY DETAILS SECTION (ARTICLE & SIDEBAR)
         ====================================================================== -->
    <section class="activity-details-main-section">
      <div class="container">
        <div class="row g-4 g-lg-5">

          <!-- Left Column: Main Activity Content (8 Cols) -->
          <div class="col-lg-8 col-12">
            <article class="activity-details-article">

              <!-- Activity Header -->
              <header class="activity-details-header">
                <span class="activity-details-badge">
                  <i class="fa-solid fa-seedling"></i> {{ $service->category ? ucfirst($service->category) : (app()->getLocale() === 'en' ? 'Activity' : 'কার্যক্রম') }}
                </span>

                <h1 class="activity-details-title">{{ $service->title }}</h1>

                <div class="activity-details-meta-list">
                  <span class="activity-details-meta-item">
                    <i class="fa-regular fa-calendar-days"></i> {{ app()->getLocale() === 'en' ? 'Ongoing Project' : 'নিয়মিত চলমান প্রকল্প' }}
                  </span>
                  @if($service->beneficiaries)
                    <span class="activity-details-meta-item">
                      <i class="fa-solid fa-users"></i> {{ $service->beneficiaries }}
                    </span>
                  @endif
                  @if($service->location)
                    <span class="activity-details-meta-item">
                      <i class="fa-solid fa-location-dot"></i> {{ $service->location }}
                    </span>
                  @endif
                  <span class="activity-details-meta-item">
                    <i class="fa-solid fa-shield-halved"></i> {{ app()->getLocale() === 'en' ? 'Govt-Registered' : 'সরকার-নিবন্ধিত কার্যক্রম' }}
                  </span>
                </div>
              </header>

              <!-- Featured Media Figure -->
              <figure class="activity-details-figure">
                <img
                  src="{{ $service->image ? asset($service->image) : asset('2.jpeg') }}"
                  alt="{{ $service->title }}"
                  class="activity-details-img"
                  loading="eager">
                @if($service->short_description)
                  <figcaption class="activity-details-caption">
                    {{ $service->short_description }}
                  </figcaption>
                @endif
              </figure>

              <!-- Quick Impact Stat Grid -->
              <div class="activity-details-stats-grid">
                <div class="activity-details-stat-card">
                  <div class="activity-details-stat-icon"><i class="fa-solid fa-people-roof"></i></div>
                  <div class="activity-details-stat-value">{{ $service->beneficiaries ?? '২,৫০০+' }}</div>
                  <div class="activity-details-stat-label">{{ app()->getLocale() === 'en' ? 'Beneficiaries' : 'উপকৃত পরিবার' }}</div>
                </div>
                <div class="activity-details-stat-card">
                  <div class="activity-details-stat-icon"><i class="fa-solid fa-toolbox"></i></div>
                  <div class="activity-details-stat-value">৩,২০০+</div>
                  <div class="activity-details-stat-label">{{ app()->getLocale() === 'en' ? 'Items Distributed' : 'বিতরণকৃত উপকরণ' }}</div>
                </div>
                <div class="activity-details-stat-card">
                  <div class="activity-details-stat-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                  <div class="activity-details-stat-value">{{ $service->location ?? '২৫+ জেলা' }}</div>
                  <div class="activity-details-stat-label">{{ app()->getLocale() === 'en' ? 'Districts Covered' : 'প্রকল্পভুক্ত জেলা' }}</div>
                </div>
                <div class="activity-details-stat-card">
                  <div class="activity-details-stat-icon"><i class="fa-solid fa-chart-line"></i></div>
                  <div class="activity-details-stat-value">৯২%</div>
                  <div class="activity-details-stat-label">{{ app()->getLocale() === 'en' ? 'Success Rate' : 'স্বনির্ভরতার হার' }}</div>
                </div>
              </div>

              <!-- Article Body Content -->
              <div class="activity-details-body">
                {!! $service->description !!}
              </div>

            </article>
          </div>

          <!-- Right Column: Sidebar (4 Cols) -->
          <div class="col-lg-4 col-12">
            <aside class="activity-details-sidebar">

              <!-- Donation CTA Widget -->
              <div class="activity-sidebar-card activity-support-card">
                <span class="activity-support-badge">
                  <i class="fa-solid fa-hand-holding-heart"></i> {{ app()->getLocale() === 'en' ? 'Support This Project' : 'সহযোগিতা করুন' }}
                </span>
                <h3 class="activity-sidebar-title">{{ $service->title }}</h3>
                <p class="activity-support-desc">
                  {{ app()->getLocale() === 'en' ? 'Contribute to this noble project and be part of societal change.' : 'একটি সেলাই মেশিন বা ক্ষুদ্র পুঁজি দিয়ে একজন সহায়হীন মানুষকে সারাজীবনের জন্য আত্মনির্ভরশীল করে তুলুন।' }}
                </p>

                <div class="activity-support-progress-wrapper">
                  <div class="activity-support-progress-labels">
                    <span>{{ app()->getLocale() === 'en' ? 'Current Goal' : 'চলমান লক্ষ্যমাত্রা' }}</span>
                    <span>৭৬% {{ app()->getLocale() === 'en' ? 'Completed' : 'সম্পন্ন' }}</span>
                  </div>
                  <div class="activity-support-progress-bar">
                    <div class="activity-support-progress-fill" style="width: 76%;"></div>
                  </div>
                </div>

                <a href="{{ route('volunteer.index') }}" class="activity-support-btn">
                  <i class="fa-solid fa-hand-holding-heart"></i> {{ app()->getLocale() === 'en' ? 'Join / Contribute' : 'অনুদানে অংশ নিন' }}
                </a>
              </div>

              <!-- Other Ongoing Activities Widget -->
              <div class="activity-sidebar-card">
                <h3 class="activity-sidebar-title">{{ app()->getLocale() === 'en' ? 'Other Activities' : 'অন্যান্য চলমান কার্যক্রম' }}</h3>

                <div class="activity-related-list">
                  @forelse($relatedServices as $rel)
                    <a href="{{ route('activities.show', $rel->slug) }}" class="activity-related-item">
                      <div class="activity-related-thumb">
                        <img src="{{ $rel->image ? asset($rel->image) : asset('2.jpeg') }}" alt="{{ $rel->title }}" class="activity-related-thumb-img" loading="lazy">
                      </div>
                      <div class="activity-related-info">
                        <span class="activity-related-badge">{{ $rel->category ? ucfirst($rel->category) : 'কার্যক্রম' }}</span>
                        <h4 class="activity-related-item-title">{{ $rel->title }}</h4>
                      </div>
                    </a>
                  @empty
                    <p class="text-muted small">{{ app()->getLocale() === 'en' ? 'No other activities found.' : 'অন্য কোনো কার্যক্রম নেই।' }}</p>
                  @endforelse
                </div>
              </div>

            </aside>
          </div>

        </div>
      </div>
    </section>

@endsection
