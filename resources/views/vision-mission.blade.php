@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Vision & Mission - WOTM' : 'ভিশন ও মিশন - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/about-subpages.css?v=1.2') }}">
@endpush

@section('content')

    <!-- ======================================================================
         1. HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="about-hero-section" id="visionHero">
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
          <span class="about-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Vision & Mission' : 'ভিশন ও মিশন' }}</span>
        </nav>

        <h1 class="about-hero-title">{{ app()->getLocale() === 'en' ? 'Vision & Mission' : 'ভিশন ও মিশন' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         2. DEDICATED SEPARATE VISION & MISSION BLOCKS
         ====================================================================== -->
    <section class="asp-main-sec">
      <div class="container">

        <!-- Section Header -->
        <header class="asp-section-header">
          <span class="asp-badge">
            <i class="fa-solid fa-compass"></i>
            {{ app()->getLocale() === 'en' ? 'Strategic Direction' : 'কৌশলগত দিকনির্দেশনা' }}
          </span>
          <h2 class="asp-sec-title">
            {{ app()->getLocale() === 'en' ? 'Our Organizational Purpose & Direction' : 'আমাদের আদর্শিক লক্ষ্য, রূপকল্প ও কর্মপরিকল্পনা' }}
          </h2>
          <p class="asp-sec-lead">
            {{ app()->getLocale() === 'en'
                ? 'Rooted in prophetic compassion and driven by corporate rigor, our vision and mission outline our pledge to humanity and our creator.'
                : 'মহান আল্লাহর সন্তুষ্টি অর্জনে সুন্নাহর ভিত্তিতে আর্তমানবতার সার্বিক সেবা ও একটি ন্যায়ভিত্তিক সমৃদ্ধ সমাজ বিনির্মাণে আমাদের মূল অঙ্গীকার।' }}
          </p>
        </header>

        <!-- Separate Dedicated Vision & Mission Cards -->
        <div class="row g-4 mb-5">

          <!-- Block 1: The Vision Card -->
          <div class="col-lg-6 col-12">
            <article class="asp-content-card h-100 d-flex flex-column" style="border-top: 5px solid var(--asp-primary);">
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="asp-spotlight-icon-wrap asp-vision-icon" style="margin: 0;">
                  <i class="fa-solid fa-eye"></i>
                </div>
                <div>
                  <span class="asp-badge mb-1">
                    {{ app()->getLocale() === 'en' ? 'Long-Term Horizon' : 'দীর্ঘমেয়াদী রূপকল্প' }}
                  </span>
                  <h3 class="asp-spotlight-title mb-0">
                    {{ app()->getLocale() === 'en' ? 'Our Vision' : 'আমাদের ভিশন (Vision)' }}
                  </h3>
                </div>
              </div>

              <!-- In-depth Vision Narrative -->
              <p class="asp-spotlight-body mb-4">
                {{ app()->getLocale() === 'en'
                    ? 'To cultivate an enlightened, spiritually dignified, and economically resilient society where every vulnerable individual achieves access to authentic Islamic values, quality functional education, and sustainable self-reliance—transforming poverty into human dignity under the guidance of the Holy Quran and authentic Sunnah.'
                    : 'পবিত্র কুরআন ও সহীহ সুন্নাহর চিরন্তন আদর্শের আলোকে এমন একটি আলোকিত, মর্যাদাপূর্ণ ও আত্মনির্ভরশীল কল্যাণসমাজ গড়ে তোলা—যেখানে সমাজের প্রতিটি সুবিধাবঞ্চিত মানুষ বিশুদ্ধ দ্বীনি ও কর্মমুখী শিক্ষা, উন্নত নৈতিক চরিত্র এবং দারিদ্র্যমুক্ত স্বাবলম্বী জীবনের পূর্ণ সুযোগ ভোগ করবে।' }}
              </p>

              <!-- Vision Strategic Pillars -->
              <div class="mt-auto pt-3 border-top">
                <h4 class="h6 fw-bold text-dark mb-3">
                  <i class="fa-solid fa-bullseye text-primary me-2"></i>
                  {{ app()->getLocale() === 'en' ? 'Core Pillars of Our Vision:' : 'ভিশন বাস্তবায়নের ৩টি মূল স্তম্ভ:' }}
                </h4>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                  <li class="d-flex align-items-start gap-2 small text-secondary">
                    <i class="fa-solid fa-circle-check text-success mt-1 flex-shrink-0"></i>
                    <span><strong>{{ app()->getLocale() === 'en' ? 'Spiritual Dignity:' : 'আত্মমর্যাদা ও দ্বীনি শিক্ষা:' }}</strong> {{ app()->getLocale() === 'en' ? 'Empowering future generations with authentic Islamic ethics alongside modern vocational competence.' : 'কুরআন-সুন্নাহর বিশুদ্ধ জ্ঞানের মাধ্যমে ভবিষ্যৎ প্রজন্মকে আদর্শ ও দক্ষ নাগরিকে রূপান্তর।' }}</span>
                  </li>
                  <li class="d-flex align-items-start gap-2 small text-secondary">
                    <i class="fa-solid fa-circle-check text-success mt-1 flex-shrink-0"></i>
                    <span><strong>{{ app()->getLocale() === 'en' ? 'Self-Sustaining Families:' : 'স্থায়ী আত্মনির্ভরশীলতা:' }}</strong> {{ app()->getLocale() === 'en' ? 'Eradicating generational poverty through micro-livelihoods, vocational tools, and sustainable enterprise.' : 'অসহায় পরিবারগুলোকে গৃহপালিত পশু, সেলাই মেশিন ও কর্মসংস্থানের মাধ্যমে স্বাবলম্বী করা।' }}</span>
                  </li>
                  <li class="d-flex align-items-start gap-2 small text-secondary">
                    <i class="fa-solid fa-circle-check text-success mt-1 flex-shrink-0"></i>
                    <span><strong>{{ app()->getLocale() === 'en' ? 'Resilient Communities:' : 'টেকসই নিরাপদ জনপদ:' }}</strong> {{ app()->getLocale() === 'en' ? 'Equipping climate-vulnerable communities with clean water plants, disaster shelters, and healthcare access.' : 'উপকূলীয় ও বন্যাপ্রবণ অঞ্চলে বিশুদ্ধ পানি প্ল্যান্ট, জরুরি আশ্রয় ও স্বাস্থ্যসেবা নিশ্চিতকরণ।' }}</span>
                  </li>
                </ul>
              </div>
            </article>
          </div>

          <!-- Block 2: The Mission Card -->
          <div class="col-lg-6 col-12">
            <article class="asp-content-card h-100 d-flex flex-column" style="border-top: 5px solid var(--asp-gold);">
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="asp-spotlight-icon-wrap asp-mission-icon" style="margin: 0;">
                  <i class="fa-solid fa-bullseye"></i>
                </div>
                <div>
                  <span class="asp-badge asp-badge-gold mb-1">
                    {{ app()->getLocale() === 'en' ? 'Operational Mandate' : 'বাস্তবায়নযোগ্য মিশন' }}
                  </span>
                  <h3 class="asp-spotlight-title mb-0">
                    {{ app()->getLocale() === 'en' ? 'Our Mission' : 'আমাদের মিশন (Mission)' }}
                  </h3>
                </div>
              </div>

              <!-- In-depth Mission Narrative -->
              <p class="asp-spotlight-body mb-4">
                {{ app()->getLocale() === 'en'
                    ? 'To mobilize humanitarian aid with 100% financial transparency; establish accessible model educational madrasahs for orphans and marginalized children; deliver rapid crisis relief across disaster zones; and implement sustainable livelihood initiatives that transform aid recipients into self-reliant, contributing members of the Ummah.'
                    : 'অনুদানের প্রতিটি পয়সার শতভাগ স্বচ্ছতা বজায় রেখে দ্রুততম সময়ে আর্তমানবতার দ্বারে জরুরি সহায়তা পৌঁছে দেওয়া; এতিম ও অসচ্ছল শিশুদের জন্য মানসম্মত দ্বীনি ও সাধারণ শিক্ষা প্রতিষ্ঠান পরিচালনা; এবং দীর্ঘমেয়াদী পুনর্বাসন প্রকল্পের মাধ্যমে সাহায্যপ্রার্থীকে পর্যায়ক্রমে স্বাবলম্বী দাতায় পরিণত করা।' }}
              </p>

              <!-- Mission Commitments -->
              <div class="mt-auto pt-3 border-top">
                <h4 class="h6 fw-bold text-dark mb-3">
                  <i class="fa-solid fa-shield-heart text-warning me-2"></i>
                  {{ app()->getLocale() === 'en' ? 'Our Operational Commitments:' : 'মিশনের অঙ্গীকারসমূহ:' }}
                </h4>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                  <li class="d-flex align-items-start gap-2 small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary mt-1 flex-shrink-0"></i>
                    <span><strong>{{ app()->getLocale() === 'en' ? 'People-First Empathy:' : 'মানবদরদী সেবা:' }}</strong> {{ app()->getLocale() === 'en' ? 'Serving without prejudice, political bias, or compromising the self-respect and dignity of beneficiaries.' : 'কোনো প্রকার দলীয় সংকীর্ণতা ছাড়া প্রতিটি মানুষের সম্মান বজায় রেখে নিঃস্বার্থভাবে পাশে দাঁড়ানো।' }}</span>
                  </li>
                  <li class="d-flex align-items-start gap-2 small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary mt-1 flex-shrink-0"></i>
                    <span><strong>{{ app()->getLocale() === 'en' ? 'Zero Compromise on Amanah:' : 'আমানতের সর্বোচ্চ সুরক্ষা:' }}</strong> {{ app()->getLocale() === 'en' ? 'Employing digital tracking, independent CA audits, and direct distribution to guarantee total integrity.' : 'ডিজিটাল ট্র্যাকিং ও চার্টার্ড অ্যাকাউন্টেন্ট অডিটের মাধ্যমে তহবিলের শতভাগ সঠিক বণ্টন নিশ্চিত করা।' }}</span>
                  </li>
                  <li class="d-flex align-items-start gap-2 small text-secondary">
                    <i class="fa-solid fa-circle-check text-primary mt-1 flex-shrink-0"></i>
                    <span><strong>{{ app()->getLocale() === 'en' ? 'Sustainable Development:' : 'টেকসই উন্নয়ন নীতি:' }}</strong> {{ app()->getLocale() === 'en' ? 'Aligning humanitarian projects with sustainable community growth and lasting generational uplift.' : 'সাময়িক সাহায্যের ঊর্ধ্বে উঠে দীর্ঘমেয়াদী ও টেকসই পারিবারিক অর্থনৈতিক সচ্ছলতা নিশ্চিতকরণ।' }}</span>
                  </li>
                </ul>
              </div>
            </article>
          </div>

        </div>

        <!-- ==================================================================
             3. CORE VALUES (Bedrock Principles)
             ================================================================== -->
        <div class="row justify-content-center mb-5">
          <div class="col-lg-12">
            <article class="asp-content-card">
              <div class="text-center mb-4">
                <span class="asp-badge asp-badge-gold">
                  <i class="fa-solid fa-scale-balanced"></i>
                  {{ app()->getLocale() === 'en' ? 'Foundational Bedrock' : 'আদর্শিক ভিত্তি' }}
                </span>
                <h3 class="asp-sec-title">
                  {{ app()->getLocale() === 'en' ? 'Our Five Core Institutional Values' : 'আমাদের ৫টি প্রাতিষ্ঠানিক মূলনীতি (Core Values)' }}
                </h3>
                <p class="asp-sec-lead">
                  {{ app()->getLocale() === 'en'
                      ? 'The unwavering moral pillars that govern our leadership, resource allocation, and fieldwork'
                      : 'প্রতিটি কাজে আল্লাহভীতি, আমানতের সুরক্ষা ও সুন্নাহর পূর্ণাঙ্গ অনুসরণ আমাদের মূল চালিকাশক্তি' }}
                </p>
              </div>

              <div class="asp-values-grid">
                <!-- Value 1: Ikhlas -->
                <div class="asp-value-item">
                  <div class="asp-value-icon"><i class="fa-solid fa-heart"></i></div>
                  <h4 class="asp-value-title">{{ app()->getLocale() === 'en' ? '1. Ikhlas (Sincerity)' : '১. ইখলাস ও নিয়তের বিশুদ্ধতা' }}</h4>
                  <p class="asp-value-desc">
                    {{ app()->getLocale() === 'en' ? 'Seeking the pleasure of Almighty Allah alone in every undertaking, free from ostentation or worldly acclaim.' : 'সকল কর্মকাণ্ডে একমাত্র মহান আল্লাহর সন্তুষ্টি অর্জন ও প্রদর্শনেচ্ছা পরিহার।' }}
                  </p>
                </div>

                <!-- Value 2: Amanah -->
                <div class="asp-value-item">
                  <div class="asp-value-icon"><i class="fa-solid fa-shield-halved"></i></div>
                  <h4 class="asp-value-title">{{ app()->getLocale() === 'en' ? '2. Amanah (Trust)' : '২. আমানতের পবিত্র সুরক্ষা' }}</h4>
                  <p class="asp-value-desc">
                    {{ app()->getLocale() === 'en' ? 'Safeguarding every donated penny as a divine trust, ensuring it reaches deserving beneficiaries without leakage.' : 'অনুদানের প্রতিটি পয়সাকে পবিত্র আমানত হিসেবে গণ্য করে নির্ধারিত খাতে শতভাগ পৌঁছানো।' }}
                  </p>
                </div>

                <!-- Value 3: Prophetic Sunnah -->
                <div class="asp-value-item">
                  <div class="asp-value-icon"><i class="fa-solid fa-book-quran"></i></div>
                  <h4 class="asp-value-title">{{ app()->getLocale() === 'en' ? '3. Prophetic Sunnah' : '৩. সুন্নাহর পথনির্দেশ' }}</h4>
                  <p class="asp-value-desc">
                    {{ app()->getLocale() === 'en' ? 'Adhering strictly to authentic prophetic guidelines in charity administration and public service.' : 'সেবা ও সমাজ সংস্কারে মানবতার পরম শিক্ষক মহানবী মুহাম্মদ সা.-এর আদর্শের বাস্তব প্রতিফলন।' }}
                  </p>
                </div>

                <!-- Value 4: Transparency & Professionalism -->
                <div class="asp-value-item">
                  <div class="asp-value-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                  <h4 class="asp-value-title">{{ app()->getLocale() === 'en' ? '4. Transparency' : '৪. প্রাতিষ্ঠানিক স্বচ্ছতা' }}</h4>
                  <p class="asp-value-desc">
                    {{ app()->getLocale() === 'en' ? 'Operating with annual independent Chartered Accountant audits, public accounts, and corporate rigor.' : 'স্বাধীন চার্টার্ড অ্যাকাউন্টেন্ট ফার্ম দ্বারা নিয়মিত অডিট ও উন্মুক্ত জবাবদিহিতা।' }}
                  </p>
                </div>

                <!-- Value 5: Human Dignity -->
                <div class="asp-value-item">
                  <div class="asp-value-icon"><i class="fa-solid fa-hands-holding-child"></i></div>
                  <h4 class="asp-value-title">{{ app()->getLocale() === 'en' ? '5. Human Dignity' : '৫. আত্মমর্যাদা রক্ষা' }}</h4>
                  <p class="asp-value-desc">
                    {{ app()->getLocale() === 'en' ? 'Alleviating distress while preserving the honor and self-esteem of every brother and sister we serve.' : 'সাহায্যপ্রার্থী প্রতিটি মানুষের মানবিক সম্মান অক্ষুণ্ণ রেখে হৃদয় উজাড় করা সেবা প্রদান।' }}
                  </p>
                </div>
              </div>
            </article>
          </div>
        </div>

        <!-- ==================================================================
             4. FUTURE DIRECTION & HORIZON 2030 GOALS
             ================================================================== -->
        <article class="asp-charter-box mb-5">
          <img src="{{ asset('images/patterns/gold-pattern.svg') }}" alt="প্যাটার্ন" class="asp-charter-pattern">
          <div class="row align-items-center g-4">
            <div class="col-lg-8 col-12">
              <span class="asp-badge asp-badge-gold mb-2">
                <i class="fa-solid fa-mountain-sun"></i>
                {{ app()->getLocale() === 'en' ? 'Strategic Horizon 2030' : 'ভবিষ্যৎ লক্ষ্য ও কৌশলগত পথরেখা' }}
              </span>
              <h2 class="asp-charter-title mb-3">
                {{ app()->getLocale() === 'en' ? 'Future Goals & Long-Term Milestones' : 'ভবিষ্যতের সুদূরপ্রসারী লক্ষ্য ও কর্মপরিকল্পনা' }}
              </h2>
              <p class="asp-charter-text mb-4">
                {{ app()->getLocale() === 'en'
                    ? 'Our roadmap targets transforming 50,000 vulnerable households into self-sufficient families, establishing 20 permanent integrated education institutions, and installing 1,000 community deep-tube water filtration systems nationwide by 2030.'
                    : 'আমাদের লক্ষ্য—২০৩০ সালের মধ্যে দেশজুড়ে ৫০,০০০ পরিবারকে স্থায়ী স্বাবলম্বী করে তোলা, ২০টি সমন্বিত মডেল মাদরাসা ও এতিমখানা প্রতিষ্ঠা করা এবং আর্সেনিক ও লবণাক্ততাপ্রবণ অঞ্চলে ১,০০০টি গভীর নলকূপ ও ওয়াটার প্ল্যান্ট স্থাপন করা।' }}
              </p>
              <div class="d-flex flex-wrap gap-4 text-white">
                <div>
                  <div class="h3 fw-bold text-warning mb-0">৫০,০০০+</div>
                  <div class="small opacity-75">{{ app()->getLocale() === 'en' ? 'Families Self-Reliant' : 'পরিবারকে স্বাবলম্বীকরণ' }}</div>
                </div>
                <div class="border-start ps-4">
                  <div class="h3 fw-bold text-warning mb-0">২০+</div>
                  <div class="small opacity-75">{{ app()->getLocale() === 'en' ? 'Model Madrasahs' : 'মডেল শিক্ষা প্রতিষ্ঠান' }}</div>
                </div>
                <div class="border-start ps-4">
                  <div class="h3 fw-bold text-warning mb-0">১,০০০+</div>
                  <div class="small opacity-75">{{ app()->getLocale() === 'en' ? 'Clean Water Stations' : 'বিশুদ্ধ পানি প্ল্যান্ট' }}</div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-12 text-lg-end">
              <a href="{{ route('contact.index') }}" class="asp-btn-solid">
                <i class="fa-solid fa-handshake-angle"></i>
                {{ app()->getLocale() === 'en' ? 'Partner With Us' : 'যৌথ উদ্যোগে অংশ নিন' }}
              </a>
            </div>
          </div>
        </article>

        <!-- Bottom CTA Banner -->
        <div class="asp-cta-sec">
          <div class="asp-cta-card">
            <img src="{{ asset('images/patterns/gold-pattern.svg') }}" alt="প্যাটার্ন" class="asp-cta-pattern">
            <div class="asp-cta-content">
              <div class="row align-items-center g-3">
                <div class="col-lg-8 col-12">
                  <h2 class="asp-cta-heading">
                    {{ app()->getLocale() === 'en' ? 'Support Our Vision for an Ideal Society' : 'একটি আদর্শ কল্যাণসমাজ বিনির্মাণে পাশে থাকুন' }}
                  </h2>
                  <p class="asp-cta-lead">
                    {{ app()->getLocale() === 'en'
                        ? 'Join our mission by donating towards educational, livelihood, and humanitarian projects.'
                        : 'আপনার যাকাত, সাদাকাহ ও উন্নয়ন অনুদানে বদলে যেতে পারে একটি অসহায় পরিবারের ভবিষ্যৎ।' }}
                  </p>
                </div>
                <div class="col-lg-4 col-12 text-lg-end">
                  <div class="asp-cta-actions">
                    <a href="{{ route('home') }}#funds" class="asp-btn-solid">
                      <i class="fa-solid fa-hand-holding-heart"></i> {{ app()->getLocale() === 'en' ? 'Donate Now' : 'অনুদান দিন' }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

@endsection
