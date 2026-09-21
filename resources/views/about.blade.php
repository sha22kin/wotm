@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'About Us - WOTM' : 'আমাদের সম্পর্কে - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/about-us.css?v=2.1') }}">
@endpush

@section('content')

    <!-- ======================================================================
         2. PAGE HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="about-hero-section" id="about-hero">
      <img src="{{ asset('images/hero.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="about-hero-bg-img">
      <div class="about-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="about-hero-pattern-img">

      <div class="container about-hero-container">
        <nav class="about-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="about-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="about-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="about-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'About Us' : 'আমাদের সম্পর্কে' }}</span>
        </nav>

        <h1 class="about-hero-title">{{ app()->getLocale() === 'en' ? 'About Us' : 'আমাদের সম্পর্কে' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         3. ORGANIZATION PROFILE & INTRO
         ====================================================================== -->
    <section class="about-intro-section" id="about-intro">
      <div class="container">
        <div class="row align-items-center g-5">
          <!-- Col 1: Text Overview -->
          <div class="col-lg-7 col-12">
            <div class="about-intro-text-wrapper">
              <span class="about-section-badge">
                <i class="fa-solid fa-circle-info"></i> {{ app()->getLocale() === 'en' ? 'Profile & Background' : 'পরিচিতি ও পটভূমি' }}
              </span>
              <h2 class="about-intro-heading">
                {{ app()->getLocale() === 'en' ? 'An Ideal Institution Dedicated to Human Welfare, Pure Education and Service' : 'মানবকল্যাণ, বিশুদ্ধ শিক্ষা ও সেবায় নিবেদিত একটি আদর্শ প্রতিষ্ঠান' }}
              </h2>
              <p class="about-intro-paragraph">
                {{ app()->getLocale() === 'en' 
                    ? App\Models\Setting::get('footer_about_en', 'WOTM is a non-political, non-profit education, dawah and human welfare organization.') 
                    : App\Models\Setting::get('footer_about_bn', 'WOTM একটি অরাজনৈতিক, অলাভজনক শিক্ষা, দাওয়াহ ও পূর্ণত মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান (নিবন্ধন নম্বর: ' . App\Models\Setting::get('site_reg_no', 'এস-১৩১১১/২০১৯') . ')।') }}
              </p>
              <p class="about-intro-paragraph">
                {{ app()->getLocale() === 'en' 
                    ? 'Following the footsteps of the Prophet Muhammad (PBUH), we strive tirelessly to build an ideal welfare society in the service of suffering humanity.' 
                    : 'এই প্রতিষ্ঠান মানবতার শিক্ষক, মানুষের মুক্তি ও শান্তির দূত, মানবসেবার আদর্শ, মহানবী মুহাম্মদ সা.-এর পদাঙ্ক অনুসরণ করে আর্তমানবতার সেবায় একটি আদর্শ কল্যাণসমাজ বিনির্মাণে যথাসক্তি প্রচেষ্টা চালিয়ে যাচ্ছে। সমাজের অসচ্ছল ও সুবিধাবঞ্চিত মানুষদের আত্মমর্যাদার সাথে বাঁচার স্বপ্ন পূরণে আমরা শিক্ষা, মানবিক সেবা ও দাওয়াহ কার্যক্রম একসাথে পরিচালনা করি।' }}
              </p>

              <ul class="about-intro-feature-list">
                <li class="about-intro-feature-item">
                  <div class="about-intro-check-icon"><i class="fa-solid fa-check"></i></div>
                  <span>{{ app()->getLocale() === 'en' ? '100% Non-political, Non-sectarian and Neutral Humanitarian Aid' : 'শতভাগ অরাজনৈতিক, অসাম্প্রদায়িক ও নিরপেক্ষ মানবিক সহায়তা' }}</span>
                </li>
                <li class="about-intro-feature-item">
                  <div class="about-intro-check-icon"><i class="fa-solid fa-check"></i></div>
                  <span>{{ app()->getLocale() === 'en' ? 'National Board of Revenue (NBR) Approved 100% Tax Exempted Organization' : 'জাতীয় রাজস্ব বোর্ড (NBR) অনুমোদিত শতভাগ কর রেয়াতযোগ্য প্রতিষ্ঠান' }}</span>
                </li>
                <li class="about-intro-feature-item">
                  <div class="about-intro-check-icon"><i class="fa-solid fa-check"></i></div>
                  <span>{{ app()->getLocale() === 'en' ? 'Regularly Audited with Full Transparency by Independent Chartered Accountant Firm' : 'স্বতন্ত্র চার্টার্ড অ্যাকাউন্টেন্ট ফার্ম দ্বারা সম্পূর্ণ স্বচ্ছতার সাথে অডিটকৃত' }}</span>
                </li>
              </ul>

              <div class="about-intro-btn-group">
                <a href="#about-philosophy" class="about-btn-solid">
                  <i class="fa-solid fa-bullseye"></i> {{ app()->getLocale() === 'en' ? 'Vision & Mission' : 'ভিশন ও মিশন' }}
                </a>
                <a href="{{ route('activities.index') }}" class="about-btn-outline">
                  <i class="fa-solid fa-handshake-angle"></i> {{ app()->getLocale() === 'en' ? 'Ongoing Activities' : 'চলমান কার্যক্রম' }}
                </a>
              </div>
            </div>
          </div>

          <!-- Col 2: Image Showcase -->
          <div class="col-lg-5 col-12">
            <div class="about-intro-image-container">
              <div class="about-intro-photo-card">
                <img src="{{ asset('logo.jpeg') }}" alt="WOTM অফিসিয়াল লোগো" class="about-intro-main-photo" loading="lazy">
                <div class="about-intro-floating-badge">
                  <div class="about-intro-badge-icon">
                    <i class="fa-solid fa-award"></i>
                  </div>
                  <div>
                    <div class="about-intro-badge-number">{{ app()->getLocale() === 'en' ? '7+ Years' : '৭+ বছর' }}</div>
                    <p class="about-intro-badge-label">{{ app()->getLocale() === 'en' ? 'Uninterrupted Service with Trust' : 'বিশ্বস্ততার সাথে নিরবচ্ছিন্ন মানবসেবা' }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         4. IMPACT METRICS / STATS COUNTER
         ====================================================================== -->
    <section class="about-stats-section" id="about-stats">
      <div class="container">
        <div class="row g-4">
          <!-- Stat 1 -->
          <div class="col-xl-3 col-md-6 col-12">
            <div class="about-stat-card">
              <div class="about-stat-icon-container">
                <i class="fa-solid fa-users"></i>
              </div>
              <div class="about-stat-number">{{ app()->getLocale() === 'en' ? '1 Million+' : '১০ লক্ষ+' }}</div>
              <h3 class="about-stat-title">{{ app()->getLocale() === 'en' ? 'Direct Beneficiaries' : 'সরাসরি উপকৃত মানুষ' }}</h3>
            </div>
          </div>

          <!-- Stat 2 -->
          <div class="col-xl-3 col-md-6 col-12">
            <div class="about-stat-card">
              <div class="about-stat-icon-container">
                <i class="fa-solid fa-list-check"></i>
              </div>
              <div class="about-stat-number">250+</div>
              <h3 class="about-stat-title">{{ app()->getLocale() === 'en' ? 'Projects Implemented' : 'সফল প্রকল্প বাস্তবায়ন' }}</h3>
            </div>
          </div>

          <!-- Stat 3 -->
          <div class="col-xl-3 col-md-6 col-12">
            <div class="about-stat-card">
              <div class="about-stat-icon-container">
                <i class="fa-solid fa-map-location-dot"></i>
              </div>
              <div class="about-stat-number">64</div>
              <h3 class="about-stat-title">{{ app()->getLocale() === 'en' ? 'Districts Covered' : 'জেলায় বিস্তার ও উপস্থিতি' }}</h3>
            </div>
          </div>

          <!-- Stat 4 -->
          <div class="col-xl-3 col-md-6 col-12">
            <div class="about-stat-card">
              <div class="about-stat-icon-container">
                <i class="fa-solid fa-hand-holding-heart"></i>
              </div>
              <div class="about-stat-number">{{ app()->getLocale() === 'en' ? '15,000+' : '১৫,০০০+' }}</div>
              <h3 class="about-stat-title">{{ app()->getLocale() === 'en' ? 'Dedicated Volunteers' : 'নিবেদিতপ্রাণ স্বেচ্ছাসেবক' }}</h3>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         5. PHILOSOPHY (VISION, MISSION, CORE VALUES)
         ====================================================================== -->
    <section class="about-philosophy-section" id="about-philosophy">
      <div class="container">
        <div class="about-section-header">
          <span class="about-section-badge">
            <i class="fa-solid fa-compass"></i> {{ app()->getLocale() === 'en' ? 'Our Philosophy' : 'আমাদের দর্শন' }}
          </span>
          <h2 class="about-section-title">{{ app()->getLocale() === 'en' ? 'Our Vision, Mission & Values' : 'আমাদের ভিশন, মিশন ও মূল্যবোধ' }}</h2>
          <p class="about-section-subtitle">
            {{ app()->getLocale() === 'en' ? 'Commitment to building a self-reliant and dignified society under the guidance of Sunnah' : 'সুন্নাহর পথনির্দেশনায় আত্মনির্ভরশীল ও মর্যাদাপূর্ণ আলোকিত সমাজ গঠনের প্রত্যয়' }}
          </p>
        </div>

        <div class="row g-4">
          <!-- Card 1: Vision -->
          <div class="col-lg-4 col-md-6 col-12">
            <div class="about-philosophy-card">
              <div class="about-philosophy-icon-box">
                <i class="fa-solid fa-eye"></i>
              </div>
              <h3 class="about-philosophy-title">{{ app()->getLocale() === 'en' ? 'Our Vision' : 'আমাদের ভিশন (Vision)' }}</h3>
              <p class="about-philosophy-desc">
                {{ app()->getLocale() === 'en' ? 'To build an enlightened society where every individual has access to moral education, human dignity and a poverty-free life.' : 'দ্বীনি মূল্যবোধ ও সুন্নাহর আলোকে এমন একটি সমৃদ্ধ ও আলোকিত সমাজ গড়ে তোলা, যেখানে প্রতিটি মানুষ বিশুদ্ধ ধর্মীয় শিক্ষা, মানবিক আত্মমর্যাদা এবং দারিদ্র্যমুক্ত অর্থনৈতিক জীবনযাপনের সুযোগ লাভ করবে।' }}
              </p>
            </div>
          </div>

          <!-- Card 2: Mission -->
          <div class="col-lg-4 col-md-6 col-12">
            <div class="about-philosophy-card">
              <div class="about-philosophy-icon-box">
                <i class="fa-solid fa-bullseye"></i>
              </div>
              <h3 class="about-philosophy-title">{{ app()->getLocale() === 'en' ? 'Our Mission' : 'আমাদের মিশন (Mission)' }}</h3>
              <p class="about-philosophy-desc">
                {{ app()->getLocale() === 'en' ? 'Disseminating ethical and modern education, delivering emergency relief, eradicating poverty via sustainable livelihoods and authentic dawah.' : 'সুবিধাবঞ্চিত মানুষের মাঝে নৈতিক ও আধুনিক শিক্ষা বিস্তার, প্রাকৃতিক দুর্যোগে দ্রুততম সময়ে মানবিক ত্রাণ পৌঁছানো, কর্মসংস্থান সৃষ্টির মাধ্যমে দারিদ্র্য দূরীকরণ এবং সমাজ সংস্কারে সহীহ দাওয়াহ পরিচালনা।' }}
              </p>
            </div>
          </div>

          <!-- Card 3: Core Values -->
          <div class="col-lg-4 col-md-12 col-12">
            <div class="about-philosophy-card">
              <div class="about-philosophy-icon-box">
                <i class="fa-solid fa-scale-balanced"></i>
              </div>
              <h3 class="about-philosophy-title">{{ app()->getLocale() === 'en' ? 'Core Values' : 'আমাদের মূলনীতি (Core Values)' }}</h3>
              <p class="about-philosophy-desc">
                {{ app()->getLocale() === 'en' ? 'Purity of intention (Ikhlas), 100% protection of trust (Amanah), steadfast following of Sunnah, and utmost respect for every human being.' : 'ইখলাস ও নিয়তের বিশুদ্ধতা, আমানতের শতভাগ সুরক্ষা, সুন্নাহর অবিচল অনুসরণ, মেধা ও আধুনিক ব্যবস্থাপনার সমন্বয় এবং ধর্ম-বর্ণ নির্বিশেষে প্রতিটি মানুষের প্রতি সর্বোচ্চ সম্মান প্রদর্শন।' }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         6. THREE CORE PILLARS SECTION
         ====================================================================== -->
    <section class="about-pillars-section" id="about-pillars">
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="about-pillars-pattern-img">
      <div class="container about-pillars-container">
        <div class="about-section-header">
          <span class="about-pillars-badge">
            <i class="fa-solid fa-shapes"></i> {{ app()->getLocale() === 'en' ? 'Foundations' : 'ভিত্তিপ্রস্তর' }}
          </span>
          <h2 class="about-pillars-title">{{ app()->getLocale() === 'en' ? '3 Core Pillars of Our Work' : 'আমাদের কার্যক্রমের ৩টি মূল স্তম্ভ' }}</h2>
          <p class="about-pillars-subtitle">
            {{ app()->getLocale() === 'en' ? 'Education, Service and Dawah — WOTM works in these three integrated dimensions' : 'শিক্ষা, সেবা এবং দাওয়াহ — এই ত্রিমুখী সমন্বিত প্রয়াসে মানবতার কল্যাণে কাজ করছে WOTM' }}
          </p>
        </div>

        <div class="row g-4">
          <!-- Pillar 1: Education -->
          <div class="col-lg-4 col-md-6 col-12">
            <div class="about-pillar-feature-card">
              <div class="about-pillar-icon-symbol">
                <i class="fa-solid fa-graduation-cap"></i>
              </div>
              <h3 class="about-pillar-card-title">{{ app()->getLocale() === 'en' ? '1. Education' : '১. শিক্ষা কার্যক্রম' }}</h3>
              <p class="about-pillar-card-text">
                {{ app()->getLocale() === 'en' ? 'Educational institutions and scholarship programs aimed at building ideal citizens with moral character.' : 'দ্বীনি ও সাধারণ শিক্ষার সমন্বিত সিলেবাসের মাধ্যমে সুনাগরিক ও নৈতিকতাসম্পন্ন আদর্শ মানুষ গড়ার লক্ষ্যে পরিচালিত শিক্ষা প্রতিষ্ঠান ও সহায়তা প্রকল্প।' }}
              </p>
              <ul class="about-pillar-list">
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Integrated madrasah curriculum' : 'সমন্বিত সিলেবাসের মাদরাসা পরিচালনা' }}</li>
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Scholarships for meritorious students' : 'অসচ্ছল মেধাবীদের শিক্ষাবৃত্তি প্রদান' }}</li>
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Technical and vocational training' : 'কারিগরি ও বৃত্তিমূলক দক্ষতা প্রশিক্ষণ' }}</li>
              </ul>
            </div>
          </div>

          <!-- Pillar 2: Service -->
          <div class="col-lg-4 col-md-6 col-12">
            <div class="about-pillar-feature-card">
              <div class="about-pillar-icon-symbol">
                <i class="fa-solid fa-hands-holding-child"></i>
              </div>
              <h3 class="about-pillar-card-title">{{ app()->getLocale() === 'en' ? '2. Service & Rehabilitation' : '২. সেবা ও পুনর্বাসন' }}</h3>
              <p class="about-pillar-card-text">
                {{ app()->getLocale() === 'en' ? 'From immediate disaster relief to long-term economic self-reliance for vulnerable families.' : 'জরুরি দুর্যোগে তাৎক্ষণিক ত্রাণ সরবরাহ থেকে শুরু করে অসহায় পরিবারের দীর্ঘমেয়াদী অর্থনৈতিক স্বাবলম্বীকরণ নিশ্চিত করার লক্ষ্যে পরিচালিত সেবা।' }}
              </p>
              <ul class="about-pillar-list">
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Livelihood materials for unemployed' : 'কর্মক্ষমদের স্বাবলম্বীকরণ সামগ্রী প্রদান' }}</li>
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Deep tube-wells & water plants' : 'বিশুদ্ধ পানির গভীর নলকূপ ও প্ল্যান্ট স্থাপন' }}</li>
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Disaster relief, winter clothes & Qurbani' : 'দুর্যোগে জরুরি ত্রাণ, শীতবস্ত্র ও কুরবানী বিতরণ' }}</li>
              </ul>
            </div>
          </div>

          <!-- Pillar 3: Dawah -->
          <div class="col-lg-4 col-md-12 col-12">
            <div class="about-pillar-feature-card">
              <div class="about-pillar-icon-symbol">
                <i class="fa-solid fa-book-quran"></i>
              </div>
              <h3 class="about-pillar-card-title">{{ app()->getLocale() === 'en' ? '3. Dawah & Research' : '৩. দাওয়াহ ও গবেষণা' }}</h3>
              <p class="about-pillar-card-text">
                {{ app()->getLocale() === 'en' ? 'Spreading authentic Sunnah knowledge to build religious consciousness and eliminate superstitions.' : 'সহীহ সুন্নাহর বিশুদ্ধ জ্ঞান ছড়িয়ে দিয়ে সমাজকে কুসংস্কারমুক্ত করা এবং সাধারণ মানুষের মাঝে প্রকৃত দ্বীনি সচেতনতা গড়ে তোলার উদ্যোগ।' }}
              </p>
              <ul class="about-pillar-list">
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Imam and scholar training workshops' : 'আলেম ও ইমাম প্রশিক্ষণ কর্মশালা' }}</li>
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Research-backed Islamic publications' : 'গবেষণাধর্মী ইসলামিক গ্রন্থ প্রকাশনা' }}</li>
                <li class="about-pillar-list-entry"><i class="fa-solid fa-circle-check"></i> {{ app()->getLocale() === 'en' ? 'Public symposia & digital dawah' : 'উন্মুক্ত আলোচনা সভা ও ডিজিটাল দাওয়াহ' }}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         7. TRANSPARENCY, AUDIT & TAX REBATE
         ====================================================================== -->
    <section class="about-transparency-section" id="about-transparency">
      <div class="container">
        <div class="row g-5 align-items-stretch">
          <!-- Col 1: Audit & Transparency -->
          <div class="col-lg-6 col-12">
            <div class="about-transparency-card">
              <span class="about-transparency-badge">
                <i class="fa-solid fa-shield-halved"></i> {{ app()->getLocale() === 'en' ? 'Financial Transparency' : 'আর্থিক স্বচ্ছতা' }}
              </span>
              <h2 class="about-transparency-title">{{ app()->getLocale() === 'en' ? '100% Transparency & Accountability' : 'শতভাগ স্বচ্ছতা ও দায়িত্বশীলতা' }}</h2>
              <p class="about-transparency-desc">
                {{ app()->getLocale() === 'en' ? 'Every donation and expenditure in WOTM is tracked digitally with rigorous standards to prevent waste and ensure maximum impact.' : 'WOTM-এ প্রতিটি দান ও ব্যয়ের হিসাব অত্যন্ত নিখুঁত ও ডিজিটালভাবে সংরক্ষিত। কোনো প্রকার অপচয় রোধে আমরা অভ্যন্তরীণ ও আন্তর্জাতিক মানের আর্থিক নিরীক্ষা নিশ্চিত করি।' }}
              </p>
              <ul class="about-audit-checklist">
                <li class="about-audit-check-item">
                  <div class="about-audit-icon-box"><i class="fa-solid fa-check"></i></div>
                  <span>{{ app()->getLocale() === 'en' ? 'Regular annual audit by leading Chartered Accountant (CA) firms.' : 'দেশের শীর্ষস্থানীয় ও নিবন্ধিত চার্টার্ড অ্যাকাউন্ট্যান্ট (CA) ফার্ম দ্বারা নিয়মিত বার্ষিক অডিট।' }}</span>
                </li>
                <li class="about-audit-check-item">
                  <div class="about-audit-icon-box"><i class="fa-solid fa-check"></i></div>
                  <span>{{ app()->getLocale() === 'en' ? 'Direct bank deposits with instantaneous digital money receipts.' : 'অনুদানের অর্থ সরাসরি প্রকল্পের ব্যাংক হিসাবে জমা এবং ডিজিটাল মানি রিসিট প্রদান।' }}</span>
                </li>
                <li class="about-audit-check-item">
                  <div class="about-audit-icon-box"><i class="fa-solid fa-check"></i></div>
                  <span>{{ app()->getLocale() === 'en' ? 'Public release of annual comprehensive financial reports.' : 'সাধারণ দাতা ও শুভানুধ্যায়ীদের জন্য বার্ষিক পূর্ণাঙ্গ রিপোর্ট ও হিসাব উন্মুক্ত রাখা।' }}</span>
                </li>
              </ul>
            </div>
          </div>

          <!-- Col 2: Tax Rebate Benefits -->
          <div class="col-lg-6 col-12">
            <div class="about-tax-card">
              <img src="{{ asset('images/patterns/gold-pattern.svg') }}" alt="প্যাটার্ন" class="about-tax-pattern-img">
              <div class="about-tax-content">
                <span class="about-tax-badge">
                  <i class="fa-solid fa-certificate"></i> {{ app()->getLocale() === 'en' ? 'NBR Gazetted' : 'এনবিআর প্রজ্ঞাপন' }}
                </span>
                <h2 class="about-tax-title">{{ app()->getLocale() === 'en' ? '100% Tax Exemption' : 'শতভাগ কর রেয়াত সুবিধা (Tax Exemption)' }}</h2>
                <p class="about-tax-text">
                  {{ app()->getLocale() === 'en' ? 'According to NBR notifications, any individual or corporate donation to WOTM is 100% tax exempted under Section 44(2)(b) of the Income Tax Ordinance.' : 'জাতীয় রাজস্ব বোর্ড (NBR) এর প্রজ্ঞাপন অনুযায়ী WOTM একটি সরকার-নিবন্ধিত অনুমোদিত মানবকল্যাণ সংস্থা। এই সংস্থায় যেকোনো ব্যক্তি বা প্রাতিষ্ঠানিক দান আয়কর অধ্যাদেশ ১৯৮৪ এর ধারা ৪৪(২)(খ) অনুযায়ী শতভাগ কর রেয়াতযোগ্য।' }}
                </p>
                <div class="about-tax-notice-box">
                  <h4 class="about-tax-notice-title">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ app()->getLocale() === 'en' ? 'Reg No: ' : 'নিবন্ধন নম্বর: ' }}{{ App\Models\Setting::get('site_reg_no', 'এস-১৩১১১/২০১৯') }}
                  </h4>
                  <p class="about-tax-notice-text">
                    {{ app()->getLocale() === 'en' ? 'A verified digital e-receipt is issued for every donation, valid for tax returns.' : 'প্রতিটি আর্থিক অনুদানের সাথে বৈধ ডিজিটাল ই-রসিদ তাৎক্ষণিক প্রদান করা হয়, যা আপনার আয়কর নথিতে শতভাগ গ্রহণযোগ্য।' }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         8. CALL TO ACTION (CTA) SECTION
         ====================================================================== -->
    <section class="about-cta-section" id="about-cta">
      <div class="container">
        <div class="about-cta-container-card">
          <img src="{{ asset('images/patterns/gold-pattern.svg') }}" alt="প্যাটার্ন" class="about-cta-pattern-img">
          <div class="about-cta-content">
            <h2 class="about-cta-headline">{{ app()->getLocale() === 'en' ? 'You Too Can Be Part of This Noble Journey' : 'আপনিও হতে পারেন এই মহৎ কাফেলার অংশীদার' }}</h2>
            <p class="about-cta-subtext">
              {{ app()->getLocale() === 'en' ? 'Your contribution can bring smiles to vulnerable faces and become everlasting reward. Join us in serving humanity.' : 'আপনার সামান্য সহযোগিতা একজন অসহায় মানুষের মুখে হাসি ফোটাতে পারে এবং পরকালের অনন্ত পাথেয় হতে পারে। যুক্ত হোন আর্তমানবতার সেবায়।' }}
            </p>
            <div class="about-cta-btn-group">
              <a href="{{ route('volunteer.index') }}" class="about-cta-btn-primary">
                <i class="fa-solid fa-user-plus"></i> {{ app()->getLocale() === 'en' ? 'Join as Volunteer' : 'স্বেচ্ছাসেবক হিসেবে যুক্ত হোন' }}
              </a>
              <a href="{{ route('home') }}#funds" class="about-cta-btn-secondary">
                <i class="fa-solid fa-hand-holding-heart"></i> {{ app()->getLocale() === 'en' ? 'Donate to Funds' : 'তহবিলে অনুদান দিন' }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
