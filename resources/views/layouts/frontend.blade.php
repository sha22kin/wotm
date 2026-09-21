<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Dynamic SEO Meta Tags -->
  <title>@yield('meta_title', $page->meta_title ?? App\Models\Setting::get('seo_meta_title', 'WOTM | উম্মাহর স্বার্থে, সুন্নাহর সাথে'))</title>
  <meta name="description" content="@yield('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description', 'WOTM একটি অরাজনৈতিক, অলাভজনক শিক্ষা, দাওয়াহ ও পূর্ণত মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান।'))">
  <meta name="keywords" content="@yield('meta_keywords', $page->meta_keywords ?? App\Models\Setting::get('seo_meta_keywords', 'WOTM, অনুদান, যাকাত, কুরবানী, ত্রাণ, শিক্ষা, দাওয়াহ, মানবকল্যাণ'))">
  <meta name="author" content="WOTM">
  @if(!empty($page->canonical_url))
    <link rel="canonical" href="{{ $page->canonical_url }}">
  @endif

  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="@yield('meta_title', $page->meta_title ?? App\Models\Setting::get('seo_meta_title', 'WOTM | উম্মাহর স্বার্থে, সুন্নাহর সাথে'))">
  <meta property="og:description" content="@yield('meta_description', $page->meta_description ?? App\Models\Setting::get('seo_meta_description', 'মানবকল্যাণে নিবেদিত সেবামূলক সরকার-নিবন্ধিত প্রতিষ্ঠান।'))">
  <meta property="og:image" content="{{ asset($page->og_image ?? App\Models\Setting::get('seo_og_image', 'images/hero.webp')) }}">
  <meta property="og:type" content="website">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset(App\Models\Setting::get('site_favicon', 'images/logos/logo.webp')) }}">

  <!-- Google Fonts: Anek Bangla -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 Grid & Utilities CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- Font Awesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Custom External CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css?v=3.4') }}">
  @stack('styles')
