@extends('layouts.frontend')

@section('meta_title', $page->meta_title ?? (app()->getLocale() === 'en' ? 'Introduction & Background - WOTM' : 'পরিচিতি ও পটভূমি - WOTM'))
@section('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description'))
@section('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords'))

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/about-subpages.css?v=1.2') }}">
@endpush

@section('content')

    <!-- ======================================================================
         1. HERO / BREADCRUMB BANNER
         ====================================================================== -->
    <section class="about-hero-section" id="introHero">
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
          <span class="about-breadcrumb-current">{{ app()->getLocale() === 'en' ? 'Introduction & Background' : 'পরিচিতি ও পটভূমি' }}</span>
        </nav>

        <h1 class="about-hero-title">{{ app()->getLocale() === 'en' ? 'Introduction & Background' : 'পরিচিতি ও পটভূমি' }}</h1>
      </div>
    </section>

    <!-- ======================================================================
         2. MAIN INSTITUTIONAL IMAGE & NARRATIVE LAYOUT
         ====================================================================== -->
    <section class="asp-main-sec">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-11 col-12">

            <!-- Professional Institutional Image Layout -->
            <div class="asp-institution-hero-card">
              <div class="asp-institution-img-wrap">
                <img src="{{ asset('images/institutional_headquarters.jpg') }}" 
                     alt="WOTM প্রাতিষ্ঠানিক কেন্দ্র ও সদর দপ্তর" 
                     class="asp-institution-main-img" 
                     loading="eager"
                     onerror="this.onerror=null;this.src='{{ asset('images/hero.webp') }}';">
                <div class="asp-institution-overlay-caption">
                  <div class="asp-institution-caption-title">
                    <i class="fa-solid fa-building-shield me-2"></i>
                    {{ app()->getLocale() === 'en' ? 'WOTM Institutional Headquarters & Humanitarian Operations' : 'WOTM প্রাতিষ্ঠানিক সদর দপ্তর ও মানবিক কার্যক্রম কেন্দ্র' }}
                  </div>
                  <p class="asp-institution-caption-sub">
                    {{ app()->getLocale() === 'en'
                        ? 'Government Registered Humanitarian Foundation (Reg No: ' . App\Models\Setting::get('site_reg_no', 'S-13111/2019') . ') | Serving 64 Districts Across Bangladesh'
                        : 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের আরজেএসসি নিবন্ধিত (নং: ' . App\Models\Setting::get('site_reg_no', 'এস-১৩১১১/২০১৯') . ') | দেশব্যাপী ৬৪ জেলায় সেবামূলক কার্যক্রম' }}
                  </p>
                </div>
              </div>

              <!-- In-depth Narrative Article: Introduction, History, Background & Development -->
              <article class="asp-narrative-article">
                <span class="asp-badge mb-3">
                  <i class="fa-solid fa-landmark"></i>
                  {{ app()->getLocale() === 'en' ? 'Organizational Heritage' : 'প্রাতিষ্ঠানিক ঐতিহ্য ও পরিচিতি' }}
                </span>

                <h2 class="asp-sec-title text-start mb-4">
                  {{ app()->getLocale() === 'en'
                      ? 'A Legacy of Compassion, Prophetic Sunnah, and Sustainable Development'
                      : 'মানবকল্যাণ, বিশুদ্ধ শিক্ষা ও সুন্নাহর ভিত্তিতে একটি আদর্শ সামাজিক রূপান্তর' }}
                </h2>

                <!-- Lead Paragraph -->
                <div class="asp-narrative-lead">
                  {{ app()->getLocale() === 'en'
                      ? 'Founded on the uncompromising pillars of authentic Quran-Sunnah values, institutional transparency, and dignified human empowerment, WOTM stands as one of Bangladesh’s dedicated non-political, non-profit humanitarian institutions.'
                      : 'পবিত্র কুরআন ও সহীহ সুন্নাহর চিরন্তন আদর্শ, প্রাতিষ্ঠানিক স্বচ্ছতা এবং মানবতার আত্মমর্যাদা রক্ষার দৃঢ় অঙ্গীকার নিয়ে প্রতিষ্ঠিত WOTM বাংলাদেশের অন্যতম নির্ভরযোগ্য অরাজনৈতিক ও অলাভজনক সেবামূলক জাতীয় প্রতিষ্ঠান।' }}
                </div>

                <!-- Paragraph 1: Genesis & Foundational Context -->
                <p class="asp-narrative-paragraph">
                  {{ app()->getLocale() === 'en'
                      ? 'The inception of WOTM emerged from a shared moral urgency among visionary Islamic scholars, chartered professionals, and compassionate community leaders in early 2018. Observing widespread vulnerabilities—from severe seasonal cold waves and recurring flash floods to the critical deficit of authentic Islamic education in rural heartlands—the founders envisioned an institutional platform capable of delivering organized, dignified, and religiously authentic relief.'
                      : 'WOTM-এর পথচলার সূচনা হয় ২০১৮ সালের প্রারম্ভে একদল দূরদর্শী ইসলামী চিন্তাবিদ, পেশাজীবী ও সমাজসেবকদের হাত ধরে। বাংলাদেশের প্রান্তিক জনপদে তীব্র শীতের প্রকোপ, আকস্মিক বন্যা এবং বিশুদ্ধ দ্বীনি ও কর্মমুখী শিক্ষার অভাব দেখে প্রতিষ্ঠাতাগণ এমন একটি সুসংগঠিত প্রাতিষ্ঠানিক কাঠামোর প্রয়োজনীয়তা গভীরভাবে অনুধাবন করেন, যা কেবল তাৎক্ষণিক ত্রাণ নয়, বরং মানুষের সার্বিক জীবনমান পরিবর্তনে কার্যকর ভূমিকা রাখবে।' }}
                </p>

                <!-- Paragraph 2: Legal Recognition & Governance Framework -->
                <p class="asp-narrative-paragraph">
                  {{ app()->getLocale() === 'en'
                      ? 'To ensure complete organizational permanence and public accountability, the institution achieved formal legal status in 2019 under the Societies Registration Act (Registration No: S-13111/2019). This landmark formalization inaugurated an independent Board of Trustees and an advisory panel of scholars and legal authorities, ensuring every donated currency is managed with absolute fidelity to the Islamic concept of Amanah (Sacred Trust).'
                      : 'কার্যক্রমের স্থায়িত্ব এবং দাতাদের আমানতের পূর্ণাঙ্গ সুরক্ষা নিশ্চিত করতে ২০১৯ সালে প্রতিষ্ঠানটি গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের আরজেএসসি থেকে সোসাইটি রেজিস্ট্রেশন অ্যাক্টের আওতায় আনুষ্ঠানিক আইনি নিবন্ধন লাভ করে (নিবন্ধন নং: ' . App\Models\Setting::get('site_reg_no', 'এস-১৩১১১/২০১৯') . ')। এর মাধ্যমে একটি দক্ষ ট্রাস্টি বোর্ড ও সম্মানিত শরীয়াহ উপদেষ্টা পরিষদের সমন্বয়ে আধুনিক প্রশাসনিক ব্যবস্থাপনা গড়ে তোলা হয়।' }}
                </p>

                <!-- Paragraph 3: Strategic Development & Three Pillars Expansion -->
                <p class="asp-narrative-paragraph">
                  {{ app()->getLocale() === 'en'
                      ? 'Over subsequent years, WOTM systematically evolved from immediate emergency distributions into a comprehensive tripartite institutional model: First, integrated educational institutions blending Hifz, Quranic sciences, and contemporary functional literacy; second, sustainable livelihood interventions—such as livestock provision, mechanized sewing equipment, and clean water plants—transforming dependent recipients into self-sufficient contributors; and third, research-driven Dawah symposiums and nationwide ethical development initiatives.'
                      : 'প্রতিষ্ঠার পর থেকে WOTM ধাপে ধাপে তার সেবাকে ৩টি মৌলিক স্তম্ভে সম্প্রসারিত করেছে: প্রথমত, বিশুদ্ধ কুরআন শিক্ষা ও আধুনিক সাধারণ শিক্ষার সমন্বয়ে মাদরাসা ও এতিমখানা পরিচালনা; দ্বিতীয়ত, স্বাবলম্বীকরণ প্রকল্পের আওতায় রিকশা-ভ্যান, সেলাই মেশিন, ছাগল-গরু ও গভীর নলকূপ স্থাপন করে পরিবারগুলোকে স্থায়ীভাবে স্বনির্ভর করা; এবং তৃতীয়ত, সমাজের সর্বস্তরে সহীহ সুন্নাহর দাওয়াহ ও মানবিক মূল্যবোধ ছড়িয়ে দেওয়া।' }}
                </p>

                <!-- Paragraph 4: National Outreach & Modern Institutional Standards -->
                <p class="asp-narrative-paragraph mb-0">
                  {{ app()->getLocale() === 'en'
                      ? 'Today, WOTM operates an active nationwide volunteer network spanning all 64 districts in Bangladesh, having positively impacted more than 1 million beneficiaries. Honored with 100% Tax Exemption status by the National Board of Revenue (NBR) under Section 44(2)(b) and subjected to annual audits by independent Chartered Accountant firms, the organization combines religious sincerity with world-class corporate governance.'
                      : 'বর্তমানে WOTM বাংলাদেশের সকল ৬৪টি জেলায় সক্রিয় সমন্বয়ক ও নিবেদিতপ্রাণ স্বেচ্ছাসেবকদের মাধ্যমে ১০ লক্ষাধিক মানুষের দোরগোড়ায় সেবা পৌঁছে দিয়েছে। জাতীয় রাজস্ব বোর্ড (NBR) কর্তৃক ধারা ৪৪(২)(খ) অনুযায়ী শতভাগ কর রেয়াত মর্যাদা এবং দেশের শীর্ষস্থানীয় চার্টার্ড অ্যাকাউন্টেন্ট ফার্ম দ্বারা নিয়মিত অডিট রিপোর্টের মাধ্যমে প্রতিষ্ঠানটি ধর্মীয় ইখলাসের পাশাপাশি সর্বোচ্চ কর্পোরেট সুশাসন নিশ্চিত করেছে।' }}
                </p>
              </article>
            </div>

            <!-- Official Registration & Regulatory Compliance Badges -->
            <article class="asp-content-card mb-5">
              <h3 class="h5 fw-bold text-dark mb-3">
                <i class="fa-solid fa-stamp text-success me-2"></i>
                {{ app()->getLocale() === 'en' ? 'Institutional Credentials & Legal Compliance' : 'সরকারি স্বীকৃতি ও প্রাতিষ্ঠানিক বৈধতা' }}
              </h3>

              <div class="asp-cert-grid">
                <!-- Cert 1: Govt Registration -->
                <div class="asp-cert-box">
                  <div class="asp-cert-icon"><i class="fa-solid fa-award"></i></div>
                  <div>
                    <h4 class="asp-cert-title">{{ app()->getLocale() === 'en' ? 'Govt. Registration' : 'সরকারি নিবন্ধন' }}</h4>
                    <p class="asp-cert-desc">
                      {{ app()->getLocale() === 'en' ? 'Registered with RJSC under Societies Act (Reg: S-13111/2019)' : 'গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের আরজেএসসি নিবন্ধিত (নং: এস-১৩১১১/২০১৯)' }}
                    </p>
                  </div>
                </div>

                <!-- Cert 2: NBR Tax Exemption -->
                <div class="asp-cert-box">
                  <div class="asp-cert-icon"><i class="fa-solid fa-certificate"></i></div>
                  <div>
                    <h4 class="asp-cert-title">{{ app()->getLocale() === 'en' ? '100% Tax Exemption' : 'শতভাগ কর রেয়াতযোগ্য' }}</h4>
                    <p class="asp-cert-desc">
                      {{ app()->getLocale() === 'en' ? 'National Board of Revenue (NBR) Section 44(2)(b) Approved' : 'জাতীয় রাজস্ব বোর্ড (NBR) ধারা ৪৪(২)(খ) অনুযায়ী দান শতভাগ কর রেয়াতযোগ্য' }}
                    </p>
                  </div>
                </div>

                <!-- Cert 3: Independent CA Audit -->
                <div class="asp-cert-box">
                  <div class="asp-cert-icon"><i class="fa-solid fa-shield-halved"></i></div>
                  <div>
                    <h4 class="asp-cert-title">{{ app()->getLocale() === 'en' ? 'Regular CA Audit' : 'স্বাধীন সিএ অডিট' }}</h4>
                    <p class="asp-cert-desc">
                      {{ app()->getLocale() === 'en' ? 'Audited annually by certified chartered accountant firm with public reports' : 'দেশের শীর্ষস্থানীয় চার্টার্ড অ্যাকাউন্টেন্ট ফার্ম দ্বারা নিয়মিত স্বচ্ছ অডিট' }}
                    </p>
                  </div>
                </div>
              </div>
            </article>

            <!-- Historical Milestone Timeline -->
            <article class="asp-content-card">
              <span class="asp-badge asp-badge-gold">
                <i class="fa-solid fa-clock-rotate-left"></i>
                {{ app()->getLocale() === 'en' ? 'Development Trajectory' : 'ঐতিহাসিক পরিক্রমা ও বিকাশ' }}
              </span>
              <h2 class="asp-sec-title text-start">
                {{ app()->getLocale() === 'en' ? 'Chronicle of Institutional Growth' : 'WOTM-এর পথচলার ইতিহাস ও বিকাশ' }}
              </h2>
              <p class="asp-sec-lead text-start mb-4">
                {{ app()->getLocale() === 'en'
                    ? 'From an emergency humanitarian relief initiative to an established national welfare and educational institution'
                    : 'একটি মহতী উদ্যোগ থেকে দেশব্যাপী পরিচিত সেবামূলক জাতীয় প্রতিষ্ঠানে রূপান্তরের ধারাবাহিক ধাপসমূহ' }}
              </p>

              <div class="asp-history-timeline">
                <!-- Milestone 1 -->
                <div class="asp-timeline-node">
                  <div class="asp-timeline-dot"></div>
                  <span class="asp-timeline-year">২০১৮</span>
                  <h3 class="asp-timeline-heading">
                    {{ app()->getLocale() === 'en' ? 'Inception & Emergency Humanitarian Aid' : 'প্রাথমিক সূচনা ও স্বেচ্ছাসেবী মানবিক উদ্যোগ' }}
                  </h3>
                  <p class="asp-timeline-text">
                    {{ app()->getLocale() === 'en'
                        ? 'A dedicated fraternity of scholars, youth leaders, and professionals launched organized emergency relief operations providing food security, warm clothing, and clean drinking water to flood and winter-affected populations.'
                        : 'একদল নিবেদিতপ্রাণ আলেম, সমাজসেবক ও তরুণ পেশাজীবী একত্রিত হয়ে দুর্যোগকবলিত ও সুবিধাবঞ্চিত মানুষের মাঝে জরুরি খাদ্য, বিশুদ্ধ পানি ও শীতবস্ত্র বিতরণের মাধ্যমে কার্যক্রমের সূচনা করেন।' }}
                  </p>
                </div>

                <!-- Milestone 2 -->
                <div class="asp-timeline-node">
                  <div class="asp-timeline-dot"></div>
                  <span class="asp-timeline-year">২০১৯</span>
                  <h3 class="asp-timeline-heading">
                    {{ app()->getLocale() === 'en' ? 'Official Government Registration & Charter Formation' : 'আনুষ্ঠানিক সরকারি নিবন্ধন ও পরিচালনা সনদ প্রণয়ন' }}
                  </h3>
                  <p class="asp-timeline-text">
                    {{ app()->getLocale() === 'en'
                        ? 'Obtained statutory registration under the Societies Registration Act (Reg No: S-13111/2019), institutionalizing our Board of Trustees and founding our governance code of ethics.'
                        : 'সোসাইটি রেজিস্ট্রেশন অ্যাক্টের অধীনে WOTM আনুষ্ঠানিক সরকারি নিবন্ধন লাভ করে (নং: এস-১৩১১১/২০১৯) এবং স্থায়ী ট্রাস্টি বোর্ড ও প্রশাসনিক নীতিমালা কার্যকর হয়।' }}
                  </p>
                </div>

                <!-- Milestone 3 -->
                <div class="asp-timeline-node">
                  <div class="asp-timeline-dot"></div>
                  <span class="asp-timeline-year">২০২১</span>
                  <h3 class="asp-timeline-heading">
                    {{ app()->getLocale() === 'en' ? 'Tripartite Pillar Expansion: Education & Livelihoods' : 'ত্রিমুখী সমন্বিত কার্যক্রম: শিক্ষা ও স্বাবলম্বীকরণ' }}
                  </h3>
                  <p class="asp-timeline-text">
                    {{ app()->getLocale() === 'en'
                        ? 'Formalized permanent operations in Quranic-vocational education, livelihood asset distribution (sewing machines, livestock, rickshaws), and community water plants.'
                        : 'জরুরি ত্রাণের পাশাপাশি স্থায়ী শিক্ষা প্রতিষ্ঠান, অসচ্ছল পরিবারগুলোর আত্মকর্মসংস্থান সৃষ্টি এবং বিশুদ্ধ খাবার পানির স্থায়ী প্ল্যান্ট স্থাপন কার্যক্রম শুরু হয়।' }}
                  </p>
                </div>

                <!-- Milestone 4 -->
                <div class="asp-timeline-node">
                  <div class="asp-timeline-dot"></div>
                  <span class="asp-timeline-year">২০২৪ – বর্তমান</span>
                  <h3 class="asp-timeline-heading">
                    {{ app()->getLocale() === 'en' ? 'NBR 100% Tax Exemption & All-District Network' : 'দেশব্যাপী নেটওয়ার্ক ও এনবিআর কর রেয়াত সম্মাননা' }}
                  </h3>
                  <p class="asp-timeline-text">
                    {{ app()->getLocale() === 'en'
                        ? 'Recognized with statutory 100% tax exemption under Section 44(2)(b) of the Income Tax Act, expanding permanent volunteer coverage across all 64 administrative districts in Bangladesh.'
                        : 'জাতীয় রাজস্ব বোর্ড (NBR) কর্তৃক আয়কর আইন অনুযায়ী শতভাগ কর রেয়াত মর্যাদা লাভ এবং বাংলাদেশের সকল ৬৪টি জেলায় স্থায়ী ভলান্টিয়ার ও সেবামূলক নেটওয়ার্ক সুপ্রতিষ্ঠিত।' }}
                  </p>
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
                        {{ app()->getLocale() === 'en' ? 'Join Our Journey in Serving Humanity' : 'মানবসেবার এই মহৎ কাফেলায় আপনিও যুক্ত হোন' }}
                      </h2>
                      <p class="asp-cta-lead">
                        {{ app()->getLocale() === 'en'
                            ? 'Be a proud part of our mission by becoming a volunteer or extending your support today.'
                            : 'WOTM-এর সম্মানিত সদস্য অথবা স্বেচ্ছাসেবক হিসেবে আর্তমানবতার সেবায় অংশ নিন।' }}
                      </p>
                    </div>
                    <div class="col-lg-4 col-12 text-lg-end">
                      <div class="asp-cta-actions">
                        <a href="{{ route('volunteer.index') }}" class="asp-btn-solid">
                          <i class="fa-solid fa-user-plus"></i> {{ app()->getLocale() === 'en' ? 'Join as Volunteer' : 'স্বেচ্ছাসেবক হোন' }}
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
