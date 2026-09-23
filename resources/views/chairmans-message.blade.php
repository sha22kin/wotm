@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? "Chairman's Message - WOTM" : 'চেয়ারম্যানের বাণী - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/chairmans-message.css?v=1.2') }}">
@endpush

@section('content')

    <!-- ======================================================================
         1. HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="about-hero-section" id="chairmanHero">
      <img src="{{ asset('images/hero.webp') }}" alt="WOTM কার্যক্রম ব্যানার" class="about-hero-bg-img">
      <div class="about-hero-overlay"></div>
      <img src="{{ asset('images/patterns/islamic-pattern.svg') }}" alt="ইসলামিক প্যাটার্ন" class="about-hero-pattern-img">

      <div class="container about-hero-container">
        <nav class="about-breadcrumb-nav" aria-label="ব্রেডক্রাম্ব নেভিগেশন">
          <a href="{{ route('home') }}" class="about-breadcrumb-link">
            <i class="fa-solid fa-house"></i> {{ app()->getLocale() === 'en' ? 'Home' : 'হোম' }}
          </a>
          <span class="about-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <a href="{{ route('about') }}" class="about-breadcrumb-link">
            {{ app()->getLocale() === 'en' ? 'About Us' : 'আমাদের সম্পর্কে' }}
          </a>
          <span class="about-breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></span>
          <span class="about-breadcrumb-current">{{ app()->getLocale() === 'en' ? "Chairman's Message" : 'চেয়ারম্যানের বাণী' }}</span>
        </nav>

        <h1 class="about-hero-title">{{ app()->getLocale() === 'en' ? "Chairman's Message" : 'চেয়ারম্যানের বাণী' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         2. MAIN CONTENT: PHOTO AT TOP -> MESSAGE BELOW PHOTO -> NAME AT BOTTOM
         ====================================================================== -->
    <section class="chm-main-sec" id="main-content">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-xl-9 col-12">

            <article class="chm-unified-card">

              <!-- ==========================================================
                   STEP 1: CHAIRMAN'S PHOTO AT THE TOP (প্রথমে চেয়ারম্যানের ছবি)
                   ========================================================== -->
              <header class="chm-top-portrait-sec">
                <div class="chm-top-avatar-wrap">
                  <img src="{{ $chairman ? $chairman->image_url : asset('images/avatar-placeholder.png') }}" 
                       alt="{{ $chairman ? $chairman->name : 'Chairman' }}" 
                       class="chm-top-avatar-img" 
                       loading="eager"
                       onerror="this.onerror=null;this.src='{{ asset('images/avatar-placeholder.png') }}';">
                  <div class="chm-top-badge" title="{{ app()->getLocale() === 'en' ? 'Chairman & Chief Patron' : 'চেয়ারম্যান ও প্রধান পৃষ্ঠপোষক' }}">
                    <i class="fa-solid fa-crown"></i>
                  </div>
                </div>

                <div>
                  <span class="chm-top-role-badge">
                    <i class="fa-solid fa-award"></i>
                    {{ $chairman ? $chairman->designation : (app()->getLocale() === 'en' ? 'Chairman & Chief Patron' : 'চেয়ারম্যান ও প্রধান পৃষ্ঠপোষক') }}
                  </span>
                </div>
              </header>

              <!-- ==========================================================
                   STEP 2: CHAIRMAN'S MESSAGE BELOW THE PHOTO (ছবির নিচে চেয়ারম্যানের বাণী)
                   ========================================================== -->
              <div class="chm-body-wrapper">

                <!-- Bismillah Calligraphy Box -->
                <header class="chm-bismillah-box mb-4">
                  <div class="chm-bismillah-txt">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
                  <p class="chm-bismillah-trans">
                    {{ app()->getLocale() === 'en' 
                        ? 'In the Name of Allah, the Most Gracious, the Most Merciful' 
                        : 'পরম করুণাময় ও অসীম দয়ালু আল্লাহর নামে শুরু করছি' }}
                  </p>
                </header>

                <!-- Inspiring Opening Quote Callout -->
                <blockquote class="chm-quote-callout mb-4">
                  <div class="chm-quote-icon"><i class="fa-solid fa-quote-left"></i></div>
                  <p class="chm-quote-text">
                    {{ app()->getLocale() === 'en'
                        ? '“True societal reform begins when compassionate hearts unite to alleviate suffering, empower families with dignity, and foster sustainable self-reliance under the guidance of the Sunnah.”'
                        : '“একটি আদর্শ সমাজের সূচনা তখনই হয়, যখন মানবদরদী মানুষ একতাবদ্ধ হয়ে আর্তমানবতার দুঃখ লাঘব করে এবং সুন্নাহর পথনির্দেশনায় আত্মমর্যাদাশীল সমাজ বিনির্মাণে আত্মনিয়োগ করে।”' }}
                  </p>
                </blockquote>

                <!-- Formal Message Body -->
                <div class="chm-body-text">
                  @if(!empty($page->content))
                    {!! $page->content !!}
                  @else
                    @if(app()->getLocale() === 'en')
                      <p>All praise is due to Allah, the Lord of the worlds, and peace and blessings be upon the final Prophet, Muhammad (PBUH), his family, and all his companions.</p>
                      <p>WOTM was founded with a profound vision: to bridge authentic Islamic values, ethical education, and transparent humanitarian assistance for the underprivileged members of our community. In an era fraught with hardship, natural crises, and moral distress, our duty as an Ummah is to embody the mercy of the Prophet Muhammad (PBUH) in concrete, measurable deeds.</p>
                      <p>We believe that every donation, every hour of volunteer service, and every prayer entrusted to us is a sacred trust (Amanah). Under our leadership, we remain steadfast in upholding total financial transparency, independent chartered audits, and zero compromise on the Sunnah-based ethics of public service.</p>
                    @else
                      <p>সমস্ত প্রশংসা মহান আল্লাহ রাব্বুল আলামীনের, যিনি নিখিল বিশ্বের স্রষ্টা ও পালনকর্তা। দরূদ ও সালাম বর্ষিত হোক মানবতার মুক্তির দিশারী, সর্বশ্রেষ্ঠ রাসুল হযরত মুহাম্মদ (সা.)-এর প্রতি এবং তাঁর সম্মানিত পরিবারবর্গ ও সাহাবায়ে কেরামের প্রতি।</p>
                      <p>মানবতার পরম আদর্শ মহানবী সা.-এর সুন্নাহর ভিত্তিতে আর্তমানবতার সার্বিক কল্যাণসাধন এবং সমাজ সংস্কারের মহতী লক্ষ্য নিয়ে প্রতিষ্ঠিত হয়েছে WOTM। সমাজের অসচ্ছল ও সুবিধাবঞ্চিত মানুষের আত্মমর্যাদার সাথে বাঁচার স্বপ্ন পূরণে আমরা শিক্ষা, মানবিক সেবা ও দাওয়াহ কার্যক্রম সমন্বিতভাবে পরিচালনা করছি।</p>
                      <p>আমরা দৃঢ়ভাবে বিশ্বাস করি—আপনাদের প্রতিটি অনুদান ও আন্তরিক সহযোগিতা মহান আল্লাহর পক্ষ থেকে আমাদের নিকট অর্পিত এক পবিত্র আমানত। সেই আমানতের শতভাগ সুরক্ষা নিশ্চিত করতে আমরা আধুনিক ডিজিটাল ব্যবস্থাপনা, দেশের শীর্ষস্থানীয় চার্টার্ড অ্যাকাউন্টেন্ট ফার্ম দ্বারা বার্ষিক অডিট এবং সর্বোচ্চ স্বচ্ছতা বজায় রাখতে সর্বদা প্রতিজ্ঞাবদ্ধ।</p>
                    @endif
                  @endif


                  @if(app()->getLocale() === 'en')
                    <p>I extend my heartfelt gratitude to our devoted donors, life members, volunteers, and well-wishers worldwide. Let us continue to march forward together—For the Ummah, with the Sunnah.</p>
                  @else
                    <p>আমাদের সকল শুভাকাঙ্ক্ষী, সম্মানিত দাতা এবং মাঠপর্যায়ের নিবেদিতপ্রাণ স্বেচ্ছাসেবকদের জানাই আন্তরিক মোবারকবাদ। আসুন, আর্তমানবতার সেবায় আমরা একতাবদ্ধ হয়ে কাজ করি—উম্মাহর স্বার্থে, সুন্নাহর সাথে।</p>
                  @endif
                </div>

              </div>

              <!-- ==========================================================
                   STEP 3: CHAIRMAN'S NAME AT THE BOTTOM (বাণীর শেষে নিচে নাম)
                   ========================================================== -->
              <footer class="chm-bottom-signoff">
                <div class="chm-bottom-details">
                  <div class="chm-bottom-complimentary">
                    {{ app()->getLocale() === 'en' ? 'With sincere prayers & regards,' : 'ওয়াসসালামু আলাইকুম ওয়া রাহমাতুল্লাহ,' }}
                  </div>

                  <!-- Chairman's Name -->
                  <h3 class="chm-bottom-chairman-name">
                    {{ $chairman ? $chairman->name : (app()->getLocale() === 'en' ? 'Dr. Muhammad Abdur Rahman' : 'ড. মুহাম্মদ আব্দুর রহমান') }}
                  </h3>

                  <!-- Chairman's Designation -->
                  <div class="chm-bottom-chairman-desig">
                    {{ $chairman ? $chairman->designation : (app()->getLocale() === 'en' ? 'Chairman & Chief Patron' : 'চেয়ারম্যান ও প্রধান পৃষ্ঠপোষক') }}
                  </div>

                  <!-- Organization -->
                  <div class="chm-bottom-chairman-org">
                    {{ app()->getLocale() === 'en' ? 'Board of Trustees, WOTM Foundation' : 'পরিচালনা পর্ষদ, WOTM ফাউন্ডেশন' }}
                  </div>

                  <!-- Optional Direct Contact Chips if available -->
                  @if($chairman && ($chairman->phone || $chairman->email))
                    <div class="chm-bottom-contacts">
                      @if($chairman->phone)
                        <a href="tel:{{ $chairman->phone }}" class="chm-bottom-chip" title="Call">
                          <i class="fa-solid fa-phone"></i> {{ $chairman->phone }}
                        </a>
                      @endif
                      @if($chairman->email)
                        <a href="mailto:{{ $chairman->email }}" class="chm-bottom-chip" title="Email">
                          <i class="fa-solid fa-envelope"></i> {{ $chairman->email }}
                        </a>
                      @endif
                    </div>
                  @endif
                </div>

                <!-- Official Stamp / Seal Box -->
                <div class="chm-bottom-seal-box">
                  <div class="chm-bottom-seal-icon"><i class="fa-solid fa-award"></i></div>
                  <div class="chm-bottom-seal-title">{{ app()->getLocale() === 'en' ? 'Official Seal' : 'অনুমোদিত বাণী' }}</div>
                  <div class="chm-bottom-seal-sub">{{ app()->getLocale() === 'en' ? 'WOTM Board of Trustees' : 'WOTM পরিচালনা পর্ষদ' }}</div>
                </div>
              </footer>

            </article>

            <!-- Bottom Call to Action Card -->
            <div class="chm-cta-sec">
              <div class="chm-cta-card">
                <img src="{{ asset('images/patterns/gold-pattern.svg') }}" alt="প্যাটার্ন" class="chm-cta-pattern">
                <div class="chm-cta-content">
                  <div class="row align-items-center g-3">
                    <div class="col-lg-8 col-12">
                      <h2 class="chm-cta-heading">
                        {{ app()->getLocale() === 'en' ? 'Support Our Humanitarian Vision' : 'আমাদের মানবিক উদ্যোগে অংশ নিন' }}
                      </h2>
                      <p class="chm-cta-lead">
                        {{ app()->getLocale() === 'en'
                            ? 'Your contributions help educate orphans, support vulnerable families, and respond to disasters.'
                            : 'আপনার সামান্য অনুদান অসহায় মানুষের মুখে হাসি ফোটাতে পারে এবং পরকালের অফুরন্ত পাথেয় হতে পারে।' }}
                      </p>
                    </div>
                    <div class="col-lg-4 col-12 text-lg-end">
                      <div class="chm-cta-actions">
                        <a href="{{ route('volunteer.index') }}" class="chm-btn-solid">
                          <i class="fa-solid fa-user-plus"></i> {{ app()->getLocale() === 'en' ? 'Join Us' : 'যুক্ত হোন' }}
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

@endsection