</head>
<body class="@yield('body_class')">

  <!-- ========================================================================
       1. HEADER / NAVIGATION
       ======================================================================== -->
  <header class="site-header" id="siteHeader">
    <div class="header-container">
      <div class="navigation-container" id="navBox">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="nav-brand" aria-label="WOTM হোমপেজ">
          <img src="{{ asset(App\Models\Setting::get('site_logo', 'images/logos/logo.webp')) }}" alt="WOTM লোগো" class="brand-logo">
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="d-none d-lg-block" aria-label="প্রধান নেভিগেশন">
          <ul class="nav-menu">
            @php
              $navItems = App\Models\NavigationItem::with(['children' => function($q) {
                  $q->where('is_active', true)->orderBy('order', 'asc')->orderBy('id', 'asc');
              }])->whereNull('parent_id')->where('is_active', true)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
            @endphp

            @foreach($navItems as $nav)
              <li class="navigation-link-item">
                <a href="{{ url($nav->url) }}" target="{{ $nav->target }}" class="nav-link {{ request()->is(ltrim($nav->url, '/')) || (request()->routeIs('home') && $nav->url === '/') ? 'is-active' : '' }}">
                  {{ $nav->title }}
                  @if($nav->children->count() > 0)
                    <i class="fa-solid fa-angle-down"></i>
                  @endif
                </a>
                @if($nav->children->count() > 0)
                  <ul class="nav-dropdown">
                    @foreach($nav->children as $child)
                      <li class="navigation-submenu-item">
                        <a href="{{ url($child->url) }}" target="{{ $child->target }}">{{ $child->title }}</a>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </li>
            @endforeach
          </ul>
        </nav>

        <!-- Right Utilities & Action Buttons -->
        <div class="nav-actions">
          <!-- Language Switcher -->
          <div class="lang-switch notranslate" role="group" aria-label="ভাষা পরিবর্তন">
            <a href="{{ route('lang.switch', 'bn') }}" class="lang-btn {{ app()->getLocale() === 'bn' ? 'active' : '' }}">বাং</a>
            <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
          </div>

          <!-- User Auth Button -->
          @auth
            <div class="dropdown">
              <a href="#" class="user-btn is-active" data-bs-toggle="dropdown" aria-expanded="false" title="{{ auth()->user()->name }}">
                <i class="fa-solid fa-user"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-header">{{ auth()->user()->name }}</li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fa-solid fa-user-circle me-2"></i>{{ app()->getLocale() === 'en' ? 'My Profile' : 'আমার প্রোফাইল' }}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>{{ app()->getLocale() === 'en' ? 'Logout' : 'লগআউট' }}</button>
                  </form>
                </li>
              </ul>
            </div>
          @else
            <a href="{{ route('login') }}" class="user-btn" aria-label="ইউজার লগইন" title="লগইন ও সাইনআপ">
              <i class="fa-solid fa-user"></i>
            </a>
          @endauth

          <!-- Donate / Volunteer Button -->
          <a href="{{ route('volunteer.index') }}" class="btn-top-donate">
            <i class="fa-solid fa-user-plus"></i> {{ app()->getLocale() === 'en' ? 'Join Us' : 'যুক্ত হোন' }}
          </a>

          <!-- Mobile Hamburger Toggle -->
          <button class="nav-toggle" id="navToggle" type="button" aria-label="মোবাইল মেনু খুলুন">
            <i class="fa-solid fa-bars"></i>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Mobile Drawer Menu -->
  <aside class="mobile-nav-panel" id="mobileNavPanel" aria-hidden="true">
    <div class="mobile-nav-content">
      <div class="mobile-nav-header">
        <img src="{{ asset(App\Models\Setting::get('site_logo', 'images/logos/logo.webp')) }}" alt="WOTM" class="brand-logo">
        <button class="mobile-nav-close" id="mobileNavClose" type="button" aria-label="মেনু বন্ধ করুন">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="d-flex align-items-center justify-content-between my-2">
        <div class="lang-switch notranslate">
          <a href="{{ route('lang.switch', 'bn') }}" class="lang-btn {{ app()->getLocale() === 'bn' ? 'active' : '' }}">বাং</a>
          <a href="{{ route('lang.switch', 'en') }}" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>
        @auth
          <div class="dropdown">
            <a href="#" class="user-btn is-active" data-bs-toggle="dropdown" aria-expanded="false" title="{{ auth()->user()->name }}">
              <i class="fa-solid fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="dropdown-header">{{ auth()->user()->name }}</li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fa-solid fa-user-circle me-2"></i>{{ app()->getLocale() === 'en' ? 'My Profile' : 'আমার প্রোফাইল' }}</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>{{ app()->getLocale() === 'en' ? 'Logout' : 'লগআউট' }}</button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <a href="{{ route('login') }}" class="user-btn" aria-label="ইউজার লগইন" title="লগইন ও সাইনআপ">
            <i class="fa-solid fa-user"></i>
          </a>
        @endauth
      </div>

      <ul class="mobile-menu-list">
        @foreach($navItems as $nav)
          <li>
            <a href="{{ url($nav->url) }}" class="mobile-nav-link">{{ $nav->title }}</a>
          </li>
        @endforeach
      </ul>

      <div class="mt-auto">
        <a href="{{ route('volunteer.index') }}" class="btn-solid-green text-center w-100 mobile-nav-link">
          <i class="fa-solid fa-user-plus me-2"></i> {{ app()->getLocale() === 'en' ? 'Join Now' : 'যুক্ত হোন' }}
        </a>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main>
    @yield('content')
  </main>

  <!-- ========================================================================
       FOOTER
       ======================================================================== -->
  <!-- ========================================================================
       FOOTER
       ======================================================================== -->
  <footer class="site-footer footer-overlap" id="contact">
    <img src="{{ asset('images/patterns/mosque-silhouette.svg') }}" alt="Mosque Silhouette" class="footer-mosque-img">

    <div class="container footer-content-wrapper">
      <div class="row g-4 g-lg-5">
        <!-- Col 1: About & Mission -->
        <div class="col-lg-4 col-md-6 col-12">
          <div class="footer-brand">
            <img src="{{ asset(App\Models\Setting::get('footer_logo', 'images/logos/logo4.webp')) }}" alt="WOTM লোগো" class="footer-logo">
            <p class="footer-desc">
              {{ app()->getLocale() === 'en' 
                  ? App\Models\Setting::get('footer_about_en', 'This institution is striving with its utmost efforts to build an ideal welfare society in the service of suffering humanity, following the footsteps of Prophet Muhammad (PBUH).') 
                  : App\Models\Setting::get('footer_about_bn', 'এই প্রতিষ্ঠান মানবতার শিক্ষক, মানুষের মুক্তি ও শান্তির দূত, মানবসেবার আদর্শ, মহানবী মুহাম্মদ সা.-এর পদাঙ্ক অনুসরণ করে আর্তমানবতার সেবায় একটি আদর্শ কল্যাণসমাজ বিনির্মাণে যথাসক্তি প্রচেষ্টা চালিয়ে যাচ্ছে।') }}
            </p>
            <div class="footer-socials">
              @if($fb = App\Models\Setting::get('social_facebook', 'https://facebook.com'))
                <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Facebook">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
              @endif
              @if($yt = App\Models\Setting::get('social_youtube', 'https://youtube.com'))
                <a href="{{ $yt }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="YouTube">
                  <i class="fa-brands fa-youtube"></i>
                </a>
              @endif
              @if($li = App\Models\Setting::get('social_linkedin', 'https://linkedin.com'))
                <a href="{{ $li }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="LinkedIn">
                  <i class="fa-brands fa-linkedin-in"></i>
                </a>
              @endif
              @if($tw = App\Models\Setting::get('social_twitter', 'https://twitter.com'))
                <a href="{{ $tw }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Twitter">
                  <i class="fa-brands fa-x-twitter"></i>
                </a>
              @endif
              @if($ig = App\Models\Setting::get('social_instagram'))
                <a href="{{ $ig }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Instagram">
                  <i class="fa-brands fa-instagram"></i>
                </a>
              @endif
            </div>
          </div>
        </div>

        <!-- Col 2: Menu Links -->
        <div class="col-lg-2 col-md-6 col-6">
          <h4 class="footer-col-title">{{ app()->getLocale() === 'en' ? 'Menu' : 'মেনু' }}</h4>
          <ul class="footer-links">
            <li><a href="{{ route('about') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'About Us' : 'আমাদের সম্পর্কে' }}</a></li>
            <li><a href="{{ route('activities.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Activities' : 'কার্যক্রমসমূহ' }}</a></li>
            <li><a href="{{ route('blog.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Blog' : 'ব্লগ' }}</a></li>
            <li><a href="{{ route('gallery.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Gallery' : 'গ্যালারি' }}</a></li>
            <li><a href="{{ route('notice.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Notice Board' : 'নোটিশ বোর্ড' }}</a></li>
          </ul>
        </div>

        <!-- Col 3: Get Involved -->
        <div class="col-lg-3 col-md-6 col-6">
          <h4 class="footer-col-title">{{ app()->getLocale() === 'en' ? 'Get Involved' : 'যুক্ত হোন' }}</h4>
          <ul class="footer-links">
            <li><a href="{{ route('volunteer.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Regular Donor Member' : 'নিয়মিত দাতা সদস্য' }}</a></li>
            <li><a href="{{ route('volunteer.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Lifetime Member' : 'আজীবন ও দাতা সদস্য' }}</a></li>
            <li><a href="{{ route('volunteer.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Volunteer' : 'স্বেচ্ছাসেবক' }}</a></li>
            <li><a href="{{ route('volunteer.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Career' : 'ক্যারিয়ার' }}</a></li>
          </ul>
        </div>

        <!-- Col 4: Other Links -->
        <div class="col-lg-3 col-md-6 col-12">
          <h4 class="footer-col-title">{{ app()->getLocale() === 'en' ? 'Other Links' : 'অন্যান্য' }}</h4>
          <ul class="footer-links">
            <li><a href="{{ route('contact.index') }}"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Contact' : 'যোগাযোগ' }}</a></li>
            <li><a href="{{ route('home') }}#terms"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Terms of Service' : 'পরিষেবার শর্তাবলী' }}</a></li>
            <li><a href="{{ route('home') }}#privacy"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Privacy Policy' : 'গোপনীয়তা নীতি' }}</a></li>
            <li><a href="{{ route('about') }}#about-transparency"><i class="fa-solid fa-angle-right"></i> {{ app()->getLocale() === 'en' ? 'Audit Report' : 'অডিট রিপোর্ট' }}</a></li>
          </ul>
        </div>
      </div>

      <!-- Copyright Bottom Bar -->
      <div class="footer-bottom">
        <p>{{ app()->getLocale() === 'en' ? App\Models\Setting::get('footer_copyright_en', 'Copyright © 2026 WOTM - All Rights Reserved.') : App\Models\Setting::get('footer_copyright_bn', 'স্বত্ব © ২০২৬ WOTM - সর্ব স্বত্ব সংরক্ষিত।') }}</p>
      </div>
    </div>
  </footer>

  <!-- ========================================================================
       INTERACTIVE MODALS
       ======================================================================== -->
  <!-- Video Player Modal -->
  <div class="custom-modal" id="videoModal" role="dialog" aria-modal="true" aria-label="ভিডিও প্লেয়ার">
    <div class="modal-inner-container">
      <button type="button" class="modal-close-btn" id="closeVideoModal" aria-label="ভিডিও বন্ধ করুন">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="video-frame-wrapper">
        <iframe id="videoIframe" src="" title="WOTM ভিডিও" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
  </div>

  <!-- Image Lightbox Modal -->
  <div class="lightbox-modal" id="lightboxModal" role="dialog" aria-modal="true" aria-label="ছবি গ্যালারি">
    <button type="button" class="lightbox-close" id="lightboxClose" aria-label="বন্ধ করুন">
      <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="lightbox-nav prev" id="lightboxPrev"><i class="fa-solid fa-chevron-left"></i></div>
    <div class="lightbox-nav next" id="lightboxNext"><i class="fa-solid fa-chevron-right"></i></div>
    <div class="lightbox-image-wrapper text-center">
      <img src="" alt="গ্যালারি ছবি" class="lightbox-img" id="lightboxImg">
      <p class="text-white mt-2 mb-0 fw-medium" id="lightboxCaption"></p>
    </div>
  </div>

  <!-- Tax Rebate Info Modal -->
  <div class="custom-modal" id="taxModal" role="dialog" aria-modal="true" aria-label="কর রেয়াত সংক্রান্ত তথ্য">
    <div class="modal-inner-container p-4">
      <button type="button" class="modal-close-btn" id="closeTaxModal" aria-label="বন্ধ করুন">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <h3 class="fw-bold mb-3 text-success">কর রেয়াত সংক্রান্ত তথ্য</h3>
      <p class="text-muted leading-relaxed">
        জাতীয় রাজস্ব বোর্ড (NBR) এর প্রজ্ঞাপন অনুযায়ী WOTM একটি সরকার-নিবন্ধিত অনুমোদিত মানবকল্যাণ সংস্থা। 
        এই সংস্থায় যেকোনো ব্যক্তি বা প্রাতিষ্ঠানিক দান আয়কর অধ্যাদেশ ১৯৮৪ এর ধারা ৪৪(২)(খ) অনুযায়ী শতভাগ কর রেয়াতযোগ্য (Tax Exemption)।
      </p>
      <div class="bg-light p-3 rounded-3 mb-3 border">
        <p class="mb-1 fw-semibold text-dark">নিবন্ধন নম্বর: এস-১৩১১১/২০১৯</p>
        <p class="mb-0 text-muted">প্রতিটি অনুদানের সাথে ডিজিটাল ই-রসিদ প্রদান করা হয় যা আয়কর নথিতে ব্যবহারযোগ্য।</p>
      </div>
      <div class="text-end">
        <button type="button" class="btn btn-success px-4" id="taxModalOkBtn">বুঝেছি</button>
      </div>
    </div>
  </div>

  <!-- Quick Donation Modal -->
  <div class="custom-modal" id="quickDonateModal" role="dialog" aria-modal="true" aria-label="দ্রুত অনুদান">
    <div class="modal-inner-container p-4">
      <button type="button" class="modal-close-btn" id="closeDonateModal" aria-label="বন্ধ করুন">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <h3 class="fw-bold mb-2 text-success" id="modalFundTitle">অনুদান প্রদান করুন</h3>
      <p class="text-muted mb-4">অনুদানের মাধ্যমে আর্তমানবতার কল্যাণে ভূমিকা রাখুন</p>
      <form id="modalDonateForm" novalidate>
        <div class="mb-3">
          <label class="form-label fw-semibold text-dark">অনুদানের পরিমাণ (টাকা)</label>
          <div class="d-flex gap-2 mb-2 flex-wrap">
            <button type="button" class="btn btn-outline-success btn-sm preset-amount" data-amount="500">৳ ৫০০</button>
            <button type="button" class="btn btn-outline-success btn-sm preset-amount" data-amount="1000">৳ ১,০০০</button>
            <button type="button" class="btn btn-outline-success btn-sm preset-amount" data-amount="5000">৳ ৫,০০০</button>
            <button type="button" class="btn btn-outline-success btn-sm preset-amount" data-amount="10000">৳ ১০,০০০</button>
          </div>
          <input type="number" class="form-control" id="modalAmountInput" placeholder="৳ নিজস্ব পরিমাণ লিখুন" min="10" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold text-dark">মোবাইল নম্বর / ইমেইল</label>
          <input type="text" class="form-control" id="modalContactInput" placeholder="০১৭xxxxxxxx বা ইমেইল" required>
        </div>
        <div class="mb-4">
          <label class="form-label fw-semibold text-dark">অনুদানের মাধ্যম</label>
          <div class="d-flex gap-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payMethod" id="payBkash" checked>
              <label class="form-check-label" for="payBkash">বিকাশ / নগদ / রকেট</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payMethod" id="payBank">
              <label class="form-check-label" for="payBank">ব্যাংক ট্রান্সফার</label>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
          <i class="fa-solid fa-lock me-1"></i> পেমেন্টে এগিয়ে যান
        </button>
      </form>
    </div>
  </div>

  <!-- Floating WhatsApp Button -->
  @php
    $whatsappNum = App\Models\Setting::get('whatsapp_number', '8801700000000');
  @endphp
  <a href="https://wa.me/{{ $whatsappNum }}" target="_blank" rel="noopener noreferrer" class="floating-whatsapp" aria-label="হোয়াটসঅ্যাপে যোগাযোগ করুন">
    <i class="fa-brands fa-whatsapp"></i>
  </a>

  <!-- Back to Top Button -->
  <button type="button" class="back-to-top" id="backToTop" aria-label="পৃষ্ঠার শীর্ষে যান">
    <i class="fa-solid fa-arrow-up"></i>
  </button>

  <!-- jQuery 3.7.1 CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom External JavaScript -->
  <script src="{{ asset('js/script.js?v=2.9') }}"></script>
  @stack('scripts')
</body>
</html>
