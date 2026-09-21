@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? App\Models\Setting::get('seo_meta_title', 'WOTM | উম্মাহর স্বার্থে, সুন্নাহর সাথে'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@section('content')

    <!-- ======================================================================
         2. HERO SECTION
         ====================================================================== -->
    <section class="hero-sec" id="home">
      <img src="{{ asset('images/hero2.webp') }}" alt="Hero Background" class="hero-bg-img">
      <div class="hero-overlay"></div>
      <div class="hero-pattern">
        <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="Islamic Pattern" class="hero-pattern-img">
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-9 col-12">
            <div class="hero-content">
              <h1 class="hero-title">{{ App\Models\Setting::get('site_name', 'WOTM') }}</h1>
              <div class="hero-tagline">{{ App\Models\Setting::get('site_tagline', 'উম্মাহর স্বার্থে, সুন্নাহর সাথে') }}</div>
              <p class="hero-desc">
                {{ app()->getLocale() === 'en' 
                    ? App\Models\Setting::get('footer_about_en', 'WOTM is a non-political, non-profit education, dawah and human welfare organization.') 
                    : App\Models\Setting::get('footer_about_bn', 'WOTM একটি অরাজনৈতিক, অলাভজনক শিক্ষা, দাওয়াহ ও পূর্ণত মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান। নিবন্ধন নম্বর: ' . App\Models\Setting::get('site_reg_no', 'এস-১৩১১১/২০১৯')) }}
              </p>
              <div class="hero-btn-group">
                <a href="{{ route('about') }}" class="btn-hero-solid">{{ app()->getLocale() === 'en' ? 'Learn More' : 'আরও জানুন' }}</a>
                <a href="{{ route('activities.index') }}" class="btn-hero-outline">{{ app()->getLocale() === 'en' ? 'Activities' : 'কার্যক্রমসমূহ' }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         3. FLOATING VOLUNTEER BOX
         ====================================================================== -->
    <section class="donation-panel-wrapper" id="volunteer">
      <div class="container">
        <div class="donation-panel-card">
          <img src="{{ asset('images/patterns/gold-pattern.svg') }}" alt="Gold Pattern" class="donation-pattern-img">
          <div class="donation-card-content">
            <h2 class="donation-panel-title">{{ app()->getLocale() === 'en' ? 'Join as a Volunteer' : 'স্বেচ্ছাসেবক হিসেবে যুক্ত হোন' }}</h2>

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form id="volunteerForm" action="{{ route('volunteer.store') }}" method="POST">
              @csrf
              <div class="row g-3 align-items-end">
                <!-- Name -->
                <div class="col-lg-3 col-md-6 col-12">
                  <div class="donation-field-group">
                    <label for="volName" class="donation-field-label">
                      {{ app()->getLocale() === 'en' ? 'Your Name' : 'আপনার নাম' }} <span class="req">*</span>
                    </label>
                    <input type="text" name="full_name" class="donation-input-field" id="volName" placeholder="{{ app()->getLocale() === 'en' ? 'Enter your name' : 'আপনার নাম লিখুন' }}" required>
                  </div>
                </div>

                <!-- Phone / Email -->
                <div class="col-lg-3 col-md-6 col-12">
                  <div class="donation-field-group">
                    <label for="volContact" class="donation-field-label">
                      {{ app()->getLocale() === 'en' ? 'Mobile / Email' : 'মোবাইল / ইমেইল' }} <span class="req">*</span>
                    </label>
                    <input type="text" name="phone" class="donation-input-field" id="volContact" placeholder="{{ app()->getLocale() === 'en' ? 'Phone or email' : 'মোবাইল নম্বর / ইমেইল' }}" required>
                  </div>
                </div>

                <!-- Area / Interest -->
                <div class="col-lg-3 col-md-6 col-12">
                  <div class="donation-field-group">
                    <label for="volArea" class="donation-field-label">
                      {{ app()->getLocale() === 'en' ? 'Area of Interest' : 'আগ্রহের ক্ষেত্র' }} <span class="req">*</span>
                    </label>
                    <div class="donation-select-container">
                      <select name="area_of_interest" class="donation-input-field donation-select-input" id="volArea" required>
                        <option value="" selected disabled>{{ app()->getLocale() === 'en' ? 'Select One' : 'নির্বাচন করুন' }}</option>
                        <option value="education">{{ app()->getLocale() === 'en' ? 'Education & Dawah' : 'শিক্ষা কার্যক্রম' }}</option>
                        <option value="relief">{{ app()->getLocale() === 'en' ? 'Relief & Rehabilitation' : 'ত্রাণ ও পুনর্বাসন' }}</option>
                        <option value="dawah">{{ app()->getLocale() === 'en' ? 'Dawah Programs' : 'দাওয়াহ কার্যক্রম' }}</option>
                        <option value="it">{{ app()->getLocale() === 'en' ? 'IT & Media' : 'আইটি ও মিডিয়া' }}</option>
                      </select>
                      <i class="fa-solid fa-chevron-down custom-select-icon"></i>
                    </div>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="col-lg-3 col-md-6 col-12">
                  <button type="submit" class="donation-submit-btn" id="volSubmitBtn">
                    <i class="fa-solid fa-user-plus"></i> {{ app()->getLocale() === 'en' ? 'Join Now' : 'যুক্ত হোন' }}
                  </button>
                </div>
              </div>
            </form>

            <p class="donation-panel-tax-notice">
              {{ app()->getLocale() === 'en' ? 'Join us in serving humanity and contribute to societal change.' : 'মানবতার সেবায় আমাদের সাথে যুক্ত হয়ে সমাজ পরিবর্তনে ভূমিকা রাখুন।' }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         4. INTRO / 3 CORE PILLARS SECTION
         ====================================================================== -->
    <section class="intro-sec" id="about">
      <div class="container">
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'In the Interest of Ummah, with Sunnah' : 'উম্মাহর স্বার্থে, সুন্নাহর সাথে' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Our tireless journey to build an enlightened society combining human welfare, education and dawah.' : 'মানবসেবা, শিক্ষা এবং দাওয়াহর সমন্বয়ে একটি আলোকিত সমাজ বিনির্মাণের লক্ষ্যে আমাদের নিরলস পদযাত্রা' }}</p>

        <div class="row g-4 mt-2">
          <!-- Pillar 1: Education -->
          <div class="col-lg-4 col-md-4 col-12">
            <div class="pillar-col">
              <div class="pillar-icon-container">
                <i class="fa-solid fa-graduation-cap"></i>
              </div>
              <h3 class="pillar-title">{{ app()->getLocale() === 'en' ? 'Education' : 'শিক্ষা' }}</h3>
              <p class="pillar-desc">
                {{ app()->getLocale() === 'en' ? 'Establishing integrated madrasahs, general colleges and vocational institutions along with informal learning.' : 'দ্বীনি ও সাধারণ শিক্ষার সমন্বিত সিলেবাসের মাদ্রাসা প্রতিষ্ঠা; স্কুল, কলেজ ও বিশ্ববিদ্যালয়সহ বিভিন্ন সাধারণ ও কারিগরি বিদ্যালয় প্রতিষ্ঠা; এছাড়া অপ্রতিষ্ঠানিক শিক্ষার উদ্যোগ গ্রহণ।' }}
              </p>
            </div>
          </div>

          <!-- Pillar 2: Service -->
          <div class="col-lg-4 col-md-4 col-12">
            <div class="pillar-col">
              <div class="pillar-icon-container">
                <i class="fa-solid fa-hands-holding-child"></i>
              </div>
              <h3 class="pillar-title">{{ app()->getLocale() === 'en' ? 'Service' : 'সেবা' }}</h3>
              <p class="pillar-desc">
                {{ app()->getLocale() === 'en' ? 'Empowerment for poor, flood relief, clean water plants, winter clothing, iftar distribution and qurbani projects.' : 'দরিদ্রদের স্বাবলম্বীকরণ, বন্যার্তদের ত্রাণ ও পুনর্বাসন, নলকূপ ও পানি শোধনাগার স্থাপন, বৃক্ষরোপণ, শীতবস্ত্র বিতরণ, ইফতার বিতরণ, সবার জন্য কুরবানীসহ বিভিন্ন সেবামূলক কার্যক্রম।' }}
              </p>
            </div>
          </div>

          <!-- Pillar 3: Dawah -->
          <div class="col-lg-4 col-md-4 col-12">
            <div class="pillar-col">
              <div class="pillar-icon-container">
                <i class="fa-solid fa-book-quran"></i>
              </div>
              <h3 class="pillar-title">{{ app()->getLocale() === 'en' ? 'Dawah' : 'দাওয়াহ' }}</h3>
              <p class="pillar-desc">
                {{ app()->getLocale() === 'en' ? 'Writing & publishing books, mosque-based study circles, dawah training workshops and nationwide conferences.' : 'বই-পুস্তক রচনা ও প্রকাশনা, মসজিদ ও অডিটোরিয়ামভিত্তিক দ্বীনি হালাকাহ, দাওয়াহ বিষয়ক প্রশিক্ষণ ও কর্মশালাসহ অনলাইন-অফলাইনভিত্তিক বহুমুখী কার্যক্রম পরিচালনা।' }}
              </p>
            </div>
          </div>
        </div>

        <div class="text-center-wrapper">
          <a href="{{ route('about') }}" class="btn-more">
            {{ app()->getLocale() === 'en' ? 'Learn more about us' : 'আমাদের সম্পর্কে আরও জানুন' }} <i class="fa-solid fa-arrow-right-long ms-2"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         5. ONGOING PROJECTS / ACTIVITIES SECTION
         ====================================================================== -->
    <section class="projects-sec" id="projects">
      <div class="container">
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'Ongoing Activities' : 'চলমান কার্যক্রমসমূহ' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Active social welfare initiatives of WOTM for the underprivileged' : 'সুবিধাবঞ্চিত মানুষের কল্যাণে WOTMের সক্রিয় সামাজিক উদ্যোগ' }}</p>

        <div class="slider-ctrl-wrapper">
          <button type="button" class="ctrl-btn prev" id="projPrev" aria-label="{{ app()->getLocale() === 'en' ? 'Previous Activity' : 'পূর্ববর্তী কার্যক্রম' }}">
            <i class="fa-solid fa-chevron-left"></i>
          </button>
          
          <div class="proj-slider-viewport" id="projSliderViewport">
            <div class="proj-slider-track" id="projectCardsContainer">
              @forelse($services as $service)
                <div class="proj-slide">
                  <article class="project-card">
                    <div class="project-img-wrapper">
                      <img src="{{ $service->image ? asset($service->image) : asset('10.jpeg') }}" alt="{{ $service->title }}" class="project-img" loading="lazy">
                      <span class="proj-badge">
                        <i class="fa-solid fa-rocket"></i> {{ $service->category ? ucfirst($service->category) : (app()->getLocale() === 'en' ? 'Regular Project' : 'নিয়মিত কার্যক্রম') }}
                      </span>
                    </div>
                    <div class="project-body">
                      <h3 class="project-title">{{ $service->title }}</h3>
                      <p class="project-desc">{{ $service->short_description ?? Str::limit(strip_tags($service->description), 110) }}</p>
                      <div class="project-card-bottom">
                        <a href="{{ route('activities.show', $service->slug) }}" class="btn-outline-green">
                          {{ app()->getLocale() === 'en' ? 'View Details' : 'বিস্তারিত দেখুন' }} <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                      </div>
                    </div>
                  </article>
                </div>
              @empty
                <!-- Fallback Default Items -->
                <div class="proj-slide">
                  <article class="project-card">
                    <div class="project-img-wrapper">
                      <img src="{{ asset('10.jpeg') }}" alt="স্বাবলম্বীকরণ কার্যক্রম" class="project-img" loading="lazy">
                      <span class="proj-badge"><i class="fa-solid fa-rocket"></i> নিয়মিত কার্যক্রম</span>
                    </div>
                    <div class="project-body">
                      <h3 class="project-title">স্বাবলম্বীকরণ</h3>
                      <p class="project-desc">এই কার্যক্রমের আওতায় কর্মক্ষম দরিদ্রদের উপার্জন উপকরণ দেয়া হয়। যাতে তারা নিজ পায়ে দাঁড়িয়ে সচ্ছল জীবনযাপন করতে পারেন।</p>
                      <div class="project-card-bottom">
                        <a href="{{ route('activities.index') }}" class="btn-outline-green">বিস্তারিত দেখুন <i class="fa-solid fa-arrow-right ms-1"></i></a>
                      </div>
                    </div>
                  </article>
                </div>
                <div class="proj-slide">
                  <article class="project-card">
                    <div class="project-img-wrapper">
                      <img src="{{ asset('3.jpeg') }}" alt="মেধাবী কার্যক্রম" class="project-img" loading="lazy">
                      <span class="proj-badge"><i class="fa-solid fa-rocket"></i> নিয়মিত কার্যক্রম</span>
                    </div>
                    <div class="project-body">
                      <h3 class="project-title">মেধাবী কার্যক্রম</h3>
                      <p class="project-desc">সৎ, দক্ষ ও মানবিক মূল্যবোধসম্পন্ন প্রজন্ম বিনির্মাণের প্রয়াস। আর্থিক অনটনে থাকা মেধাবী শিক্ষার্থীদের ভবিষ্যৎ গঠনে নিয়মিত শিক্ষাবৃত্তি।</p>
                      <div class="project-card-bottom">
                        <a href="{{ route('activities.index') }}" class="btn-outline-green">বিস্তারিত দেখুন <i class="fa-solid fa-arrow-right ms-1"></i></a>
                      </div>
                    </div>
                  </article>
                </div>
                <div class="proj-slide">
                  <article class="project-card">
                    <div class="project-img-wrapper">
                      <img src="{{ asset('2.jpeg') }}" alt="দাওয়াহ কার্যক্রম" class="project-img" loading="lazy">
                      <span class="proj-badge"><i class="fa-solid fa-rocket"></i> নিয়মিত কার্যক্রম</span>
                    </div>
                    <div class="project-body">
                      <h3 class="project-title">দাওয়াহ কার্যক্রম</h3>
                      <p class="project-desc">বিশুদ্ধ জ্ঞান ছড়িয়ে দিয়ে ইসলামী চেতনায় উজ্জীবিত করতে WOTMের দাওয়াহমূলক উদ্যোগ ও দেশব্যাপী আলেম সম্মেলন।</p>
                      <div class="project-card-bottom">
                        <a href="{{ route('activities.index') }}" class="btn-outline-green">বিস্তারিত দেখুন <i class="fa-solid fa-arrow-right ms-1"></i></a>
                      </div>
                    </div>
                  </article>
                </div>
              @endforelse
            </div>
          </div>

          <button type="button" class="ctrl-btn next" id="projNext" aria-label="{{ app()->getLocale() === 'en' ? 'Next Activity' : 'পরবর্তী কার্যক্রম' }}">
            <i class="fa-solid fa-chevron-right"></i>
          </button>
        </div>

        <!-- Slider Pagination Dots -->
        <div class="proj-dots-container" id="projDotsContainer"></div>

        <div class="text-center-wrapper">
          <a href="{{ route('activities.index') }}" class="btn-more">
            {{ app()->getLocale() === 'en' ? 'All Activities' : 'কার্যক্রমসমূহ' }} <i class="fa-solid fa-arrow-right-long ms-2"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         6. DONATION FUNDS SECTION
         ====================================================================== -->
    <section class="funds-sec" id="funds">
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="Islamic Pattern" class="funds-pattern-img">
      <div class="container funds-content-wrapper">
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'Donation Funds' : 'অনুদান তহবিলসমূহ' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Let us bring change together' : 'চলুন একসাথে পরিবর্তন আনি' }}</p>

        <div class="row g-4">
          <!-- Fund 1 -->
          <div class="col-lg-4 col-md-6 col-12">
            <article class="fund-card">
              <div class="fund-img-wrapper">
                <img src="{{ asset('images/donation/donate1.jpg') }}" alt="যাকাত তহবিল" class="fund-img" loading="lazy">
              </div>
              <div class="fund-body">
                <h3 class="fund-title">{{ app()->getLocale() === 'en' ? 'Zakat Fund' : 'যাকাত তহবিল' }}</h3>
                <p class="fund-desc">
                  {{ app()->getLocale() === 'en' ? 'Zakat is a fundamental pillar of Islam and a social safety net to eradicate poverty.' : 'যাকাত একদিকে যেমন ইসলামের অন্যতম মৌলিক স্তম্ভ, তেমনই এটি একটি মানবিক ইবাদত। যাকাত অর্থনৈতিক বৈষম্য দূর করতে সব থেকে বড় ভূমিকা পালন করে।' }}
                </p>
                <button type="button" class="btn-solid-green quick-fund-btn" data-fund="zakat" data-fund-name="{{ app()->getLocale() === 'en' ? 'Zakat Fund' : 'যাকাত তহবিল' }}">
                  <i class="fa-solid fa-hand-holding-heart me-1"></i> {{ app()->getLocale() === 'en' ? 'Donate' : 'দান করুন' }}
                </button>
              </div>
            </article>
          </div>

          <!-- Fund 2 -->
          <div class="col-lg-4 col-md-6 col-12">
            <article class="fund-card">
              <div class="fund-img-wrapper">
                <img src="{{ asset('images/donation/donate2.jpg') }}" alt="দক্ষতা উন্নয়ন ইনস্টিটিউট" class="fund-img" loading="lazy">
              </div>
              <div class="fund-body">
                <h3 class="fund-title">{{ app()->getLocale() === 'en' ? 'Skill Development Institute' : 'দক্ষতা উন্নয়ন ইনস্টিটিউট' }}</h3>
                <p class="fund-desc">
                  {{ app()->getLocale() === 'en' ? 'Vocational training and technical expertise development for unemployed youth to build self-reliance.' : 'আস-সুন্নাহ স্কিল ডেভেলপমেন্ট ইনস্টিটিউট WOTMএর একটি অঙ্গ প্রতিষ্ঠান, যা ২০২২ সালে প্রতিষ্ঠিত হয়েছে। এটি জাতীয় দক্ষতা উন্নয়ন কর্তৃপক্ষ কর্তৃক নিবন্ধিত।' }}
                </p>
                <button type="button" class="btn-solid-green quick-fund-btn" data-fund="skill" data-fund-name="{{ app()->getLocale() === 'en' ? 'Skill Institute' : 'দক্ষতা উন্নয়ন ইনস্টিটিউট' }}">
                  <i class="fa-solid fa-hand-holding-heart me-1"></i> {{ app()->getLocale() === 'en' ? 'Donate' : 'দান করুন' }}
                </button>
              </div>
            </article>
          </div>

          <!-- Fund 3 -->
          <div class="col-lg-4 col-md-6 col-12">
            <article class="fund-card">
              <div class="fund-img-wrapper">
                <img src="{{ asset('images/donation/donate3.jpg') }}" alt="WOTM মসজিদ কমপ্লেক্স" class="fund-img" loading="lazy">
              </div>
              <div class="fund-body">
                <h3 class="fund-title">{{ app()->getLocale() === 'en' ? 'Mosque Complex & Islamic Center' : 'WOTM মসজিদ কমপ্লেক্স ও ইসলামিক সেন্টার' }}</h3>
                <p class="fund-desc">
                  {{ app()->getLocale() === 'en' ? 'The hub for all educational, spiritual, and community initiatives with modern Islamic facilities.' : 'দেশ, জাতি ও উম্মাহর কল্যাণার্থে পরিচালিত WOTMের নানামুখী কার্যক্রমের কেন্দ্রবিন্দু হবে WOTM মসজিদ কমপ্লেক্স। এই কমপ্লেক্সে একটি আধুনিক দ্বীনি পরিবেশ গড়া হচ্ছে।' }}
                </p>
                <button type="button" class="btn-solid-green quick-fund-btn" data-fund="mosque" data-fund-name="{{ app()->getLocale() === 'en' ? 'Mosque Complex' : 'মসজিদ কমপ্লেক্স ও ইসলামিক সেন্টার' }}">
                  <i class="fa-solid fa-hand-holding-heart me-1"></i> {{ app()->getLocale() === 'en' ? 'Donate' : 'দান করুন' }}
                </button>
              </div>
            </article>
          </div>
        </div>

        <div class="text-center-wrapper">
          <a href="{{ route('volunteer.index') }}" class="btn-more">
            {{ app()->getLocale() === 'en' ? 'All Funds' : 'তহবিলসমূহ' }} <i class="fa-solid fa-arrow-right-long ms-2"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         7. VIDEO SECTION
         ====================================================================== -->
    <section class="video-sec">
      <div class="container">
        <span class="sec-pill">{{ app()->getLocale() === 'en' ? 'Video' : 'ভিডিও' }}</span>
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'Videos About Our Activities' : 'আমাদের কার্যক্রম সম্পর্কে ভিডিও' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Watch documentary footage of WOTM field operations' : 'ভিডিও চিত্রে WOTMের মাঠপর্যায়ের কার্যক্রম ও অনুদানের যথাযথ ব্যবহার দেখুন' }}</p>

        <div class="video-container" id="videoTrigger" role="button" aria-label="ভিডিওটি চালু করুন" data-video-url="https://www.youtube.com/embed/dQw4w9WgXcQ">
          <img src="{{ asset('WhatsApp Image 2026-09-07 at 12.06.17 PM.jpeg') }}" alt="WOTM কার্যক্রমের ভিডিও চিত্র" class="video-thumb" loading="lazy">
          <div class="video-overlay">
            <div class="video-play-btn">
              <i class="fa-solid fa-play"></i>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         8. GET INVOLVED / ACTION SECTION
         ====================================================================== -->
    <section class="join-sec" id="join">
      <div class="container">
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'Get Involved With Us' : 'আমাদের সাথে যুক্ত হোন' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Join us in serving humanity through any of the following channels.' : 'নিচের যে কোনো পদ্ধতিতে আমাদের সঙ্গে যুক্ত হয়ে আর্তমানবতার সেবায় ভূমিকা রাখতে পারেন।' }}</p>

        <!-- Big Green Card: Regular Donor -->
        <div class="row">
          <div class="col-12">
            <div class="join-banner-border">
              <a href="{{ route('volunteer.index') }}" class="text-decoration-none">
                <div class="join-banner-inner" id="regularDonorCard">
                  <div class="join-banner-icon">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                  </div>
                  <h3 class="join-banner-title">{{ app()->getLocale() === 'en' ? 'Regular Donor Member' : 'নিয়মিত দাতা' }}</h3>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- 3 Smaller Action Cards -->
        <div class="row g-4 mt-1">
          <!-- Card 1: Blue -->
          <div class="col-lg-4 col-md-4 col-12">
            <div class="action-card-border blue">
              <a href="{{ route('volunteer.index') }}" class="text-decoration-none">
                <div class="action-card-inner blue" id="lifetimeMemberCard">
                  <div class="action-card-icon">
                    <i class="fa-solid fa-gift"></i>
                  </div>
                  <h3 class="action-card-title">{{ app()->getLocale() === 'en' ? 'Lifetime & Donor Member' : 'আজীবন ও দাতা সদস্য' }}</h3>
                </div>
              </a>
            </div>
          </div>

          <!-- Card 2: Gold -->
          <div class="col-lg-4 col-md-4 col-12">
            <div class="action-card-border gold">
              <a href="{{ route('volunteer.index') }}" class="text-decoration-none">
                <div class="action-card-inner gold" id="volunteerCard">
                  <div class="action-card-icon">
                    <i class="fa-solid fa-people-carry-box"></i>
                  </div>
                  <h3 class="action-card-title">{{ app()->getLocale() === 'en' ? 'Volunteer' : 'স্বেচ্ছাসেবক' }}</h3>
                </div>
              </a>
            </div>
          </div>

          <!-- Card 3: Purple -->
          <div class="col-lg-4 col-md-4 col-12">
            <div class="action-card-border purple">
              <a href="{{ route('contact.index') }}" class="text-decoration-none">
                <div class="action-card-inner purple" id="careerCard">
                  <div class="action-card-icon">
                    <i class="fa-solid fa-briefcase"></i>
                  </div>
                  <h3 class="action-card-title">{{ app()->getLocale() === 'en' ? 'Career & Connect' : 'ক্যারিয়ার' }}</h3>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         9. IMAGE GALLERY SECTION
         ====================================================================== -->
    <section class="gallery-sec" id="gallery">
      <div class="container">
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'Photo Gallery' : 'ছবিসমূহ' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Snapshots from the ground of our charitable and dawah operations' : 'মাঠপর্যায়ে সেবা ও দাওয়াহমূলক কার্যক্রমের খণ্ডচিত্র' }}</p>

        <div class="row g-4">
          @forelse($galleryImages as $item)
            @php
              $imgSrc = $item->image_path ? (str_starts_with($item->image_path, 'http') ? $item->image_path : asset($item->image_path)) : asset('12.jpeg');
            @endphp
            <div class="col-lg-4 col-md-6 col-12">
              <div class="gallery-photo-wrapper" data-src="{{ $imgSrc }}" data-caption="{{ $item->title }}">
                <img src="{{ $imgSrc }}" alt="{{ $item->title }}" class="gallery-img" loading="lazy">
                <div class="gallery-overlay">
                  <i class="fa-solid fa-magnifying-glass-plus"></i>
                  @if($item->title)
                    <span class="gallery-overlay-caption">{{ $item->title }}</span>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-4">
              <p class="text-muted">{{ app()->getLocale() === 'en' ? 'No gallery photos available.' : 'গ্যালারিতে কোনো ছবি পাওয়া যায়নি।' }}</p>
            </div>
          @endforelse
        </div>

        <div class="text-center-wrapper">
          <a href="{{ route('gallery.index') }}" class="btn-more" id="moreGalleryBtn">
            {{ app()->getLocale() === 'en' ? 'View All Photos' : 'আরও দেখুন' }} <i class="fa-solid fa-arrow-right-long ms-2"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         10. BLOG / SPEECHES SECTION
         ====================================================================== -->
    <section class="blogs-sec" id="blogs">
      <div class="container">
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'Latest Blog & News' : 'ব্লগসমূহ' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Recent news, reports, and thought-leadership articles from WOTM' : 'WOTMএর সাম্প্রতিক কার্যক্রমের সংবাদ, প্রতিবেদন ও দিকনির্দেশনা' }}</p>

        <div class="row g-4">
          @forelse($posts as $post)
            <div class="col-lg-4 col-md-6 col-12">
              <a href="{{ route('blog.show', $post->slug) }}" class="blog-card">
                <div class="blog-img-wrapper">
                  <img src="{{ $post->featured_image ? asset($post->featured_image) : asset('images/blogs/blog1.jpg') }}" alt="{{ $post->title }}" class="blog-img" loading="lazy">
                </div>
                <div class="blog-body">
                  <h3 class="blog-title">{{ $post->title }}</h3>
                  <p class="blog-desc">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                  <div class="blog-date">
                    <i class="fa-regular fa-calendar-days me-1"></i> {{ $post->published_at ? $post->published_at->format('d M, Y') : $post->created_at->format('d M, Y') }}
                  </div>
                </div>
              </a>
            </div>
          @empty
            <div class="col-lg-4 col-md-6 col-12">
              <a href="{{ route('blog.index') }}" class="blog-card">
                <div class="blog-img-wrapper">
                  <img src="{{ asset('images/blogs/blog1.jpg') }}" alt="ইমাম প্রশিক্ষণ কর্মশালা" class="blog-img" loading="lazy">
                </div>
                <div class="blog-body">
                  <h3 class="blog-title">খুলনা বিভাগের ইমাম প্রশিক্ষণ কর্মশালা : 'মসজিদের ইমাম থেকে...</h3>
                  <p class="blog-desc">মসজিদের মিম্বর থেকে একজন ইমাম কীভাবে পুরো সমাজের নেতা হয়ে উঠতে পারেন—সেই চেতনায় উদ্দীপ্ত হয়ে বাড়ি ফিরছেন ইমামগণ।</p>
                  <div class="blog-date"><i class="fa-regular fa-calendar-days me-1"></i> ১৬ আগস্ট, ২০২৬</div>
                </div>
              </a>
            </div>
          @endforelse
        </div>

        <div class="text-center-wrapper">
          <a href="{{ route('blog.index') }}" class="btn-more">
            {{ app()->getLocale() === 'en' ? 'View All Blogs' : 'আরও দেখুন' }} <i class="fa-solid fa-arrow-right-long ms-2"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         11. SISTER ORGANIZATIONS / LOGOS
         ====================================================================== -->
    <section class="partners-sec">
      <div class="container">
        <h2 class="sec-title">{{ app()->getLocale() === 'en' ? 'Our Institutions' : 'আমাদের প্রতিষ্ঠান' }}</h2>
        <p class="sec-sub">{{ app()->getLocale() === 'en' ? 'Sister organizations and affiliated projects operated under WOTM' : 'WOTM পরিচালিত অঙ্গ সংগঠন ও সহযোগী প্রকল্পসমূহ' }}</p>

        <div class="partners-row">
          <div class="partner-logo-wrapper">
            <img src="{{ asset('images/logos/logo1.png') }}" alt="As-Sunnah Skill Development Institute" class="partner-logo-img" loading="lazy">
          </div>
          <div class="partner-logo-wrapper">
            <img src="{{ asset('images/logos/logo2.png') }}" alt="Madrasatus Sunnah" class="partner-logo-img" loading="lazy">
          </div>
          <div class="partner-logo-wrapper">
            <img src="{{ asset('images/logos/logo3.png') }}" alt="IQA Islamic Question and Answer" class="partner-logo-img" loading="lazy">
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================================
         12. NEWSLETTER / CTA SECTION
         ====================================================================== -->
    <section class="newsletter-sec">
      <div class="container">
        <div class="newsletter-container">
          <img src="{{ asset('images/patterns/newsletter-waves.svg') }}" alt="Waves Pattern" class="newsletter-pattern-img">
          <div class="newsletter-content-wrapper">
            <h3 class="newsletter-title">{{ app()->getLocale() === 'en' ? 'Subscribe to Our Regular Newsletter' : 'নিয়মিত নিউজলেটার পেতে সাবস্ক্রাইব করুন' }}</h3>
            <form class="newsletter-form" id="newsletterForm" action="{{ route('contact.store') }}" method="POST">
              @csrf
              <input type="hidden" name="name" value="Newsletter Subscriber">
              <input type="hidden" name="subject" value="Newsletter Subscription">
              <input type="hidden" name="message" value="Subscribed to regular newsletter.">
              <input type="email" name="contact" class="newsletter-input" id="newsletterEmail" placeholder="{{ app()->getLocale() === 'en' ? 'Enter email address' : 'ইমেইল লিখুন' }}" required>
              <button type="submit" class="newsletter-btn">{{ app()->getLocale() === 'en' ? 'Subscribe' : 'সাবস্ক্রাইব' }}</button>
            </form>
          </div>
        </div>
      </div>
    </section>

@endsection
